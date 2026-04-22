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

class StateSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    public function __construct(protected Project $project, protected Collection $cashflows) {}

    public function title(): string
    {
        return 'Revenus Etat';
    }

    public function headings(): array
    {
        return [
            'Annee', 'Redevances (M$)', 'Profit Oil Etat (M$)', 'Part PETROSEN (M$)',
            'IS (M$)', 'CEL (M$)', 'Taxe Export (M$)', 'WHT Div. (M$)', 'BLT (M$)',
            'Total Etat (M$)', 'Revenu Brut (M$)', 'Government Take (%)',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->cashflows as $cf) {
            $totalEtat = $cf->royalties + $cf->state_share + $cf->petrosen_share
                       + $cf->income_tax + $cf->cel + $cf->export_tax
                       + ($cf->wht_dividendes ?? 0) + ($cf->business_license_tax ?? 0);
            $govTake = $cf->gross_revenue > 0 ? round($totalEtat / $cf->gross_revenue * 100, 2) : 0;

            $rows[] = [
                $cf->year, $cf->royalties, $cf->state_share, $cf->petrosen_share,
                $cf->income_tax, $cf->cel, $cf->export_tax,
                $cf->wht_dividendes ?? 0, $cf->business_license_tax ?? 0,
                round($totalEtat, 2), $cf->gross_revenue, $govTake,
            ];
        }

        $totals = ['TOTAL'];
        for ($i = 1; $i <= 11; $i++) {
            if ($i === 11) { // Gov Take: weighted average
                $totalEtat = array_sum(array_column($rows, 9));
                $totalRev = array_sum(array_column($rows, 10));
                $totals[] = $totalRev > 0 ? round($totalEtat / $totalRev * 100, 2) : 0;
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
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '10B981']]],
            $lastRow => ['font' => ['bold' => true]],
        ];
    }
}
