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
        Schema::create('dipendenti', function (Blueprint $table) {
            // Chiave primaria ULID
            $table->ulid('id')->primary();

            // Dati Anagrafici
            $table->string('nome')->nullable();
            $table->string('cognome');

            // Dati Sensibili (PII) - Da gestire con casts 'encrypted' nel Model
            $table
                ->string('codice_fiscale')
                ->nullable()
                ->comment('Dato PII - Criptato a riposo ex Art. 32 GDPR');

            $table
                ->string('email_aziendale')
                ->nullable()
                ->comment('Email per comunicazioni e notifiche scadenze corsi');
            $table
                ->string('label_id')
                ->nullable()
                ->comment('Label per lettura email aziendale');
            // Informazioni Lavorative
            $table
                ->foreignUlid('mansione_id')
                ->nullable()
                ->constrained('mansioni')
                ->nullable()
                ->comment('Ruolo aziendale per definizione profilo di rischio');

            $table
                ->date('data_assunzione')
                ->nullable();
            $table->string('albo')->nullable()->comment('Albo/Ordine di appartenenza');
            $table->date('data_iscrizione')->nullable()->comment("Data di iscrizione all'albo");

            $table
                ->date('data_dimissioni')
                ->nullable();

            $table
                ->boolean('is_active')
                ->default(true)
                ->comment("Stato del dipendente nell'organico attivo");

            // Relazione con il Mandante (Tenant - Responsabile del Trattamento)
            $table
                ->foreignUlid('mandante_id')
                ->constrained('mandanti')
                ->cascadeOnDelete()
                ->comment('ID del Tenant proprietario del dato');

            // Relazione con la Filiale (Sede di lavoro)
            $table
                ->foreignUlid('filiale_id')
                ->nullable()
                ->constrained('filiali')
                ->nullOnDelete()
                ->comment('Sede fisica di assegnazione del dipendente');

            // Timestamp e SoftDeletes
            $table->timestamps();
            $table
                ->softDeletes()
                ->comment('Cancellazione logica per conservazione dati post-licenziamento');

            // Commento della tabella
            $table->comment('Anagrafica dipendenti del Responsabile (Mandante) con tracciamento sede e protezione PII');

            $table->foreignUlid('fornitore_id')->nullable()->constrained('fornitori')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dipendenti');
    }
};
