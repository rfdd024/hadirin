@extends('layouts.app') {{-- Sesuaikan dengan layout aplikasi Anda --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Detail Kegiatan</h1>

    <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-md mx-auto"> {{-- Card responsif untuk detail --}}
        <div class="bg-gray-200 px-6 py-4 border-b border-gray-300"> {{-- card-header diganti --}}
            <h2 class="text-xl font-semibold text-gray-800">{{ $kegiatan->judul }}</h2>
        </div>
        <div class="p-6"> {{-- card-body diganti --}}
            <p class="mb-2"><strong>Judul:</strong> <span class="text-gray-700">{{ $kegiatan->judul }}</span></p>
            <p class="mb-2"><strong>Tanggal:</strong> <span class="text-gray-700">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d F Y') }}</span></p>
            <p class="mb-2"><strong>Deskripsi:</strong></p>
            <p class="text-gray-700 mb-4">{{ $kegiatan->deskripsi }}</p>
            <p class="text-sm text-gray-500 mb-1"><strong>Dibuat Pada:</strong> {{ $kegiatan->created_at->format('d M Y H:i') }}</p>
            <p class="text-sm text-gray-500"><strong>Terakhir Diperbarui:</strong> {{ $kegiatan->updated_at->format('d M Y H:i') }}</p>
        </div>
        <div class="bg-gray-100 px-6 py-4 border-t border-gray-300 flex flex-col sm:flex-row justify-end items-center space-y-3 sm:space-y-0 sm:space-x-3"> {{-- card-footer diganti, flexbox untuk tombol --}}
            <a href="{{ route('kegiatans.edit', $kegiatan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-sm transition duration-300 ease-in-out w-full sm:w-auto text-center">Edit</a>
            <form action="{{ route('kegiatans.destroy', $kegiatan->id) }}" method="POST" class="w-full sm:w-auto"> {{-- Menggunakan w-full sm:w-auto untuk form --}}
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded text-sm transition duration-300 ease-in-out w-full" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">Hapus</button>
            </form>
            <a href="{{ route('kegiatans.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-sm transition duration-300 ease-in-out w-full sm:w-auto text-center">Kembali ke Daftar</a>
        </div>
    </div>
</div>
@endsection