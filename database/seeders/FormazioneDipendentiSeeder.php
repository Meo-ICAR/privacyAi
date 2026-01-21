<?php

namespace Database\Seeders;

use App\Models\CorsoTemplate;
use App\Models\Dipendenti;
use App\Models\FormazioneDipendenti;
use Illuminate\Database\Seeder;

class FormazioneDipendentiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dipendenti = Dipendenti::all();
        $corsi = CorsoTemplate::all();

        foreach ($dipendenti as $dipendente) {
            $corso = $corsi->random();

            FormazioneDipendenti::create([
                'mandante_id' => $dipendente->mandante_id,
                'dipendente_id' => $dipendente->id,
                'corso_template_id' => $corso->id,
                'data_conseguimento' => now()->subMonths(3)->format('Y-m-d'),
                'data_scadenza' => now()->addMonths(9)->format('Y-m-d'),
                'stato' => 'valido',
            ]);
        }
    }
}
