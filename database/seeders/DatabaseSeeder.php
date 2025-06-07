<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota; // Import model Anggota
use App\Models\Kegiatan; // Import model Kegiatan
use App\Models\Kehadiran; // Import model Kehadiran
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama (opsional, berguna saat development)
        Kehadiran::truncate();
        Anggota::truncate();
        Kegiatan::truncate();

        // Buat 20 anggota dummy
        Anggota::factory(20)->create();

        // Buat 10 kegiatan dummy
        Kegiatan::factory(10)->create();

        // Buat data kehadiran
        // Ambil semua anggota dan kegiatan yang sudah ada
        $anggotas = Anggota::all();
        $kegiatans = Kegiatan::all();

        // Buat kehadiran untuk beberapa kombinasi anggota dan kegiatan
        foreach ($kegiatans as $kegiatan) {
            // Setiap kegiatan akan memiliki kehadiran dari sekitar 5-15 anggota acak
            $randomAnggotas = $anggotas->random(rand(5, min(15, $anggotas->count())));

            foreach ($randomAnggotas as $anggota) {
                // Pastikan tidak ada duplikasi sebelum membuat kehadiran
                if (!Kehadiran::where('anggota_id', $anggota->id)
                             ->where('kegiatan_id', $kegiatan->id)
                             ->exists()) {
                    Kehadiran::factory()->create([
                        'anggota_id' => $anggota->id,
                        'kegiatan_id' => $kegiatan->id,
                        // Anda bisa override data faker di sini jika ingin lebih spesifik
                        // 'status' => 'hadir',
                    ]);
                }
            }
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Contoh membuat user admin (jika ada model User)
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}