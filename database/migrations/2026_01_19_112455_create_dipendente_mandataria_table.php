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
        Schema::create('dipendente_mandataria', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relazioni
            $table->foreignUlid('dipendente_id')->constrained('dipendenti')->cascadeOnDelete();
            $table->foreignUlid('mandataria_id')->constrained('mandatarie')->cascadeOnDelete();

            // Campi di Compliance
            $table->date('data_autorizzazione')->comment('Data in cui il dipendente è stato autorizzato a operare su questa specifica Mandataria');
            $table->boolean('is_active')->default(true)->comment('Indica se il dipendente opera ancora con questa Mandataria');

            $table->timestamps();

            $table->comment('Tabella pivot: associa i dipendenti del Call Center (Responsabile) ai Titolari (Mandatarie)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dipendente_mandataria');
    }
};
