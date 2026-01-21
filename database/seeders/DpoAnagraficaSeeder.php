<?php

namespace Database\Seeders;

use App\Models\DpoAnagrafica;
use Illuminate\Database\Seeder;

class DpoAnagraficaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DpoAnagrafica::create([
            'denominazione' => 'Studio Legale Privacy Pro',
            'partita_iva' => '01122334455',
            'email_ordinaria' => 'info@privacypro.it',
            'email_pec' => 'privacypro@legalmail.it',
            'telefono' => '021234567',
            'indirizzo' => 'Via Roma 1',
            'cap' => '20121',
            'citta' => 'Milano',
            'provincia' => 'MI',
            'certificazioni' => 'DPO Certificato UNI 11697',
            'is_persona_giuridica' => true,
        ]);

        DpoAnagrafica::create([
            'denominazione' => 'Dott. Alessandro Verdi',
            'codice_fiscale' => 'VRDLSN70A01H501W',
            'email_ordinaria' => 'alessandro.verdi@dpo.it',
            'telefono' => '069876543',
            'indirizzo' => 'Via Napoli 10',
            'cap' => '00184',
            'citta' => 'Roma',
            'provincia' => 'RM',
            'certificazioni' => 'Lead Auditor ISO 27001',
            'is_persona_giuridica' => false,
        ]);
    }
}
