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
        Schema::create('servizi_dpo', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nome');  // Es: Assistenza Audit, Canone DPO Annuale
            $table->string('stripe_price_id')->unique();
            $table->decimal('prezzo', 10, 2);
            $table->enum('tipo', ['una_tantum', 'ricorrente']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servizi_dpo');
    }
};
