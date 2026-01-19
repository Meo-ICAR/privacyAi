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
        Schema::create('corso_templates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('titolo')->comment('Nome standard del percorso formativo');
            $table->text('descrizione')->nullable()->comment('Dettagli sugli argomenti trattati');
            $table->integer('validita_mesi')->default(12)->comment('Periodo di validità del certificato prima del rinnovo');
            $table->boolean('is_obbligatorio')->default(true)->comment('Indica se il corso è richiesto per la compliance minima');
            $table->timestamps();

            $table->comment('Catalogo dei corsi privacy disponibili per i mandanti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corso_templates');
    }
};
