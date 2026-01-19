<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentoTipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipi = [
            [
                'nome' => 'Atto di Nomina a Responsabile (Art. 28)',
                'categoria' => 'Privacy',
                'is_obbligatorio' => true,
                'descrizione' => 'Contratto tra Titolare e Responsabile.'
            ],
            [
                'nome' => 'Informativa e Consenso Dipendente',
                'categoria' => 'HR',
                'is_obbligatorio' => true,
            ],
            [
                'nome' => 'Attestato di Formazione',
                'categoria' => 'Formazione',
                'is_obbligatorio' => true,
            ],
            [
                'nome' => 'Lettera di Incarico Autorizzato',
                'categoria' => 'Privacy',
                'is_obbligatorio' => true,
            ],
            [
                'nome' => 'Nomina Amministratore di Sistema',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => false,
            ],
            [
                'nome' => 'Verbale di Audit',
                'categoria' => 'Audit',
                'is_obbligatorio' => false,
            ],
        ];

        foreach ($tipi as $tipo) {
            DB::table('documenti_tipo')->updateOrInsert(
                ['slug' => Str::slug($tipo['nome'])],
                array_merge($tipo, [
                    'id' => (string) Str::ulid(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
