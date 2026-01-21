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
            $table->string('p_iva', 11);
            $table->string('website')->nullable()->comment('Sito web aziendale');
            $table->string('responsabile_trattamento')->comment('Responsabile del Trattamento ( amministratore azienda)');
            // Privacy Logic: La Mandataria nomina TE (Mandante)
            $table->date('data_nomina')->comment('Data in cui abbiamo nominato il fornitore come Responsabile');
            $table->string('email_referente')->nullable()->comment('Contatto primario per comunicazioni privacy');
            $table
                ->enum('locazione_dati', ['UE', 'USA', 'Extra-UE'])
                ->default('UE')
                ->comment('Critico per Transfer Impact Assessment (TIA)');
            $table->text('note_compliance')->nullable()->comment('Eventuali clausole contrattuali specifiche');

            // Informazioni Lavorative

            // Informazioni Lavorative
            $table
                ->foreignUlid('mansione_id')
                ->nullable()
                ->constrained('mansioni')
                ->nullable()
                ->comment('Ruolo fornitore per definizione profilo di rischio');
            $table->comment('Censimento degli asset software e verifica locazione dati Extra-UE');
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
