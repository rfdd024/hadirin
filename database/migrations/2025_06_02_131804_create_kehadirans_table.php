<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel anggotas
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
            // Foreign key ke tabel kegiatans
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->onDelete('cascade');
            $table->enum('status', ['hadir', 'tidak hadir', 'izin', 'sakit'])->default('hadir');
            $table->text('keterangan')->nullable(); // Untuk alasan izin/sakit atau catatan lain
            $table->timestamp('waktu_hadir')->nullable(); // Waktu spesifik kehadiran
            $table->timestamps();

            // Memastikan satu anggota hanya bisa memiliki satu status kehadiran per kegiatan
            $table->unique(['anggota_id', 'kegiatan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};