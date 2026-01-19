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
        Schema::create('mansioni', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();

            $table->string('nome')->comment('Esempio: Operatore Front-End, DPO, Sistemista');
            $table->text('descrizione')->nullable()->comment('Descrizione dei compiti rilevanti ai fini privacy');

            // Livello di autorizzazione suggerito
            $table->enum('livello_rischio', ['basso', 'medio', 'alto'])->default('basso');

            $table->timestamps();
            $table->softDeletes();

            $table->comment('Catalogo delle mansioni aziendali e dei profili di rischio autorizzativi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mansioni');
    }
};
