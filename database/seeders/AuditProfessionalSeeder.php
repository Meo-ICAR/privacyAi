<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuditProfessionalSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Governance e Compliance' => [
                ['domanda' => 'Il fornitore ha nominato un DPO (Data Protection Officer)?', 'ref' => 'GDPR Art. 37', 'critica' => false, 'peso' => 2],
                ['domanda' => 'Esiste un Registro dei Trattamenti ex Art. 30 regolarmente aggiornato?', 'ref' => 'GDPR Art. 30', 'critica' => true, 'peso' => 4],
                ['domanda' => 'Viene effettuata una DPIA per i trattamenti ad alto rischio?', 'ref' => 'GDPR Art. 35', 'critica' => true, 'peso' => 5],
            ],
            'Sicurezza Logica e Accessi' => [
                ['domanda' => 'È implementato il principio del "Least Privilege" per gli admin?', 'ref' => 'ISO 27001 A.9', 'critica' => true, 'peso' => 3],
                ['domanda' => 'Vengono loggati tutti gli accessi ai dati personali (Audit Log)?', 'ref' => 'GDPR Art. 32', 'critica' => true, 'peso' => 4],
                ['domanda' => 'Esiste una policy di disattivazione immediata degli account ex-dipendenti?', 'ref' => 'ISO 27001 A.8', 'critica' => false, 'peso' => 2],
            ],
            'Resilienza e Disaster Recovery' => [
                ['domanda' => 'I backup sono immutabili o protetti da Ransomware?', 'ref' => 'NIST CSF', 'critica' => true, 'peso' => 5],
                ['domanda' => 'Esiste un piano di Business Continuity testato negli ultimi 12 mesi?', 'ref' => 'ISO 22301', 'critica' => false, 'peso' => 3],
                ['domanda' => 'Il RTO (Recovery Time Objective) è compatibile con le esigenze del Titolare?', 'ref' => 'SLA', 'critica' => false, 'peso' => 2],
            ],
            'Sviluppo Software (SDLC)' => [
                ['domanda' => 'Vengono eseguiti Vulnerability Assessment / Penetration Test periodici?', 'ref' => 'OWASP Top 10', 'critica' => true, 'peso' => 4],
                ['domanda' => 'Il codice viene scansionato per vulnerabilità note (SAST/DAST)?', 'ref' => 'Cyber Resilience Act', 'critica' => false, 'peso' => 3],
                ['domanda' => 'Viene utilizzata la pseudonimizzazione nei database di test/staging?', 'ref' => 'GDPR Art. 25', 'critica' => true, 'peso' => 4],
            ],
            'Gestione Sub-Responsabili' => [
                ['domanda' => "L'elenco dei sub-responsabili (Sub-processors) è pubblico o notificato?", 'ref' => 'GDPR Art. 28', 'critica' => true, 'peso' => 4],
                ['domanda' => 'Il fornitore impone ai sub-responsabili gli stessi obblighi contrattuali?', 'ref' => 'GDPR Art. 28(4)', 'critica' => true, 'peso' => 5],
            ],
            'Protezione Fisica e Ambientale' => [
                ['domanda' => 'Il Data Center dispone di sistemi di protezione antincendio e controllo allagamento?', 'ref' => 'ISO 27001 A.11', 'critica' => false, 'peso' => 2],
                ['domanda' => "L'accesso fisico ai server è limitato al personale autorizzato e loggato?", 'ref' => 'ISO 27001 A.11.1', 'critica' => true, 'peso' => 3],
                ['domanda' => 'Esiste un sistema di videosorveglianza perimetrale dei locali critici?', 'ref' => 'Sicurezza Fisica', 'critica' => false, 'peso' => 1],
            ],
            'Gestione Incidenti e Data Breach' => [
                ['domanda' => 'Esiste un canale di comunicazione attivo 24/7 per la segnalazione di incidenti?', 'ref' => 'GDPR Art. 33', 'critica' => true, 'peso' => 4],
                ['domanda' => 'Il fornitore garantisce la notifica di un Data Breach entro 24-48 ore?', 'ref' => 'GDPR Art. 33', 'critica' => true, 'peso' => 5],
                ['domanda' => 'Viene mantenuto un registro storico degli incidenti di sicurezza occorsi?', 'ref' => 'ISO 27001 A.16', 'critica' => false, 'peso' => 3],
            ],
            'Intelligenza Artificiale e Algoritmi' => [
                ['domanda' => 'Il software utilizza sistemi di IA per processi decisionali automatizzati?', 'ref' => 'EU AI Act / GDPR Art. 22', 'critica' => false, 'peso' => 2],
                ['domanda' => "È stata condotta una valutazione dell'impatto sui diritti fondamentali per l'IA?", 'ref' => 'AI Act', 'critica' => true, 'peso' => 4],
                ['domanda' => 'Viene garantita la trasparenza e la spiegabilità degli algoritmi utilizzati?', 'ref' => 'GDPR Art. 13-14', 'critica' => false, 'peso' => 3],
            ],
            'Cancellazione e Portabilità' => [
                ['domanda' => 'Al termine del contratto, i dati vengono restituiti in un formato standard (es. JSON/CSV)?', 'ref' => 'GDPR Art. 20', 'critica' => true, 'peso' => 4],
                ['domanda' => 'Il fornitore rilascia un certificato di avvenuta distruzione sicura dei dati?', 'ref' => 'ISO 27001 A.8.3.2', 'critica' => true, 'peso' => 3],
                ['domanda' => 'Esiste una policy di data retention che preveda la cancellazione automatica dei dati obsoleti?', 'ref' => 'GDPR Art. 5(1)(e)', 'critica' => false, 'peso' => 2],
            ]
        ];

        foreach ($data as $sezioneNome => $domande) {
            $sezioneId = Str::ulid();
            DB::table('audit_sezioni')->insert([
                'id' => $sezioneId,
                'nome' => $sezioneNome,
                'created_at' => now()
            ]);

            foreach ($domande as $d) {
                DB::table('audit_software_domande')->insert([
                    'id' => Str::ulid(),
                    'sezione_id' => $sezioneId,
                    'testo_domanda' => $d['domanda'],
                    'riferimento_normativo' => $d['ref'],
                    'is_critica' => $d['critica'],
                    'peso' => $d['peso'],
                    'created_at' => now()
                ]);
            }
        }
    }
}
