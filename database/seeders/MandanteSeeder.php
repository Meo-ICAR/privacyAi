<?php

namespace Database\Seeders;

use App\Models\AziendaTipo;
use App\Models\Holding;
use App\Models\Mandante;
use Illuminate\Database\Seeder;

class MandanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holdings = Holding::all();
        $tipiAzienda = AziendaTipo::all();
        $holdingDago = Holding::where('codice_gruppo', 'DAGO')->first()->id;
        $holdingPeople = Holding::where('codice_gruppo', 'PEOPLE')->first()->id;
        $holdingGargiulo = Holding::where('codice_gruppo', 'GARG')->first()->id;

        $mandanti = [
            [
                'ragione_sociale' => 'Privacy Solutions S.r.l.',
                'p_iva' => '01234567890',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.privacysolutions.it',
                'holding_id' => $holdings->first()?->id,
                'aziendatipo_id' => $tipiAzienda->where('name', 'Piccola Impresa')->first()?->id,
            ],
            [
                'ragione_sociale' => 'Tech Innovations S.p.A.',
                'p_iva' => '09876543210',
                'titolare_trattamento' => 'Laura Bianchi',
                'email_referente' => 'laura@techinnovations.it',
                'website' => 'https://www.techinnovations.it',
                'holding_id' => $holdings->last()?->id,
                'aziendatipo_id' => $tipiAzienda->where('name', 'Media Impresa')->first()?->id,
            ],
            [
                'ragione_sociale' => 'THUNDER S.R.L.',
                'p_iva' => '08865331212',
                'titolare_trattamento' => 'Nunziata',
                'email_referente' => 'nunziata@thundersrl.it',
                'website' => 'https://www.thundersrl.it',
                'stripe_prezzo_mensile' => 1050.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'CREDIFACILE S.R.L.',
                'p_iva' => '13742821005',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.credifacile.it',
                'holding_id' => $holdingGargiulo,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '6',
            ],
            [
                'ragione_sociale' => 'HOLYDAY INVESTMENT S.R.L.',
                'p_iva' => '17373941008',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.apuliahotelroma.it/',
                'holding_id' => $holdingGargiulo,
                'stripe_prezzo_mensile' => 1200.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => "MR SOCIETA' A RESPONSABILITA' LIMITATA SEMPLIFICATA",
                'p_iva' => '04541290617',
                'titolare_trattamento' => 'Armando',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.mrsrl.it',
                'holding_id' => $holdingDago,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'INNOVATIVE',
                'p_iva' => '04541290617',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.innova-tech.cloud',
                'holding_id' => $holdingDago,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => "TEAM2COM - SOCIETA' A RESPONSABILITA' LIMITATA SEMPLIFICATA",
                'p_iva' => '14717001003',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.privacysolutions.it',
                'holding_id' => $holdingDago,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => "PROFESSIONE CREDITO AGENZIA IN ATTIVITA' FINANZIARIA S.R.L.",
                'p_iva' => '09926620965',
                'titolare_trattamento' => 'D Agostino',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.professionecredito.com',
                'holding_id' => $holdingDago,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'RACES FINANCE S.R.L.',
                'p_iva' => '10282211001',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.races.it',
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '3',
            ],
            [
                'ragione_sociale' => 'PEOPLE GROUP S.R.L.',
                'p_iva' => '08719101217',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.peoplegroupsrl.it',
                'holding_id' => $holdingPeople,
                'stripe_prezzo_mensile' => 300.0,
                'periodicita' => '2',
            ],
            [
                'ragione_sociale' => 'NO&MI S.R.L.',
                'p_iva' => '02910060355',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.noemisrls.it',
                'holding_id' => $holdingPeople,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '2',
            ],
            [
                'ragione_sociale' => 'PEOPLE S.R.L.',
                'p_iva' => '08357181216',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.peoplesrl.it',
                'holding_id' => $holdingPeople,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '2',
            ],
            [
                'ragione_sociale' => 'PALK S.R.L.',
                'p_iva' => '09816371216',
                'titolare_trattamento' => 'Gianni Rossi',
                'email_referente' => 'gianni@privacysolutions.it',
                'website' => 'https://www.palk.it',
                'holding_id' => $holdingPeople,
                'stripe_prezzo_mensile' => 600.0,
                'periodicita' => '2',
            ],
        ];

        foreach ($mandanti as $mandante) {
            Mandante::firstOrCreate(['p_iva' => $mandante['p_iva']], $mandante);
        }
    }
}
