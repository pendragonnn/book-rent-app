<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Book Catalog') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Filter & Search --}}
      <form method="GET" class="mb-6 flex flex-col md:flex-row items-center gap-4">
        <input type="text" name="search" value="{{ request('search') }}"
          class="w-full md:w-1/3 border-gray-300 rounded shadow-sm px-4 py-2"
          placeholder="Search by title or author...">

        <select name="category" class="w-full md:w-1/4 border-gray-300 rounded shadow-sm px-4 py-2">
          <option value="">All Categories</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>

        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
          Search
        </button>
      </form>

      {{-- Book Cards --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($books as $book)
          <div class="bg-white rounded-lg shadow-md flex flex-col">
            <img src="{{ asset('covers/' . $book->cover_image) }}" alt="{{ $book->title }}"
              class="w-full h-60 object-cover rounded-t-lg">

            <div class="p-4 flex flex-col justify-between flex-1">
              <div>
                <h3 class="text-lg font-bold text-gray-800">{{ $book->title }}</h3>
                <p class="text-sm text-gray-600">Author: {{ $book->author }}</p>
                <p class="text-sm text-gray-600">Category: {{ $book->category->name ?? '-' }}</p>
                <p class="text-sm text-gray-600 mb-2">Available: {{ $book->availableItemsCount() }}</p>
              </div>

              <div class="mt-3 flex justify-between">
                <a href="{{ route('member.books.show', $book) }}"
                  class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                  Detail
                </a>

                @if ($book->availableItemsCount() > 0)
                  <form action="#" method="POST">
                    @csrf
                    <button type="submit"
                      class="text-sm bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                      Pinjam
                    </button>
                  </form>
                @else
                  <span class="text-sm text-red-500 font-semibold self-center">Tidak Tersedia</span>
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="col-span-full text-center text-gray-600">No books found.</div>
        @endforelse
      </div>

      {{-- Pagination --}}
      <div class="mt-6">
        {{ $books->withQueryString()->links() }}
      </div>
    </div>
  </div>
</x-app-layout>
