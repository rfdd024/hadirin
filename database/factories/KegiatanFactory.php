<?php

namespace Database\Factories;

use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KegiatanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kegiatan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(rand(3, 7)), // Kalimat acak 3-7 kata
            'deskripsi' => $this->faker->paragraph(rand(3, 7)), // Paragraf acak 3-7 kalimat
            'tanggal' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'), // Tanggal antara sekarang dan 1 tahun ke depan
        ];
    }
}