<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('plat_nomor')->unique();
            $table->string('jenis_kendaraan');
            $table->string('nomor_hp')->nullable();
            $table->string('rfid_code')->nullable();
            $table->string('qr_code')->nullable();
            $table->date('masa_aktif_sampai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};