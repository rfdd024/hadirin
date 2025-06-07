@extends('layouts.app') {{-- Sesuaikan dengan layout Anda --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Detail Kehadiran</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-md mx-auto"> {{-- Card responsif untuk detail --}}
        <div class="bg-gray-200 px-6 py-4 border-b border-gray-300">
            <h2 class="text-xl font-semibold text-gray-800">Kehadiran #{{ $kehadiran->id }}</h2>
        </div>
        <div class="p-6">
            <p class="mb-2"><strong>Anggota:</strong> <span class="text-gray-700">{{ $kehadiran->anggota->nama ?? 'N/A' }}</span></p>
            <p class="mb-2"><strong>Email Anggota:</strong> <span class="text-gray-700">{{ $kehadiran->anggota->email ?? 'N/A' }}</span></p>
            <p class="mb-2"><strong>Kegiatan:</strong> <span class="text-gray-700">{{ $kehadiran->kegiatan->judul ?? 'N/A' }}</span></p>
            <p class="mb-2"><strong>Tanggal Kegiatan:</strong> <span class="text-gray-700">{{ $kehadiran->kegiatan->tanggal ? \Carbon\Carbon::parse($kehadiran->kegiatan->tanggal)->format('d M Y') : 'N/A' }}</span></p>
            <p class="mb-2"><strong>Status:</strong> <span class="text-gray-700">{{ ucfirst($kehadiran->status) }}</span></p>
            <p class="mb-2"><strong>Keterangan:</strong> <span class="text-gray-700">{{ $kehadiran->keterangan ?? '-' }}</span></p>
            <p class="mb-4"><strong>Waktu Hadir:</strong> <span class="text-gray-700">{{ $kehadiran->waktu_hadir ? \Carbon\Carbon::parse($kehadiran->waktu_hadir)->format('d M Y H:i') : '-' }}</span></p>
            <p class="text-sm text-gray-500 mb-1"><strong>Dibuat Pada:</strong> {{ $kehadiran->created_at->format('d M Y H:i') }}</p>
            <p class="text-sm text-gray-500"><strong>Terakhir Diperbarui:</strong> {{ $kehadiran->updated_at->format('d M Y H:i') }}</p>
        </div>
        <div class="bg-gray-100 px-6 py-4 border-t border-gray-300 flex flex-col sm:flex-row justify-end items-center space-y-3 sm:space-y-0 sm:space-x-3">
            <a href="{{ route('kehadirans.edit', $kehadiran->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-sm transition duration-300 ease-in-out w-full sm:w-auto text-center">Edit</a>
            <form action="{{ route('kehadirans.destroy', $kehadiran->id) }}" method="POST" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded text-sm transition duration-300 ease-in-out w-full" onclick="return confirm('Apakah Anda yakin ingin menghapus kehadiran ini?')">Hapus</button>
            </form>
            <a href="{{ route('kehadirans.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-sm transition duration-300 ease-in-out w-full sm:w-auto text-center">Kembali ke Daftar</a>
        </div>
    </div>
</div>
@endsection