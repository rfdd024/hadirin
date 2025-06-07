@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800 text-center">Tambah Kehadiran Baru</h1>

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
        <form action="{{ route('kehadirans.store') }}" method="POST">
            @csrf
            <div class="mb-4"> {{-- form-group diganti mb-4 --}}
                <label for="anggota_id" class="block text-gray-700 text-sm font-bold mb-2">Anggota:</label>
                {{-- Select2 akan mengelola styling ini, namun kita tetap berikan kelas dasar untuk konsistensi --}}
                <select name="anggota_id" id="anggota_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">Cari Anggota...</option>
                </select>
                @error('anggota_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p> {{-- Styling Tailwind untuk pesan error validasi --}}
                @enderror
            </div>
            <div class="mb-4">
                <label for="kegiatan_id" class="block text-gray-700 text-sm font-bold mb-2">Kegiatan:</label>
                <select name="kegiatan_id" id="kegiatan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="">-- Pilih Kegiatan --</option>
                    @foreach ($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id') == $kegiatan->id ? 'selected' : '' }}>
                            {{ $kegiatan->judul }} ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Kehadiran:</label>
                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="tidak hadir" {{ old('status') == 'tidak hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 text-sm font-bold mb-2">Keterangan (Opsional):</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('keterangan') }}</textarea>
            </div>
            <div class="mb-6"> {{-- mb-6 untuk elemen terakhir sebelum tombol --}}
                <label for="waktu_hadir" class="block text-gray-700 text-sm font-bold mb-2">Waktu Hadir (Opsional):</label>
                <input type="datetime-local" name="waktu_hadir" id="waktu_hadir" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ old('waktu_hadir', now()->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 space-y-4 sm:space-y-0 sm:space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 w-full sm:w-auto transition duration-300 ease-in-out">
                    Simpan Kehadiran
                </button>
                <a href="{{ route('kehadirans.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800 w-full text-center sm:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts') {{-- Memasukkan script ke stack 'scripts' di layout --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#anggota_id').select2({
            placeholder: 'Cari Anggota berdasarkan nama atau email...',
            minimumInputLength: 2, // Mulai pencarian setelah 2 karakter
            ajax: {
                url: '{{ route('kehadirans.searchAnggota') }}', // URL endpoint pencarian anggota
                dataType: 'json',
                delay: 250, // Penundaan saat mengetik
                data: function (params) {
                    return {
                        term: params.term // Parameter pencarian yang dikirim ke server
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results // Mengambil array 'results' dari respons JSON
                    };
                },
                cache: true
            },
            // Menambahkan kelas Tailwind ke elemen Select2 yang dihasilkan
            // Ini mungkin memerlukan sedikit penyesuaian CSS kustom jika ada konflik visual
            theme: "default" // Gunakan tema default Select2, atau buat tema kustom
        });

        // Jika ada nilai old('anggota_id') (misal setelah validasi gagal)
        @if(old('anggota_id'))
            // Dapatkan ID anggota yang lama
            var oldAnggotaId = "{{ old('anggota_id') }}";
            // Lakukan AJAX call untuk mendapatkan detail anggota berdasarkan ID
            $.ajax({
                type: 'GET',
                url: '{{ route('kehadirans.searchAnggota') }}?term=' + oldAnggotaId, // Kirim ID sebagai 'term'
                dataType: 'json'
            }).then(function (data) {
                if (data.results && data.results.length > 0) {
                    // Buat opsi dan set sebagai terpilih
                    var option = new Option(data.results[0].text, data.results[0].id, true, true);
                    $('#anggota_id').append(option).trigger('change');
                }
            });
        @endif
    });
</script>
@endpush