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
        Schema::create('siti_web', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();
            $table->string('url')->comment('URL completo del sito');
            $table->string('nome_progetto')->nullable()->comment('Es: E-commerce, Blog, Portale Agenti');
            $table->enum('tipo', ['istituzionale', 'ecommerce', 'landing_page', 'app_web'])->default('istituzionale');
            $table->text('descrizione_trattamenti')->nullable()->comment('Quali dati vengono raccolti su questo sito?');

            // Campi per la Compliance rapida
            $table->boolean('has_cookie_policy')->default(false);
            $table->boolean('has_privacy_policy')->default(false);
            $table->string('hosting_provider')->nullable()->comment('Dove risiedono i dati? (Es: AWS, Aruba)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siti_web');
    }
};
