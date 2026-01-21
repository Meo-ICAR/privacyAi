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
        Schema::create('corso_dipendente', function (Blueprint $table) {
            $table->foreignUlid('corso_id')->constrained('corsi')->onDelete('cascade');
            $table->foreignUlid('dipendente_id')->constrained('dipendenti')->onDelete('cascade');
            $table->primary(['corso_id', 'dipendente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corso_dipendente');
    }
};
