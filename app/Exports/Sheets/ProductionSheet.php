<?php

namespace App\Exports\Sheets;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductionSheet implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize
{
    public function __construct(protected Project $project) {}

    public function title(): string { return 'Production'; }

    public function headings(): array
    {
        return [
            'Annee',
            'Petrole (mbbl/j)', 'Petrole (mmbbls/an)',
            'Gaz Dom. (mmscf/j)', 'Gaz Dom. (Tbtu/an)',
            'GNL (mmscf/j)', 'GNL (MTPA)', 'GNL (Tbtu/an)',
            'Gaz Comb./Pertes (mmscf/j)',
            'Total Gaz (mmscf/j)', 'Equiv. Petrole (mbbl/j)', 'Equiv. hors pertes (mbbl/j)',
        ];
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->project->productions as $p) {
            $rows[] = [
                $p->year,
                round($p->petrole_jour, 4), round($p->petroleAn(), 4),
                round($p->gaz_domestique_jour, 4), round($p->gazDomestiqueTbtu(), 4),
                round($p->gnl_jour, 4), round($p->gnlMtpa(), 4), round($p->gnlTbtu(), 4),
                round($p->gaz_combustible_pertes, 4),
                round($p->totalGazJour(), 2), round($p->totalEquivPetrole(), 2), round($p->totalEquivPetroleHorsPertes(), 2),
            ];
        }
        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F59E0B']]]];
    }
}
