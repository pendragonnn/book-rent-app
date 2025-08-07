<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Book Detail') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white border border-[#D2C1B6] rounded-xl shadow p-6 flex flex-col md:flex-row gap-6">
        {{-- Book Cover --}}
        <div class="flex-shrink-0 flex justify-center md:justify-start">
          <img src="{{ asset('covers/' . $book->cover_image) }}" alt="{{ $book->title }}"
            class="w-48 h-auto rounded-md shadow-md">
        </div>

        {{-- Book Info --}}
        <div class="flex-1 space-y-3 text-[#4B4B4B]">
          <h3 class="text-2xl font-bold text-[#1B3C53]">{{ $book->title }}</h3>
          <p class="text-sm"><span class="font-medium">Author:</span> {{ $book->author }}</p>
          <p class="text-sm"><span class="font-medium">Category:</span> {{ $book->category->name ?? '-' }}</p>
          <p class="text-sm"><span class="font-medium">Publisher:</span> {{ $book->publisher ?? '-' }}</p>
          <p class="text-sm"><span class="font-medium">Published Year:</span> {{ $book->year ?? '-' }}</p>
          <p class="text-sm"><span class="font-medium">ISBN:</span> {{ $book->isbn ?? '-' }}</p>
          <p class="text-sm"><span class="font-medium">Rental Price:</span> Rp {{ number_format($book->rental_price, 0, ',', '.') }}</p>
          <p class="text-sm"><span class="font-medium">Available Stock:</span> {{ $book->availableItemsCount() }}</p>

          {{-- Description --}}
          @if ($book->description)
            <div class="pt-2">
              <h4 class="text-sm font-medium text-[#1B3C53] mb-1">Description:</h4>
              <p class="text-sm leading-relaxed">{{ $book->description }}</p>
            </div>
          @endif

          {{-- Buttons --}}
          <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('member.books.index') }}"
              class="inline-block bg-[#D2C1B6] hover:bg-[#bba797] text-white text-sm px-4 py-2 rounded-md text-center">
              ← Back to Catalog
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
</x-app-layout>
