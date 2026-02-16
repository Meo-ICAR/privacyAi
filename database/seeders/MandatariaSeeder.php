<?php

namespace Database\Seeders;

use App\Models\AziendaTipo;
use App\Models\Mandante;
use App\Models\Mandatarie;
use Illuminate\Database\Seeder;

class MandatariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mandanti = Mandante::all();
        $tipiAzienda = AziendaTipo::all();

        foreach ($mandanti as $mandante) {
            $mandatarie = [
                [
                    'mandante_id' => $mandante->id,
                    'ragione_sociale' => 'Customer Care Hub',
                    'p_iva' => '22334455667',
                    'data_ricezione_nomina' => now()->subMonths(6)->format('Y-m-d'),
                    'titolare_trattamento' => 'Franco Neri',
                    'aziendatipo_id' => $tipiAzienda->where('name', 'Media Impresa')->first()?->id,
                ],
                [
                    'mandante_id' => $mandante->id,
                    'ragione_sociale' => 'Digital Marketing Agency',
                    'p_iva' => '77889900112',
                    'data_ricezione_nomina' => now()->subMonths(2)->format('Y-m-d'),
                    'titolare_trattamento' => 'Sara Verdi',
                    'aziendatipo_id' => $tipiAzienda->where('name', 'Piccola Impresa')->first()?->id,
                ],
            ];

            foreach ($mandatarie as $mandataria) {
                Mandatarie::create($mandataria);
            }
        }
    }
}
