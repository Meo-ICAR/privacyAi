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
        Schema::create('normativas', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('control_area');
            $table->string('question_en');
            $table->string('question_it');
            $table->string('iso_27001_2022_reference')->nullable();
            $table->string('gdpr_reference')->nullable();
            $table->enum('answer', ['Y', 'N', 'N.A.'])->nullable();
            $table->string('evidence_required')->nullable();
            $table->text('notes')->nullable();
            $table->integer('weight')->default(1);
            $table->integer('score')->default(0);
            $table->string('risk_level')->default('Low');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('normativas');
    }
};
