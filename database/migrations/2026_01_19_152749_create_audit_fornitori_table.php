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
        Schema::create('audit_fornitori', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->foreignUlid('mandante_id')->constrained()->cascadeOnDelete();

            $table->foreignUlid('fornitore_id')->constrained()->cascadeOnDelete();

            $table->year('anno_riferimento');

            $table->date('data_esecuzione')->nullable();

            $table->enum('stato', ['Pianificato', 'In Corso', 'Completato', 'Annullato'])->default('Pianificato');

            $table->integer('punteggio_compliance')->nullable()->comment('Punteggio da 0 a 100');

            $table->text('note_generali')->nullable();

            $table->foreignUlid('eseguito_da')->nullable()->constrained('users');

            $table->timestamps();

            $table->unique(['fornitore_id', 'anno_riferimento'], 'unique_audit_annuale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_fornitori');
    }
};
