<?php

namespace Database\Seeders;

use App\Models\AziendaTipo;
use App\Models\Fornitori;
use App\Models\Mandante;
use App\Models\Mansioni;
use Illuminate\Database\Seeder;

class FornitoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mandanti = Mandante::all();
        $tipiAzienda = AziendaTipo::all();
        $mansioni = Mansioni::all();

        foreach ($mandanti as $mandante) {
            $fornitori = [
                [
                    'mandante_id' => $mandante->id,
                    'ragione_sociale' => 'Amazon Web Services',
                    'p_iva' => '00000000000',
                    'website' => 'https://aws.amazon.com',
                    'responsabile_trattamento' => 'Legal Department AWS',
                    'data_nomina' => now()->subYear()->format('Y-m-d'),
                    'locazione_dati' => 'USA',
                    'aziendatipo_id' => $tipiAzienda->where('name', 'Grande Impresa')->first()?->id,
                    'mansione_id' => $mansioni->first()?->id,
                ],
                [
                    'mandante_id' => $mandante->id,
                    'ragione_sociale' => 'Microsoft Azure',
                    'p_iva' => '11111111111',
                    'website' => 'https://azure.microsoft.com',
                    'responsabile_trattamento' => 'Compliance Officer Azure',
                    'data_nomina' => now()->subMonths(8)->format('Y-m-d'),
                    'locazione_dati' => 'UE',
                    'aziendatipo_id' => $tipiAzienda->where('name', 'Grande Impresa')->first()?->id,
                    'mansione_id' => $mansioni->last()?->id,
                ],
            ];

            foreach ($fornitori as $fornitore) {
                Fornitori::create($fornitore);
            }
        }
    }
}
