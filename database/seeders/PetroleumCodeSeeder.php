<?php

namespace Database\Seeders;

use App\Models\PetroleumCode;
use Illuminate\Database\Seeder;

class PetroleumCodeSeeder extends Seeder
{
    public function run(): void
    {
        // ══════════════════════════════════════════
        // Code Petrolier 2019 (CPP & JOA)
        // ══════════════════════════════════════════
        $code2019 = PetroleumCode::firstOrCreate(
            ['short_name' => '2019'],
            [
                'name' => 'Code Petrolier 2019',
                'description' => 'Code Petrolier, CPP et JOA de 2019 du Senegal. Utilise le mecanisme R-Factor pour le partage du Profit Oil.',
                'profit_split_method' => 'r_factor',
                'royalty_oil_rates' => [
                    'onshore' => 10,
                    'offshore_peu_profond' => 9,
                    'offshore_profond' => 8,
                    'offshore_ultra_profond' => 7,
                ],
                'royalty_gas_rate' => 6,
                'cost_recovery_ceilings' => [
                    'onshore' => 55,
                    'offshore_peu_profond' => 60,
                    'offshore_profond' => 65,
                    'offshore_ultra_profond' => 70,
                ],
                'taux_is' => 30,
                'cel' => 1,
                'taxe_export' => 1,
                'wht_dividendes' => 5,
                'business_license_tax' => 0.02,
                'tva' => 18,
                'petrosen_participation_default' => 10,
                'state_participation_default' => 0,
                'depreciation_exploration' => 1,
                'depreciation_installations' => 5,
                'depreciation_pipeline_fpso' => 10,
                'nol_years' => 3,
                'is_system' => true,
            ]
        );

        // R-Factor tranches (Article 23)
        if ($code2019->tranches()->count() === 0) {
            $code2019->tranches()->createMany([
                ['order' => 1, 'threshold_max' => 1.0,       'state_share' => 40, 'contractor_share' => 60],
                ['order' => 2, 'threshold_max' => 2.0,       'state_share' => 45, 'contractor_share' => 55],
                ['order' => 3, 'threshold_max' => 3.0,       'state_share' => 55, 'contractor_share' => 45],
                ['order' => 4, 'threshold_max' => 9999999.0, 'state_share' => 60, 'contractor_share' => 40],
            ]);
        }

        // ══════════════════════════════════════════
        // Code Petrolier 1998 (CRPP & JOA)
        // ══════════════════════════════════════════
        $code1998 = PetroleumCode::firstOrCreate(
            ['short_name' => '1998'],
            [
                'name' => 'Code Petrolier 1998',
                'description' => 'Code Petrolier, CRPP et JOA de 1998 du Senegal. Utilise des tranches basees sur la production journaliere pour le partage du Profit Oil.',
                'profit_split_method' => 'production',
                'royalty_oil_rates' => [
                    'onshore' => 10,
                    'offshore_peu_profond' => 10,
                    'offshore_profond' => 10,
                    'offshore_ultra_profond' => 10,
                ],
                'royalty_gas_rate' => 5,
                'cost_recovery_ceilings' => [
                    'onshore' => 75,
                    'offshore_peu_profond' => 75,
                    'offshore_profond' => 75,
                    'offshore_ultra_profond' => 75,
                ],
                'taux_is' => 30,
                'cel' => 1,
                'taxe_export' => 0,
                'wht_dividendes' => 5,
                'business_license_tax' => 0.02,
                'tva' => 18,
                'petrosen_participation_default' => 10,
                'state_participation_default' => 0,
                'depreciation_exploration' => 1,
                'depreciation_installations' => 5,
                'depreciation_pipeline_fpso' => 10,
                'nol_years' => 3,
                'is_system' => true,
            ]
        );

        // Production-based tranches (mboed thresholds)
        if ($code1998->tranches()->count() === 0) {
            $code1998->tranches()->createMany([
                ['order' => 1, 'threshold_max' => 25000,     'state_share' => 40, 'contractor_share' => 60],
                ['order' => 2, 'threshold_max' => 50000,     'state_share' => 45, 'contractor_share' => 55],
                ['order' => 3, 'threshold_max' => 75000,     'state_share' => 50, 'contractor_share' => 50],
                ['order' => 4, 'threshold_max' => 100000,    'state_share' => 55, 'contractor_share' => 45],
                ['order' => 5, 'threshold_max' => 9999999.0, 'state_share' => 60, 'contractor_share' => 40],
            ]);
        }
    }
}
