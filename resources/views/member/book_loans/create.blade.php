<x-app-layout>
  {{-- Define the title for the browser tab --}}
    <x-slot:title>
        {{ __('Create Loan') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      Book Loan Confirmation
    </h2>
  </x-slot>

  <div class="py-6 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md border border-[#d2c1b6]">
      <div class="flex flex-col md:flex-row gap-6">
        <img src="{{ asset('covers/' . $bookItems->book->cover_image) }}" alt="Book Cover"
          class="w-full md:w-40 h-auto rounded-lg shadow-md object-cover">

        <div>
          <h3 class="text-2xl font-bold text-[#1B3C53]">{{ $bookItems->book->title }}</h3>
          <p class="text-[#555] mt-1">✍️ Author: <span class="font-medium">{{ $bookItems->book->author }}</span></p>
          <p class="text-[#555]">📅 Year: {{ $bookItems->book->year }}</p>
          <p class="text-[#555]">💰 Rental Price: <span
              class="font-semibold text-[#1B3C53]">Rp{{ number_format($bookItems->book->rental_price, 0, ',', '.') }}</span>
          </p>
        </div>
      </div>

      <form action="{{ route('member.cart.add') }}" method="POST" class="mt-8 space-y-6">
        @csrf
        <input type="hidden" name="book_item_id" value="{{ $bookItems->id }}">

        <div>
          <label class="block text-sm font-medium text-[#1B3C53] mb-1">📆 Loan Date</label>
          <input type="date" name="loan_date" required
            class="w-full px-4 py-2 border border-[#d2c1b6] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1B3C53] bg-[#F9F3EF]"
            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </div>

        <div>
          <label class="block text-sm font-medium text-[#1B3C53] mb-1">📆 Return Date</label>
          <input type="date" name="due_date" required
            class="w-full px-4 py-2 border border-[#d2c1b6] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#1B3C53] bg-[#F9F3EF]">
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-3">
          <a href="{{ route('member.books.index') }}"
            class="inline-block text-center bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-full transition">
            Cancel
          </a>
          <button type="submit" class="bg-[#1B3C53] hover:bg-[#162d42] text-white px-4 py-2 rounded-full transition">
            Add to Cart
          </button>
        </div>
      </form>

    </div>
  </div>
</x-app-layout>