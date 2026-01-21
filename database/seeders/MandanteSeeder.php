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
        ];

        foreach ($mandanti as $mandante) {
            Mandante::firstOrCreate(['p_iva' => $mandante['p_iva']], $mandante);
        }
    }
}
