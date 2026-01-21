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
            'Micro Impresa',
            'Piccola Impresa',
            'Media Impresa',
            'Grande Impresa',
            'Pubblica Amministrazione',
            'Libero Professionista',
        ];

        foreach ($tipi as $tipo) {
            AziendaTipo::firstOrCreate(['name' => $tipo]);
        }
    }
}
