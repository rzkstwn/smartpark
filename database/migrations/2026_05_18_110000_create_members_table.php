<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('plat_nomor')->unique();
            $table->string('jenis_kendaraan');
            $table->string('nomor_hp')->nullable();
            $table->string('rfid_code')->nullable()->unique();
            $table->string('qr_code')->nullable()->unique();
            $table->date('masa_aktif_sampai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};
