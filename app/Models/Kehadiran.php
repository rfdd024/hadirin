<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'kegiatan_id',
        'status',
        'keterangan',
        'waktu_hadir',
    ];

    // Relasi: Kehadiran dimiliki oleh satu Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relasi: Kehadiran dimiliki oleh satu Kegiatan
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}