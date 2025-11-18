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
            $table->boolean('can_sterilize')->default(false)->after('can_use_scanner');
            $table->boolean('can_wash')->default(false)->after('can_sterilize');
            $table->boolean('can_manage_stock')->default(false)->after('can_wash');
            $table->boolean('can_distribute_sterile')->default(false)->after('can_manage_stock');
            $table->boolean('can_distribute_dirty')->default(false)->after('can_distribute_sterile');
            $table->boolean('can_receive_returns')->default(false)->after('can_distribute_dirty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'can_sterilize',
                'can_wash',
                'can_manage_stock',
                'can_distribute_sterile',
                'can_distribute_dirty',
                'can_receive_returns'
            ]);
        });
    }
};
