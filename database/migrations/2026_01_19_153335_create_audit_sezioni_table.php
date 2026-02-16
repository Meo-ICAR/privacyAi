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
        // Tabella Sezioni
        Schema::create('audit_sezioni', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nome')->unique();  // Es: Sicurezza Infrastrutturale
            $table->text('descrizione')->nullable();
            $table->integer('ordine')->default(0);
            $table->timestamps();
        });

        // Tabella Domande (aggiornata)
        Schema::create('audit_software_domande', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('sezione_id')->constrained('audit_sezioni')->cascadeOnDelete();
            $table->string('testo_domanda');
            $table->string('riferimento_normativo')->nullable();  // GDPR, ISO, NIST
            $table->integer('peso')->default(1);
            $table->boolean('is_critica')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_sezioni');
    }
};
