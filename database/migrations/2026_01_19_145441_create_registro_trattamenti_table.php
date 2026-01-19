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
        Schema::create('registro_trattamenti', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('versione');  // Es: v2026.01.19.001
            $table->json('payload');  // Snapshot completo dei dati (Dati societari, Dipendenti, Fornitori, Mandatarie)
            $table->timestamp('data_aggiornamento');
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();
            $table->foreignUlid('user_id')->nullable()->comment("Chi ha generato/causato l'aggiornamento");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_trattamenti');
    }
};
