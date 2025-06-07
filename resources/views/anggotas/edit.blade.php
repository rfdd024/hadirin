@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Edit Anggota</h1> {{-- Ukuran teks responsif dan ditengah --}}

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert"> {{-- Styling Tailwind untuk alert --}}
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
        <form action="{{ route('anggotas.update', $anggota->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Add this line for PUT method spoofing --}}
            <div class="mb-4"> {{-- form-group diganti mb-4 --}}
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama:</label>
                <input type="text" name="nama" id="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('nama', $anggota->nama) }}" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('email', $anggota->email) }}" required>
            </div>
            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">No HP:</label>
                <input type="text" name="no_hp" id="no_hp" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('no_hp', $anggota->no_hp) }}">
            </div>
            <div class="mb-6"> {{-- mb-6 untuk elemen terakhir sebelum tombol --}}
                <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat:</label>
                <textarea name="alamat" id="alamat" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('alamat', $anggota->alamat) }}</textarea>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0 sm:space-x-4"> {{-- Flexbox responsif untuk tombol --}}
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 w-full sm:w-auto transition duration-300 ease-in-out">
                    Simpan Perubahan
                </button>
                <a href="{{ route('anggotas.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 w-full text-center sm:w-auto"> {{-- Link kembali responsif --}}
                    Kembali ke Daftar Anggota
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
