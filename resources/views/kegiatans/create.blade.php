@extends('layouts.app') {{-- Sesuaikan dengan layout aplikasi Anda --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Tambah Kegiatan Baru</h1>

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
        <form action="{{ route('kegiatans.store') }}" method="POST">
            @csrf
            <div class="mb-4"> {{-- form-group diganti mb-4 --}}
                <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul Kegiatan:</label>
                <input type="text" name="judul" id="judul" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('judul') }}" required>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="5" required>{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-6"> {{-- mb-6 untuk elemen terakhir sebelum tombol --}}
                <label for="tanggal" class="block text-gray-700 text-sm font-bold mb-2">Tanggal:</label>
                <input type="date" name="tanggal" id="tanggal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('tanggal') }}" required>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0 sm:space-x-4"> {{-- Flexbox responsif untuk tombol --}}
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 w-full sm:w-auto transition duration-300 ease-in-out">
                    Simpan Kegiatan
                </button>
                <a href="{{ route('kegiatans.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 w-full text-center sm:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection