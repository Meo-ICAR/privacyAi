<?php

namespace Database\Seeders;

use App\Models\Mandante;
use Illuminate\Database\Seeder;

class MandantiSeeder extends Seeder
{
    public function run()
    {
        $mandanti = [
            [
                'ragione_sociale' => 'THUNDER S.R.L.',
                'p_iva' => '08865331212',
                'stripe_prezzo_mensile' => 1050.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'NEWSENSE S.R.L.S.',
                'p_iva' => '13742821005',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '6',
            ],
            [
                'ragione_sociale' => "MR SOCIETA' A RESPONSABILITA' LIMITATA SEMPLIFICATA",
                'p_iva' => '04541290617',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => "TEAM2COM - SOCIETA' A RESPONSABILITA' LIMITATA SEMPLIFICATA",
                'p_iva' => '14717001003',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => "PROFESSIONE CREDITO AGENZIA IN ATTIVITA' FINANZIARIA S.R.L.",
                'p_iva' => '09926620965',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'RACES FINANCE S.R.L.',
                'p_iva' => '10282211001',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'HOLYDAY INVESTMENT S.R.L.',
                'p_iva' => '17373941008',
                'stripe_prezzo_mensile' => 1200.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'PEOPLE GROUP S.R.L.',
                'p_iva' => '08719101217',
                'stripe_prezzo_mensile' => 300.0,
                'periodicita' => '2',
            ],
            [
                'ragione_sociale' => 'NO&MI S.R.L.',
                'p_iva' => '02910060355',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '2',
            ],
            [
                'ragione_sociale' => 'PEOPLE S.R.L.',
                'p_iva' => '08357181216',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '2',
            ],
            [
                'ragione_sociale' => 'PALK S.R.L.',
                'p_iva' => '09816371216',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '2',
            ],
        ];

        foreach ($mandanti as $mandante) {
            Mandante::updateOrCreate(
                ['p_iva' => $mandante['p_iva']],
                [
                    'ragione_sociale' => $mandante['ragione_sociale'],
                    'titolare_trattamento' => $mandante['ragione_sociale'],
                    'stripe_prezzo_mensile' => $mandante['stripe_prezzo_mensile'],
                    'is_active' => true,
                    'periodicita' => $mandante['periodicita'],
                ]
            );
        }
    }
}
