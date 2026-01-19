<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filiali', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // Appartiene al Mandante (Tenant)
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();

            $table->string('nome')->comment('Esempio: Sede Roma, Filiale Napoli Nord');
            $table->string('indirizzo')->nullable();
            $table->string('citta')->nullable();
            $table->string('codice_sede')->nullable()->comment('Codice interno identificativo');

            $table->timestamps();
            $table->softDeletes();

            $table->comment('Sedi fisiche o unità locali del Mandante (Responsabile)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filiali');
    }
};
