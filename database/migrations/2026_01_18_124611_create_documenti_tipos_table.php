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
        Schema::create('documenti_tipo', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nome')->unique()->comment('Es: Nomina Art. 28, Registro Trattamenti');
            $table->string('slug')->unique();
            $table->string('categoria')->index()->comment('Es: Privacy, Formazione, Audit');
            $table->text('descrizione')->nullable();
            $table->boolean('is_obbligatorio')->default(false);
            $table->timestamps();

            $table->comment('Catalogo globale delle tipologie di documenti per la compliance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_tipos');
    }
};
