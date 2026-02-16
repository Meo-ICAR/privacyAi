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
        Schema::create('dpo_anagrafica', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Dati Identificativi
            $table->string('denominazione');  // Es: "Studio Privacy Romeo" o Nome Cognome
            $table->string('codice_fiscale', 16)->nullable();
            $table->string('partita_iva', 11)->nullable();

            // Recapiti Ufficiali (obbligatori per Art. 37 GDPR)
            $table->string('email_ordinaria');
            $table->string('email_pec')->nullable();
            $table->string('telefono')->nullable();

            // Sede Legale/Operativa
            $table->string('indirizzo');
            $table->string('cap', 5);
            $table->string('citta');
            $table->string('provincia', 2);

            // Dati Professionali
            $table->string('numero_iscrizione_albo')->nullable();  // Es: Avvocati, Ingegneri, etc.
            $table->string('certificazioni')->nullable();  // Es: "UNI 11697:2017", "EIPASS"
            $table->boolean('is_persona_giuridica')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpo_anagrafica');
    }
};
