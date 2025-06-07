<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Anggota; // Import model Anggota
use App\Models\Kegiatan; // Import model Kegiatan
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QrCode facade
use Carbon\Carbon;
use Illuminate\Support\Facades\File; // Tambahkan ini di atas
use Illuminate\Support\Facades\Response;

class KehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kehadirans = Kehadiran::with(['anggota', 'kegiatan'])->latest()->paginate(10);
        return view('kehadirans.index', compact('kehadirans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kita tidak perlu lagi mengirim semua anggota ke view ini,
        // karena pencarian akan dilakukan via AJAX
        $kegiatans = Kegiatan::all();
        return view('kehadirans.create', compact('kegiatans'));
    }

    public function searchAnggota(Request $request)
    {
        $search = $request->query('term'); // Select2 menggunakan 'term' untuk query pencarian

        if (empty($search)) {
            return response()->json(['results' => []]);
        }

        $anggotas = Anggota::where('nama', 'LIKE', '%' . $search . '%')
                           ->orWhere('email', 'LIKE', '%' . $search . '%')
                           ->limit(10) // Batasi hasil pencarian
                           ->get(['id', 'nama', 'email']); // Hanya ambil kolom yang dibutuhkan

        $formattedAnggotas = [];
        foreach ($anggotas as $anggota) {
            $formattedAnggotas[] = [
                'id' => $anggota->id,
                'text' => $anggota->nama . ' (' . $anggota->email . ')', // Format tampilan di Select2
            ];
        }

        return response()->json(['results' => $formattedAnggotas]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'status' => ['required', Rule::in(['hadir', 'tidak hadir', 'izin', 'sakit'])],
            'keterangan' => 'nullable|string|max:500',
            'waktu_hadir' => 'nullable|date',
        ]);

        // Periksa apakah kehadiran sudah ada untuk anggota dan kegiatan yang sama
        $existingKehadiran = Kehadiran::where('anggota_id', $request->anggota_id)
                                    ->where('kegiatan_id', $request->kegiatan_id)
                                    ->first();

        if ($existingKehadiran) {
            return redirect()->back()->withErrors(['message' => 'Kehadiran untuk anggota ini pada kegiatan ini sudah ada. Harap edit jika ingin mengubahnya.'])->withInput();
        }

        Kehadiran::create($request->all());

        return redirect()->route('kehadirans.index')->with('success', 'Data kehadiran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kehadiran $kehadiran)
    {
        // Model binding otomatis mengambil kehadiran dan meload relasi
        return view('kehadirans.show', compact('kehadiran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kehadiran $kehadiran)
    {
        $anggotas = Anggota::all();
        $kegiatans = Kegiatan::all();
        return view('kehadirans.edit', compact('kehadiran', 'anggotas', 'kegiatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kehadiran $kehadiran)
    {
        $request->validate([
            'anggota_id' => [
                'required',
                'exists:anggotas,id',
                // Pastikan kombinasi anggota_id dan kegiatan_id unik, kecuali untuk kehadiran yang sedang diedit
                Rule::unique('kehadirans')->ignore($kehadiran->id)->where(function ($query) use ($request) {
                    return $query->where('kegiatan_id', $request->kegiatan_id);
                }),
            ],
            'kegiatan_id' => [
                'required',
                'exists:kegiatans,id',
                // Pastikan kombinasi anggota_id dan kegiatan_id unik, kecuali untuk kehadiran yang sedang diedit
                Rule::unique('kehadirans')->ignore($kehadiran->id)->where(function ($query) use ($request) {
                    return $query->where('anggota_id', $request->anggota_id);
                }),
            ],
            'status' => ['required', Rule::in(['hadir', 'tidak hadir', 'izin', 'sakit'])],
            'keterangan' => 'nullable|string|max:500',
            'waktu_hadir' => 'nullable|date',
        ]);

        $kehadiran->update($request->all());

        return redirect()->route('kehadirans.index')->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kehadiran $kehadiran)
    {
        $kehadiran->delete();

        return redirect()->route('kehadirans.index')->with('success', 'Data kehadiran berhasil dihapus.');
    }

        /**
     * Show the form for scanning QR Code for attendance.
     */
    public function scanQrForm()
    {
        $kegiatans = Kegiatan::all(); // Untuk memilih kegiatan mana yang akan dicatat kehadirannya
        return view('kehadirans.scan_qr', compact('kegiatans'));
    }

    /**
     * Process the QR Code scan for attendance.
     * This will be an API endpoint called by JavaScript after scanning.
     */
    public function processQrScan(Request $request)
    {
        $request->validate([
            'id_card' => 'required|string|exists:anggotas,id_card', // Validasi id_card dari QR
            'kegiatan_id' => 'required|exists:kegiatans,id', // Validasi kegiatan yang dipilih
        ]);

        $anggota = Anggota::where('id_card', $request->id_card)->first();
        $kegiatanId = $request->kegiatan_id;

        if (!$anggota) {
            return response()->json(['success' => false, 'message' => 'Anggota tidak ditemukan.'], 404);
        }

        // Periksa apakah kehadiran sudah ada untuk anggota ini pada kegiatan ini
        $existingKehadiran = Kehadiran::where('anggota_id', $anggota->id)
                                    ->where('kegiatan_id', $kegiatanId)
                                    ->first();

        if ($existingKehadiran) {
            return response()->json(['success' => false, 'message' => 'Anggota ini sudah tercatat kehadirannya untuk kegiatan ini.'], 409); // Conflict
        }

        // Catat kehadiran
        Kehadiran::create([
            'anggota_id' => $anggota->id,
            'kegiatan_id' => $kegiatanId,
            'status' => 'hadir', // Status default saat scan QR adalah 'hadir'
            'waktu_hadir' => Carbon::now(),
            'keterangan' => 'Hadir via QR Code',
        ]);

        return response()->json(['success' => true, 'message' => $anggota->nama . ' berhasil dicatat kehadirannya!', 'anggota' => $anggota->nama, 'kegiatan' => Kegiatan::find($kegiatanId)->judul]);
    }

    /**
     * Show the QR Code for a specific Anggota.
     * This method will generate and display the QR Code.
     */
    /**
     * Show the QR Code for a specific Anggota and provide a download link.
     */
    public function showAnggotaQr($id)
    {
        $anggota = Anggota::findOrFail($id);
        $qrCodeSvg = QrCode::size(300)->generate($anggota->id_card); // Tetap generate SVG untuk tampilan

        // // Generate QR Code sebagai PNG untuk diunduh
        // // Penting: Pastikan Anda telah menginstal GD Library atau Imagick di server PHP Anda
        // $qrCodePngData = QrCode::format('png')->size(300)->generate($anggota->id_card);
        // $encodedQrCodePng = base64_encode($qrCodePngData); // Encode ke base64 untuk sematan dalam data URI

        return view('anggotas.show_qr', compact('anggota', 'qrCodeSvg'));
    }

    /**
     * Download the QR Code for a specific Anggota.
     */
    public function downloadAnggotaQr($id)
    {
        $anggota = Anggota::findOrFail($id);
        $qrCodePng = QrCode::format('png')->size(300)->generate($anggota->id_card);

        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="QR_Code_Anggota_' . $anggota->id_card . '.png"',
        ];

        return Response::make($qrCodePng, 200, $headers);
    }
}