<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'nama',
        'plat_nomor',
        'jenis_kendaraan',
        'nomor_hp',
        'rfid_code',
        'qr_code',
        'masa_aktif_sampai'
    ];

    public function parkirs()
    {
        return $this->hasMany(Parkir::class);
    }
}
