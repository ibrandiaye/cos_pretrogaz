<?php

namespace App\Http\Controllers;

use App\Models\Project;
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

        return view('dashboards.show', compact(
            'project', 'cashflows', 'labels', 'revenues', 
            'netProfits', 'stateShare', 'petrosenShare', 'cumulativeNPV'
        ));
    }

    public function state(Project $project)
    {
        $cashflows = $project->cashflows()->where('scenario', 'base')->get();
        return view('dashboards.state', compact('project', 'cashflows'));
    }
}
