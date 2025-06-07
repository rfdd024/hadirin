<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
    ];

    // Relasi: Satu kegiatan bisa memiliki banyak kehadiran
    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }
}