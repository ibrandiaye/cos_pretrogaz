<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
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
            'redevance_petrole' => 10,
            'redevance_gaz' => 5,
            'taxe_carbone' => 0,
            'petrosen_participation' => 18,
            'state_participation' => 0,
            'cost_recovery_ceiling' => 75,
            'bonus_signature' => 25,
            'bonus_production' => 0,
            'petrosen_loan_amount' => 200,
            'petrosen_interest_rate' => 7,
            'petrosen_grace_period' => 3,
            'petrosen_maturity' => 10,
            'discount_rate' => 10,
        ]);

        // Production (Mbbl/an pour petrole, Bcf/an pour gaz, MT/an pour GNL)
        $production = [
            1  => ['oil' => 0,     'gas' => 0,    'gnl' => 0],
            2  => ['oil' => 0,     'gas' => 0,    'gnl' => 0],
            3  => ['oil' => 5.0,   'gas' => 0.5,  'gnl' => 0],
            4  => ['oil' => 18.0,  'gas' => 2.0,  'gnl' => 0],
            5  => ['oil' => 30.0,  'gas' => 3.5,  'gnl' => 0],
            6  => ['oil' => 36.5,  'gas' => 4.2,  'gnl' => 0],
            7  => ['oil' => 36.5,  'gas' => 4.5,  'gnl' => 0],
            8  => ['oil' => 36.5,  'gas' => 4.5,  'gnl' => 0],
            9  => ['oil' => 36.0,  'gas' => 4.3,  'gnl' => 0],
            10 => ['oil' => 35.0,  'gas' => 4.0,  'gnl' => 0],
            11 => ['oil' => 33.0,  'gas' => 3.8,  'gnl' => 0],
            12 => ['oil' => 30.0,  'gas' => 3.5,  'gnl' => 0],
            13 => ['oil' => 27.0,  'gas' => 3.0,  'gnl' => 0],
            14 => ['oil' => 24.0,  'gas' => 2.7,  'gnl' => 0],
            15 => ['oil' => 21.0,  'gas' => 2.3,  'gnl' => 0],
            16 => ['oil' => 18.0,  'gas' => 2.0,  'gnl' => 0],
            17 => ['oil' => 15.0,  'gas' => 1.6,  'gnl' => 0],
            18 => ['oil' => 12.0,  'gas' => 1.2,  'gnl' => 0],
            19 => ['oil' => 9.0,   'gas' => 0.8,  'gnl' => 0],
            20 => ['oil' => 6.0,   'gas' => 0.5,  'gnl' => 0],
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
            'duration' => 30,
            'type' => 'offshore',
            'description' => 'Projet GNL transfrontalier Senegal-Mauritanie. Production de gaz naturel et GNL. Donnees issues du fichier Excel de modelisation.',
        ]);

        $p2->parameter()->create([
            'taux_is' => 30,
            'tva' => 18,
            'cel' => 1,
            'taxe_export' => 0,
            'redevance_petrole' => 10,
            'redevance_gaz' => 5,
            'taxe_carbone' => 0,
            'petrosen_participation' => 10,
            'state_participation' => 0,
            'cost_recovery_ceiling' => 70,
            'bonus_signature' => 15,
            'bonus_production' => 0,
            'petrosen_loan_amount' => 150,
            'petrosen_interest_rate' => 6.5,
            'petrosen_grace_period' => 3,
            'petrosen_maturity' => 12,
            'discount_rate' => 10,
        ]);

        // Production du fichier Excel "Calcul production" (30 ans)
        // Petrole (Mbbl/an), Gaz domestique (Tbtu/an → Bcf), GNL (MTPA)
        $p2Production = [
            1  => ['oil' => 1.095,  'gas' => 116.62, 'gnl' => 2.113],
            2  => ['oil' => 0.73,   'gas' => 97.18,  'gnl' => 1.761],
            3  => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            4  => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            5  => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            6  => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            7  => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            8  => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            9  => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            10 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            11 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            12 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            13 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            14 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            15 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            16 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            17 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            18 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            19 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            20 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            21 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            22 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            23 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            24 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            25 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            26 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            27 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            28 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            29 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
            30 => ['oil' => 0,      'gas' => 0,      'gnl' => 0],
        ];

        // CAPEX Details du fichier Excel "Details Capex" (30 ans)
        $p2Capex = [
            1  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            2  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            3  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            4  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            5  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            6  => ['exploration' => 0, 'etudes_pre_fid' => 110, 'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            7  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 245, 'installations_sous_marines' => 230, 'pipeline' => 121, 'installations_surface' => 357, 'owners_cost' => 25, 'imprevus' => 0],
            8  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 156, 'pipeline' => 450, 'installations_surface' => 300, 'owners_cost' => 18, 'imprevus' => 0],
            9  => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            10 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            11 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            12 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            13 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            14 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            15 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            16 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            17 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            18 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            19 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            20 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            21 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            22 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            23 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            24 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            25 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            26 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            27 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            28 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            29 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
            30 => ['exploration' => 0, 'etudes_pre_fid' => 0,   'forage_completion' => 0,   'installations_sous_marines' => 0,   'pipeline' => 0,   'installations_surface' => 0,   'owners_cost' => 0,  'imprevus' => 0],
        ];

        // OPEX Details du fichier Excel "Details Opex" (30 ans)
        $p2Opex = [
            1  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            2  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            3  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            4  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            5  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 5,  'maintenance_installations' => 15, 'autres_opex' => 35],
            6  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 5,  'maintenance_installations' => 15, 'autres_opex' => 35],
            7  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            8  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            9  => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            10 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            11 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            12 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 15, 'maintenance_installations' => 15, 'autres_opex' => 35],
            13 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            14 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            15 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            16 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            17 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            18 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            19 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            20 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 15, 'autres_opex' => 35],
            21 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            22 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            23 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            24 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            25 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            26 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            27 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            28 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            29 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
            30 => ['location_flng' => 0, 'location_fpso' => 0, 'opex_puits' => 0,  'maintenance_installations' => 0,  'autres_opex' => 0],
        ];

        // ABEX du fichier Excel "Details Abex" (tous a zero)
        $p2Abex = [];
        for ($y = 1; $y <= 30; $y++) {
            $p2Abex[$y] = ['cout_abandon' => 0];
        }

        // Prix macro pour GTA (30 ans)
        $p2Prices = [];
        for ($y = 1; $y <= 30; $y++) {
            $baseYear = min($y, 20);
            $p2Prices[$y] = $prices[$baseYear] ?? [
                'oil_price' => 68, 'gas_price' => 2.8, 'gnl_price' => 9, 'inflation' => 2.0, 'exchange_rate' => 650,
            ];
        }

        for ($y = 1; $y <= 30; $y++) {
            $p2->capexes()->create(array_merge(['year' => $y], $p2Capex[$y]));
            $p2->opexes()->create(array_merge(['year' => $y], $p2Opex[$y]));
            $p2->abexes()->create(array_merge(['year' => $y], $p2Abex[$y]));
            $p2->productions()->create(array_merge(['year' => $y], $p2Production[$y]));
            $p2->prices()->create(array_merge(['year' => $y], $p2Prices[$y]));
        }
    }
}
