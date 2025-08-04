<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Konfirmasi Peminjaman Buku
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
      <div class="flex gap-6">
        <img src="{{ asset('covers/' . $bookItem->book->cover_image) }}" alt="Book Cover" class="w-40 h-auto rounded shadow">
        <div>
          <h3 class="text-xl font-bold">{{ $bookItem->book->title }}</h3>
          <p class="text-gray-700">Penulis: {{ $bookItem->book->author }}</p>
          <p class="text-gray-700">Tahun: {{ $bookItem->book->year }}</p>
          <p class="text-gray-700">Harga Sewa: Rp{{ number_format($bookItem->book->rental_price, 0, ',', '.') }}</p>
        </div>
      </div>

      <form action="{{ route('member.book-loans.store') }}" method="POST" class="mt-6">
        @csrf
        <input type="hidden" name="book_item_id" value="{{ $bookItem->id }}">

        <div class="mb-4">
          <label class="block font-medium text-sm text-gray-700">Tanggal Pinjam</label>
          <input type="date" name="loan_date" class="form-input mt-1 block w-full"
                 value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
        </div>

        <div class="mb-4">
          <label class="block font-medium text-sm text-gray-700">Tanggal Kembali</label>
          <input type="date" name="due_date" class="form-input mt-1 block w-full" required>
        </div>

        <div class="flex justify-end">
          <a href="{{ route('member.books.index') }}"
             class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
            Batal
          </a>
          <button type="submit"
                  class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Konfirmasi Pinjam
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
