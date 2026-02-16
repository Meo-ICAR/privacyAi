<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'slug' => 'scadenza-corso-formazione',
                'oggetto' => '⚠️ Scadenza Formazione Privacy: {{corso_titolo}}',
                'corpo_markdown' => "Gentile **{{nome_dipendente}}**,\n\nti informiamo che il tuo attestato relativo al corso **{{corso_titolo}}** scadrà in data **{{data_scadenza}}**.\n\nPer mantenere la conformità aziendale ai sensi del GDPR, ti invitiamo a completare il rinnovo del corso il prima possibile accedendo alla tua area riservata.\n\nCordiali saluti,\n*Team Privacy*",
                'placeholders' => ['nome_dipendente', 'corso_titolo', 'data_scadenza'],
            ],
            [
                'slug' => 'notifica-nuovo-audit',
                'oggetto' => '📌 Nuovo Audit Fornitore Pianificato: {{fornitore_nome}}',
                'corpo_markdown' => "Buongiorno,\n\nè stato pianificato un nuovo audit di controllo per il fornitore **{{fornitore_nome}}** relativo all'anno **{{anno}}**.\n\n**Dettagli Audit:**\n- Mandante: {{mandante_nome}}\n- Responsabile: {{esecutore_nome}}\n\nSi prega di preparare la documentazione necessaria.\n\nSaluti,\n*Il DPO*",
                'placeholders' => ['fornitore_nome', 'anno', 'mandante_nome', 'esecutore_nome'],
            ],
            [
                'slug' => 'conferma-pagamento-stripe',
                'oggetto' => '✅ Conferma Pagamento Servizi DPO - Fattura {{fattura_numero}}',
                'corpo_markdown' => "Gentile cliente,\n\nabbiamo ricevuto correttamente il pagamento relativo alla fattura **{{fattura_numero}}** di **{{importo}}**.\n\nPuoi scaricare il documento contabile in formato PDF direttamente dal tuo portale nella sezione 'Fatturazione'.\n\nGrazie per la collaborazione,\n*Amministrazione DPO*",
                'placeholders' => ['fattura_numero', 'importo'],
            ],
            [
                'slug' => 'alert-data-breach-interno',
                'oggetto' => '🚨 ALERT: Segnalazione potenziale Data Breach - {{mandante_nome}}',
                'corpo_markdown' => "### ATTENZIONE\n\nÈ stata registrata una segnalazione di potenziale violazione dei dati (Data Breach) per il mandante **{{mandante_nome}}**.\n\n**Descrizione preliminare:**\n{{descrizione_incidente}}\n\nÈ necessario attivare immediatamente la procedura di valutazione dell'impatto (DPIA) e verificare se sussistono gli obblighi di notifica al Garante entro 72 ore.",
                'placeholders' => ['mandante_nome', 'descrizione_incidente'],
            ],
        ];

        foreach ($templates as $template) {
            DB::table('email_templates')->updateOrInsert(
                ['slug' => $template['slug']],  // Condizione di ricerca
                [
                    // Generiamo l'ID solo se stiamo inserendo un nuovo record
                    'id' => (string) Str::ulid(),
                    'oggetto' => $template['oggetto'],
                    'corpo_markdown' => $template['corpo_markdown'],
                    // TRASFORMAZIONE MANUALE: L'array placeholders diventa una stringa JSON
                    'placeholders' => json_encode($template['placeholders']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
