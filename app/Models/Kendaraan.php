<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    public function parkir()
{
    return $this->hasMany(Parkir::class);
}
protected $fillable = [
    'jenis_kendaraan',
    'plat_nomor'
];
}
