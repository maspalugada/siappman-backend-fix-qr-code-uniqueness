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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->string('qr_code')->unique();
            $table->text('qr_image'); // base64 encoded SVG
            $table->integer('sequence_number'); // 1, 2, 3, etc.
            $table->enum('status', ['active', 'scanned', 'inactive'])->default('active');
            $table->timestamp('scanned_at')->nullable();
            $table->timestamps();

            $table->index(['asset_id', 'sequence_number']);
            $table->index('qr_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
