<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\EconomicModelService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show(Project $project)
    {
        $cashflows = $project->cashflows()->where('scenario', 'base')->get();

        // Prepare data for Chart.js
        $labels = $cashflows->pluck('year')->toArray();
        $revenues = $cashflows->pluck('gross_revenue')->toArray();
        $netProfits = $cashflows->pluck('operator_share')->toArray();
        $stateShare = $cashflows->pluck('state_share')->toArray();
        $petrosenShare = $cashflows->pluck('petrosen_share')->toArray();

        $cumulativeNPV = [];
        $total = 0;
        foreach ($cashflows->pluck('discounted_cashflow') as $cf) {
            $total += $cf;
            $cumulativeNPV[] = round($total, 2);
        }

        // Calculate IRR
        $irr = null;
        $projectCashflows = $cashflows->pluck('project_cashflow')->toArray();
        if (!empty($projectCashflows)) {
            $economicService = app(EconomicModelService::class);
            $irr = $economicService->getIRR($projectCashflows);
        }

        // Totals for doughnut chart & KPIs
        $totalState = round($cashflows->sum('state_share') + $cashflows->sum('royalties')
                    + $cashflows->sum('petrosen_share'), 2);
        $totalOperator = round($cashflows->sum('operator_share'), 2);
        $totalTaxes = round($cashflows->sum('income_tax') + $cashflows->sum('cel')
                    + $cashflows->sum('export_tax') + $cashflows->sum('wht_dividendes')
                    + $cashflows->sum('business_license_tax'), 2);
        $totalCapex = round($cashflows->sum('capex_total'), 2);

        return view('dashboards.show', compact(
            'project', 'cashflows', 'labels', 'revenues',
            'netProfits', 'stateShare', 'petrosenShare', 'cumulativeNPV', 'irr',
            'totalState', 'totalOperator', 'totalTaxes', 'totalCapex'
        ));
    }

    public function state(Project $project)
    {
        $cashflows = $project->cashflows()->where('scenario', 'base')->get();

        $cumulativeNPV = [];
        $total = 0;
        foreach ($cashflows->pluck('discounted_cashflow') as $cf) {
            $total += $cf;
            $cumulativeNPV[] = round($total, 2);
        }

        return view('dashboards.state', compact('project', 'cashflows', 'cumulativeNPV'));
    }
}
