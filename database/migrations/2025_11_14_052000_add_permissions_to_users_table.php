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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_view_instrument_sets')->default(false)->after('is_admin');
            $table->boolean('can_view_qr_codes')->default(false)->after('can_view_instrument_sets');
            $table->boolean('can_manage_master_data')->default(false)->after('can_view_qr_codes');
            $table->boolean('can_view_assets')->default(false)->after('can_manage_master_data');
            $table->boolean('can_view_scan_history')->default(false)->after('can_view_assets');
            $table->boolean('can_use_scanner')->default(false)->after('can_view_scan_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'can_view_instrument_sets',
                'can_view_qr_codes',
                'can_manage_master_data',
                'can_view_assets',
                'can_view_scan_history',
                'can_use_scanner'
            ]);
        });
    }
};
