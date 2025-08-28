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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    {{-- Main container for the entire layout --}}
    <div class="min-h-screen bg-[#F9F3EF] flex">
        {{-- Sidebar Backdrop (for mobile overlay when sidebar is open) --}}
        {{-- This darkens the main content and allows closing sidebar by clicking outside --}}
        <div id="sidebarBackdrop" class="fixed inset-0 bg-black opacity-50 z-30 hidden md:hidden"></div>

        {{-- Sidebar Component --}}
        {{-- Menggunakan komponen x-sidebar yang sudah dibuat terpisah --}}
        <x-sidebar />

        {{-- Main Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Top Bar for Mobile (with Hamburger Icon) --}}
            {{-- This header is only visible on small screens (md:hidden) --}}
            <header class="bg-white shadow-sm py-3 px-6 md:hidden flex items-center justify-between z-20">
                <button id="sidebarToggle"
                    class="text-[#1B3C53] focus:outline-none p-2 rounded-md hover:bg-gray-100 transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="text-xl font-semibold text-gray-800">LibraryApp</h1>
            </header>

            {{-- Page Header (for desktop, or when sidebar is closed on mobile) --}}
            @isset($header)
                <header class="bg-white shadow-sm py-5 px-4 md:px-6">
                    <div class="max-w-7xl mx-auto">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#F9F3EF] md:p-0 p-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- JavaScript for Sidebar Interactivity --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebarButton = document.getElementById('closeSidebar');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            // Function to open the sidebar
            function openSidebar() {
                sidebar.classList.remove('-translate-x-full'); // Move sidebar into view
                sidebar.classList.add('translate-x-0');
                sidebarBackdrop.classList.remove('hidden'); // Show backdrop
                document.body.classList.add('overflow-hidden'); // Prevent body scrolling
            }

            // Function to close the sidebar
            function closeSidebar() {
                sidebar.classList.remove('translate-x-0'); // Move sidebar out of view
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('hidden'); // Hide backdrop
                document.body.classList.remove('overflow-hidden'); // Allow body scrolling
            }

            // Event listener for the hamburger icon (to open sidebar)
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', openSidebar);
            }

            // Event listener for the close button inside the sidebar (on mobile)
            if (closeSidebarButton) {
                closeSidebarButton.addEventListener('click', closeSidebar);
            }

            // Event listener for clicking the backdrop (to close sidebar on mobile)
            if (sidebarBackdrop) {
                sidebarBackdrop.addEventListener('click', closeSidebar);
            }

            // Close sidebar when a navigation link is clicked (improves mobile UX)
            const navLinks = sidebar.querySelectorAll('nav a, nav button');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    // Only close if it's a mobile view (sidebar is fixed/translated)
                    if (window.innerWidth < 768) { // Corresponds to Tailwind's 'md' breakpoint
                        closeSidebar();
                    }
                });
            });

            // Handle sidebar state on window resize (e.g., rotating device or resizing browser)
            function handleResize() {
                if (window.innerWidth >= 768) { // If desktop view ('md' breakpoint or larger)
                    // Ensure sidebar is always visible and positioned relatively
                    sidebar.classList.remove('-translate-x-full', 'fixed', 'inset-y-0', 'left-0', 'z-40');
                    sidebar.classList.add('relative', 'translate-x-0');
                    sidebarBackdrop.classList.add('hidden'); // Ensure backdrop is hidden
                    document.body.classList.remove('overflow-hidden'); // Ensure body scrolling is allowed
                } else { // If mobile view (smaller than 'md' breakpoint)
                    // Ensure sidebar is fixed and hidden by default
                    sidebar.classList.remove('relative', 'translate-x-0');
                    sidebar.classList.add('-translate-x-full', 'fixed', 'inset-y-0', 'left-0', 'z-40');
                    // Backdrop should be hidden unless sidebar is explicitly open
                    if (!sidebar.classList.contains('translate-x-0')) {
                        sidebarBackdrop.classList.add('hidden');
                    }
                    // If sidebar was open and resized to mobile, ensure body overflow is handled
                    if (sidebar.classList.contains('translate-x-0')) {
                        document.body.classList.add('overflow-hidden');
                    } else {
                        document.body.classList.remove('overflow-hidden');
                    }
                }
            }

            // Initial call to set sidebar state based on current screen size
            handleResize();

            // Listen for window resize events to adjust sidebar state
            window.addEventListener('resize', handleResize);
        });
    </script>
</body>
@stack('scripts')

</html>