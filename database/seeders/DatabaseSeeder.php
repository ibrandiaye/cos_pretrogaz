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
        // Phase exploration: annees 1-3, ramp-up: 4-6, plateau: 7-12, decline: 13-20
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

        // CAPEX (M$) - Gros investissement en phase exploration/developpement
        $capex = [
            1  => ['exploration' => 150, 'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 20],
            2  => ['exploration' => 80,  'development' => 350,  'pipeline_fpso' => 500,  'installations' => 200, 'divers' => 50],
            3  => ['exploration' => 30,  'development' => 600,  'pipeline_fpso' => 800,  'installations' => 350, 'divers' => 80],
            4  => ['exploration' => 0,   'development' => 200,  'pipeline_fpso' => 150,  'installations' => 100, 'divers' => 30],
            5  => ['exploration' => 0,   'development' => 50,   'pipeline_fpso' => 0,    'installations' => 30,  'divers' => 15],
            6  => ['exploration' => 0,   'development' => 20,   'pipeline_fpso' => 0,    'installations' => 15,  'divers' => 10],
            7  => ['exploration' => 0,   'development' => 10,   'pipeline_fpso' => 0,    'installations' => 10,  'divers' => 5],
            8  => ['exploration' => 0,   'development' => 10,   'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            9  => ['exploration' => 0,   'development' => 5,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            10 => ['exploration' => 0,   'development' => 5,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            11 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            12 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            13 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 5],
            14 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 5],
            15 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 5],
            16 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 5],
            17 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 3],
            18 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 3],
            19 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 2],
            20 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 50],
        ];

        // OPEX (M$) - Couts operationnels croissants avec la production
        $opex = [
            1  => ['exploitation' => 5,   'maintenance' => 2,   'location' => 0],
            2  => ['exploitation' => 10,  'maintenance' => 5,   'location' => 15],
            3  => ['exploitation' => 25,  'maintenance' => 10,  'location' => 30],
            4  => ['exploitation' => 60,  'maintenance' => 25,  'location' => 45],
            5  => ['exploitation' => 85,  'maintenance' => 35,  'location' => 50],
            6  => ['exploitation' => 95,  'maintenance' => 40,  'location' => 50],
            7  => ['exploitation' => 100, 'maintenance' => 42,  'location' => 50],
            8  => ['exploitation' => 102, 'maintenance' => 45,  'location' => 50],
            9  => ['exploitation' => 100, 'maintenance' => 45,  'location' => 50],
            10 => ['exploitation' => 98,  'maintenance' => 48,  'location' => 50],
            11 => ['exploitation' => 95,  'maintenance' => 50,  'location' => 48],
            12 => ['exploitation' => 90,  'maintenance' => 48,  'location' => 45],
            13 => ['exploitation' => 85,  'maintenance' => 45,  'location' => 42],
            14 => ['exploitation' => 80,  'maintenance' => 42,  'location' => 40],
            15 => ['exploitation' => 72,  'maintenance' => 38,  'location' => 38],
            16 => ['exploitation' => 65,  'maintenance' => 35,  'location' => 35],
            17 => ['exploitation' => 55,  'maintenance' => 30,  'location' => 30],
            18 => ['exploitation' => 45,  'maintenance' => 25,  'location' => 25],
            19 => ['exploitation' => 35,  'maintenance' => 20,  'location' => 20],
            20 => ['exploitation' => 25,  'maintenance' => 15,  'location' => 15],
        ];

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
            $p1->productions()->create(array_merge(['year' => $y], $production[$y]));
            $p1->prices()->create(array_merge(['year' => $y], $prices[$y]));
        }

        // ══════════════════════════════════════════
        // PROJET 2 : Grand Tortue Ahmeyim GTA (GNL)
        // ══════════════════════════════════════════
        $p2 = $user->projects()->create([
            'name' => 'Grand Tortue Ahmeyim (GTA)',
            'code_petrolier' => '2019',
            'duration' => 20,
            'type' => 'offshore',
            'description' => 'Projet GNL transfrontalier Senegal-Mauritanie. Production de gaz naturel et GNL. Capacite 2.5 MTPA Phase 1.',
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

        // GTA: principalement gaz + GNL
        $p2Production = [
            1  => ['oil' => 0, 'gas' => 0,    'gnl' => 0],
            2  => ['oil' => 0, 'gas' => 0,    'gnl' => 0],
            3  => ['oil' => 0, 'gas' => 0,    'gnl' => 0],
            4  => ['oil' => 0, 'gas' => 5.0,  'gnl' => 0.5],
            5  => ['oil' => 0, 'gas' => 15.0, 'gnl' => 1.5],
            6  => ['oil' => 0, 'gas' => 25.0, 'gnl' => 2.5],
            7  => ['oil' => 0, 'gas' => 28.0, 'gnl' => 2.5],
            8  => ['oil' => 0, 'gas' => 28.0, 'gnl' => 2.5],
            9  => ['oil' => 0, 'gas' => 27.0, 'gnl' => 2.5],
            10 => ['oil' => 0, 'gas' => 26.0, 'gnl' => 2.4],
            11 => ['oil' => 0, 'gas' => 25.0, 'gnl' => 2.3],
            12 => ['oil' => 0, 'gas' => 24.0, 'gnl' => 2.2],
            13 => ['oil' => 0, 'gas' => 22.0, 'gnl' => 2.0],
            14 => ['oil' => 0, 'gas' => 20.0, 'gnl' => 1.8],
            15 => ['oil' => 0, 'gas' => 18.0, 'gnl' => 1.6],
            16 => ['oil' => 0, 'gas' => 16.0, 'gnl' => 1.4],
            17 => ['oil' => 0, 'gas' => 14.0, 'gnl' => 1.2],
            18 => ['oil' => 0, 'gas' => 12.0, 'gnl' => 1.0],
            19 => ['oil' => 0, 'gas' => 10.0, 'gnl' => 0.8],
            20 => ['oil' => 0, 'gas' => 8.0,  'gnl' => 0.5],
        ];

        $p2Capex = [
            1  => ['exploration' => 120, 'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 15],
            2  => ['exploration' => 60,  'development' => 200,  'pipeline_fpso' => 400,  'installations' => 300, 'divers' => 40],
            3  => ['exploration' => 20,  'development' => 500,  'pipeline_fpso' => 900,  'installations' => 600, 'divers' => 100],
            4  => ['exploration' => 0,   'development' => 300,  'pipeline_fpso' => 200,  'installations' => 150, 'divers' => 50],
            5  => ['exploration' => 0,   'development' => 80,   'pipeline_fpso' => 50,   'installations' => 30,  'divers' => 20],
            6  => ['exploration' => 0,   'development' => 20,   'pipeline_fpso' => 0,    'installations' => 15,  'divers' => 10],
            7  => ['exploration' => 0,   'development' => 10,   'pipeline_fpso' => 0,    'installations' => 10,  'divers' => 5],
            8  => ['exploration' => 0,   'development' => 5,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            9  => ['exploration' => 0,   'development' => 5,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            10 => ['exploration' => 0,   'development' => 5,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 5],
            11 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 3],
            12 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 5,   'divers' => 3],
            13 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 3],
            14 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 3],
            15 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 3],
            16 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 3],
            17 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 2],
            18 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 2],
            19 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 2],
            20 => ['exploration' => 0,   'development' => 0,    'pipeline_fpso' => 0,    'installations' => 0,   'divers' => 30],
        ];

        $p2Opex = [
            1  => ['exploitation' => 3,   'maintenance' => 1,   'location' => 0],
            2  => ['exploitation' => 8,   'maintenance' => 3,   'location' => 10],
            3  => ['exploitation' => 15,  'maintenance' => 8,   'location' => 25],
            4  => ['exploitation' => 40,  'maintenance' => 18,  'location' => 35],
            5  => ['exploitation' => 70,  'maintenance' => 30,  'location' => 45],
            6  => ['exploitation' => 90,  'maintenance' => 38,  'location' => 50],
            7  => ['exploitation' => 95,  'maintenance' => 40,  'location' => 50],
            8  => ['exploitation' => 95,  'maintenance' => 42,  'location' => 50],
            9  => ['exploitation' => 92,  'maintenance' => 42,  'location' => 48],
            10 => ['exploitation' => 90,  'maintenance' => 40,  'location' => 48],
            11 => ['exploitation' => 85,  'maintenance' => 40,  'location' => 45],
            12 => ['exploitation' => 82,  'maintenance' => 38,  'location' => 42],
            13 => ['exploitation' => 75,  'maintenance' => 35,  'location' => 40],
            14 => ['exploitation' => 68,  'maintenance' => 32,  'location' => 38],
            15 => ['exploitation' => 60,  'maintenance' => 28,  'location' => 35],
            16 => ['exploitation' => 52,  'maintenance' => 25,  'location' => 30],
            17 => ['exploitation' => 45,  'maintenance' => 22,  'location' => 28],
            18 => ['exploitation' => 38,  'maintenance' => 18,  'location' => 22],
            19 => ['exploitation' => 30,  'maintenance' => 15,  'location' => 18],
            20 => ['exploitation' => 22,  'maintenance' => 12,  'location' => 12],
        ];

        // GTA utilise les memes prix macro
        for ($y = 1; $y <= 20; $y++) {
            $p2->capexes()->create(array_merge(['year' => $y], $p2Capex[$y]));
            $p2->opexes()->create(array_merge(['year' => $y], $p2Opex[$y]));
            $p2->productions()->create(array_merge(['year' => $y], $p2Production[$y]));
            $p2->prices()->create(array_merge(['year' => $y], $prices[$y]));
        }
    }
}
