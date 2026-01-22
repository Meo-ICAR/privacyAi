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
        // 3. INBOUND EMAILS (Messaggi scaricati)
        Schema::create('inbound_emails', function (Blueprint $table) {
            $table->char('id', 26)->primary(); // ULID

            // *** CORREZIONE ERRORE 3780 ***
            // Non usare foreignId() qui, perché creerebbe un BIGINT.
            // Dato che canali_email.id è CHAR(26), anche questa deve essere CHAR(26).
            $table->char('canale_email_id', 26)->index();
            $table->foreign('canale_email_id')->references('id')->on('canali_email')->cascadeOnDelete();

            $table->string('message_id')->index();
            $table->string('subject')->nullable();
            $table->string('from_email');
            $table->string('from_name')->nullable();

            $table->text('body_text')->nullable();
            $table->longText('body_html')->nullable();

            $table->timestamp('received_at');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->unique(['canale_email_id', 'message_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inboun_emails');
    }
};
