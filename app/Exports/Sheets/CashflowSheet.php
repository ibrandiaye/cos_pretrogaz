<?php

namespace App\Exports\Sheets;

use App\Models\Project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashflowSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    public function __construct(protected Project $project, protected Collection $cashflows) {}

    public function title(): string
    {
        return 'Cashflow';
    }

    public function headings(): array
    {
        return [
            'Annee', 'Revenu Brut (M$)', 'Redevances (M$)', 'Revenu Net (M$)',
            'Cost Recovery (M$)', 'Profit Oil (M$)', 'R-Factor',
            'Part Etat (M$)', 'Part PETROSEN (M$)', 'Part Operateur (M$)',
            'IS (M$)', 'CEL (M$)', 'Taxe Export (M$)', 'WHT Div. (M$)', 'BLT (M$)',
            'Depreciation (M$)', 'CAPEX Total (M$)', 'OPEX Total (M$)', 'ABEX Total (M$)',
            'Cashflow Projet (M$)', 'Cashflow Actualise (M$)',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->cashflows as $cf) {
            $rows[] = [
                $cf->year, $cf->gross_revenue, $cf->royalties, $cf->net_revenue,
                $cf->cost_recovery, $cf->profit_oil, $cf->r_factor,
                $cf->state_share, $cf->petrosen_share, $cf->operator_share,
                $cf->income_tax, $cf->cel, $cf->export_tax,
                $cf->wht_dividendes ?? 0, $cf->business_license_tax ?? 0,
                $cf->depreciation ?? 0, $cf->capex_total, $cf->opex_total, $cf->abex_total ?? 0,
                $cf->project_cashflow, $cf->discounted_cashflow,
            ];
        }

        // Total row
        $totals = ['TOTAL'];
        for ($i = 1; $i < 21; $i++) {
            if ($i === 6) { // R-Factor: average
                $vals = array_column($rows, $i);
                $nonNull = array_filter($vals, fn($v) => $v !== null);
                $totals[] = count($nonNull) > 0 ? round(array_sum($nonNull) / count($nonNull), 4) : null;
            } else {
                $totals[] = round(array_sum(array_column($rows, $i)), 2);
            }
        }
        $rows[] = $totals;

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        $lastRow = $this->cashflows->count() + 2;
        return [
            1 => ['font' => ['bold' => true, 'size' => 11], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '3B82F6']], 'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
            $lastRow => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}
