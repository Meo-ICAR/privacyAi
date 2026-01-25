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
        Schema::create('mandatarie', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // Il tenant (Mandante) censisce i propri clienti (Mandatarie)
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();

            $table->string('ragione_sociale')->comment('Titolare del Trattamento (Cliente del Call Center)');
            $table->string('p_iva', 13)->nullable();
            $table->string('website')->nullable()->comment('Sito web aziendale');
            $table->string('landingpage')->nullable()->comment('Landing page per mandataria');
            // Privacy Logic: La Mandataria nomina TE (Mandante)
            $table->date('data_ricezione_nomina')->comment('Data in cui la Mandataria ha nominato il Mandante come Responsabile');
            $table->string('titolare_trattamento')->comment('Titolare del Trattamento');
            $table->string('email_referente')->nullable()->comment('Contatto primario per comunicazioni privacy');
            $table
                ->foreignUlid('holding_id')
                ->nullable()  // Nullable se un Mandante è indipendente (non appartiene a gruppi)
                ->constrained('holdings')
                ->nullOnDelete()
                ->comment('Riferimento alla Holding di appartenenza');
            $table->text('categorie_dati')->nullable()->comment('Categorie di dati personali trattati');
            $table->text('descrizione_categorie_dati')->nullable()->comment('Descrizione dettagliata delle categorie di dati');
            $table->text('categorie_interessati')->nullable()->comment('Categorie di interessati (es. dipendenti, clienti, fornitori)');
            $table->text('finalita_trattamento')->nullable()->comment('Finalità del trattamento dei dati');
            $table->enum('tipo_trattamento', ['manuale', 'digitale', 'misto'])->default('digitale');
            $table->text('termini_conservazione')->nullable()->comment('Termini di conservazione e cancellazione dei dati');
            $table->text('paesi_trasferimento_dati')->nullable()->comment('Paesi terzi o organizzazioni internazionali destinatari dei dati');
            $table->text('misure_sicurezza_tecniche')->nullable()->comment('Misure di sicurezza tecniche adottate');
            $table->text('misure_sicurezza_organizzative')->nullable()->comment('Misure di sicurezza organizzative adottate');
            $table->text('responsabili_esterni')->nullable()->comment('Elenco dei responsabili esterni al trattamento');
            $table->text('base_giuridica')->nullable()->comment('Base giuridica del trattamento');
            $table->boolean('richiesto_consenso')->default(false);
            $table->text('modalita_raccolta_consenso')->nullable();
            $table->string('contitolare_trattamento')->nullable()->comment('Contitolare del trattamento');
            $table->text('note_gdpr')->nullable()->comment('Note aggiuntive relative al trattamento dei dati');

            $table->foreignUlid('aziendatipo_id')->nullable()->constrained('aziendatipo')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->comment('Titolari del Trattamento esterni che hanno nominato la società Mandante come Responsabile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandatarie');
    }
};
