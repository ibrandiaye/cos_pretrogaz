<?php

namespace App\Exports\Sheets;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CapexSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    public function __construct(protected Project $project) {}

    public function title(): string { return 'Details CAPEX'; }

    public function headings(): array
    {
        return [
            'Annee', 'Exploration (M$)', 'Etudes Pre-FID (M$)', 'Forage & Completion (M$)',
            'Inst. Sous-Marines (M$)', 'Pipeline(s) (M$)', 'Inst. Surface (M$)',
            'Owners Cost (M$)', 'Imprevus (M$)', 'Total (M$)',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->project->capexes as $c) {
            $rows[] = [
                $c->year, $c->exploration, $c->etudes_pre_fid, $c->forage_completion,
                $c->installations_sous_marines, $c->pipeline, $c->installations_surface,
                $c->owners_cost, $c->imprevus, round($c->total(), 2),
            ];
        }
        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '3B82F6']]]];
    }
}
