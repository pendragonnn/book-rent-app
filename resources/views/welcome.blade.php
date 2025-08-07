<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Pinjam Buku') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Custom styles to ensure smooth transitions and consistent colors */
            html {
                scroll-behavior: smooth;
            }
            .bg-primary-light {
                background-color: #F9F3EF;
            }
            .bg-secondary-light {
                background-color: #d2c1b6;
            }
            .text-dark-blue {
                color: #1B3C53;
            }
            .border-dark-blue {
                border-color: #1B3C53;
            }
            .focus-ring-blue-500:focus {
                --tw-ring-color: #3b82f6; /* blue-500 */
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-primary-light text-dark-blue">
        <div class="min-h-screen flex flex-col">
            {{-- Navigation Header --}}
            <header class="w-full bg-white shadow-sm py-4 px-6 sm:px-8 lg:px-12 flex items-center justify-between z-10">
                <div class="flex items-center">
                    <img src="https://placehold.co/40x40/1B3C53/FFFFFF?text=PB" alt="Pinjam Buku Logo" class="h-10 w-10 rounded-full mr-3">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-dark-blue">Pinjam Buku</a>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium text-dark-blue hover:bg-gray-100 transition-colors duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium text-dark-blue hover:bg-gray-100 transition-colors duration-200">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-md text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-blue-500 transition-all duration-300 shadow-md">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            {{-- Hero Section --}}
            <section class="flex-1 flex flex-col md:flex-row items-center justify-center p-6 sm:p-10 lg:p-16 bg-gradient-to-br from-primary-light to-secondary-light text-center md:text-left">
                <div class="md:w-1/2 lg:w-2/3 md:pr-8 mb-8 md:mb-0">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-dark-blue animate-fade-in-down">
                        Temukan Dunia Pengetahuan di <span class="text-blue-600">Pinjam Buku</span>
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl text-gray-700 mb-8 animate-fade-in delay-200">
                        Akses ribuan buku dari berbagai genre dengan mudah dan gratis. Pinjam, baca, dan kembalikan dengan nyaman.
                    </p>
                    <div class="flex justify-center md:justify-start space-x-4 animate-fade-in-up delay-400">
                        <a href="{{ route('member.books.index') }}" class="px-8 py-4 rounded-full text-lg font-bold text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-blue-500 transition-all duration-300 shadow-lg">
                            Jelajahi Koleksi
                        </a>
                        <a href="#how-it-works" class="px-8 py-4 rounded-full text-lg font-bold text-dark-blue border-2 border-dark-blue hover:bg-dark-blue hover:text-white transition-all duration-300 shadow-lg">
                            Bagaimana Cara Kerjanya?
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 lg:w-1/3 flex justify-center items-center animate-fade-in delay-600">
                    {{-- Placeholder for a book illustration or simple graphic --}}
                    <img src="https://placehold.co/400x300/1B3C53/FFFFFF?text=Baca+Buku" alt="Book Illustration" class="w-full max-w-sm rounded-lg shadow-2xl transform hover:scale-105 transition-transform duration-500">
                </div>
            </section>

            {{-- How It Works Section --}}
            <section id="how-it-works" class="py-16 px-6 sm:px-10 lg:px-16 bg-white text-dark-blue">
                <h2 class="text-3xl sm:text-4xl font-bold text-center mb-12">
                    Proses Peminjaman yang Mudah
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center text-center p-6 rounded-xl shadow-md bg-primary-light hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">1. Cari Buku</h3>
                        <p class="text-gray-700">Temukan buku favorit Anda dari koleksi kami yang luas.</p>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center text-center p-6 rounded-xl shadow-md bg-primary-light hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">2. Pinjam Buku</h3>
                        <p class="text-gray-700">Pilih tanggal pinjam dan kembali, lalu konfirmasi.</p>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex flex-col items-center text-center p-6 rounded-xl shadow-md bg-primary-light hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">3. Nikmati Baca</h3>
                        <p class="text-gray-700">Baca buku Anda dan kembalikan tepat waktu.</p>
                    </div>
                </div>
            </section>

            {{-- Call to Action Section --}}
            <section class="py-16 px-6 sm:px-10 lg:px-16 bg-secondary-light text-dark-blue text-center">
                <h2 class="text-3xl sm:text-4xl font-bold mb-6">Siap Memulai Petualangan Membaca Anda?</h2>
                <p class="text-lg sm:text-xl mb-8 text-gray-700">Bergabunglah dengan komunitas Pinjam Buku dan mulailah membaca hari ini!</p>
                <a href="{{ route('register') }}" class="px-10 py-4 rounded-full text-xl font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-blue-500 transition-all duration-300 shadow-xl">
                    Daftar Gratis Sekarang
                </a>
            </section>

            {{-- Footer --}}
            <footer class="py-8 px-6 sm:px-10 lg:px-16 bg-dark-blue text-white text-center">
                <p class="text-sm">&copy; {{ date('Y') }} Pinjam Buku. All rights reserved.</p>
                <p class="text-xs mt-2">Dibuat dengan ❤️ untuk para pecinta buku.</p>
            </footer>
        </div>

        {{-- Custom CSS for animations --}}
        <style>
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes wave {
                0% { transform: rotate(0deg); }
                10% { transform: rotate(14deg); }
                20% { transform: rotate(-8deg); }
                30% { transform: rotate(14deg); }
                40% { transform: rotate(-4deg); }
                50% { transform: rotate(10deg); }
                60% { transform: rotate(0deg); }
                100% { transform: rotate(0deg); }
            }

            .animate-fade-in { animation: fadeIn 1s ease-out forwards; }
            .animate-fade-in-down { animation: fadeInDown 1s ease-out forwards; }
            .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
            .animate-wave {
                animation: wave 2.5s infinite;
                transform-origin: 70% 70%;
                display: inline-block;
            }
            .delay-200 { animation-delay: 0.2s; }
            .delay-400 { animation-delay: 0.4s; }
            .delay-600 { animation-delay: 0.6s; }
        </style>
    </body>
</html>