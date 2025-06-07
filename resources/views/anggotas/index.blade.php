@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8"> {{-- Menggunakan container responsif dari layout --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6"> {{-- Flexbox untuk judul dan tombol --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Daftar Anggota</h1> {{-- Ukuran teks responsif --}}
        <a href="{{ route('anggotas.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out w-full sm:w-auto text-center"> {{-- Tombol responsif --}}
            Tambah Anggota
        </a>
    </div>

    @if(session('success'))
        {{-- Menggunakan styling Tailwind untuk alert, disarankan untuk menghapus kelas Bootstrap 'alert alert-success' jika sepenuhnya beralih ke Tailwind --}}
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg"> {{-- Membuat tabel bisa discroll horizontal pada layar kecil --}}
        <table class="min-w-full leading-normal"> {{-- min-w-full memastikan tabel tidak menyusut --}}
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left hidden md:table-cell">No HP</th> {{-- Sembunyikan di mobile --}}
                    <th class="py-3 px-6 text-left hidden lg:table-cell">Alamat</th> {{-- Sembunyikan di mobile dan tablet --}}
                    <th class="py-3 px-6 text-left hidden sm:table-cell">ID Card</th> {{-- Sembunyikan di mobile --}}
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($anggotas as $anggota)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $anggota->nama }}</td>
                    <td class="py-3 px-6 text-left">{{ $anggota->email }}</td>
                    <td class="py-3 px-6 text-left hidden md:table-cell">{{ $anggota->no_hp }}</td>
                    <td class="py-3 px-6 text-left hidden lg:table-cell">{{ $anggota->alamat }}</td>
                    <td class="py-3 px-6 text-left hidden sm:table-cell">{{ $anggota->id_card }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2"> {{-- Flexbox untuk tombol aksi --}}
                            <a href="{{ route('anggotas.edit', $anggota->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out">Edit</a>
                            <a href="{{ route('anggotas.showQr', $anggota->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out">QR Code</a>
                            <form action="{{ route('anggotas.destroy', $anggota->id) }}" method="POST" class="inline-block"> 
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-xs transition duration-300 ease-in-out" onclick="return confirm('Yakin ingin menghapus anggota ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection