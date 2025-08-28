<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <meta name="description"
        content="Discover thousands of books with LibraryApp. Browse, borrow, and read your favorite books anytime, anywhere.">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-bg {
            background: linear-gradient(135deg, #FADFAD 0%, #D8BFD8 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
        }

        .book-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .book-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .stats-counter {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating-icon {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="font-inter antialiased bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">

        {{-- Navigation --}}
        <header
    class="w-full fixed top-0 left-0 bg-white/98 backdrop-blur-sm shadow-sm py-4 px-6 lg:px-12 flex items-center justify-between z-50 transition-all duration-300">
    <div class="flex items-center">
        <div
            class="h-10 w-10 rounded-lg bg-gradient-to-br from-[#442C1D] to-[#C88A21] flex items-center justify-center mr-3 floating-icon">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                </path>
            </svg>
        </div>
        <a href="{{ url('/') }}" class="text-xl font-bold text-[#442C1D]">LibraryApp</a>
    </div>

    {{-- Hamburger menu for mobile --}}
    <div class="lg:hidden flex items-center">
        <button id="hamburger-menu-btn" class="text-[#442C1D] focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16m-7 6h7"></path>
                <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    {{-- Desktop navigation --}}
    <nav class="hidden lg:flex items-center space-x-6">
        <a href="#features"
            class="text-sm font-medium text-[#442C1D] hover:text-[#C88A21] transition-colors">Features</a>
        <a href="#how-it-works"
            class="text-sm font-medium text-[#442C1D] hover:text-[#C88A21] transition-colors">How It Works</a>
        <a href="#latest-books"
            class="text-sm font-medium text-[#442C1D] hover:text-[#C88A21] transition-colors">Books</a>
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="text-sm font-medium text-[#442C1D] hover:text-[#C88A21] transition-colors">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-[#442C1D] hover:text-[#C88A21] transition-colors">Sign In</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold text-[#F9F3EF] bg-gradient-to-r from-[#442C1D] to-[#C88A21] hover:from-[#2F1E12] hover:to-[#A37B1B] transition-all duration-300 shadow-lg hover:shadow-xl">
                        Register Free
                    </a>
                @endif
            @endauth
        @endif
    </nav>

    {{-- Mobile menu (off-canvas) --}}
    <div id="mobile-menu"
        class="fixed top-0 left-0 h-full w-full bg-white/98 backdrop-blur-sm transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden z-40">
        <div class="p-6 flex justify-between items-center bg-white">
            <div class="flex items-center ">
                <div
                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-[#442C1D] to-[#C88A21] flex items-center justify-center mr-3 floating-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                        </path>
                    </svg>
                </div>
                <span class="text-xl font-bold text-[#442C1D]">LibraryApp</span>
            </div>
            <button id="close-menu-btn" class="text-[#442C1D] focus:outline-none p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center py-8 space-y-6 bg-white">
            <a href="#features"
                class="text-xl font-bold text-[#442C1D] hover:text-[#C88A21] transition-colors">Features</a>
            <a href="#how-it-works"
                class="text-xl font-bold text-[#442C1D] hover:text-[#C88A21] transition-colors">How It Works</a>
            <a href="#latest-books"
                class="text-xl font-bold text-[#442C1D] hover:text-[#C88A21] transition-colors">Books</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-xl font-bold text-[#442C1D] hover:text-[#C88A21] transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xl font-bold text-[#442C1D] hover:text-[#C88A21] transition-colors">Sign In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-8 py-3 rounded-full text-lg font-semibold text-[#F9F3EF] bg-gradient-to-r from-[#442C1D] to-[#C88A21] hover:from-[#2F1E12] hover:to-[#A37B1B] transition-all duration-300 shadow-lg hover:shadow-xl">
                            Register Free
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</header>



        {{-- Hero Section --}}
        <section
            class="hero-bg flex flex-col-reverse md:flex-row items-center justify-between px-6 lg:px-16 pt-28 pb-20 text-[#442C1D]">
            <div class="md:w-1/2 space-y-8">
                <div class="stats-counter">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Your Digital
                        <span class="block text-[#C88A21]">Library</span>
                        Awaits
                    </h1>
                    <p class="text-xl text-[#6B5A4B] mb-8 max-w-lg">
                        Discover thousands of books, manage your reading journey, and unlock knowledge with our modern
                        digital library platform.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('member.books.index') }}"
                        class="px-8 py-4 rounded-full text-lg font-semibold bg-[#F9F3EF] text-[#442C1D] hover:bg-[#EBE3DC] transition-all duration-300 shadow-lg hover:shadow-xl text-center">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Explore Books
                    </a>
                    <a href="#latest-books"
                        class="px-8 py-4 rounded-full border-2 border-[#442C1D] font-semibold text-[#442C1D] hover:bg-[#442C1D] hover:text-[#F9F3EF] transition-all duration-300 text-center">
                        Latest Arrivals
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex space-x-8 pt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#C88A21]" data-count="{{ $totalBooks }}">{{
                            number_format($totalBooks ?: 1000) }}+</div>
                        <div class="text-sm text-[#8D7F72]">Books Available</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#C88A21]" data-count="{{ $totalUsers }}">{{
                            number_format($totalUsers ?: 500) }}+</div>
                        <div class="text-sm text-[#8D7F72]">Happy Readers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#C88A21]">24/7</div>
                        <div class="text-sm text-[#8D7F72]">Access</div>
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 flex justify-center mb-10 md:mb-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-[#442C1D]/10 rounded-3xl blur-3xl"></div>
                    <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=300&h=400&fit=crop"
                        alt="Digital Library Illustration"
                        class="relative rounded-2xl shadow-2xl w-96 h-80 object-cover">
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section id="features" class="py-20 px-6 lg:px-16 bg-[#F9F3EF]">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl font-bold text-center text-[#442C1D] mb-4">Why Choose LibraryApp?</h2>
                <p class="text-lg text-[#6B5A4B] text-center mb-16 max-w-2xl mx-auto">
                    Experience the future of reading with our comprehensive digital library platform
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="text-center card-hover">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-[#442C1D] to-[#C88A21] rounded-xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-[#442C1D]">Vast Collection</h3>
                        <p class="text-[#6B5A4B]">Access thousands of books across all genres and categories, from
                            classics to contemporary works.</p>
                    </div>

                    <div class="text-center card-hover">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-[#9E6C36] to-[#C88A21] rounded-xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-[#442C1D]">24/7 Availability</h3>
                        <p class="text-[#6B5A4B]">Read anytime, anywhere. Our digital platform ensures your books are
                            always accessible.</p>
                    </div>

                    <div class="text-center card-hover">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-[#957DAD] to-[#D8BFD8] rounded-xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-[#442C1D]">Easy Management</h3>
                        <p class="text-[#6B5A4B]">Simple borrowing system with automatic returns and renewal
                            notifications.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- How It Works Section --}}
        <section id="how-it-works"
            class="py-20 px-6 lg:px-16 bg-gradient-to-br from-[#442C1D] via-[#6B5A4B] to-[#957DAD] text-white relative overflow-hidden">
            {{-- Background pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-gradient-to-r from-[#C88A21]/20 to-[#D8BFD8]/20"></div>
                <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#grid)" />
                </svg>
            </div>

            <div class="relative max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">How It Works</h2>
                    <p class="text-xl text-[#F0E6D8] max-w-3xl mx-auto">
                        Getting started with LibraryApp is simple. Follow these easy steps to begin your digital reading
                        journey.
                    </p>
                </div>

                {{-- Steps --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                    {{-- Step 1 --}}
                    <div class="relative group">
                        <div
                            class="bg-[#F9F3EF]/10 backdrop-blur-sm rounded-2xl p-8 h-full border border-[#F9F3EF]/20 card-hover group-hover:bg-[#F9F3EF]/15 transition-all duration-300">
                            <div
                                class="absolute -top-4 -right-4 w-8 h-8 bg-gradient-to-br from-[#C88A21] to-[#D8BFD8] rounded-full flex items-center justify-center text-sm font-bold">
                                1
                            </div>

                            <div
                                class="w-16 h-16 bg-gradient-to-br from-[#C88A21] to-[#D8BFD8] rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold mb-4 text-center">Create Account</h3>
                            <p class="text-[#F0E6D8] text-center leading-relaxed">
                                Sign up for free with just your email and create your personal library profile in
                                seconds.
                            </p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="relative group">
                        <div
                            class="bg-[#F9F3EF]/10 backdrop-blur-sm rounded-2xl p-8 h-full border border-[#F9F3EF]/20 card-hover group-hover:bg-[#F9F3EF]/15 transition-all duration-300">
                            <div
                                class="absolute -top-4 -right-4 w-8 h-8 bg-gradient-to-br from-[#C88A21] to-[#D8BFD8] rounded-full flex items-center justify-center text-sm font-bold">
                                2
                            </div>

                            <div
                                class="w-16 h-16 bg-gradient-to-br from-[#9E6C36] to-[#C88A21] rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold mb-4 text-center">Browse Books</h3>
                            <p class="text-[#F0E6D8] text-center leading-relaxed">
                                Explore our vast collection by genre, author, or use our smart search to find exactly
                                what you're looking for.
                            </p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="relative group">
                        <div
                            class="bg-[#F9F3EF]/10 backdrop-blur-sm rounded-2xl p-8 h-full border border-[#F9F3EF]/20 card-hover group-hover:bg-[#F9F3EF]/15 transition-all duration-300">
                            <div
                                class="absolute -top-4 -right-4 w-8 h-8 bg-gradient-to-br from-[#C88A21] to-[#D8BFD8] rounded-full flex items-center justify-center text-sm font-bold">
                                3
                            </div>

                            <div
                                class="w-16 h-16 bg-gradient-to-br from-[#957DAD] to-[#D8BFD8] rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold mb-4 text-center">Borrow Instantly</h3>
                            <p class="text-[#F0E6D8] text-center leading-relaxed">
                                Found something you like? Click to borrow instantly. No waiting in lines or physical
                                visits required.
                            </p>
                        </div>
                    </div>

                    {{-- Step 4 --}}
                    <div class="relative group">
                        <div
                            class="bg-[#F9F3EF]/10 backdrop-blur-sm rounded-2xl p-8 h-full border border-[#F9F3EF]/20 card-hover group-hover:bg-[#F9F3EF]/15 transition-all duration-300">
                            <div
                                class="absolute -top-4 -right-4 w-8 h-8 bg-gradient-to-br from-[#C88A21] to-[#D8BFD8] rounded-full flex items-center justify-center text-sm font-bold">
                                4
                            </div>

                            <div
                                class="w-16 h-16 bg-gradient-to-br from-[#442C1D] to-[#9E6C36] rounded-2xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                                    </path>
                                </svg>
                            </div>

                            <h3 class="text-xl font-bold mb-4 text-center">Read & Enjoy</h3>
                            <p class="text-[#F0E6D8] text-center leading-relaxed">
                                Start reading immediately on any device. Automatic returns mean you never have to worry
                                about late fees.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Interactive Demo --}}
                <div class="bg-[#F9F3EF]/5 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-[#F9F3EF]/20">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h3 class="text-3xl font-bold mb-6">See It In Action</h3>
                            <p class="text-lg text-[#F0E6D8] mb-8">
                                Watch how easy it is to find and borrow your next favorite book with our intuitive
                                interface.
                            </p>

                            <div class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-8 h-8 bg-[#C88A21] rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-[#F0E6D8]">Advanced search and filtering</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-8 h-8 bg-[#C88A21] rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-[#F0E6D8]">Real-time availability status</span>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-8 h-8 bg-[#C88A21] rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-[#F0E6D8]">Reading progress tracking</span>
                                </div>
                            </div>

                            <div class="mt-8">
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-6 py-3 bg-[#F9F3EF] text-[#442C1D] font-semibold rounded-xl hover:bg-[#EBE3DC] transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a1 1 0 001 1h4M9 10V9a1 1 0 011-1h4a1 1 0 011 1v1M9 10H8a1 1 0 00-1 1v3a1 1 0 001 1h1m0-4h.01">
                                        </path>
                                    </svg>
                                    register Now
                                </a>
                            </div>
                        </div>

                        {{-- Mock Interface Preview --}}
                        <div class="relative">
                            <div class="bg-[#442C1D]/50 rounded-2xl p-6 backdrop-blur-sm border border-[#6B5A4B]/30">
                                {{-- Mock browser header --}}
                                <div class="flex items-center space-x-2 mb-4 pb-3 border-b border-[#6B5A4B]/30">
                                    <div class="w-3 h-3 bg-[#D35B5B] rounded-full"></div>
                                    <div class="w-3 h-3 bg-[#E5B53B] rounded-full"></div>
                                    <div class="w-3 h-3 bg-[#A5C189] rounded-full"></div>
                                    <div
                                        class="ml-4 flex-1 bg-[#6B5A4B]/50 rounded-md px-3 py-1 text-xs text-[#8D7F72]">
                                        libraryapp.com/books
                                    </div>
                                </div>

                                {{-- Mock search bar --}}
                                <div class="bg-[#6B5A4B]/50 rounded-lg p-3 mb-4">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-4 h-4 text-[#8D7F72]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <div class="flex-1 text-sm text-[#F0E6D8]">Search for books...</div>
                                        <div class="text-xs bg-[#442C1D] px-2 py-1 rounded text-[#F9F3EF]">Enter</div>
                                    </div>
                                </div>

                                {{-- Mock book cards --}}
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-[#6B5A4B]/30 rounded-lg p-3 border border-[#6B5A4B]/20">
                                        <div
                                            class="w-full h-16 bg-gradient-to-br from-[#442C1D] to-[#9E6C36] rounded-md mb-2 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="text-xs text-[#F0E6D8] mb-1">Future Worlds</div>
                                        <div class="text-xs text-[#8D7F72]">Sarah Johnson</div>
                                        <div class="mt-2">
                                            <div
                                                class="text-xs bg-[#C88A21] px-2 py-1 rounded text-[#F9F3EF] inline-block">
                                                Available</div>
                                        </div>
                                    </div>

                                    <div class="bg-[#6B5A4B]/30 rounded-lg p-3 border border-[#6B5A4B]/20">
                                        <div
                                            class="w-full h-16 bg-gradient-to-br from-[#957DAD] to-[#D8BFD8] rounded-md mb-2 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="text-xs text-[#F0E6D8] mb-1">The Missing Piece</div>
                                        <div class="text-xs text-[#8D7F72]">Detective Brown</div>
                                        <div class="mt-2">
                                            <div
                                                class="text-xs bg-[#C88A21] px-2 py-1 rounded text-[#F9F3EF] inline-block">
                                                Borrow</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Animated cursor --}}
                                <div
                                    class="absolute bottom-20 right-16 w-4 h-4 bg-[#F9F3EF] rounded-full opacity-75 animate-pulse">
                                </div>
                            </div>

                            {{-- Floating elements for visual appeal --}}
                            <div
                                class="absolute -top-4 -left-4 w-8 h-8 bg-[#C88A21]/30 rounded-full blur-sm animate-pulse">
                            </div>
                            <div
                                class="absolute -bottom-2 -right-2 w-6 h-6 bg-[#D8BFD8]/30 rounded-full blur-sm animate-pulse delay-1000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Latest Books Section --}}
        <section id="latest-books" class="py-20 px-6 lg:px-16 bg-[#F9F3EF]">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl font-bold text-center text-[#442C1D] mb-4">Newest Arrivals</h2>
                <p class="text-lg text-[#6B5A4B] text-center mb-16">
                    Discover the latest additions to our growing collection
                </p>

                @if($latestBooks && $latestBooks->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                        @foreach($latestBooks as $book)
                            <div class="book-card rounded-2xl overflow-hidden card-hover bg-white shadow-lg">
                                <div class="aspect-[3/4] overflow-hidden">
                                    <img src="{{ $book->cover_url ?? 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=300&h=400&fit=crop' }}"
                                        alt="{{ $book->title }}"
                                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-lg font-bold mb-2 line-clamp-2 text-[#442C1D]">{{ $book->title }}</h3>
                                    <p class="text-sm text-[#6B5A4B] mb-4">by {{ $book->author }}</p>
                                    <a href="{{ route('member.books.show', $book->id) }}"
                                        class="block w-full text-center px-4 py-3 text-sm font-semibold rounded-xl bg-gradient-to-r from-[#442C1D] to-[#633f02] text-white hover:from-[#6B5A4B] hover:to-[#9E6C36] transition-all duration-300 shadow-lg hover:shadow-xl">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-[#EBE3DC] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-[#9E6C36]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#442C1D] mb-2">No Books Available Yet</h3>
                        <p class="text-[#6B5A4B] mb-6">We're working on adding amazing books to our collection.</p>
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.books.create') }}"
                                    class="px-6 py-3 bg-[#442C1D] text-white rounded-lg hover:bg-[#6B5A4B] transition">
                                    Add First Book
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <div class="text-center mt-12">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 rounded-full font-semibold bg-gradient-to-r from-[#442C1D] to-[#633f02] text-white hover:from-[#6B5A4B] hover:to-[#9E6C36] transition-all duration-300 shadow-lg hover:shadow-xl">
                        Start Your Reading Journey
                    </a>
                </div>
            </div>
        </section>

        {{-- Call to Action --}}
        <section
            class="py-20 px-6 lg:px-16 bg-gradient-to-r from-[#442C1D] via-[#6B5A4B] to-[#957DAD] text-white text-center">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Start Your Reading Journey?</h2>
                <p class="text-xl mb-8 opacity-90 text-[#F0E6D8]">
                    Join thousands of readers who have already discovered the joy of digital reading with LibraryApp.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 mb-12">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-10 py-4 rounded-full text-lg font-bold bg-[#F9F3EF] text-[#442C1D] hover:bg-[#EBE3DC] transition-all duration-300 shadow-xl hover:shadow-2xl">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            Create Free Account
                        </a>
                    @endif
                    <a href="{{ route('member.books.index') }}"
                        class="px-10 py-4 rounded-full border-2 border-white font-bold text-white hover:bg-white hover:text-[#442C1D] transition-all duration-300">
                        Browse Books First
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="flex justify-center items-center space-x-8 text-sm opacity-75 text-[#F0E6D8]">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#C88A21]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        100% Free to Join
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#C88A21]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        No Hidden Fees
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#C88A21]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Instant Access
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="py-12 px-6 lg:px-16 bg-[#442C1D] text-[#D4C3B2]">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <div
                                class="h-8 w-8 rounded-lg bg-gradient-to-br from-[#C88A21] to-[#957DAD] flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-white font-bold text-lg">LibraryApp</span>
                        </div>
                        <p class="text-sm">
                            Your trusted digital library platform for discovering and enjoying books from around the
                            world.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#features" class="hover:text-white transition">Features</a></li>
                            <li><a href="#how-it-works" class="hover:text-white transition">How It Works</a></li>
                            <li><a href="#latest-books" class="hover:text-white transition">New Arrivals</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Support</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="https://wa.me/6287704135800" class="hover:text-white transition">Help
                                    Center</a></li>
                            <li><a href="https://wa.me/6287704135800" class="hover:text-white transition">Contact Us</a>
                            </li>
                            <li><a href="https://wa.me/6287704135800" class="hover:text-white transition">FAQs</a></li>
                            <li><a href="https://wa.me/6287704135800" class="hover:text-white transition">Terms of
                                    Service</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Connect</h4>
                        <div class="flex space-x-4">
                            <a href="https://wa.me/6287704135800"
                                class="w-8 h-8 bg-[#6B5A4B] rounded-full flex items-center justify-center hover:bg-[#C88A21] transition">

                                <svg class="w-4 h-4" viewBox="0 0 24 24" version="1.1" id="svg8"
                                    inkscape:version="0.92.4 (5da689c313, 2019-01-14)" sodipodi:docname="1881161.svg"
                                    xmlns:cc="http://creativecommons.org/ns#"
                                    xmlns:dc="http://purl.org/dc/elements/1.1/"
                                    xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                    xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                    xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">
                                    <path stroke="#FFFFFF" id="path4" inkscape:connector-curvature="0"
                                        d="M16.6,14c-0.2-0.1-1.5-0.7-1.7-0.8c-0.2-0.1-0.4-0.1-0.6,0.1c-0.2,0.2-0.6,0.8-0.8,1c-0.1,0.2-0.3,0.2-0.5,0.1c-0.7-0.3-1.4-0.7-2-1.2c-0.5-0.5-1-1.1-1.4-1.7c-0.1-0.2,0-0.4,0.1-0.5c0.1-0.1,0.2-0.3,0.4-0.4c0.1-0.1,0.2-0.3,0.2-0.4c0.1-0.1,0.1-0.3,0-0.4c-0.1-0.1-0.6-1.3-0.8-1.8C9.4,7.3,9.2,7.3,9,7.3c-0.1,0-0.3,0-0.5,0C8.3,7.3,8,7.5,7.9,7.6C7.3,8.2,7,8.9,7,9.7c0.1,0.9,0.4,1.8,1,2.6c1.1,1.6,2.5,2.9,4.2,3.7c0.5,0.2,0.9,0.4,1.4,0.5c0.5,0.2,1,0.2,1.6,0.1c0.7-0.1,1.3-0.6,1.7-1.2c0.2-0.4,0.2-0.8,0.1-1.2C17,14.2,16.8,14.1,16.6,14 M19.1,4.9C15.2,1,8.9,1,5,4.9c-3.2,3.2-3.8,8.1-1.6,12L2,22l5.3-1.4c1.5,0.8,3.1,1.2,4.7,1.2h0c5.5,0,9.9-4.4,9.9-9.9C22,9.3,20.9,6.8,19.1,4.9 M16.4,18.9c-1.3,0.8-2.8,1.3-4.4,1.3h0c-1.5,0-2.9-0.4-4.2-1.1l-0.3-0.2l-3.1,0.8l0.8-3l-0.2-0.3C2.6,12.4,3.8,7.4,7.7,4.9S16.6,3.7,19,7.5C21.4,11.4,20.3,16.5,16.4,18.9" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-8 h-8 bg-[#6B5A4B] rounded-full flex items-center justify-center hover:bg-[#C88A21] transition">
                                <svg class="w-4 h-4" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg"
                                    fill="none">
                                    <path stroke="#FFFFFF" stroke-linejoin="round" stroke-width="12"
                                        d="M22 57.265V142c0 5.523 4.477 10 10 10h24V95.056l40 30.278 40-30.278V152h24c5.523 0 10-4.477 10-10V57.265c0-13.233-15.15-20.746-25.684-12.736L96 81.265 47.684 44.53C37.15 36.519 22 44.032 22 57.265Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-[#6B5A4B] pt-8 mt-8 text-center">
                    <p>&copy; {{ date('Y') }} LibraryApp. All rights reserved. Made with ❤️ for book lovers.</p>
                </div>
            </div>
        </footer>
    </div>

    {{-- Smooth scrolling script --}}
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function () {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('bg-white/98');
                header.classList.remove('bg-white/95');
            } else {
                header.classList.add('bg-white/95');
                header.classList.remove('bg-white/98');
            }
        });

        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.7,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('stats-counter');

                    // Animate counter numbers
                    const counters = entry.target.querySelectorAll('[data-count]');
                    counters.forEach(counter => {
                        const target = parseInt(counter.dataset.count);
                        const increment = target / 100;
                        let current = 0;

                        const updateCounter = () => {
                            if (current < target) {
                                current += increment;
                                counter.textContent = Math.floor(current).toLocaleString() + '+';
                                setTimeout(updateCounter, 20);
                            } else {
                                counter.textContent = target.toLocaleString() + '+';
                            }
                        };
                        updateCounter();
                    });
                }
            });
        }, observerOptions);

        // Observe stats section
        const statsSection = document.querySelector('.hero-bg .flex.space-x-8');
        if (statsSection) {
            observer.observe(statsSection);
        }

    {{-- Script for mobile menu functionality --}}
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburger-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const body = document.body;

        function closeMenu() {
            mobileMenu.classList.add('-translate-x-full');
            body.style.overflow = 'auto'; // Re-enable scrolling
        }

        function openMenu() {
            mobileMenu.classList.remove('-translate-x-full');
            body.style.overflow = 'hidden'; // Disable scrolling
        }

        hamburgerBtn.addEventListener('click', openMenu);
        closeMenuBtn.addEventListener('click', closeMenu);

        // Close menu when a link is clicked
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    });
    </script>

</body>

</html>