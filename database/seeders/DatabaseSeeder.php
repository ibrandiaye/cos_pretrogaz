<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PetroleumCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Codes Petroliers ──
        $this->call(PetroleumCodeSeeder::class);
        $code2019 = PetroleumCode::where('short_name', '2019')->first();
        $code1998 = PetroleumCode::where('short_name', '1998')->first();

        // ── Utilisateur ──
        $user = User::firstOrCreate(
            ['email' => 'admin@cos-petrogaz.sn'],
            [
                'name' => 'Admin COS',
                'password' => bcrypt('password123'),
            ]
        );

        // ══════════════════════════════════════════
        // PROJET 1 : Sangomar Phase 1 (Code 2019)
        // ══════════════════════════════════════════
        $p1 = $user->projects()->create([
            'name' => 'Sangomar Phase 1',
            'code_petrolier' => '2019',
            'petroleum_code_id' => $code2019->id,
            'duration' => 20,
            'type' => 'offshore',
            'description' => 'Projet offshore profond Sangomar - Phase 1. Production de petrole brut avec capacite de 100 000 bbl/j. FPSO Leoplod Sedar Senghor.',
        ]);

        // Parametres fiscaux (Code 2019 Senegal)
        $p1->parameter()->create([
            'taux_is' => 30,
            'tva' => 18,
            'cel' => 1,
            'taxe_export' => 0,
            'wht_dividendes' => 5,
            'business_license_tax' => 0.02,
            'redevance_petrole' => 10,
            'redevance_gaz' => 5,
            'taxe_carbone' => 0,
            'petrosen_participation' => 18,
            'state_participation' => 0,
            'cost_recovery_ceiling' => 75,
            'bloc_type' => 'offshore_profond',
            'bonus_signature' => 25,
            'bonus_production' => 0,
            'petrosen_loan_amount' => 200,
            'petrosen_interest_rate' => 7,
            'petrosen_grace_period' => 3,
            'petrosen_maturity' => 10,
            'discount_rate' => 10,
            'depreciation_exploration' => 1,
            'depreciation_installations' => 5,
            'depreciation_pipeline_fpso' => 10,
            'nol_years' => 3,
            'abandonment_provision' => 0,
        ]);

        // Production en taux journaliers (comme le fichier Excel)
        // petrole_jour: mbaril/jour, gaz_domestique_jour: mmscf/jour, gnl_jour: mmscf/jour, gaz_combustible_pertes: mmscf/jour
        // Conversions depuis anciennes valeurs: petrole_jour = Mbbl_an * 1000/365, gaz_jour = Bcf_an * 1000/365
        $production = [
            1  => ['petrole_jour' => 0,      'gaz_domestique_jour' => 0,     'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            2  => ['petrole_jour' => 0,      'gaz_domestique_jour' => 0,     'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            3  => ['petrole_jour' => 13.70,  'gaz_domestique_jour' => 1.37,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            4  => ['petrole_jour' => 49.32,  'gaz_domestique_jour' => 5.48,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            5  => ['petrole_jour' => 82.19,  'gaz_domestique_jour' => 9.59,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            6  => ['petrole_jour' => 100.00, 'gaz_domestique_jour' => 11.51, 'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            7  => ['petrole_jour' => 100.00, 'gaz_domestique_jour' => 12.33, 'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            8  => ['petrole_jour' => 100.00, 'gaz_domestique_jour' => 12.33, 'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            9  => ['petrole_jour' => 98.63,  'gaz_domestique_jour' => 11.78, 'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            10 => ['petrole_jour' => 95.89,  'gaz_domestique_jour' => 10.96, 'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            11 => ['petrole_jour' => 90.41,  'gaz_domestique_jour' => 10.41, 'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            12 => ['petrole_jour' => 82.19,  'gaz_domestique_jour' => 9.59,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            13 => ['petrole_jour' => 73.97,  'gaz_domestique_jour' => 8.22,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            14 => ['petrole_jour' => 65.75,  'gaz_domestique_jour' => 7.40,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            15 => ['petrole_jour' => 57.53,  'gaz_domestique_jour' => 6.30,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            16 => ['petrole_jour' => 49.32,  'gaz_domestique_jour' => 5.48,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            17 => ['petrole_jour' => 41.10,  'gaz_domestique_jour' => 4.38,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            18 => ['petrole_jour' => 32.88,  'gaz_domestique_jour' => 3.29,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            19 => ['petrole_jour' => 24.66,  'gaz_domestique_jour' => 2.19,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
            20 => ['petrole_jour' => 16.44,  'gaz_domestique_jour' => 1.37,  'gnl_jour' => 0, 'gaz_combustible_pertes' => 0],
        ];

        // CAPEX Details (M$) - Colonnes du fichier Excel "Details Capex"
        // exploration, etudes_pre_fid, forage_completion, installations_sous_marines, pipeline, installations_surface, owners_cost, imprevus
        $capex = [
            1  => ['exploration' => 150, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 20],
            2  => ['exploration' => 80,  'etudes_pre_fid' => 50,  'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 50],
            3  => ['exploration' => 30,  'etudes_pre_fid' => 80,  'forage_completion' => 200, 'installations_sous_marines' => 180, 'pipeline' => 100, 'installations_surface' => 280, 'owners_cost' => 20, 'imprevus' => 80],
            4  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 245, 'installations_sous_marines' => 230, 'pipeline' => 121, 'installations_surface' => 357, 'owners_cost' => 25, 'imprevus' => 30],
            5  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 156, 'installations_sous_marines' => 156, 'pipeline' => 0,   'installations_surface' => 300, 'owners_cost' => 18, 'imprevus' => 15],
            6  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 10],
            7  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            8  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            9  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            10 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            11 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            12 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            13 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            14 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            15 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            16 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 5],
            17 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 3],
            18 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 3],
            19 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 2],
            20 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 50],
        ];

        // OPEX Details (M$) - Colonnes du fichier Excel "Details Opex"
        // location_flng, location_fpso, opex_puits, maintenance_installations, autres_opex
        $opex = [
            1  => ['location_flng' => 0, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 2,  'autres_opex' => 5],
            2  => ['location_flng' => 0, 'location_fpso' => 15, 'opex_puits' => 0,  'maintenance_installations' => 5,  'autres_opex' => 10],
            3  => ['location_flng' => 0, 'location_fpso' => 30, 'opex_puits' => 5,  'maintenance_installations' => 10, 'autres_opex' => 20],
            4  => ['location_flng' => 0, 'location_fpso' => 45, 'opex_puits' => 10, 'maintenance_installations' => 25, 'autres_opex' => 50],
            5  => ['location_flng' => 0, 'location_fpso' => 50, 'opex_puits' => 5,  'maintenance_installations' => 35, 'autres_opex' => 35],
            6  => ['location_flng' => 0, 'location_fpso' => 50, 'opex_puits' => 5,  'maintenance_installations' => 40, 'autres_opex' => 35],
            7  => ['location_flng' => 0, 'location_fpso' => 50, 'opex_puits' => 0,  'maintenance_installations' => 42, 'autres_opex' => 35],
            8  => ['location_flng' => 0, 'location_fpso' => 50, 'opex_puits' => 0,  'maintenance_installations' => 45, 'autres_opex' => 35],
            9  => ['location_flng' => 0, 'location_fpso' => 50, 'opex_puits' => 0,  'maintenance_installations' => 45, 'autres_opex' => 35],
            10 => ['location_flng' => 0, 'location_fpso' => 50, 'opex_puits' => 0,  'maintenance_installations' => 48, 'autres_opex' => 35],
            11 => ['location_flng' => 0, 'location_fpso' => 48, 'opex_puits' => 0,  'maintenance_installations' => 50, 'autres_opex' => 35],
            12 => ['location_flng' => 0, 'location_fpso' => 45, 'opex_puits' => 15, 'maintenance_installations' => 48, 'autres_opex' => 35],
            13 => ['location_flng' => 0, 'location_fpso' => 42, 'opex_puits' => 0,  'maintenance_installations' => 45, 'autres_opex' => 35],
            14 => ['location_flng' => 0, 'location_fpso' => 40, 'opex_puits' => 0,  'maintenance_installations' => 42, 'autres_opex' => 35],
            15 => ['location_flng' => 0, 'location_fpso' => 38, 'opex_puits' => 0,  'maintenance_installations' => 38, 'autres_opex' => 35],
            16 => ['location_flng' => 0, 'location_fpso' => 35, 'opex_puits' => 0,  'maintenance_installations' => 35, 'autres_opex' => 35],
            17 => ['location_flng' => 0, 'location_fpso' => 30, 'opex_puits' => 0,  'maintenance_installations' => 30, 'autres_opex' => 35],
            18 => ['location_flng' => 0, 'location_fpso' => 25, 'opex_puits' => 0,  'maintenance_installations' => 25, 'autres_opex' => 35],
            19 => ['location_flng' => 0, 'location_fpso' => 20, 'opex_puits' => 0,  'maintenance_installations' => 20, 'autres_opex' => 35],
            20 => ['location_flng' => 0, 'location_fpso' => 15, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 25],
        ];

        // ABEX (M$) - Couts d'abandon (tous a zero pour Sangomar Phase 1)
        $abex = [];
        for ($y = 1; $y <= 20; $y++) {
            $abex[$y] = ['cout_abandon' => 0];
        }

        // Prix macro (prix realistes avec legere inflation)
        $prices = [
            1  => ['oil_price' => 72,  'gas_price' => 3.2,  'gnl_price' => 10, 'inflation' => 2.0, 'exchange_rate' => 600],
            2  => ['oil_price' => 75,  'gas_price' => 3.4,  'gnl_price' => 10, 'inflation' => 2.1, 'exchange_rate' => 605],
            3  => ['oil_price' => 78,  'gas_price' => 3.5,  'gnl_price' => 11, 'inflation' => 2.2, 'exchange_rate' => 608],
            4  => ['oil_price' => 80,  'gas_price' => 3.6,  'gnl_price' => 11, 'inflation' => 2.0, 'exchange_rate' => 610],
            5  => ['oil_price' => 82,  'gas_price' => 3.8,  'gnl_price' => 12, 'inflation' => 2.3, 'exchange_rate' => 612],
            6  => ['oil_price' => 85,  'gas_price' => 4.0,  'gnl_price' => 12, 'inflation' => 2.1, 'exchange_rate' => 615],
            7  => ['oil_price' => 83,  'gas_price' => 3.9,  'gnl_price' => 12, 'inflation' => 2.0, 'exchange_rate' => 618],
            8  => ['oil_price' => 80,  'gas_price' => 3.7,  'gnl_price' => 11, 'inflation' => 2.2, 'exchange_rate' => 620],
            9  => ['oil_price' => 78,  'gas_price' => 3.6,  'gnl_price' => 11, 'inflation' => 2.0, 'exchange_rate' => 622],
            10 => ['oil_price' => 76,  'gas_price' => 3.5,  'gnl_price' => 11, 'inflation' => 1.8, 'exchange_rate' => 625],
            11 => ['oil_price' => 75,  'gas_price' => 3.4,  'gnl_price' => 10, 'inflation' => 2.0, 'exchange_rate' => 628],
            12 => ['oil_price' => 74,  'gas_price' => 3.3,  'gnl_price' => 10, 'inflation' => 2.1, 'exchange_rate' => 630],
            13 => ['oil_price' => 73,  'gas_price' => 3.3,  'gnl_price' => 10, 'inflation' => 2.0, 'exchange_rate' => 632],
            14 => ['oil_price' => 72,  'gas_price' => 3.2,  'gnl_price' => 10, 'inflation' => 2.2, 'exchange_rate' => 635],
            15 => ['oil_price' => 71,  'gas_price' => 3.1,  'gnl_price' => 10, 'inflation' => 2.0, 'exchange_rate' => 638],
            16 => ['oil_price' => 70,  'gas_price' => 3.0,  'gnl_price' => 10, 'inflation' => 2.1, 'exchange_rate' => 640],
            17 => ['oil_price' => 70,  'gas_price' => 3.0,  'gnl_price' => 10, 'inflation' => 2.0, 'exchange_rate' => 642],
            18 => ['oil_price' => 69,  'gas_price' => 2.9,  'gnl_price' => 9,  'inflation' => 2.0, 'exchange_rate' => 645],
            19 => ['oil_price' => 68,  'gas_price' => 2.8,  'gnl_price' => 9,  'inflation' => 2.1, 'exchange_rate' => 648],
            20 => ['oil_price' => 68,  'gas_price' => 2.8,  'gnl_price' => 9,  'inflation' => 2.0, 'exchange_rate' => 650],
        ];

        // Insert data year by year
        for ($y = 1; $y <= 20; $y++) {
            $p1->capexes()->create(array_merge(['year' => $y], $capex[$y]));
            $p1->opexes()->create(array_merge(['year' => $y], $opex[$y]));
            $p1->abexes()->create(array_merge(['year' => $y], $abex[$y]));
            $p1->productions()->create(array_merge(['year' => $y], $production[$y]));
            $p1->prices()->create(array_merge(['year' => $y], $prices[$y]));
        }

        // ══════════════════════════════════════════════════════════════════
        // PROJET 2 : Projet GNL (donnees du fichier Excel de modelisation)
        // ══════════════════════════════════════════════════════════════════
        $p2 = $user->projects()->create([
            'name' => 'Grand Tortue Ahmeyim (GTA)',
            'code_petrolier' => '2019',
            'petroleum_code_id' => $code2019->id,
            'duration' => 20,
            'type' => 'offshore',
            'description' => 'Projet GNL transfrontalier Senegal-Mauritanie. Production de gaz naturel et GNL Phase 1 (2.5 MTPA). Donnees issues du fichier Excel de modelisation.',
        ]);

        $p2->parameter()->create([
            'taux_is' => 30,
            'tva' => 18,
            'cel' => 1,
            'taxe_export' => 0,
            'wht_dividendes' => 5,
            'business_license_tax' => 0.02,
            'redevance_petrole' => 10,
            'redevance_gaz' => 5,
            'taxe_carbone' => 0,
            'petrosen_participation' => 10,
            'state_participation' => 0,
            'cost_recovery_ceiling' => 70,
            'bloc_type' => 'offshore_profond',
            'bonus_signature' => 15,
            'bonus_production' => 0,
            'petrosen_loan_amount' => 150,
            'petrosen_interest_rate' => 6.5,
            'petrosen_grace_period' => 3,
            'petrosen_maturity' => 12,
            'discount_rate' => 10,
            'depreciation_exploration' => 1,
            'depreciation_installations' => 5,
            'depreciation_pipeline_fpso' => 10,
            'nol_years' => 3,
            'abandonment_provision' => 0,
        ]);

        // Production GTA 20 ans : exploration (1-3), ramp-up (4-5), plateau GNL 2.5 MTPA (6-12), declin (13-20)
        // petrole_jour (mbaril/j), gaz_domestique_jour (mmscf/j), gnl_jour (mmscf/j), gaz_combustible_pertes (mmscf/j)
        $p2Production = [
            1  => ['petrole_jour' => 0,    'gaz_domestique_jour' => 0,   'gnl_jour' => 0,   'gaz_combustible_pertes' => 0],
            2  => ['petrole_jour' => 0,    'gaz_domestique_jour' => 0,   'gnl_jour' => 0,   'gaz_combustible_pertes' => 0],
            3  => ['petrole_jour' => 0,    'gaz_domestique_jour' => 0,   'gnl_jour' => 0,   'gaz_combustible_pertes' => 0],
            4  => ['petrole_jour' => 1.5,  'gaz_domestique_jour' => 120, 'gnl_jour' => 150, 'gaz_combustible_pertes' => 3],
            5  => ['petrole_jour' => 3,    'gaz_domestique_jour' => 250, 'gnl_jour' => 300, 'gaz_combustible_pertes' => 5],
            6  => ['petrole_jour' => 3,    'gaz_domestique_jour' => 300, 'gnl_jour' => 355, 'gaz_combustible_pertes' => 6],
            7  => ['petrole_jour' => 3,    'gaz_domestique_jour' => 300, 'gnl_jour' => 355, 'gaz_combustible_pertes' => 6],
            8  => ['petrole_jour' => 2.8,  'gaz_domestique_jour' => 300, 'gnl_jour' => 355, 'gaz_combustible_pertes' => 6],
            9  => ['petrole_jour' => 2.5,  'gaz_domestique_jour' => 290, 'gnl_jour' => 345, 'gaz_combustible_pertes' => 6],
            10 => ['petrole_jour' => 2.2,  'gaz_domestique_jour' => 280, 'gnl_jour' => 335, 'gaz_combustible_pertes' => 5],
            11 => ['petrole_jour' => 2,    'gaz_domestique_jour' => 270, 'gnl_jour' => 320, 'gaz_combustible_pertes' => 5],
            12 => ['petrole_jour' => 1.8,  'gaz_domestique_jour' => 255, 'gnl_jour' => 300, 'gaz_combustible_pertes' => 5],
            13 => ['petrole_jour' => 1.5,  'gaz_domestique_jour' => 235, 'gnl_jour' => 275, 'gaz_combustible_pertes' => 4],
            14 => ['petrole_jour' => 1.2,  'gaz_domestique_jour' => 210, 'gnl_jour' => 245, 'gaz_combustible_pertes' => 4],
            15 => ['petrole_jour' => 1,    'gaz_domestique_jour' => 185, 'gnl_jour' => 215, 'gaz_combustible_pertes' => 3],
            16 => ['petrole_jour' => 0.8,  'gaz_domestique_jour' => 160, 'gnl_jour' => 185, 'gaz_combustible_pertes' => 3],
            17 => ['petrole_jour' => 0.6,  'gaz_domestique_jour' => 135, 'gnl_jour' => 155, 'gaz_combustible_pertes' => 2],
            18 => ['petrole_jour' => 0.4,  'gaz_domestique_jour' => 110, 'gnl_jour' => 125, 'gaz_combustible_pertes' => 2],
            19 => ['petrole_jour' => 0.2,  'gaz_domestique_jour' => 85,  'gnl_jour' => 95,  'gaz_combustible_pertes' => 1],
            20 => ['petrole_jour' => 0.1,  'gaz_domestique_jour' => 60,  'gnl_jour' => 65,  'gaz_combustible_pertes' => 1],
        ];

        // CAPEX Details GTA 20 ans : exploration (1-2), etudes+FID (3), construction (4-5), maintenance (6+)
        $p2Capex = [
            1  => ['exploration' => 80,  'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 10],
            2  => ['exploration' => 120, 'etudes_pre_fid' => 30,  'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 15],
            3  => ['exploration' => 0,   'etudes_pre_fid' => 110, 'forage_completion' => 80,  'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 10, 'imprevus' => 20],
            4  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 245, 'installations_sous_marines' => 230, 'pipeline' => 121, 'installations_surface' => 357, 'owners_cost' => 25, 'imprevus' => 50],
            5  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 120, 'installations_sous_marines' => 156, 'pipeline' => 450, 'installations_surface' => 300, 'owners_cost' => 18, 'imprevus' => 40],
            6  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 20,  'owners_cost' => 0,  'imprevus' => 10],
            7  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 15,  'owners_cost' => 0,  'imprevus' => 8],
            8  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 10,  'owners_cost' => 0,  'imprevus' => 5],
            9  => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 10,  'owners_cost' => 0,  'imprevus' => 5],
            10 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 8,   'owners_cost' => 0,  'imprevus' => 5],
            11 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 5,   'owners_cost' => 0,  'imprevus' => 3],
            12 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 30,  'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 5,   'owners_cost' => 0,  'imprevus' => 3],
            13 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 5,   'owners_cost' => 0,  'imprevus' => 3],
            14 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 5,   'owners_cost' => 0,  'imprevus' => 3],
            15 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 3,   'owners_cost' => 0,  'imprevus' => 2],
            16 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 3,   'owners_cost' => 0,  'imprevus' => 2],
            17 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 3,   'owners_cost' => 0,  'imprevus' => 2],
            18 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 2,   'owners_cost' => 0,  'imprevus' => 2],
            19 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 2,   'owners_cost' => 0,  'imprevus' => 2],
            20 => ['exploration' => 0,   'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 2,   'owners_cost' => 0,  'imprevus' => 2],
        ];

        // OPEX Details GTA 20 ans : location FLNG commence a la production, augmente puis stabilise
        $p2Opex = [
            1  => ['location_flng' => 0,   'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 5],
            2  => ['location_flng' => 0,   'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 8],
            3  => ['location_flng' => 0,   'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 5,  'autres_opex' => 12],
            4  => ['location_flng' => 80,  'location_fpso' => 0,  'opex_puits' => 5,  'maintenance_installations' => 15, 'autres_opex' => 30],
            5  => ['location_flng' => 120, 'location_fpso' => 0,  'opex_puits' => 5,  'maintenance_installations' => 20, 'autres_opex' => 40],
            6  => ['location_flng' => 130, 'location_fpso' => 0,  'opex_puits' => 5,  'maintenance_installations' => 22, 'autres_opex' => 45],
            7  => ['location_flng' => 130, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 25, 'autres_opex' => 45],
            8  => ['location_flng' => 130, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 25, 'autres_opex' => 45],
            9  => ['location_flng' => 130, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 25, 'autres_opex' => 42],
            10 => ['location_flng' => 125, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 25, 'autres_opex' => 40],
            11 => ['location_flng' => 120, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 22, 'autres_opex' => 38],
            12 => ['location_flng' => 115, 'location_fpso' => 0,  'opex_puits' => 15, 'maintenance_installations' => 22, 'autres_opex' => 38],
            13 => ['location_flng' => 108, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 20, 'autres_opex' => 35],
            14 => ['location_flng' => 100, 'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 20, 'autres_opex' => 32],
            15 => ['location_flng' => 90,  'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 18, 'autres_opex' => 30],
            16 => ['location_flng' => 80,  'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 18, 'autres_opex' => 28],
            17 => ['location_flng' => 70,  'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 25],
            18 => ['location_flng' => 60,  'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 12, 'autres_opex' => 22],
            19 => ['location_flng' => 50,  'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 10, 'autres_opex' => 18],
            20 => ['location_flng' => 40,  'location_fpso' => 0,  'opex_puits' => 0,  'maintenance_installations' => 8,  'autres_opex' => 15],
        ];

        // ABEX GTA : provision d'abandon en fin de vie (annees 19-20)
        $p2Abex = [
            1  => ['cout_abandon' => 0], 2  => ['cout_abandon' => 0], 3  => ['cout_abandon' => 0],
            4  => ['cout_abandon' => 0], 5  => ['cout_abandon' => 0], 6  => ['cout_abandon' => 0],
            7  => ['cout_abandon' => 0], 8  => ['cout_abandon' => 0], 9  => ['cout_abandon' => 0],
            10 => ['cout_abandon' => 0], 11 => ['cout_abandon' => 0], 12 => ['cout_abandon' => 0],
            13 => ['cout_abandon' => 0], 14 => ['cout_abandon' => 0], 15 => ['cout_abandon' => 0],
            16 => ['cout_abandon' => 0], 17 => ['cout_abandon' => 0], 18 => ['cout_abandon' => 0],
            19 => ['cout_abandon' => 50], 20 => ['cout_abandon' => 150],
        ];

        // Prix macro GTA 20 ans
        for ($y = 1; $y <= 20; $y++) {
            $p2Prices[$y] = $prices[$y];
        }

        for ($y = 1; $y <= 20; $y++) {
            $p2->capexes()->create(array_merge(['year' => $y], $p2Capex[$y]));
            $p2->opexes()->create(array_merge(['year' => $y], $p2Opex[$y]));
            $p2->abexes()->create(array_merge(['year' => $y], $p2Abex[$y]));
            $p2->productions()->create(array_merge(['year' => $y], $p2Production[$y]));
            $p2->prices()->create(array_merge(['year' => $y], $p2Prices[$y]));
        }
    }
}
