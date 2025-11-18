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
        Schema::table('locations', function (Blueprint $table) {
            // Add composite unique constraint on unit, unit_code, and floor
            $table->unique(['unit', 'unit_code', 'floor'], 'locations_unit_unit_code_floor_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // Drop the composite unique constraint if it exists
            if (Schema::hasColumn('locations', 'unit') && Schema::hasColumn('locations', 'unit_code') && Schema::hasColumn('locations', 'floor')) {
                $table->dropUnique('locations_unit_unit_code_floor_unique');
            }
        });
    }
};
