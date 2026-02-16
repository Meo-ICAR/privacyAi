<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ---------------------------------------------------------
        // 1. COMMENTI ALLE TABELLE (Table Comments)
        // ---------------------------------------------------------

        // Core Privacy & Audit
        DB::statement("ALTER TABLE `audit_exports` COMMENT = 'Log delle esportazioni (Dossier, Report) per finalità di accountability'");
        DB::statement("ALTER TABLE `audit_sezioni` COMMENT = 'Macro-aree tematiche per i questionari di audit (es. Sicurezza Fisica, GDPR, HR)'");
        DB::statement("ALTER TABLE `audit_software_domande` COMMENT = 'Catalogo delle singole domande di controllo per le checklist di audit'");
        DB::statement("ALTER TABLE `audit_requests` COMMENT = 'Ticket di assistenza e richieste di audit aperte dai Mandanti'");

        // Registro e Normativa
        DB::statement("ALTER TABLE `registro_trattamenti` COMMENT = 'Storico versionato del Registro delle Attività di Trattamento (Art. 30 GDPR)'");
        DB::statement("ALTER TABLE `basi_giuridiche` COMMENT = 'Elenco delle basi giuridiche (Art. 6 GDPR) applicabili ai trattamenti'");
        DB::statement("ALTER TABLE `misura_sicurezza` COMMENT = 'Catalogo misure di sicurezza tecniche e organizzative (TOMs) Art. 32'");

        // Struttura Aziendale & Multi-tenant
        DB::statement("ALTER TABLE `users` COMMENT = 'Utenti con accesso alla piattaforma (Admin, DPO, Referenti Mandanti)'");
        DB::statement("ALTER TABLE `dpo_anagrafica` COMMENT = 'Dettagli e contatti ufficiali del Data Protection Officer nominato'");
        DB::statement("ALTER TABLE `siti_web` COMMENT = 'Asset digitali (Siti, App) gestiti dal Mandante oggetto di analisi privacy'");

        // Risorse Umane
        DB::statement("ALTER TABLE `corsi` COMMENT = 'Eventi formativi specifici (Aula/Webinar) pianificati'");
        DB::statement("ALTER TABLE `corso_dipendente` COMMENT = 'Registro presenze e completamento corsi per singolo dipendente'");

        // Sistema & Laravel
        DB::statement("ALTER TABLE `failed_jobs` COMMENT = 'Coda di debug per i job asincroni falliti'");
        DB::statement("ALTER TABLE `jobs` COMMENT = 'Coda attiva dei job di sistema in attesa di esecuzione'");
        DB::statement("ALTER TABLE `media` COMMENT = 'Gestione file e allegati (Spatie Media Library)'");
        DB::statement("ALTER TABLE `model_has_roles` COMMENT = 'Tabella pivot per assegnazione Ruoli agli Utenti'");
        DB::statement("ALTER TABLE `model_has_permissions` COMMENT = 'Tabella pivot per assegnazione Permessi diretti agli Utenti'");

        // ---------------------------------------------------------
        // 2. COMMENTI AI CAMPI SPECIFICI (Column Comments)
        // Nota: In MySQL, per aggiungere un commento bisogna ridefinire la colonna.
        // Qui sotto sono ridefinite esattamente come nel dump originale.
        // ---------------------------------------------------------

        // Audit Exports - Relazioni
        DB::statement("ALTER TABLE `audit_exports` MODIFY `mandante_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK: Azienda cliente oggetto dell''audit'");
        DB::statement("ALTER TABLE `audit_exports` MODIFY `user_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK: Utente che ha generato il report'");

        // Audit Fornitori - Stato e Anno
        DB::statement("ALTER TABLE `audit_fornitori` MODIFY `anno_riferimento` year NOT NULL COMMENT 'Anno fiscale di competenza dell''audit'");
        DB::statement("ALTER TABLE `audit_fornitori` MODIFY `stato` enum('Pianificato','In Corso','Completato','Annullato') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pianificato' COMMENT 'Workflow di avanzamento verifica'");

        // Users - Tenant
        DB::statement("ALTER TABLE `users` MODIFY `mandante_id` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'FK: Tenant di appartenenza (NULL per SuperAdmin)'");

        // Registro Trattamenti - Payload
        DB::statement("ALTER TABLE `registro_trattamenti` MODIFY `payload` json NOT NULL COMMENT 'Snapshot completo del registro in formato JSON al momento del salvataggio'");

        // Siti Web - Flags Compliance
        DB::statement("ALTER TABLE `siti_web` MODIFY `has_cookie_policy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Cookie Policy presente e linkata'");
        DB::statement("ALTER TABLE `siti_web` MODIFY `has_privacy_policy` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Privacy Policy presente e conforme'");

        // Corso Templates - Validità
        DB::statement("ALTER TABLE `corso_templates` MODIFY `validita_mesi` int NOT NULL DEFAULT '12' COMMENT 'Periodo validità attestato (es. 12, 24, 36 mesi)'");

        // Canali Email
        DB::statement("ALTER TABLE `canali_email` MODIFY `email_provider_id` bigint unsigned NOT NULL COMMENT 'FK: Configurazione tecnica provider (SMTP/IMAP settings)'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non è strettamente necessario rimuovere i commenti nel down(),
        // ma se volessi farlo, dovresti rieseguire gli ALTER TABLE con COMMENT = ''.
    }
};
