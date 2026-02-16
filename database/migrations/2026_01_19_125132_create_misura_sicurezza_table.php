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
            $table->string('codice')->nullable();
            $table->string('nome')->nullable();
            $table->string('tipo')->nullable();
            $table->string('area')->nullable();
            $table->text('descrizione')->nullable()->comment('Dettagli su come la misura è applicata');

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
