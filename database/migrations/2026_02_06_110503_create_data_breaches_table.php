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
        Schema::create('data_breaches', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('mandante_id')->constrained('mandanti')->cascadeOnDelete();

            $table->string('description');
            $table->dateTime('occurred_at');
            $table->dateTime('detected_at');

            $table->boolean('is_notified_authority')->default(false);
            $table->dateTime('authority_notified_at')->nullable();

            $table->boolean('is_notified_subjects')->default(false);
            $table->dateTime('subjects_notified_at')->nullable();

            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->enum('status', ['open', 'investigating', 'closed'])->default('open');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_breaches');
    }
};
