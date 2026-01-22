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
        Schema::create('mandanti', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('ragione_sociale')->comment("Nome legale dell'azienda cliente");
            $table->string('p_iva', 11)->unique()->comment('Identificativo fiscale univoco');
            $table->string('titolare_trattamento')->comment('Titolare del Trattamento');
            $table->string('email_referente')->nullable()->comment('Contatto primario per comunicazioni privacy');
            $table->boolean('is_active')->default(true)->comment('Stato di validità del contratto/tenant');

            $table->string('website')->nullable()->comment('Sito web aziendale');

            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->enum('periodicita', [1, 2, 3, 6])->default(2)->comment('1=Mensile, 2=Bimestrale, 3=Trimestrale, 6=Semestrale');
            $table
                ->decimal('stripe_prezzo_mensile', 10, 2)
                ->nullable()
                ->comment('Prezzo mensile per abbonamento Stripe');
            $table->timestamp('stripe_subscription_ends_at')->nullable();

            $table
                ->foreignUlid('holding_id')
                ->nullable()  // Nullable se un Mandante è indipendente (non appartiene a gruppi)
                ->constrained('holdings')
                ->nullOnDelete()
                ->comment('Riferimento alla Holding di appartenenza');
            $table->foreignUlid('aziendatipo_id')->nullable()->constrained('aziendatipo')->nullOnDelete();

            $table->text('categorie_dati')->nullable()->comment('Categorie di dati personali trattati');
            $table->text('descrizione_categorie_dati')->nullable()->comment('Descrizione dettagliata delle categorie di dati');

            // Interessati
            $table->text('categorie_interessati')->nullable()->comment('Categorie di interessati (es. dipendenti, clienti, fornitori)');

            // Finalità
            $table->text('finalita_trattamento')->nullable()->comment('Finalità del trattamento dei dati');

            // Modalità di trattamento
            $table->enum('tipo_trattamento', ['manuale', 'digitale', 'misto'])->default('digitale');

            // Conservazione
            $table->text('termini_conservazione')->nullable()->comment('Termini di conservazione e cancellazione dei dati');

            // Trasferimenti internazionali
            $table->text('paesi_trasferimento_dati')->nullable()->comment('Paesi terzi o organizzazioni internazionali destinatari dei dati');

            // Misure di sicurezza
            $table->text('misure_sicurezza_tecniche')->nullable()->comment('Misure di sicurezza tecniche adottate');
            $table->text('misure_sicurezza_organizzative')->nullable()->comment('Misure di sicurezza organizzative adottate');

            // Responsabili esterni
            $table->text('responsabili_esterni')->nullable()->comment('Elenco dei responsabili esterni al trattamento');

            // Base giuridica
            $table->text('base_giuridica')->nullable()->comment('Base giuridica del trattamento (es. consenso, obbligo contrattuale)');
            $table->boolean('richiesto_consenso')->default(false);
            $table->text('modalita_raccolta_consenso')->nullable()->comment('Modalità di raccolta del consenso');

            // Documentazione
            $table->text('note_gdpr')->nullable()->comment('Note aggiuntive relative al trattamento dei dati');

            $table->timestamps();
            $table->softDeletes();

            $table->comment("Entità Tenant: rappresenta l'azienda titolare del trattamento");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandanti');
    }
};
