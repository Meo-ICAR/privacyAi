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
        Schema::table('mandatarie', function (Blueprint $table) {
            $table->integer('compliance_score')->nullable()->default(0);
            $table->enum('dpa_status', ['missing', 'draft', 'sent', 'signed', 'expired'])->default('missing');
            $table->date('dpa_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mandatarie', function (Blueprint $table) {
            $table->dropColumn(['compliance_score', 'dpa_status', 'dpa_expires_at']);
        });
    }
};
