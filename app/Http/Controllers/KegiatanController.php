<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Menampilkan daftar semua kegiatan.
     */
    public function index()
    {
        $kegiatans = Kegiatan::latest()->paginate(10); // Menampilkan 10 kegiatan per halaman, diurutkan dari terbaru
        return view('kegiatans.index', compact('kegiatans'));
    }

    /**
     * Menampilkan form untuk membuat kegiatan baru.
     */
    public function create()
    {
        return view('kegiatans.create');
    }

    /**
     * Menyimpan kegiatan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        Kegiatan::create($request->all());

        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu kegiatan.
     */
    public function show(Kegiatan $kegiatan)
    {
        return view('kegiatans.show', compact('kegiatan'));
    }

    /**
     * Menampilkan form untuk mengedit kegiatan yang sudah ada.
     */
    public function edit(Kegiatan $kegiatan)
    {
        return view('kegiatans.edit', compact('kegiatan'));
    }

    /**
     * Memperbarui kegiatan di database.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $kegiatan->update($request->all());

        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Menghapus kegiatan dari database.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil dihapus!');
    }
}