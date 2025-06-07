@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Menggunakan container responsif dari layout --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6"> {{-- Flexbox untuk judul dan tombol --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Daftar Kehadiran</h1> {{-- Ukuran teks responsif --}}
        <a href="{{ route('kehadirans.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full sm:w-auto text-center"> {{-- Tombol responsif --}}
            Tambah Kehadiran
        </a>
    </div>

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

    <div class="overflow-x-auto bg-white shadow-md rounded-lg"> {{-- Membuat tabel bisa discroll horizontal pada layar kecil --}}
        <table class="min-w-full leading-normal"> {{-- min-w-full memastikan tabel tidak menyusut --}}
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left hidden lg:table-cell">ID</th> {{-- Sembunyikan di mobile dan tablet --}}
                    <th class="py-3 px-6 text-left">Anggota</th>
                    <th class="py-3 px-6 text-left hidden md:table-cell">Kegiatan</th> {{-- Sembunyikan di mobile --}}
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left hidden sm:table-cell">Keterangan</th> {{-- Sembunyikan di mobile --}}
                    <th class="py-3 px-6 text-left hidden md:table-cell">Waktu Hadir</th> {{-- Sembunyikan di mobile --}}
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($kehadirans as $kehadiran)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap hidden lg:table-cell">{{ $kehadiran->id }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $kehadiran->anggota->nama ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap hidden md:table-cell">{{ $kehadiran->kegiatan->judul ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ ucfirst($kehadiran->status) }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap hidden sm:table-cell">{{ $kehadiran->keterangan ?? '-' }}</td>
                    <td class="py-3 px-6 text-left whitespace-nowrap hidden md:table-cell">{{ $kehadiran->waktu_hadir ? \Carbon\Carbon::parse($kehadiran->waktu_hadir)->format('d M Y H:i') : '-' }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2"> {{-- Flexbox untuk tombol aksi --}}
                            <a href="{{ route('kehadirans.show', $kehadiran->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out">Detail</a>
                            <a href="{{ route('kehadirans.edit', $kehadiran->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out">Edit</a>
                            <form action="{{ route('kehadirans.destroy', $kehadiran->id) }}" method="POST" class="inline-block"> {{-- Menggunakan inline-block --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out" onclick="return confirm('Apakah Anda yakin ingin menghapus kehadiran ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-3 px-6 text-center text-gray-500">Tidak ada data kehadiran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginasi dengan styling dasar Tailwind --}}
    <div class="mt-6">
        {{ $kehadirans->links('pagination::tailwind') }} {{-- Menggunakan view paginasi Tailwind --}}
    </div>
</div>
@endsection