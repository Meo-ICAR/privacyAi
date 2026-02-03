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
        Schema::create('fornitori', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('ragione_sociale')->comment('Denominazione fornitore');
            $table->string('p_iva', 13)->nullable();
            $table->string('website')->nullable()->comment('Sito web aziendale');
            $table->string('fornitura_prodotti')->nullable()->comment('Descrizione servizi forniti');
            $table->string('responsabile_trattamento')->nullable()->comment('Responsabile del Trattamento ( amministratore azienda)');
            // Privacy Logic: La Mandataria nomina TE (Mandante)
            $table->date('data_nomina')->nullable()->comment('Data in cui abbiamo nominato il fornitore come Responsabile');
            $table->string('email_referente')->nullable()->comment('Contatto primario per comunicazioni privacy');
            $table
                ->enum('locazione_dati', ['UE', 'USA', 'Extra-UE'])
                ->default('UE')
                ->comment('Critico per Transfer Impact Assessment (TIA)');
            $table->text('note_compliance')->nullable()->comment('Eventuali clausole contrattuali specifiche');

            // Informazioni Lavorative
            $table
                ->foreignUlid('mansione_id')
                ->nullable()
                ->constrained('mansioni')
                ->nullable()
                ->comment('Ruolo fornitore per definizione profilo di rischio');
            $table->string('albo')->nullable()->comment('Albo/Ordine di appartenenza');
            $table->date('data_iscrizione')->nullable()->comment("Data di iscrizione all'albo");

            $table
                ->foreignUlid('holding_id')
                ->nullable()  // Nullable se un Mandante è indipendente (non appartiene a gruppi)
                ->constrained('holdings')
                ->nullOnDelete()
                ->comment('Riferimento alla Holding di appartenenza');
            $table->comment('Censimento degli asset software e verifica locazione dati Extra-UE');
            $table->string('nomina')->nullable()->comment('Tipo nomina (es. resp. esterno dati dipendenti)');

            // Attività
            $table->text('attivita_principale')->nullable()->comment('Attività principale del fornitore');

            // Date
            $table->date('data_invio_documenti')->nullable()->comment('Data invio documenti');
            $table->date('data_firma_contratto')->nullable()->comment('Data firma contratto');

            // Cessazione
            $table->date('data_cessazione')->nullable()->comment('Data di cessazione del rapporto');
            $table->text('motivo_cessazione')->nullable()->comment('Motivo della cessazione');

            // Note
            $table->text('note_contrattuali')->nullable()->comment('Note aggiuntive sul contratto');

            $table->foreignUlid('mandante_id')->constrained('mandanti');
            $table->foreignUlid('aziendatipo_id')->nullable()->constrained('aziendatipo')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });;
    }

    /**
     * * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornitori');
    }
};
