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
            [
                'ragione_sociale' => 'D AGOSTINO',
                'p_iva' => '0000000000',
                'codice_gruppo' => 'DAGO',
            ],
            [
                'ragione_sociale' => 'PEOPLE GROUP',
                'p_iva' => '1111111111',
                'codice_gruppo' => 'PEOPLE',
            ],
            [
                'ragione_sociale' => 'GARGIULO',
                'codice_gruppo' => 'GARG',
            ],
        ];

        foreach ($holdings as $holding) {
            Holding::firstOrCreate(['ragione_sociale' => $holding['ragione_sociale']], $holding);
        }
    }
}
