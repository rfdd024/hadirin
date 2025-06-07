<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import facade PDF
use Carbon\Carbon; // Untuk manipulasi tanggal

class PrintController extends Controller
{
    /**
     * Tampilkan formulir untuk pilihan cetak harian.
     */
    public function showDailyPrintForm()
    {
        // Pastikan 'category' diteruskan ke view
        return view('prints.daily', ['category' => 'prints']);
    }

    /**
     * Cetak laporan kehadiran harian.
     */
    public function printDaily(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $selectedDate = Carbon::parse($request->input('date'));

        $kehadirans = Kehadiran::with(['anggota', 'kegiatan'])
                               ->whereDate('waktu_hadir', $selectedDate)
                               ->orderBy('waktu_hadir')
                               ->get();

        $pdf = Pdf::loadView('prints.templates.daily_report', compact('kehadirans', 'selectedDate'));
        return $pdf->stream('laporan_kehadiran_harian_' . $selectedDate->format('Y-m-d') . '.pdf');
    }

    /**
     * Tampilkan formulir untuk pilihan cetak bulanan.
     */
    public function showMonthlyPrintForm()
    {
        // Pastikan 'category' diteruskan ke view
        return view('prints.monthly', ['category' => 'prints']);
    }

    /**
     * Cetak laporan kehadiran bulanan.
     */
    public function printMonthly(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5), // Batasi tahun
        ]);

        $month = $request->input('month');
        $year = $request->input('year');

        // Gunakan Carbon untuk mendapatkan awal dan akhir bulan
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        $kehadirans = Kehadiran::with(['anggota', 'kegiatan'])
                               ->whereBetween('waktu_hadir', [$startDate, $endDate])
                               ->orderBy('waktu_hadir')
                               ->get();

        $pdf = Pdf::loadView('prints.templates.monthly_report', compact('kehadirans', 'month', 'year', 'startDate', 'endDate'));
        return $pdf->stream('laporan_kehadiran_bulanan_' . $year . '_' . $month . '.pdf');
    }

    /**
     * Tampilkan formulir untuk pilihan cetak tahunan.
     */
    public function showAnnualPrintForm()
    {
        // Pastikan 'category' diteruskan ke view
        return view('prints.annual', ['category' => 'prints']);
    }

    /**
     * Cetak laporan kehadiran tahunan.
     */
    public function printAnnual(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5), // Batasi tahun
        ]);

        $year = $request->input('year');

        // Gunakan Carbon untuk mendapatkan awal dan akhir tahun
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfDay();
        $endDate = Carbon::createFromDate($year, 12, 31)->endOfDay();

        $kehadirans = Kehadiran::with(['anggota', 'kegiatan'])
                               ->whereBetween('waktu_hadir', [$startDate, $endDate])
                               ->orderBy('waktu_hadir')
                               ->get();

        $pdf = Pdf::loadView('prints.templates.annual_report', compact('kehadirans', 'year', 'startDate', 'endDate'));
        return $pdf->stream('laporan_kehadiran_tahunan_' . $year . '.pdf');
    }
}