<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Exports\SimulationExport;
use App\Services\EconomicModelService;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function excel(Project $project)
    {
        $this->authorizeAccess($project);

        $filename = 'Simulation_' . str_replace(' ', '_', $project->name) . '_' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new SimulationExport($project), $filename);
    }

    public function pdf(Project $project)
    {
        $this->authorizeAccess($project);

        $cashflows = $project->cashflows()->where('scenario', 'base')->orderBy('year')->get();

        if ($cashflows->isEmpty()) {
            return back()->with('error', 'Aucune simulation disponible. Lancez une simulation avant d\'exporter.');
        }

        // Prepare chart data for the PDF
        $labels = $cashflows->pluck('year')->toArray();
        $revenues = $cashflows->pluck('gross_revenue')->toArray();
        $stateShare = $cashflows->pluck('state_share')->toArray();
        $operatorShare = $cashflows->pluck('operator_share')->toArray();

        $cumulativeNPV = [];
        $total = 0;
        foreach ($cashflows->pluck('discounted_cashflow') as $cf) {
            $total += $cf;
            $cumulativeNPV[] = round($total, 2);
        }

        // KPIs
        $irr = null;
        $projectCashflows = $cashflows->pluck('project_cashflow')->toArray();
        if (!empty($projectCashflows)) {
            $irr = app(EconomicModelService::class)->getIRR($projectCashflows);
        }

        $totalRevenue = $cashflows->sum('gross_revenue');
        $totalState = $cashflows->sum('state_share') + $cashflows->sum('royalties')
                    + $cashflows->sum('income_tax') + $cashflows->sum('cel')
                    + $cashflows->sum('export_tax') + $cashflows->sum('petrosen_share')
                    + $cashflows->sum('wht_dividendes') + $cashflows->sum('business_license_tax');
        $totalOperator = $cashflows->sum('operator_share');
        $totalCapex = $cashflows->sum('capex_total');
        $totalOpex = $cashflows->sum('opex_total');
        $totalAbex = $cashflows->sum('abex_total');
        $npv = end($cumulativeNPV) ?: 0;
        $govTake = $totalRevenue > 0 ? round($totalState / $totalRevenue * 100, 1) : 0;

        // Advanced KPIs
        $paybackYear = null;
        $cumCF = 0;
        foreach ($cashflows as $cf) {
            $cumCF += $cf->project_cashflow;
            if ($cumCF >= 0 && $paybackYear === null && $cf->project_cashflow > 0) {
                $paybackYear = $cf->year;
            }
        }

        $profitabilityIndex = $totalCapex > 0 ? round($npv / $totalCapex, 2) : 0;
        $totalInvestment = $totalCapex + $totalOpex + $totalAbex;

        // Production totals from inputs
        $project->load(['productions', 'capexes', 'opexes', 'abexes', 'parameter']);
        $peakProdYear = null;
        $peakProdVal = 0;
        foreach ($project->productions as $p) {
            $equiv = $p->totalEquivPetrole();
            if ($equiv > $peakProdVal) {
                $peakProdVal = round($equiv, 1);
                $peakProdYear = $p->year;
            }
        }

        // CAPEX profile per year
        $capexProfile = $project->capexes->map(fn($c) => ['year' => $c->year, 'total' => round($c->total(), 1)])->toArray();
        $opexProfile = $project->opexes->map(fn($o) => ['year' => $o->year, 'total' => round($o->total(), 1)])->toArray();
        $prodProfile = $project->productions->map(fn($p) => [
            'year' => $p->year,
            'equiv' => round($p->totalEquivPetrole(), 1),
            'oil' => round($p->petroleAn(), 3),
            'gnl' => round($p->gnlMtpa(), 3),
        ])->toArray();

        $pdf = Pdf::loadView('exports.simulation-pdf', compact(
            'project', 'cashflows', 'labels', 'revenues', 'stateShare', 'operatorShare',
            'cumulativeNPV', 'irr', 'totalRevenue', 'totalState', 'totalOperator',
            'totalCapex', 'totalOpex', 'totalAbex', 'npv', 'govTake',
            'paybackYear', 'profitabilityIndex', 'totalInvestment',
            'peakProdYear', 'peakProdVal', 'capexProfile', 'opexProfile', 'prodProfile'
        ));

        $pdf->setPaper('A3', 'landscape');

        $filename = 'Simulation_' . str_replace(' ', '_', $project->name) . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    public function stateComponent(Project $project, string $component)
    {
        $this->authorizeAccess($project);

        $cashflows = $project->cashflows()->where('scenario', 'base')->orderBy('year')->get();

        if ($cashflows->isEmpty()) {
            return back()->with('error', 'Aucune simulation disponible.');
        }

        $components = [
            'redevances'  => ['label' => 'Redevances',          'field' => 'royalties'],
            'profit-oil'  => ['label' => 'Profit Oil Etat',     'field' => 'state_share'],
            'petrosen'    => ['label' => 'Part PETROSEN',        'field' => 'petrosen_share'],
            'is'          => ['label' => 'Impot sur les Societes (IS)', 'field' => 'income_tax'],
            'cel'         => ['label' => 'CEL',                  'field' => 'cel'],
            'taxe-export' => ['label' => 'Taxe Export',          'field' => 'export_tax'],
            'wht'         => ['label' => 'WHT Dividendes',       'field' => 'wht_dividendes'],
            'blt'         => ['label' => 'Business License Tax', 'field' => 'business_license_tax'],
            'total'       => ['label' => 'Total Revenus Etat',  'field' => null],
        ];

        if (!isset($components[$component])) {
            abort(404);
        }

        $config = $components[$component];
        $headings = ['Annee', 'Revenu Brut (M$)', $config['label'] . ' (M$)', '% du Revenu Brut'];
        $rows = [];

        foreach ($cashflows as $cf) {
            if ($component === 'total') {
                $val = $cf->royalties + $cf->state_share + $cf->petrosen_share
                     + $cf->income_tax + $cf->cel + $cf->export_tax
                     + ($cf->wht_dividendes ?? 0) + ($cf->business_license_tax ?? 0);
            } else {
                $val = (float) ($cf->{$config['field']} ?? 0);
            }
            $pct = $cf->gross_revenue > 0 ? round($val / $cf->gross_revenue * 100, 2) : 0;
            $rows[] = [$cf->year, round($cf->gross_revenue, 2), round($val, 2), $pct];
        }

        // Total row
        $totalRev = array_sum(array_column($rows, 1));
        $totalVal = array_sum(array_column($rows, 2));
        $totalPct = $totalRev > 0 ? round($totalVal / $totalRev * 100, 2) : 0;
        $rows[] = ['TOTAL', round($totalRev, 2), round($totalVal, 2), $totalPct];

        $export = new \App\Exports\StateComponentExport($config['label'], $headings, $rows);
        $filename = str_replace(' ', '_', $config['label']) . '_' . str_replace(' ', '_', $project->name) . '.xlsx';

        return Excel::download($export, $filename);
    }

    private function authorizeAccess(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
