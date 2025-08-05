@php
  $user = auth()->user();
  $isAdmin = $user->role->name === 'admin';
@endphp

<aside class="w-64 min-h-screen bg-white border-r shadow-sm">
  <div class="p-6 border-b">
    <h1 class="text-xl font-semibold text-gray-800">LibraryApp</h1>
  </div>

  <nav class="px-6 py-4 space-y-2 text-sm">
    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
      🏠 Dashboard
    </a>

    @if ($isAdmin)
      <a href="{{ route('admin.books.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.books.*') ? 'bg-gray-200 font-semibold' : '' }}">
        📚 Manage Books
      </a>
      <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 font-semibold' : '' }}">
        👤 Manage Users
      </a>
      <a href="{{ route('admin.book-loans.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.book-loans.*') ? 'bg-gray-200 font-semibold' : '' }}">
        📖 Book Loans
      </a>
    @else
      <a href="{{ route('member.books.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('catalog.*') ? 'bg-gray-200 font-semibold' : '' }}">
        📚 Browse Books
      </a>
      <a href="{{ route('member.book-loans.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
        📄 My Loans
      </a>
    @endif

    <hr class="my-3 border-gray-200">

    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'bg-gray-200 font-semibold' : '' }}">
      ⚙️ Profile Settings
    </a>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 text-red-600">
        🚪 Logout
      </button>
    </form>
  </nav>
</aside>
