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
        Schema::create('formazione_dipendenti', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandanti');
            $table->foreignUlid('dipendente_id')->constrained('dipendenti');
            $table->foreignUlid('corso_template_id')->constrained('corso_templates');
            $table->date('data_conseguimento')->comment('Data effettiva di superamento del test');
            $table->date('data_scadenza')->comment('Calcolo automatico: data_conseguimento + template.validita_mesi');
            $table->string('stato')->default('valido')->comment('Status: valido, in_scadenza, scaduto');
            $table->timestamps();

            $table->comment('Log delle attività formative svolte dai singoli dipendenti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formazione_dipendenti');
    }
};
