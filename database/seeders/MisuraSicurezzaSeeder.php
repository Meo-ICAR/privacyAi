<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MisuraSicurezzaSeeder extends Seeder
{
    public function run(): void
    {
        $misure = [
            [
                'codice' => 'TEC-01',
                'nome' => 'Crittografia dei dati a riposo',
                'tipo' => 'Tecnica',
                'area' => 'Protezione Dati',
                'descrizione' => 'Utilizzo di algoritmi robusti (AES-256) per i dati salvati su disco.'
            ],
            [
                'codice' => 'TEC-02',
                'nome' => 'Autenticazione a due fattori (MFA)',
                'tipo' => 'Tecnica',
                'area' => 'Controllo Accessi',
                'descrizione' => 'Accesso ai sistemi critici subordinato a secondo fattore di verifica.'
            ],
            [
                'codice' => 'ORG-01',
                'nome' => 'Policy di Password Aziendale',
                'tipo' => 'Organizzativa',
                'area' => 'Gestione Identità',
                'descrizione' => 'Regole su complessità e rotazione periodica delle password.'
            ],
            [
                'codice' => 'TEC-03',
                'nome' => 'Backup e Disaster Recovery',
                'tipo' => 'Tecnica',
                'area' => 'Continuità Operativa',
                'descrizione' => 'Salvataggio periodico dei dati e test di ripristino documentati.'
            ],
            [
                'codice' => 'ORG-02',
                'nome' => 'Piano di Formazione Privacy',
                'tipo' => 'Organizzativa',
                'area' => 'Consapevolezza',
                'descrizione' => 'Erogazione periodica di corsi ai dipendenti autorizzati.'
            ],
        ];

        foreach ($misure as $m) {
            DB::table('misura_sicurezza')->updateOrInsert(
                ['codice' => $m['codice']],  // 1. Condizione di ricerca (Trovalo tramite codice)
                array_merge(
                    [
                        'id' => (string) Str::ulid(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ],
                    $m
                )  // 2. Dati da inserire o aggiornare
            );
        }
    }
}
