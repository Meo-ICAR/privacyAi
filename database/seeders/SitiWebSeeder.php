<?php

namespace Database\Seeders;

use App\Models\Mandante;
use App\Models\SitiWeb;
use Illuminate\Database\Seeder;

class SitiWebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mandanti = Mandante::all();

        foreach ($mandanti as $mandante) {
            $siti = [
                [
                    'mandante_id' => $mandante->id,
                    'url' => $mandante->website,
                    'nome_progetto' => 'Sito Istituzionale',
                    'tipo' => 'istituzionale',
                    'has_cookie_policy' => true,
                    'has_privacy_policy' => true,
                    'hosting_provider' => 'AWS',
                ],
                [
                    'mandante_id' => $mandante->id,
                    'url' => $mandante->website . '/shop',
                    'nome_progetto' => 'E-commerce Store',
                    'tipo' => 'ecommerce',
                    'has_cookie_policy' => true,
                    'has_privacy_policy' => true,
                    'hosting_provider' => 'Aruba',
                ],
            ];

            foreach ($siti as $sito) {
                SitiWeb::create($sito);
            }
        }
    }
}
