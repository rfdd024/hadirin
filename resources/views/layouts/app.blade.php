<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Hadirin')</title>
    <link rel="icon" href="{{ asset('images/ic_hadirin.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- AOS Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <style>
      .back-button {
        transition: all 0.3s ease-in-out;
      }
      .back-button:hover {
        background-color: #FFD700 !important;
        color: #000000 !important;
      }
      .nav-link {
        position: relative;
        display: inline-block;
        transition: color 0.3s ease;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.875rem; /* Tailwind text-sm */
      }
      .nav-link::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 0;
        height: 2px;
        background-color: #FFD700;
        transition: width 0.4s ease-in-out;
      }
      .nav-link:hover {
        color: #FFD700 !important;
      }
      .nav-link:hover::after {
        width: 100%;
      }
    </style>
</head>
<body class="bg-white text-gray-900" data-aos="fade-in" data-aos-duration="800">

  <!-- HEADER -->
  <header class="bg-black text-white py-8 h-64" data-aos="fade-down" data-aos-duration="800">
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
      <h1 class="text-3xl font-bold mb-2" data-aos="zoom-in" data-aos-delay="200">Dashboard Page Hadirin</h1>
      <p class="text-gray-300 text-sm" data-aos="fade-up" data-aos-delay="400">Selamat datang! Pilih menu di bawah untuk mengakses halaman.</p>
    </div>
    <!-- Back Button -->
    <a href="{{ route('landing') }}" 
      class="back-button absolute top-6 left-6 flex items-center justify-center w-10 h-10 rounded-full bg-white text-black shadow hover:scale-110 transition-all duration-300 ease-in-out"
      title="Kembali ke Landing Page"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
    </a>
  </header>

  <!-- NAVIGASI -->
  <nav class="bg-gray-800 py-3" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
    <div class="container mx-auto px-4">
      <ul class="flex flex-wrap justify-center gap-4">
        @php
          $items = [
            ['route'=>'kegiatans.index','label'=>'Kegiatan'],
            ['route'=>'kehadirans.index','label'=>'Kehadiran'],
            ['route'=>'kehadirans.scanQrForm','label'=>'Scan QR Hadir'],
            ['route'=>'anggotas.index','label'=>'Anggota'],
          ];
        @endphp
        @foreach($items as $item)
          <li>
            <a href="{{ route($item['route']) }}"
               class="nav-link"
               data-aos="fade-up" data-aos-delay="400">
              {{ $item['label'] }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </nav>

  <!-- CONTENT -->
  <main class="container mx-auto px-4 py-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
    @yield('content')
  </main>

  <!-- SCRIPTS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ once: true });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  @stack('scripts')
</body>
</html>
