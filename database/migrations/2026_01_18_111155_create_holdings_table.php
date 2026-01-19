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
        Schema::create('holdings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('ragione_sociale')->comment('Nome del Gruppo o Holding');
            $table->string('p_iva', 11)->unique();
            $table->string('codice_gruppo')->nullable()->comment('Codice per reportistica aggregata');
            $table->timestamps();
            $table->softDeletes();

            $table->comment('Entità di vertice che raggruppa più Mandanti (Società Operative)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holdings');
    }
};
