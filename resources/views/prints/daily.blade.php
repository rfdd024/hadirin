@extends('layouts.app') {{-- Pastikan Anda punya layout app --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Cetak Laporan Kehadiran Harian</h1> {{-- Ukuran teks responsif --}}

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

    <div class="bg-white shadow-md rounded-lg p-6 max-w-md mx-auto"> {{-- Card responsif, max-w-md untuk lebar terbatas di desktop, mx-auto untuk tengah --}}
        <form action="{{ route('prints.daily.generate') }}" method="POST">
            @csrf
            <div class="mb-4"> {{-- form-group diganti mb-4 --}}
                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tanggal:</label>
                <input type="date" name="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('date', date('Y-m-d')) }}" required>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0 sm:space-x-4"> {{-- Flexbox responsif untuk tombol --}}
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 w-full sm:w-auto transition duration-300 ease-in-out">
                    Cetak Laporan
                </button>
                <a href="{{ url('/') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 w-full text-center sm:w-auto"> {{-- Link kembali responsif --}}
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection