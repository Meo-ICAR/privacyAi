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
        Schema::create('mandatarie', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // Il tenant (Mandante) censisce i propri clienti (Mandatarie)
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();

            $table->string('ragione_sociale')->comment('Titolare del Trattamento (Cliente del Call Center)');
            $table->string('p_iva', 11);
            $table->string('website')->nullable()->comment('Sito web aziendale');
            $table->string('landingpage')->nullable()->comment('Landing page per mandataria');
            // Privacy Logic: La Mandataria nomina TE (Mandante)
            $table->date('data_ricezione_nomina')->comment('Data in cui la Mandataria ha nominato il Mandante come Responsabile');
            $table->string('titolare_trattamento')->comment('Titolare del Trattamento');
            $table->string('email_referente')->nullable()->comment('Contatto primario per comunicazioni privacy');
            $table
                ->foreignUlid('holding_id')
                ->nullable()  // Nullable se un Mandante è indipendente (non appartiene a gruppi)
                ->constrained('holdings')
                ->nullOnDelete()
                ->comment('Riferimento alla Holding di appartenenza');
            $table->foreignUlid('aziendatipo_id')->nullable()->constrained('aziendatipo')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->comment('Titolari del Trattamento esterni che hanno nominato la società Mandante come Responsabile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandatarie');
    }
};
