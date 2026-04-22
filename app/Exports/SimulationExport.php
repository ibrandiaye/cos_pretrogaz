<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SimulationExport implements WithMultipleSheets
{
    public function __construct(protected Project $project) {}

    public function sheets(): array
    {
        $cashflows = $this->project->cashflows()->where('scenario', 'base')->orderBy('year')->get();

        return [
            'Cashflow' => new Sheets\CashflowSheet($this->project, $cashflows),
            'Etat' => new Sheets\StateSheet($this->project, $cashflows),
            'CAPEX' => new Sheets\CapexSheet($this->project),
            'OPEX' => new Sheets\OpexSheet($this->project),
            'Production' => new Sheets\ProductionSheet($this->project),
        ];
    }
}
