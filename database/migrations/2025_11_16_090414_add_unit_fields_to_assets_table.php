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
            $table->string('unit_code')->nullable()->after('unit');
            $table->string('destination_unit')->nullable()->after('unit_code');
            $table->string('destination_unit_code')->nullable()->after('destination_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['unit_code', 'destination_unit', 'destination_unit_code']);
        });
    }
};
