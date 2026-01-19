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
        Schema::create('audit_exports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained();
            $table->foreignUlid('user_id')->constrained()->comment('Chi ha generato il dossier');
            $table->foreignUlid('mandataria_id')->constrained();

            $table->string('tipo_report')->comment('Es: Dossier Completo, Registro Formazione');
            $table->timestamp('generato_il');
            $table->timestamps();
            $table->comment('Log delle esportazioni di dati effettuate per finalità di audit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_exports');
    }
};
