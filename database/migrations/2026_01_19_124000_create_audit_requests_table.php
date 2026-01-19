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
        Schema::create('audit_requests', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('mandataria_id')->constrained()->comment("Il Titolare che sta eseguendo l'audit");

            $table->string('titolo')->comment('Es: Audit Annuale Privacy 2026');
            $table->date('data_inizio');
            $table->enum('stato', ['aperto', 'in_corso', 'completato', 'archiviato'])->default('aperto');

            // Supporto Spatie Media Library per caricare il verbale di audit finale
            $table->timestamps();

            $table->comment('Tracciamento delle richieste di assistenza per audit ricevute dai Mandanti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_requests');
    }
};
