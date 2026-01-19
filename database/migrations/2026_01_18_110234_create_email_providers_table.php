<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_providers', function (Blueprint $table) {
            $table->id();

            // Informazioni Generali
            $table
                ->string('name')
                ->index()
                ->comment('Slug identificativo univoco (es: gmail, office365)');
            $table
                ->string('display_name')
                ->comment("Nome visualizzato nell'interfaccia utente");
            $table
                ->string('type')
                ->index()
                ->comment('Protocollo principale: imap, gmail_api, microsoft_graph');
            $table
                ->string('icon')
                ->nullable()
                ->comment('Nome del file icona o classe CSS per il brand');
            $table
                ->string('color')
                ->nullable()
                ->comment('Codice esadecimale del colore brand per la UI');

            // Configurazione IMAP (Ricezione standard)
            $table
                ->string('imap_host')
                ->nullable()
                ->comment('Indirizzo del server IMAP');
            $table
                ->integer('imap_port')
                ->nullable()
                ->comment('Porta IMAP (solitamente 993 per SSL)');
            $table
                ->string('imap_encryption')
                ->nullable()
                ->comment('Tipo di crittografia IMAP: ssl, tls o null');

            // Configurazione POP3 (Ricezione legacy)
            $table->string('pop3_host')->nullable();
            $table->integer('pop3_port')->nullable();
            $table->string('pop3_encryption')->nullable();

            // Configurazione SMTP (Invio)
            $table
                ->string('smtp_host')
                ->nullable()
                ->comment("Indirizzo del server SMTP per l'invio");
            $table
                ->integer('smtp_port')
                ->nullable()
                ->comment('Porta SMTP (es: 587 per STARTTLS)');
            $table
                ->string('smtp_encryption')
                ->nullable()
                ->comment('Tipo di crittografia SMTP: ssl o tls');
            $table
                ->boolean('smtp_auth_required')
                ->default(true)
                ->comment('Indica se il server richiede autenticazione per inviare');

            // API & OAuth2 (Integrazioni Moderne)
            $table
                ->string('api_endpoint')
                ->nullable()
                ->comment('URL base per integrazioni API (es: Graph API)');
            $table
                ->string('api_version')
                ->nullable()
                ->comment("Versione specifica dell'API utilizzata");
            $table
                ->string('oauth_client_id')
                ->nullable()
                ->comment('ID cliente per autenticazione OAuth2');
            $table
                ->string('oauth_client_secret')
                ->nullable()
                ->comment('Segreto cliente per OAuth2 (da gestire con cautela)');
            $table
                ->string('oauth_redirect_uri')
                ->nullable()
                ->comment('URL di callback per il ritorno dal login social');
            $table
                ->json('oauth_scopes')
                ->nullable()
                ->comment("Permessi richiesti all'utente (JSON array)");

            // Parametri di Connessione e Sicurezza
            $table
                ->integer('timeout')
                ->default(30)
                ->comment('Secondi di attesa prima del fallimento connessione');
            $table
                ->boolean('verify_ssl')
                ->default(true)
                ->comment('Verifica la validità del certificato SSL del server');
            $table
                ->string('auth_type')
                ->default('password')
                ->comment('Metodo di login: password, oauth, api_key');
            $table
                ->json('settings')
                ->nullable()
                ->comment('Configurazioni extra specifiche del provider in formato JSON');

            $table
                ->boolean('is_active')
                ->default(true)
                ->index()
                ->comment('Disabilita il provider a livello globale se necessario');
            $table
                ->text('description')
                ->nullable()
                ->comment('Breve descrizione del provider');
            $table
                ->text('setup_instructions')
                ->nullable()
                ->comment("Istruzioni per l'utente per abilitare IMAP/OAuth sul proprio account");

            $table->timestamps();

            // Commento della tabella
            $table->comment('Catalogo globale dei fornitori email con parametri tecnici per IMAP, SMTP e OAuth2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
