<?php

namespace Database\Seeders;

use App\Models\Filiali;
use App\Models\Mandante;
use Illuminate\Database\Seeder;

class FilialiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mandanti = Mandante::all();

        foreach ($mandanti as $mandante) {
            $filiali = [
                [
                    'nome' => 'Sede Centrale - ' . $mandante->ragione_sociale,
                    'indirizzo' => 'Via delle Industrie 1',
                    'citta' => 'Roma',
                    'codice_sede' => 'CENTRO-01',
                    'mandante_id' => $mandante->id,
                ],
                [
                    'nome' => 'Ufficio Operativo Nord',
                    'indirizzo' => 'Piazza Duomo 10',
                    'citta' => 'Milano',
                    'codice_sede' => 'NORD-02',
                    'mandante_id' => $mandante->id,
                ],
            ];

            foreach ($filiali as $filiale) {
                Filiali::create($filiale);
            }
        }
    }
}
