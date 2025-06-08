<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hadirin | Landing Page</title>
  <link rel="icon" href="{{ asset('images/ic_hadirin.png') }}" type="image/x-icon" />
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  
  <!-- Google Fonts -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    body {
      font-family: 'Inter', sans-serif;
    }
    .underline-animate {
      position: relative;
      display: inline-block;
    }
    .underline-animate::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -2px;
      height: 2px;
      width: 0%;
      background-color: #FFD700;
      transition: width 0.3s ease;
    }
    .underline-animate:hover::after {
      width: 100%;
    }
  </style>
</head>
<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-200 relative">

  <!-- Header -->
  <header class="bg-white dark:bg-gray-800 shadow-md py-4">
    <div class="container mx-auto px-4 flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <img src="{{ asset('images/ic_hadirin.png') }}" alt="Logo" class="w-12 h-12" />
        <h1 class="text-xl font-bold text-[#001F3F] dark:text-yellow-400">Hadirin App</h1>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section
    class="relative py-20 md:py-28 lg:py-32 bg-cover bg-center"
    style="background-image: url('{{ asset('images/classroom.jpeg') }}');"
  >
    <div class="absolute inset-0 bg-yellow-100 bg-opacity-60 backdrop-blur-sm"></div>
    <div class="relative container mx-auto px-4 text-center" data-aos="fade-up">
      <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4 text-[#001F3F] dark:text-yellow-400">
        Hadirin
      </h1>
      <p class="text-base md:text-lg mb-6 max-w-2xl mx-auto text-black dark:text-gray-300">
        Platform digital untuk mencatat kehadiran guru secara efisien dan modern.
      </p>
      <a
        href="#features"
        class="px-6 py-3 bg-[#FFD700] text-white rounded-md font-semibold hover:bg-yellow-400 transition"
      >
        Get Started
      </a>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-12 md:py-16 lg:py-20 bg-yellow-50 dark:bg-gray-800 text-center">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold mb-2 text-[#001F3F] dark:text-yellow-400" data-aos="fade-up">Fitur</h2>
      <div class="w-24 h-1 bg-[#FFD700] mx-auto mb-10"></div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <a
          href="{{ route('anggotas.index') }}"
          class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition block"
          data-aos="fade-up"
          data-aos-delay="100"
        >
          <div class="text-[#001F3F] text-4xl mb-4">
            <i class="fas fa-tools"></i>
          </div>
          <h3 class="text-xl font-semibold mb-2">Tools</h3>
          <p class="text-gray-700 dark:text-gray-300">Kelola data kehadiran dengan berbagai alat bantu yang disediakan.</p>
        </a>
        <a
          href="{{ route('prints.daily.form') }}"
          class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition block"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <div class="text-[#001F3F] text-4xl mb-4">
            <i class="fas fa-print"></i>
          </div>
          <h3 class="text-xl font-semibold mb-2">Prints</h3>
          <p class="text-gray-700 dark:text-gray-300">Cetak laporan kehadiran harian dengan mudah dan cepat.</p>
        </a>
        <a
          href="#about"
          class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6 hover:shadow-xl transition block"
          data-aos="fade-up"
          data-aos-delay="300"
        >
          <div class="text-[#001F3F] text-4xl mb-4">
            <i class="fas fa-info-circle"></i>
          </div>
          <h3 class="text-xl font-semibold mb-2">Info</h3>
          <p class="text-gray-700 dark:text-gray-300">Dapatkan informasi terbaru seputar penggunaan aplikasi Hadirin.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-12 md:py-16 lg:py-20 bg-white dark:bg-gray-900 text-center">
    <div class="container mx-auto px-4 max-w-3xl" data-aos="fade-up">
      <h2 class="text-3xl font-bold mb-2 text-[#001F3F] dark:text-yellow-400">Tentang Hadirin</h2>
      <div class="w-24 h-1 bg-[#FFD700] mx-auto mb-6"></div>
      <p class="text-base text-gray-700 dark:text-gray-300">
        Hadirin adalah aplikasi berbasis web yang dikembangkan oleh siswa SMKN 1 Kota Bengkulu untuk
        mempermudah proses pencatatan kehadiran guru. Dengan fitur-fitur seperti pengelolaan data kehadiran,
        pencetakan laporan, dan informasi terkini, Hadirin bertujuan untuk meningkatkan efisiensi dan
        transparansi dalam manajemen kehadiran di lingkungan pendidikan.
      </p>
    </div>
  </section>

  <!-- Back to Top Button -->
  <button
    id="backToTop"
    class="fixed bottom-6 right-6 w-12 h-12 flex items-center justify-center bg-[#FFD700] text-[#001F3F] rounded-full shadow-lg hover:bg-yellow-400 transition z-50 hidden"
    aria-label="Back to top"
  >
    <i class="fas fa-arrow-up"></i>
  </button>

  <!-- Footer -->
  <footer class="bg-[#001F3F] text-white text-lg">
    <div class="container mx-auto px-4 py-10">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="text-center md:text-left">
          <img
            src="{{ asset('images/smkn1Logo.jpeg') }}"
            alt="Logo"
            class="w-16 h-16 mx-auto md:mx-0 mb-2 rounded-full object-cover"
          />
          <h2 class="text-2xl font-bold">Hadirin</h2>
          <p class="text-base">SMKN 1 Kota Bengkulu</p>
        </div>
        <div>
          <h3 class="text-xl font-semibold mb-2">Navigasi</h3>
          <ul class="space-y-1">
            <li><a href="#features" class="underline-animate text-white no-underline">Fitur</a></li>
            <li><a href="#about" class="underline-animate text-white no-underline">Tentang</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-semibold mb-2">Kontak</h3>
          <ul class="space-y-1 text-base">
            <li>Email: info@hadirin.id</li>
            <li>Telepon: +62 812-3456-7890</li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-semibold mb-2">Ikuti Kami</h3>
          <div class="flex space-x-4 justify-center md:justify-start">
            <a href="#" class="text-white hover:text-yellow-300"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white hover:text-yellow-300"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white hover:text-yellow-300"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <div class="mt-10 border-t border-yellow-300 pt-4 text-center text-base">
        <p>&copy; 2025 Rafid PPLG. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ once: true, duration: 800, offset: 100 });

    const backToTopBtn = document.getElementById("backToTop");

    window.addEventListener("scroll", () => {
      if (window.scrollY > 500) {
        backToTopBtn.classList.remove("hidden");
      } else {
        backToTopBtn.classList.add("hidden");
      }
    });

    backToTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  </script>
</body>
</html>
