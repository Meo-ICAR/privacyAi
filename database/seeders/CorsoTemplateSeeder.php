<?php

namespace Database\Seeders;

use App\Models\CorsoTemplate;
use Illuminate\Database\Seeder;

class CorsoTemplateSeeder extends Seeder
{
    /**
     * Popola il catalogo dei corsi di formazione standard sulla privacy.
     */
    public function run(): void
    {
        $corsi = [
            [
                'titolo' => 'GDPR Base - Introduzione alla Protezione Dati',
                'descrizione' => "Concetti fondamentali del Regolamento UE 2016/679: figure privacy e diritti dell'interessato.",
                'validita_mesi' => 12,
                'is_obbligatorio' => true,
            ],
            [
                'titolo' => 'Privacy per Operatori Call Center',
                'descrizione' => 'Focus su script di informativa, gestione consensi telefonici e registrazioni vocali.',
                'validita_mesi' => 12,
                'is_obbligatorio' => true,
            ],
            [
                'titolo' => 'Amministratori di Sistema e Cybersecurity',
                'descrizione' => 'Misure tecniche di sicurezza, gestione log e prevenzione Data Breach (ex Art. 32).',
                'validita_mesi' => 24,
                'is_obbligatorio' => false,
            ],
            [
                'titolo' => 'Gestione dei Dati Sensibili in Ambito HR',
                'descrizione' => 'Trattamento dei dati particolari dei dipendenti (salute, sindacali, giudiziari).',
                'validita_mesi' => 12,
                'is_obbligatorio' => false,
            ],
            [
                'titolo' => 'Cybersecurity Awareness: Phishing',
                'descrizione' => 'Prevenzione attacchi di ingegneria sociale e protezione delle credenziali aziendali.',
                'validita_mesi' => 6,
                'is_obbligatorio' => true,
            ],
        ];

        foreach ($corsi as $corso) {
            CorsoTemplate::updateOrCreate(
                ['titolo' => $corso['titolo']],
                $corso
            );
        }
    }
}
