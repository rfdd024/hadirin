<?php

namespace Database\Factories;

use App\Models\Kehadiran;
use App\Models\Anggota; // Import Anggota model
use App\Models\Kegiatan; // Import Kegiatan model
use Illuminate\Database\Eloquent\Factories\Factory;

class KehadiranFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kehadiran::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['hadir', 'tidak hadir', 'izin', 'sakit']);
        $keterangan = null;
        if (in_array($status, ['izin', 'sakit'])) {
            $keterangan = $this->faker->sentence();
        }

        return [
            // Anggota::factory() dan Kegiatan::factory() akan otomatis membuat anggota/kegiatan jika belum ada
            'anggota_id' => Anggota::factory(),
            'kegiatan_id' => Kegiatan::factory(),
            'status' => $status,
            'keterangan' => $keterangan,
            'waktu_hadir' => $this->faker->dateTimeBetween('-1 month', 'now'), // Waktu hadir dalam 1 bulan terakhir
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Kehadiran $kehadiran) {
            // Ini untuk mengatasi unique constraint jika kombinasi anggota_id dan kegiatan_id sudah ada.
            // Factory akan mencoba membuat kehadiran baru, jika gagal karena duplikat, akan melewatkan.
            // Namun, dalam kasus seeding massal, lebih baik pastikan dulu atau handle di seeder.
            // Untuk skenario sederhana, ini mungkin tidak diperlukan jika Anda seed satu per satu atau menggunakan unique kombinasi.
        });
    }
}