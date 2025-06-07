@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto text-center">
        <h1 class="text-2xl font-bold mb-4">QR Code untuk {{ $anggota->nama }}</h1>

        <div class="mb-4">
            <p class="text-gray-700">Scan QR Code di bawah ini untuk mencatat kehadiran:</p>
        </div>

        <div class="flex justify-center mb-6">
            {{-- Menampilkan QR Code SVG --}}
            {!! $qrCodeSvg !!}
        </div>

        <p class="text-sm text-gray-600 mb-4">ID Kartu: <span class="font-semibold">{{ $anggota->id_card }}</span></p>

        {{-- Tombol untuk mengunduh QR Code --}}
        <div class="mt-6">
            {{-- Cara 1: Menggunakan rute Laravel untuk mengunduh --}}
            <a href="{{ route('anggotas.downloadQr', $anggota->id) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                Download QR Code (PNG)
            </a>

            {{-- Cara 2 (opsional): Mengunduh langsung dari data URI di browser --}}
            {{-- Ini lebih cepat karena tidak perlu request ke server lagi setelah halaman dimuat --}}
            {{-- <a href="data:image/png;base64,{{ $encodedQrCodePng }}" download="QR_Code_{{ $anggota->id_card }}.png" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out ml-2">
                Download QR Code (Data URI)
            </a> --}}
        </div>


        <a href="{{ route('anggotas.index', $anggota->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out mt-4">
            Kembali ke Detail Anggota
        </a>
    </div>
</div>
@endsection