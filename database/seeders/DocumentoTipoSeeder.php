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
            [
                'nome' => 'Registro dei Trattamenti (Art. 30)',
                'categoria' => 'Privacy',
                'is_obbligatorio' => true,
                'descrizione' => "Inventario dettagliato di tutte le attività di trattamento dati svolte dall'azienda."
            ],
            [
                'nome' => 'Policy Privacy by Design e by Default',
                'categoria' => 'Sviluppo',
                'is_obbligatorio' => true,  // Obbligatorio per chi progetta software (Art. 25)
                'descrizione' => 'Linee guida interne per garantire la protezione dati sin dalla fase di progettazione del software.'
            ],
            [
                'nome' => 'Nomina a Sub-Responsabile del Trattamento',
                'categoria' => 'Privacy',
                'is_obbligatorio' => true,
                'descrizione' => 'Contratto necessario quando la software house delega servizi a terzi (es. Cloud Provider AWS/Azure).'
            ],
            [
                'nome' => 'Procedura di Gestione Data Breach',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => 'Protocollo operativo per la rilevazione e notifica di violazioni di dati personali.'
            ],
            [
                'nome' => 'Piano di Disaster Recovery e Business Continuity',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => 'Documentazione tecnica per il ripristino dei servizi software in caso di incidente critico.'
            ],
            [
                'nome' => 'DPIA - Valutazione di Impatto sulla Protezione dei Dati',
                'categoria' => 'Privacy',
                'is_obbligatorio' => false,  // Obbligatorio solo per trattamenti ad alto rischio
                'descrizione' => 'Analisi preventiva dei rischi per trattamenti di dati su larga scala o sensibili.'
            ],
            [
                'nome' => 'Informativa Privacy e Cookie Policy App/Sito',
                'categoria' => 'Compliance',
                'is_obbligatorio' => true,
                'descrizione' => 'Documento legale rivolto agli utenti finali che utilizzano le piattaforme software.'
            ],
            [
                'nome' => 'Accordo di Riservatezza (NDA) Collaboratori Esterni',
                'categoria' => 'HR/Legale',
                'is_obbligatorio' => false,
                'descrizione' => 'Contratto di non divulgazione per freelance o consulenti che accedono al codice sorgente.'
            ],
            [
                'nome' => "Policy per l'uso degli Strumenti Informatici",
                'categoria' => 'HR/Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => "Regolamento aziendale sull'utilizzo di PC, email e account aziendali da parte dei dipendenti."
            ],
            [
                'nome' => 'Policy di Log Management e Conservazione Log',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => 'Definisce quali eventi vengono registrati (accessi, modifiche), per quanto tempo e chi può consultarli.'
            ],
            [
                'nome' => 'Nomina e Registro Amministratori di Sistema',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => 'Elenco aggiornato dei tecnici con privilegi elevati e modalità di controllo del loro operato.'
            ],
            [
                'nome' => 'Procedura di Controllo Accessi Logici',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => 'Regole per l’assegnazione, revoca e monitoraggio delle credenziali di accesso ai database e ai server.'
            ],
            [
                'nome' => 'Verbale di Verifica Periodica delle Misure di Sicurezza',
                'categoria' => 'Audit',
                'is_obbligatorio' => false,
                'descrizione' => 'Esito dei test periodici per valutare l’efficacia delle misure tecniche (Vulnerability Assessment, Penetration Test).'
            ],
            [
                'nome' => 'Policy sul Monitoraggio del Traffico di Rete',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => false,
                'descrizione' => 'Informa su come vengono monitorati i flussi di dati per prevenire intrusioni o esfiltrazioni (IDS/IPS).'
            ],
            [
                'nome' => 'Registro delle Richieste degli Interessati (Diritti GDPR)',
                'categoria' => 'Privacy',
                'is_obbligatorio' => true,
                'descrizione' => 'Log delle richieste di accesso, cancellazione o portabilità ricevute dagli utenti.'
            ],
            [
                'nome' => 'Report di Monitoraggio SLA e Uptime dei Servizi',
                'categoria' => 'Compliance',
                'is_obbligatorio' => false,
                'descrizione' => 'Documentazione che attesta la disponibilità dei sistemi, fondamentale per dimostrare la resilienza (Art. 32).'
            ],
            [
                'nome' => 'Politica per la Sicurezza delle Informazioni (ISMS)',
                'categoria' => 'ISO 27001',
                'is_obbligatorio' => true,
                'descrizione' => "Documento di alto livello che definisce gli obiettivi e l'impegno della direzione verso la sicurezza."
            ],
            [
                'nome' => 'SoA - Statement of Applicability',
                'categoria' => 'ISO 27001',
                'is_obbligatorio' => true,
                'descrizione' => "Dichiarazione di Applicabilità: l'elenco dei controlli dell'Annex A applicati o esclusi con relativa motivazione."
            ],
            [
                'nome' => 'Metodologia di Valutazione del Rischio (Risk Assessment)',
                'categoria' => 'ISO 27001',
                'is_obbligatorio' => true,
                'descrizione' => "Definisce i criteri con cui l'azienda identifica e valuta i rischi per la riservatezza, integrità e disponibilità."
            ],
            [
                'nome' => 'Inventario degli Asset (Asset Inventory)',
                'categoria' => 'ISO 27001',
                'is_obbligatorio' => true,
                'descrizione' => "Censimento di hardware, software, dati e risorse umane che hanno valore per l'organizzazione."
            ],
            [
                'nome' => 'Policy di Classificazione delle Informazioni',
                'categoria' => 'ISO 27001',
                'is_obbligatorio' => true,
                'descrizione' => 'Definisce i livelli di criticità (es. Pubblico, Interno, Riservato, Segreto) e come gestirli.'
            ],
            [
                'nome' => 'Piano di Trattamento del Rischio (Risk Treatment Plan)',
                'categoria' => 'ISO 27001',
                'is_obbligatorio' => true,
                'descrizione' => 'Pianificazione delle azioni per mitigare, trasferire o accettare i rischi identificati.'
            ],
            [
                'nome' => 'Policy di Sviluppo Software Sicuro (Secure SDLC)',
                'categoria' => 'Sviluppo',
                'is_obbligatorio' => true,
                'descrizione' => 'Regole per la sicurezza nel ciclo di vita del software (codifica, test, rilascio e gestione vulnerabilità).'
            ],
            [
                'nome' => 'Procedura di Gestione degli Incidenti ISO',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => 'Sistema di segnalazione e gestione delle anomalie di sicurezza (più ampio del semplice Data Breach).'
            ],
            [
                'nome' => 'Piano di Audit Interno ISO 27001',
                'categoria' => 'Audit',
                'is_obbligatorio' => true,
                'descrizione' => 'Pianificazione delle verifiche periodiche per garantire che il sistema di gestione sia efficace e conforme.'
            ],
            [
                'nome' => 'Politica di Access Control (Clear Desk & Clear Screen)',
                'categoria' => 'Sicurezza',
                'is_obbligatorio' => true,
                'descrizione' => "Regole per l'accesso logico ai sistemi e per la sicurezza fisica delle postazioni di lavoro."
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
