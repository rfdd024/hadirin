<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehadiran Harian</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1, h2 { text-align: center; }
        .date { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Laporan Kehadiran Harian</h1>
    <div class="date">
        Tanggal: {{ $selectedDate->format('d F Y') }}
    </div>

    @if($kehadirans->isEmpty())
        <p style="text-align: center;">Tidak ada data kehadiran untuk tanggal ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Anggota</th>
                    <th>Kegiatan</th>
                    <th>Status</th>
                    <th>Waktu Hadir</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kehadirans as $index => $kehadiran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kehadiran->anggota->nama ?? 'N/A' }}</td>
                    <td>{{ $kehadiran->kegiatan->judul ?? 'N/A' }}</td>
                    <td>{{ ucfirst($kehadiran->status) }}</td>
                    <td>{{ $kehadiran->waktu_hadir ? \Carbon\Carbon::parse($kehadiran->waktu_hadir)->format('H:i') : '-' }}</td>
                    <td>{{ $kehadiran->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>