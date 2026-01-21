<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasiGiuridicheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basi = [
            [
                'nome' => 'Consenso',
                'codice' => '6.1.a',
                'descrizione' => "L'interessato ha espresso il consenso al trattamento dei propri dati personali per una o più specifiche finalità.",
                'riferimento_normativo' => 'Art. 6, par. 1, lett. a), GDPR',
            ],
            [
                'nome' => 'Contratto',
                'codice' => '6.1.b',
                'descrizione' => "Il trattamento è necessario all'esecuzione di un contratto di cui l'interessato è parte o all'esecuzione di misure precontrattuali adottate su richiesta dello stesso.",
                'riferimento_normativo' => 'Art. 6, par. 1, lett. b), GDPR',
            ],
            [
                'nome' => 'Obbligo legale',
                'codice' => '6.1.c',
                'descrizione' => "Il trattamento è necessario per adempiere un obbligo legale al quale è soggetto il titolare del trattamento.",
                'riferimento_normativo' => 'Art. 6, par. 1, lett. c), GDPR',
            ],
            [
                'nome' => 'Interessi vitali',
                'codice' => '6.1.d',
                'descrizione' => "Il trattamento è necessario per la salvaguardia degli interessi vitali dell'interessato o di un'altra persona fisica.",
                'riferimento_normativo' => 'Art. 6, par. 1, lett. d), GDPR',
            ],
            [
                'nome' => 'Interesse pubblico',
                'codice' => '6.1.e',
                'descrizione' => "Il trattamento è necessario per l'esecuzione di un compito di interesse pubblico o connesso all'esercizio di pubblici poteri di cui è investito il titolare del trattamento.",
                'riferimento_normativo' => 'Art. 6, par. 1, lett. e), GDPR',
            ],
            [
                'nome' => 'Legittimo interesse',
                'codice' => '6.1.f',
                'descrizione' => "Il trattamento è necessario per il perseguimento del legittimo interesse del titolare del trattamento o di terzi, a condizione che non prevalgano gli interessi o i diritti e le libertà fondamentali dell'interessato.",
                'riferimento_normativo' => 'Art. 6, par. 1, lett. f), GDPR',
            ],
        ];

        foreach ($basi as $base) {
            \App\Models\BasiGiuridiche::updateOrCreate(
                ['codice' => $base['codice']],
                $base
            );
        }
    }
}
