@php
    $user = auth()->user();
    $isAdmin = $user->role->name === 'admin';
@endphp

{{-- Sidebar --}}
{{-- Fixed on mobile, relative on desktop. Hidden by default on mobile (-translate-x-full) --}}
<aside id="sidebar" class="w-64 min-h-screen bg-white border-r border-gray-200 shadow-lg fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-40 rounded-r-xl md:rounded-none">
    {{-- Sidebar Header --}}
    <div class="p-6 border-b border-[#d2c1b6] bg-[#d2c1b6] text-[#1B3C53] flex items-center justify-between rounded-tr-xl md:rounded-none">
        <h1 class="text-2xl font-bold">LibraryApp</h1>
        {{-- Close button for mobile sidebar (visible only on small screens) --}}
        <button id="closeSidebar" class="md:hidden text-[#1B3C53] hover:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    {{-- Sidebar Navigation --}}
    <nav class="px-4 py-6 space-y-2 text-base font-medium">
        {{-- Dashboard Link --}}
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-9v9a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>

        {{-- Admin Specific Links --}}
        @if ($isAdmin)
            <a href="{{ route('admin.books.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.books.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path></svg>
                Manage Books
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.146-1.28-.423-1.848M13 16H7m6 0v-2m6 2v-2a3 3 0 00-3-3H4a3 3 0 00-3 3v2m3-2h4m-4 0v-2m4 2v-2m-4-2H7m6 0h4m-4 0v-2m-4-2H7m6 0h4m-4 0v-2m-4-2H7m6 0h4m-4 0v-2"></path></svg>
                Manage Users
            </a>
            <a href="{{ route('admin.book-loans.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.book-loans.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                Book Loans
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                Book Categories
            </a>
        @else {{-- Member Specific Links --}}
            <a href="{{ route('member.books.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('member.books.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path></svg>
                Browse Books
            </a>
            <a href="{{ route('member.book-loans.index') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('member.book-loans.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                My Loans
            </a>
        @endif

        <hr class="my-3 border-gray-200">

        {{-- Profile Settings Link --}}
        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('profile.edit') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Profile Settings
        </a>

        {{-- Logout Button --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full text-left px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-red-50 hover:text-red-700 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </form>
    </nav>
</aside>