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
        Schema::create('fornitori', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandanti');
            $table->string('nome_software');
            $table->string('produttore')->comment('Nome della software house fornitrice');
            $table->enum('locazione_dati', ['UE', 'USA', 'Extra-UE'])->default('UE')
                ->comment('Critico per Transfer Impact Assessment (TIA)');
            $table->text('note_compliance')->nullable()->comment('Eventuali clausole contrattuali specifiche');

            $table->foreignUlid('mansione_id')->nullable()->constrained('mansioni')->nullOnDelete();
            // Informazioni Lavorative

            // Informazioni Lavorative
            $table->foreignUlid('mansione_id')->nullable()->constrained('mansioni')->nullable()
                ->comment('Ruolo fornitore per definizione profilo di rischio');
            $table->comment('Censimento degli asset software e verifica locazione dati Extra-UE');
            $table->timestamps();
            $table->softDeletes();
        });
        ;
    }
    /**     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornitori');
    }
};
