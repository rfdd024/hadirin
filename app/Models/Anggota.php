<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'id_card',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($anggota) {
            $anggota->id_card = self::generateUniqueIdCard();
        });
    }

    private static function generateUniqueIdCard()
    {
        do {
            $id = Str::upper(Str::random(5));
        } while (self::where('id_card', $id)->exists());

        return $id;
    }

    // Relasi: Satu anggota bisa memiliki banyak kehadiran
    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class);
    }
}
