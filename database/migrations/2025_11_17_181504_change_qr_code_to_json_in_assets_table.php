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
        Schema::table('assets', function (Blueprint $table) {
            $table->json('qr_codes')->nullable()->after('qr_code');
        });

        // Migrate existing qr_code data to qr_codes array
        DB::statement('UPDATE assets SET qr_codes = JSON_ARRAY(qr_code) WHERE qr_code IS NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('qr_codes');
        });
    }
};
