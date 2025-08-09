@php
    $user = auth()->user();
    $isAdmin = $user->role->name === 'admin';
@endphp

{{-- Sidebar --}}
{{-- Fixed on mobile, relative on desktop. Hidden by default on mobile (-translate-x-full) --}}
<aside id="sidebar"
    class="w-64 min-h-screen bg-white border-r border-gray-200 shadow-lg fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-40 rounded-r-xl md:rounded-none">
    {{-- Sidebar Header --}}
    <div
        class="p-4 leading-tight border-b border-[#d2c1b6] bg-[#d2c1b6] text-[#1B3C53] flex items-center justify-between rounded-tr-xl md:rounded-none">
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
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

            Dashboard
        </a>

        {{-- Admin Specific Links --}}
        @if ($isAdmin)
            <a href="{{ route('admin.books.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.books.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                    </path>
                </svg>
                Manage Books
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>

                Manage Users
            </a>
            <a href="{{ route('admin.book-loans.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.book-loans.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>

                Book Loans
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>

                Book Categories
            </a>
        @else {{-- Member Specific Links --}}
            <a href="{{ route('member.books.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('member.books.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z">
                    </path>
                </svg>
                Browse Books
            </a>
            <a href="{{ route('member.book-loans.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('member.book-loans.*') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
                My Loans
            </a>
        @endif

        <hr class="my-3 border-gray-200">

        {{-- Profile Settings Link --}}
        <a href="{{ route('profile.edit') }}"
            class="flex items-center px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('profile.edit') ? 'bg-blue-100 text-blue-800 font-semibold shadow-sm' : 'text-[#1B3C53]' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Profile Settings
        </a>

        {{-- Logout Button --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center w-full text-left px-4 py-2 rounded-lg transition-colors duration-200 hover:bg-red-50 hover:text-red-700 text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </nav>
</aside>