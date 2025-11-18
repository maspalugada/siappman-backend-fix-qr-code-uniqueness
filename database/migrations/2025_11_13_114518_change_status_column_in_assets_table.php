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
        // Change status column from enum to string
        DB::statement("ALTER TABLE assets MODIFY COLUMN status VARCHAR(255) DEFAULT 'Ready'");
        DB::statement("ALTER TABLE instrument_sets ADD COLUMN status VARCHAR(255) DEFAULT 'Ready' AFTER qr_code");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change status column back to enum
        DB::statement("ALTER TABLE assets MODIFY COLUMN status ENUM('active', 'inactive', 'maintenance') DEFAULT 'active'");
        DB::statement("ALTER TABLE instrument_sets DROP COLUMN status");
    }
};
