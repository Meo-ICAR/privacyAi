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
        Schema::create('canali_email', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandanti');
            $table->foreignUlid('email_provider_id')->constrained(); // Relazione col provider

            $table->string('label')->comment('Es: Email DPO Ufficiale');
            $table->string('username')->comment('L\'indirizzo email completo');
            $table->text('password')->comment('Criptata tramite Laravel Encrypter');

            $table->timestamp('last_sync_at')->nullable();

            $table->comment('Credenziali e parametri per l\'ingestion automatica delle email privacy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canali_email');
    }
};
