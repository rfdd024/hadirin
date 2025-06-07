@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Pindai QR Code Kehadiran</h1>

    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <label for="kegiatan_id_qr" class="block text-gray-700 text-sm font-bold mb-2">Pilih Kegiatan:</label>
            <select name="kegiatan_id" id="kegiatan_id_qr" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                <option value="">-- Pilih Kegiatan --</option>
                @foreach ($kegiatans as $kegiatan)
                    <option value="{{ $kegiatan->id }}">
                        {{ $kegiatan->judul }} ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div id="reader" class="w-full h-auto"></div> {{-- Element untuk QR Code reader --}}
        <div id="qr-reader-results" class="mt-4 text-center">
            <p class="text-lg font-semibold text-gray-700">Hasil Scan:</p>
            <p id="qr-result-text" class="text-blue-600"></p>
            <p id="attendance-message" class="mt-2 text-sm text-gray-800"></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Handle the scanned code, e.g., send it to your server
        console.log(`Code matched = ${decodedText}`, decodedResult);
        document.getElementById('qr-result-text').innerText = `QR Code Terdeteksi: ${decodedText}`;

        let kegiatanId = document.getElementById('kegiatan_id_qr').value;

        if (!kegiatanId) {
            document.getElementById('attendance-message').innerText = 'Pilih kegiatan terlebih dahulu!';
            document.getElementById('attendance-message').classList.remove('text-green-700', 'text-red-700');
            document.getElementById('attendance-message').classList.add('text-yellow-700');
            return;
        }

        // Kirim data ke backend Laravel
        $.ajax({
            url: '{{ route('kehadirans.processQrScan') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id_card: decodedText, // Data dari QR Code (id_card anggota)
                kegiatan_id: kegiatanId
            },
            success: function(response) {
                document.getElementById('attendance-message').innerText = response.message;
                document.getElementById('attendance-message').classList.remove('text-yellow-700', 'text-red-700');
                document.getElementById('attendance-message').classList.add('text-green-700');
                if (response.anggota && response.kegiatan) {
                    document.getElementById('attendance-message').innerText += ` (Anggota: ${response.anggota}, Kegiatan: ${response.kegiatan})`;
                }
                // Optional: Stop scanner setelah berhasil atau biarkan terus scan
                // html5QrcodeScanner.clear();
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat mencatat kehadiran.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                document.getElementById('attendance-message').innerText = errorMessage;
                document.getElementById('attendance-message').classList.remove('text-green-700', 'text-yellow-700');
                document.getElementById('attendance-message').classList.add('text-red-700');
            }
        });
    }

    function onScanError(errorMessage) {
        // Handle scan error (optional)
        // console.warn(`QR Code Scan Error: ${errorMessage}`);
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: {width: 250, height: 250} });
    html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>
@endpush