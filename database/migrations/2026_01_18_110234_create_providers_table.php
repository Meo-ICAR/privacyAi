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
        Schema::create('email_providers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nome')->comment('Es: Gmail, Microsoft 365, Aruba');
            $table->string('host')->comment('es: imap.gmail.com');
            $table->integer('port')->default(993);
            $table->string('encryption')->default('ssl')->comment('ssl o tls');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->comment('Configurazioni tecniche standard dei server IMAP');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
