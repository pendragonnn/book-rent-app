<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Detail Peminjaman Buku') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white border border-[#D2C1B6] rounded-xl shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          {{-- Cover Buku --}}
          <div class="flex justify-center items-center">
            @if($bookLoan->bookItem->book->cover_image)
              <img src="{{ asset('covers/' . $bookLoan->bookItem->book->cover_image) }}"
                alt="{{ $bookLoan->bookItem->book->title }}"
                class="w-full max-w-[180px] h-auto rounded-md shadow-md object-cover">
            @else
              <div class="w-40 h-60 bg-gray-200 flex items-center justify-center rounded shadow-md text-gray-500">
                No Cover
              </div>
            @endif
          </div>

          {{-- Info Detail --}}
          <div class="md:col-span-2 space-y-6 text-[#4B4B4B]">
            {{-- Informasi Buku --}}
            <div>
              <h3 class="text-lg font-semibold text-[#1B3C53] mb-2">📘 Informasi Buku</h3>
              <p><span class="font-medium">Judul:</span> {{ $bookLoan->bookItem->book->title }}</p>
              <p><span class="font-medium">Penulis:</span> {{ $bookLoan->bookItem->book->author }}</p>
              <p><span class="font-medium">Kode Buku:</span> {{ $bookLoan->bookItem->id }}</p>
              <p><span class="font-medium">Kategori:</span> {{ $bookLoan->bookItem->book->category->name ?? '-' }}</p>
            </div>

            {{-- Informasi Peminjaman --}}
            <div>
              <h3 class="text-lg font-semibold text-[#1B3C53] mb-2">📅 Informasi Peminjaman</h3>
              <p><span class="font-medium">Tanggal Pinjam:</span> {{ $bookLoan->loan_date }}</p>
              <p><span class="font-medium">Tanggal Kembali:</span> {{ $bookLoan->due_date }}</p>
              <p>
                <span class="font-medium">Durasi Peminjaman:</span>
                {{ \Carbon\Carbon::parse($bookLoan->loan_date)->diffInDays(\Carbon\Carbon::parse($bookLoan->due_date)) }} hari
              </p>
              <p><span class="font-medium">Status:</span> 
                <span class="inline-block px-2 py-1 bg-[#D2C1B6] text-white rounded text-xs">
                  {{ ucfirst(str_replace('_', ' ', $bookLoan->status)) }}
                </span>
              </p>
              <p><span class="font-medium">Total Harga:</span> Rp {{ number_format($bookLoan->total_price, 0, ',', '.') }}</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
              <a href="{{ route('member.book-loans.index') }}"
                class="px-4 py-2 bg-[#D2C1B6] hover:bg-[#bba797] text-white text-sm rounded text-center">
                ← Kembali ke Daftar
              </a>

              @if ($bookLoan->status === 'payment_pending')
                <a href="{{ route('member.book-loans.edit', $bookLoan) }}"
                  class="px-4 py-2 bg-[#1B3C53] hover:bg-[#162f44] text-white text-sm rounded text-center">
                  ✏️ Edit Peminjaman
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
