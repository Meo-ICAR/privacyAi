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
        Schema::create('misura_sicurezza', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('misura_id')->constrained('misure_sicurezza')->cascadeOnDelete();

            $table->boolean('is_attiva')->default(false);
            $table->text('note_implementazione')->nullable()->comment('Dettagli su come la misura è applicata');
            $table->date('ultima_verifica_at')->nullable()->comment('Data ultimo test della misura');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misura_sicurezza');
    }
};
