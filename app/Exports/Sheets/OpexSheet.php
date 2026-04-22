<?php

namespace App\Exports\Sheets;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OpexSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    public function __construct(protected Project $project) {}

    public function title(): string { return 'Details OPEX'; }

    public function headings(): array
    {
        return [
            'Annee', 'Location FLNG (M$)', 'Location FPSO (M$)', 'Opex Puits (M$)',
            'Maintenance Inst. (M$)', 'Autres Opex (M$)', 'Total (M$)',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->project->opexes as $o) {
            $rows[] = [
                $o->year, $o->location_flng, $o->location_fpso, $o->opex_puits,
                $o->maintenance_installations, $o->autres_opex, round($o->total(), 2),
            ];
        }
        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '10B981']]]];
    }
}
