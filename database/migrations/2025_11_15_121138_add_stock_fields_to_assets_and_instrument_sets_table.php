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
            $table->integer('jumlah_steril')->default(0)->after('jumlah');
            $table->integer('jumlah_kotor')->default(0)->after('jumlah_steril');
            $table->integer('jumlah_proses_cssd')->default(0)->after('jumlah_kotor');
        });

        Schema::table('instrument_sets', function (Blueprint $table) {
            $table->integer('jumlah_steril')->default(0)->after('jumlah');
            $table->integer('jumlah_kotor')->default(0)->after('jumlah_steril');
            $table->integer('jumlah_proses_cssd')->default(0)->after('jumlah_kotor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['jumlah_steril', 'jumlah_kotor', 'jumlah_proses_cssd']);
        });

        Schema::table('instrument_sets', function (Blueprint $table) {
            $table->dropColumn(['jumlah_steril', 'jumlah_kotor', 'jumlah_proses_cssd']);
        });
    }
};
