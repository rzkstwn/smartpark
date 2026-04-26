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
        Schema::create('parkirs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('kendaraan_id');
            $table->timestamp('waktu_masuk')->useCurrent();
            $table->integer('biaya')->nullable();
            $table->string('qr_code');
            $table->enum('status', ['masuk', 'keluar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkirs');
    }
};
