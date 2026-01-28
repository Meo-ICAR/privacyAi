<?php

namespace Database\Seeders;

use App\Models\ServiziDpo;
use Illuminate\Database\Seeder;

class ServiziDpoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servizi = [
            [
                'nome' => 'Canone DPO Annuale (Piccola Impresa)',
                'stripe_price_id' => 'price_dpo_annual_small',
                'prezzo' => 1200.0,
                'tipo' => 'ricorrente',
            ],
            [
                'nome' => 'Audit Privacy Completo (Singolo)',
                'stripe_price_id' => 'price_audit_one_time',
                'prezzo' => 500.0,
                'tipo' => 'una_tantum',
            ],
            [
                'nome' => 'Supporto DPIA Specialistico',
                'stripe_price_id' => 'price_dpia_support',
                'prezzo' => 300.0,
                'tipo' => 'una_tantum',
            ],
        ];

        foreach ($servizi as $servizio) {
            ServiziDpo::firstOrCreate(['nome' => $servizio['nome']], $servizio);
        }
    }
}
