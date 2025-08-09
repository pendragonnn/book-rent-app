<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Book Detail') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-[#D2C1B6]">
        <div class="flex flex-col items-center md:flex-row gap-8 p-6">
          {{-- Cover --}}
          <div class="flex-shrink-0">
            @php
                $coverPath = public_path('covers/' . $book->cover_image);
            @endphp

            @if ($book->cover_image && file_exists($coverPath))
              <img src="{{ asset('covers/' . $book->cover_image) }}"
                   alt="Cover Image"
                   class="w-40 h-56 object-cover rounded-xl shadow-md">
            @else
              <div class="w-40 h-56 bg-gray-200 flex items-center justify-center text-gray-500 rounded-xl text-center px-2 text-sm shadow-inner">
                No Cover Image Available
              </div>
            @endif
          </div>

          {{-- Book Info --}}
          <div class="flex-1 space-y-4">
            <div>
              <h3 class="text-3xl font-bold text-[#1B3C53]">{{ $book->title }}</h3>
              <p class="text-sm text-[#555] italic">by {{ $book->author }}</p>
            </div>

            <div class="text-sm text-gray-800 space-y-1">
              <p><strong>📚 Publisher:</strong> {{ $book->publisher ?? '-' }}</p>
              <p><strong>🗓 Year:</strong> {{ $book->year ?? '-' }}</p>
              <p><strong>🔖 ISBN:</strong> {{ $book->isbn ?? '-' }}</p>
              <p><strong>📂 Category:</strong> {{ $book->category->name ?? '-' }}</p>
              <p><strong>💰 Rental Price:</strong> Rp{{ number_format($book->rental_price, 0, ',', '.') }}</p>
              <p><strong>📦 Available Stock:</strong> {{ $book->items->where('status', 'available')->count() }}</p>
              <p><strong>📊 Total Stock:</strong> {{ $book->items->count() }}</p>
            </div>

            <div>
              <p class="font-semibold text-[#1B3C53]">📝 Description:</p>
              <p class="text-justify text-sm text-gray-700">
                {{ $book->description ?? 'No description available.' }}
              </p>
            </div>

            <div class="pt-4 flex items-center gap-5">
              <a href="{{ route('member.books.index') }}"
                 class="inline-block bg-[#1B3C53] hover:bg-[#153042] text-white px-5 py-2 rounded-md text-sm transition-all duration-200">
                ← Back to List
              </a>
              @if ($book->items->where('status', 'available')->count() > 0)
                @php $item = $book->items->where('status', 'available')->first(); @endphp
                <a href="{{ route('member.book-loans.create', $item->id) }}"
                  class="inline-block bg-[#1B3C53] hover:bg-[#162f44] text-white text-sm px-4 py-2 rounded-md text-center">
                  📚 Pinjam Buku Ini
                </a>
              @else
                <span class="text-gray-500 text-sm mt-2 sm:mt-0">Buku tidak tersedia untuk dipinjam</span>
              @endif
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
