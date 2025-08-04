<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Book Detail') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-md rounded-lg p-6 flex flex-col md:flex-row gap-6">
        {{-- Book Cover --}}
        <div class="flex-shrink-0">
          <img src="{{ asset('covers/' . $book->cover_image) }}"
               alt="{{ $book->title }}"
               class="w-48 h-auto rounded shadow">
        </div>

        {{-- Book Info --}}
        <div class="flex-1 space-y-3">
          <h3 class="text-2xl font-semibold text-gray-800">{{ $book->title }}</h3>
          <p class="text-sm text-gray-600">Author: {{ $book->author }}</p>
          <p class="text-sm text-gray-600">Category: {{ $book->category->name ?? '-' }}</p>
          <p class="text-sm text-gray-600">Published: {{ $book->published_year ?? '-' }}</p>
          <p class="text-sm text-gray-600">Available Stock: {{ $book->availableItemsCount() }}</p>

          <div class="mt-4">
            <a href="{{ route('member.books.index') }}"
               class="inline-block bg-gray-500 hover:bg-gray-600 text-white text-sm px-4 py-2 rounded">
              Back to Catalog
            </a>

            @if ($book->availableItemsCount() > 0)
              <form action="#" method="POST" class="inline-block ml-2">
                @csrf
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded">
                  Pinjam Buku
                </button>
              </form>
            @else
              <span class="text-red-600 text-sm font-semibold ml-2">Tidak tersedia</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
