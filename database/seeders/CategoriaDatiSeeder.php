<?php

namespace Database\Seeders;

use App\Models\CategoriaDati;
use Illuminate\Database\Seeder;

class CategoriaDatiSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $categorie = [
            // Dati Ordinari
            [
                'nome' => 'Dati Anagrafici',
                'descrizione' => 'Nome, cognome, data di nascita, luogo di nascita, codice fiscale',
                'tipo' => 'ordinari',
            ],
            [
                'nome' => 'Dati di Contatto',
                'descrizione' => 'Indirizzo email, numero di telefono, indirizzo postale',
                'tipo' => 'ordinari',
            ],
            [
                'nome' => 'Dati Economici',
                'descrizione' => 'Dati bancari, IBAN, informazioni di pagamento',
                'tipo' => 'ordinari',
            ],
            [
                'nome' => 'Dati di Navigazione',
                'descrizione' => 'Indirizzo IP, cookie, log di accesso',
                'tipo' => 'ordinari',
            ],
            [
                'nome' => 'Dati Professionali',
                'descrizione' => 'Titolo di studio, esperienza lavorativa, CV',
                'tipo' => 'ordinari',
            ],

            // Dati Particolari (Art. 9 GDPR)
            [
                'nome' => 'Dati Sanitari',
                'descrizione' => 'Stato di salute, diagnosi mediche, terapie',
                'tipo' => 'particolari',
            ],
            [
                'nome' => 'Dati Biometrici',
                'descrizione' => 'Impronte digitali, riconoscimento facciale, iris',
                'tipo' => 'particolari',
            ],
            [
                'nome' => 'Dati Genetici',
                'descrizione' => 'DNA, informazioni ereditarie',
                'tipo' => 'particolari',
            ],
            [
                'nome' => 'Origine Etnica',
                'descrizione' => 'Dati relativi all\'origine razziale o etnica',
                'tipo' => 'particolari',
            ],
            [
                'nome' => 'Opinioni Politiche',
                'descrizione' => 'Appartenenza a partiti, orientamento politico',
                'tipo' => 'particolari',
            ],
            [
                'nome' => 'Convinzioni Religiose',
                'descrizione' => 'Fede religiosa, appartenenza a comunità religiose',
                'tipo' => 'particolari',
            ],
            [
                'nome' => 'Orientamento Sessuale',
                'descrizione' => 'Dati relativi alla vita sessuale o all\'orientamento sessuale',
                'tipo' => 'particolari',
            ],

            // Dati Giudiziari (Art. 10 GDPR)
            [
                'nome' => 'Condanne Penali',
                'descrizione' => 'Sentenze di condanna, casellario giudiziale',
                'tipo' => 'giudiziari',
            ],
            [
                'nome' => 'Reati',
                'descrizione' => 'Dati relativi a reati o misure di sicurezza',
                'tipo' => 'giudiziari',
            ],
        ];

        foreach ($categorie as $categoria) {
            CategoriaDati::create($categoria);
        }
    }
}
