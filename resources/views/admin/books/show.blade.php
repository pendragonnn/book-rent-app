<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Book Detail') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex flex-col md:flex-row gap-6">
          {{-- Cover --}}
          <div class="flex-shrink-0">
            @php
        $coverPath = public_path('covers/' . $book->cover_image);
      @endphp

            @if ($book->cover_image && file_exists($coverPath))
        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover Image"
          class="w-40 h-56 object-cover rounded">
      @else
        <div
          class="w-40 h-56 bg-gray-200 flex items-center justify-center text-gray-500 rounded text-center px-2 text-sm">
          No Cover Image Available
        </div>
      @endif
          </div>

          {{-- Book Info --}}
          <div class="flex-1 space-y-3">
            <div>
              <h3 class="text-2xl font-semibold">{{ $book->title }}</h3>
              <p class="text-gray-600">by {{ $book->author }}</p>
            </div>

            <div class="text-sm text-gray-700 space-y-1">
              <p><strong>Publisher:</strong> {{ $book->publisher ?? '-' }}</p>
              <p><strong>Year:</strong> {{ $book->year ?? '-' }}</p>
              <p><strong>ISBN:</strong> {{ $book->isbn ?? '-' }}</p>
              <p><strong>Category:</strong> {{ $book->category->name ?? '-' }}</p>
              <p><strong>Rental Price:</strong> Rp{{ number_format($book->rental_price, 0, ',', '.') }}</p>
              <p><strong>Stock:</strong> {{ $book->stock }}</p>
              <p><strong>Description:</strong></p>
              <p class="text-justify">{{ $book->description ?? 'No description available.' }}</p>
            </div>

            <div class="pt-4">
              <a href="{{ route('admin.books.index') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                ← Back to List
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>