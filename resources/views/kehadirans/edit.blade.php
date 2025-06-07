@extends('layouts.app') {{-- Sesuaikan dengan layout Anda --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Edit Kehadiran</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Terjadi Kesalahan!</strong>
            <span class="block sm:inline">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto"> {{-- Card responsif untuk form --}}
        <form action="{{ route('kehadirans.update', $kehadiran->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="anggota_id" class="block text-gray-700 text-sm font-bold mb-2">Anggota:</label>
                {{-- Untuk Edit, Select2 tidak digunakan, jadi ini adalah select biasa. --}}
                <select name="anggota_id" id="anggota_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach ($anggotas as $anggota)
                        <option value="{{ $anggota->id }}" {{ old('anggota_id', $kehadiran->anggota_id) == $anggota->id ? 'selected' : '' }}>
                            {{ $anggota->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="kegiatan_id" class="block text-gray-700 text-sm font-bold mb-2">Kegiatan:</label>
                <select name="kegiatan_id" id="kegiatan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">-- Pilih Kegiatan --</option>
                    @foreach ($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id', $kehadiran->kegiatan_id) == $kegiatan->id ? 'selected' : '' }}>
                            {{ $kegiatan->judul }} ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Kehadiran:</label>
                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="hadir" {{ old('status', $kehadiran->status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="tidak hadir" {{ old('status', $kehadiran->status) == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    <option value="izin" {{ old('status', $kehadiran->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status', $kehadiran->status) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 text-sm font-bold mb-2">Keterangan (Opsional):</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('keterangan', $kehadiran->keterangan) }}</textarea>
            </div>
            <div class="mb-6"> {{-- mb-6 untuk elemen terakhir sebelum tombol --}}
                <label for="waktu_hadir" class="block text-gray-700 text-sm font-bold mb-2">Waktu Hadir (Opsional):</label>
                <input type="datetime-local" name="waktu_hadir" id="waktu_hadir" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('waktu_hadir', $kehadiran->waktu_hadir ? \Carbon\Carbon::parse($kehadiran->waktu_hadir)->format('Y-m-d\TH:i') : '') }}">
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0 sm:space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 w-full sm:w-auto transition duration-300 ease-in-out">
                    Update Kehadiran
                </button>
                <a href="{{ route('kehadirans.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 w-full text-center sm:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection