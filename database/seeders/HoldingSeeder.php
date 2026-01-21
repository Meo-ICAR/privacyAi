<?php

namespace Database\Seeders;

use App\Models\Holding;
use Illuminate\Database\Seeder;

class HoldingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holdings = [
            [
                'ragione_sociale' => 'Global Services Holding S.p.A.',
                'p_iva' => '12345678901',
                'codice_gruppo' => 'GSH-001',
            ],
            [
                'ragione_sociale' => 'Future Tech Ventures Ltd',
                'p_iva' => '98765432109',
                'codice_gruppo' => 'FTV-002',
            ],
        ];

        foreach ($holdings as $holding) {
            Holding::firstOrCreate(['p_iva' => $holding['p_iva']], $holding);
        }
    }
}
