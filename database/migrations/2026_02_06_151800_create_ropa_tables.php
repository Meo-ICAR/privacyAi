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
        // Main processing activities table
        Schema::create('trattamenti', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();

            $table->string('nome');
            $table->text('descrizione')->nullable();
            $table->text('finalita');
            $table->text('categorie_interessati');
            $table->text('base_giuridica');
            $table->text('destinatari')->nullable();
            $table->text('trasferimenti_extra_ue')->nullable();
            $table->text('termini_conservazione')->nullable();
            $table->text('misure_sicurezza')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Data categories lookup table
        Schema::create('categorie_dati', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nome');
            $table->text('descrizione')->nullable();
            $table->enum('tipo', ['ordinari', 'particolari', 'giudiziari'])->default('ordinari');
            $table->timestamps();
        });

        // Pivot table for processing activities and data categories
        Schema::create('trattamento_categoria_dati', function (Blueprint $table) {
            $table->foreignUlid('trattamento_id')->constrained('trattamenti')->cascadeOnDelete();
            $table->foreignUlid('categoria_dati_id')->constrained('categorie_dati')->cascadeOnDelete();
            $table->primary(['trattamento_id', 'categoria_dati_id']);
            $table->timestamps();
        });

        // Pivot table for processing activities and mandatarie (recipients)
        Schema::create('trattamento_mandataria', function (Blueprint $table) {
            $table->foreignUlid('trattamento_id')->constrained('trattamenti')->cascadeOnDelete();
            $table->foreignUlid('mandataria_id')->constrained('mandatarie')->cascadeOnDelete();
            $table->primary(['trattamento_id', 'mandataria_id']);
            $table->string('ruolo')->default('destinatario');  // destinatario, responsabile, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trattamento_mandataria');
        Schema::dropIfExists('trattamento_categoria_dati');
        Schema::dropIfExists('categorie_dati');
        Schema::dropIfExists('trattamenti');
    }
};
