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
        Schema::table('corso_dipendente', function (Blueprint $table) {
            $table->dropForeign(['corso_id']);
            $table->dropForeign(['dipendente_id']);
        });

        Schema::table('corso_dipendente', function (Blueprint $table) {
            $table->dropPrimary(['corso_id', 'dipendente_id']);
        });

        Schema::table('corso_dipendente', function (Blueprint $table) {
            $table->ulid('id')->primary()->first();
            $table->foreignUlid('corso_id')->change()->constrained('corsi')->cascadeOnDelete();
            $table->foreignUlid('dipendente_id')->change()->constrained('dipendenti')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corso_dipendente', function (Blueprint $table) {
            $table->dropColumn(['id', 'created_at', 'updated_at']);
            $table->primary(['corso_id', 'dipendente_id']);
        });
    }
};
