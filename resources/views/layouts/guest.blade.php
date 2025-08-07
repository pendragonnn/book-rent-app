<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-primary-light flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="w-screen bg-white rounded-xl shadow-xl overflow-hidden flex flex-col md:flex-row">
        {{-- Left Section: Illustration/Branding --}}
        <div class="md:w-1/2 bg-gradient-to-br from-secondary-light to-[#e0d0c5] p-8 flex flex-col items-center justify-center text-center text-[#1B3C53]">
            <img src="https://placehold.co/150x150/1B3C53/FFFFFF?text=PB" alt="Pinjam Buku Logo" class="h-24 w-24 rounded-full mb-6 shadow-lg">
            <h2 class="text-3xl font-bold mb-3">Selamat Datang Kembali!</h2>
            <p class="text-lg text-gray-700">Masuk untuk melanjutkan petualangan membaca Anda.</p>
            <p class="mt-6 text-sm">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="mt-2 px-6 py-2 rounded-full text-sm font-semibold text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-md">
                Daftar Sekarang
            </a>
        </div>

        {{-- Right Section: Login Form --}}
        <div class="md:w-1/2 p-8 sm:p-10 lg:p-12 bg-[#faf4f0]">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#1B3C53] mb-8 text-center">Masuk ke Akun Anda</h2>
            {{ $slot }}
        </div>
    </div>
</body>
@stack('scripts')
</html>
