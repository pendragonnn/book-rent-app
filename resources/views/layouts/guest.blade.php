<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#F9F3EF] flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="max-w-md w-full mx-auto p-8 sm:p-10 lg:p-12 bg-white rounded-xl shadow-xl space-y-8">
        {{-- Top Section: Logo & Titles --}}
        <div class="text-center">
            <div class="h-16 w-16 rounded-lg bg-gradient-to-br from-[#442C1D] to-[#C88A21] flex items-center justify-center mx-auto mb-4 floating-icon">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                    </path>
                </svg>
            </div>
            @if (Route::is('login'))
                <h2 class="text-3xl font-bold text-[#442C1D] mb-2">Welcome Back!</h2>
                <p class="text-md text-[#6B5A4B]">Log in to continue your reading journey.</p>
            @elseif (Route::is('register'))
                <h2 class="text-3xl font-bold text-[#442C1D] mb-2">Welcome</h2>
                <p class="text-md text-[#6B5A4B]">Register to start your reading adventure.</p>
            @endif
        </div>

        {{-- Form Section --}}
        <div>
            @if(Route::is("login")) 
                <h3 class="text-xl sm:text-2xl font-semibold text-[#442C1D] mb-6 text-center">Log In to Your Account</h3>
            @elseif(Route::is("register"))
                <h3 class="text-xl sm:text-2xl font-semibold text-[#442C1D] mb-6 text-center">Your Account Details</h3>
            @endif
            {{ $slot }}
        </div>

        {{-- Bottom Section: Redirect Link --}}
        <div class="text-center mt-6">
            @if (Route::is('login'))
                <p class="text-sm text-[#6B5A4B]">Don't have an account?</p>
                <a href="{{ route('register') }}"
                    class="mt-2 text-sm font-semibold text-[#C88A21] hover:text-[#A37B1B] transition-colors duration-200">
                    Register Now
                </a>
            @elseif (Route::is('register'))
                <p class="text-sm text-[#6B5A4B]">Already have an account?</p>
                <a href="{{ route('login') }}"
                    class="mt-2 text-sm font-semibold text-[#C88A21] hover:text-[#A37B1B] transition-colors duration-200">
                    Sign In
                </a>
            @endif
        </div>
    </div>
</body>
@stack('scripts')

</html>