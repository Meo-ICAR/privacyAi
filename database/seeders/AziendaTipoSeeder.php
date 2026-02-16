<?php

namespace Database\Seeders;

use App\Models\AziendaTipo;
use Illuminate\Database\Seeder;

class AziendaTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipi = [
            'Albergo',
            'Call center',
            'Finanziaria',
            'List Provider',
            'Mediatore',
            'Software',
            'Subagenzia',
            'Utility',
        ];

        foreach ($tipi as $tipo) {
            AziendaTipo::firstOrCreate(['name' => $tipo]);
        }
    }
}
