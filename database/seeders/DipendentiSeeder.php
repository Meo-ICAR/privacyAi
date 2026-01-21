<?php

namespace Database\Seeders;

use App\Models\Dipendenti;
use App\Models\Filiali;
use App\Models\Mandante;
use App\Models\Mansioni;
use Illuminate\Database\Seeder;

class DipendentiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mandanti = Mandante::with('filiali')->get();
        $mansioni = Mansioni::all();

        foreach ($mandanti as $mandante) {
            $filiale = $mandante->filiali->first();

            $dipendenti = [
                [
                    'nome' => 'Marco',
                    'cognome' => 'Scola',
                    'codice_fiscale' => 'SCLMRC80A01H501U',
                    'email_aziendale' => 'm.scola@' . parse_url($mandante->website, PHP_URL_HOST),
                    'mansione_id' => $mansioni->first()?->id,
                    'is_active' => true,
                    'mandante_id' => $mandante->id,
                    'filiale_id' => $filiale?->id,
                    'data_assunzione' => now()->subYears(3)->format('Y-m-d'),
                ],
                [
                    'nome' => 'Elena',
                    'cognome' => 'Galli',
                    'codice_fiscale' => 'GLLLEN85B41H501V',
                    'email_aziendale' => 'e.galli@' . parse_url($mandante->website, PHP_URL_HOST),
                    'mansione_id' => $mansioni->last()?->id,
                    'is_active' => true,
                    'mandante_id' => $mandante->id,
                    'filiale_id' => $filiale?->id,
                    'data_assunzione' => now()->subYears(1)->format('Y-m-d'),
                ],
            ];

            foreach ($dipendenti as $dipendente) {
                Dipendenti::create($dipendente);
            }
        }
    }
}
