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
        Schema::create('mandanti', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('ragione_sociale')->comment("Nome legale dell'azienda cliente");
            $table->string('p_iva', 11)->unique()->comment('Identificativo fiscale univoco');
            $table->string('titolare_trattamento')->comment('Titolare del Trattamento');
            $table->string('email_referente')->nullable()->comment('Contatto primario per comunicazioni privacy');
            $table->boolean('is_active')->default(true)->comment('Stato di validità del contratto/tenant');

            $table->string('website')->nullable()->comment('Sito web aziendale');

            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->enum('periodicita', [1, 2, 3, 6])->default(2)->comment('1=Mensile, 2=Bimestrale, 3=Trimestrale, 6=Semestrale');
            $table->timestamp('stripe_subscription_ends_at')->nullable();
            $table->boolean('is_active')->default(true);

            $table
                ->foreignUlid('holding_id')
                ->nullable()  // Nullable se un Mandante è indipendente (non appartiene a gruppi)
                ->constrained('holdings')
                ->nullOnDelete()
                ->comment('Riferimento alla Holding di appartenenza');
            $table->foreignUlid('aziendatipo_id')->nullable()->constrained('aziendatipo')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->comment("Entità Tenant: rappresenta l'azienda titolare del trattamento");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandanti');
    }
};
