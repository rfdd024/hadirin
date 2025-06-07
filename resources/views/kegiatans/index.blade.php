@extends('layouts.app') {{-- Sesuaikan dengan layout aplikasi Anda --}}

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Menggunakan container responsif dari layout --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6"> {{-- Flexbox untuk judul dan tombol --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Daftar Kegiatan</h1> {{-- Ukuran teks responsif --}}
        <a href="{{ route('kegiatans.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full sm:w-auto text-center"> {{-- Tombol responsif --}}
            Tambah Kegiatan Baru
        </a>
    </div>

    @if (session('success'))
        {{-- Menggunakan styling Tailwind untuk alert --}}
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg"> {{-- Membuat tabel bisa discroll horizontal pada layar kecil --}}
        <table class="min-w-full leading-normal"> {{-- min-w-full memastikan tabel tidak menyusut --}}
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left hidden sm:table-cell">ID</th> {{-- Sembunyikan di mobile --}}
                    <th class="py-3 px-6 text-left">Judul</th>
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($kegiatans as $kegiatan)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap hidden sm:table-cell">{{ $kegiatan->id }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $kegiatan->judul }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d F Y') }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2"> {{-- Flexbox untuk tombol aksi --}}
                            <a href="{{ route('kegiatans.show', $kegiatan->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out">Detail</a>
                            <a href="{{ route('kegiatans.edit', $kegiatan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out">Edit</a>
                            <form action="{{ route('kegiatans.destroy', $kegiatan->id) }}" method="POST" class="inline-block"> {{-- Menggunakan inline-block --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-3 px-6 text-center text-gray-500">Tidak ada kegiatan yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginasi dengan styling dasar Tailwind --}}
    <div class="mt-6">
        {{ $kegiatans->links('pagination::tailwind') }} {{-- Menggunakan view paginasi Tailwind --}}
    </div>
</div>
@endsection
