<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fornitore_mandataria', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Foreign keys
            $table->foreignUlid('fornitore_id')->constrained('fornitori')->cascadeOnDelete();
            $table->foreignUlid('mandataria_id')->constrained('mandatarie')->cascadeOnDelete();
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();

            // Status and dates
            $table->date('data_invio_accettazione')->nullable();
            $table->date('data_accettazione')->nullable();
            $table->enum('esito', ['in_attesa', 'accettato', 'rifiutato', 'revocato'])->default('in_attesa');
            $table->text('annotazioni')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Composite unique key to prevent duplicate relationships
            $table->unique(['fornitore_id', 'mandataria_id', 'mandante_id'], 'fornitore_mandataria_mandante_unique');

            $table->comment('Tabella di relazione tra fornitori e mandatarie per ogni mandante');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fornitore_mandataria');
    }
};
