<?php

namespace Database\Seeders;

use App\Models\Mansione;
use Illuminate\Database\Seeder;

class MansioneSeeder extends Seeder
{
    /**
     * Esegue il popolamento della tabella mansioni.
     * Questa tabella è globale e condivisa tra tutti i mandanti/tenant.
     */
    public function run(): void
    {
        $mansioni = [
            [
                'nome' => 'Operatore Call Center',
                'livello_rischio' => 'medio',
                'descrizione' => 'Addetto alla gestione contatti telefonici e trattamento dati comuni/registrazioni.'
            ],
            [
                'nome' => 'HR / Amministrazione',
                'livello_rischio' => 'alto',
                'descrizione' => 'Gestione dati sensibili, giudiziari e contrattualistica dipendenti.'
            ],
            [
                'nome' => 'Sistemista IT / Amministratore di Sistema',
                'livello_rischio' => 'alto',
                'descrizione' => 'Accesso privilegiato alle infrastrutture, database e gestione sicurezza informatica.'
            ],
            [
                'nome' => 'Sales / Marketing',
                'livello_rischio' => 'medio',
                'descrizione' => 'Gestione lead, potenziali clienti e consensi per finalità promozionali.'
            ],
            [
                'nome' => 'DPO (Data Protection Officer)',
                'livello_rischio' => 'alto',
                'descrizione' => 'Monitoraggio della conformità e consulenza in materia di protezione dati.'
            ],
            [
                'nome' => 'Reception / Segreteria',
                'livello_rischio' => 'basso',
                'descrizione' => 'Accoglienza e gestione flussi documentali generici.'
            ],
            [
                'nome' => 'Logistica / Manutenzione',
                'livello_rischio' => 'basso',
                'descrizione' => 'Personale operativo senza accesso diretto ai sistemi informativi aziendali.'
            ],
        ];

        foreach ($mansioni as $mansione) {
            // Utilizziamo updateOrCreate per evitare duplicati in caso di esecuzioni multiple
            Mansione::updateOrCreate(
                ['nome' => $mansione['nome']],
                $mansione
            );
        }
    }
}
