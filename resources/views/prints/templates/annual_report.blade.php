<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehadiran Tahunan</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1, h2 { text-align: center; }
        .period { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Laporan Kehadiran Tahunan</h1>
    <div class="period">
        Tahun: {{ $year }}
    </div>

    @if($kehadirans->isEmpty())
        <p style="text-align: center;">Tidak ada data kehadiran untuk tahun ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Anggota</th>
                    <th>Kegiatan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kehadirans as $index => $kehadiran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kehadiran->waktu_hadir ? \Carbon\Carbon::parse($kehadiran->waktu_hadir)->format('d F Y') : '-' }}</td>
                    <td>{{ $kehadiran->anggota->nama ?? 'N/A' }}</td>
                    <td>{{ $kehadiran->kegiatan->judul ?? 'N/A' }}</td>
                    <td>{{ ucfirst($kehadiran->status) }}</td>
                    <td>{{ $kehadiran->keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>