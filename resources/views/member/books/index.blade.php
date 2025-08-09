<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-white">
            <h2 class="font-bold text-xl text-[#1B3C53] leading-tight">
                {{ __('Katalog Buku') }}
            </h2>
            {{-- Optional: Add a button to go back to dashboard or another relevant page --}}
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 text-sm font-medium underline text-gray-500 hover:text-[#1B3C53] transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>

                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-7xl mx-auto px-6 space-y-8">
            {{-- Filter & Search Section --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h3 class="text-xl font-bold text-[#1B3C53] mb-5">Cari dan Filter Buku</h3>
                <form method="GET" class="flex flex-col md:flex-row items-center gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full md:flex-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] placeholder-gray-500 transition-colors duration-200"
                        placeholder="Cari berdasarkan judul atau penulis...">

                    <select name="category"
                        class="w-full md:w-1/4 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] transition-colors duration-200">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-md transition-colors duration-300 shadow-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    {{-- Clear Filter Button --}}
                    @if(request('search') || request('category'))
                        <a href="{{ route('member.books.index') }}"
                            class="w-full md:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-md transition-colors duration-300 shadow-md flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Book Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($books as $book)
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-102 hover:shadow-xl flex flex-col">
                        {{-- Book Cover Image --}}
                        <img src="{{ asset('covers/' . $book->cover_image) }}" alt="{{ $book->title }}"
                            class="w-full h-60 object-cover rounded-t-xl">

                        <div class="p-5 flex flex-col justify-between flex-1">
                            <div>
                                {{-- Book Title --}}
                                <h3 class="text-xl font-bold text-[#1B3C53] mb-1">{{ $book->title }}</h3>
                                {{-- Author & Category --}}
                                <p class="text-sm text-gray-700">Penulis: {{ $book->author }}</p>
                                <p class="text-sm text-gray-700">Kategori: {{ $book->category->name ?? '-' }}</p>
                                {{-- Available Items Count --}}
                                <p class="text-sm text-gray-700 mt-2">Tersedia: <span
                                        class="font-semibold {{ $book->availableItemsCount() > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $book->availableItemsCount() }}</span>
                                </p>
                            </div>

                            {{-- Rental Price --}}
                            <div
                                class="mt-4 flex items-center justify-left gap-x-1 bg-[#F9F3EF] p-3 rounded-lg shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="#1B3C53" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>

                                <span class="text-base font-semibold text-gray-800">Harga Rental:</span>
                                <span class="text-md font-bold text-[#1B3C53]">
                                    {{-- Assuming $book->rental_price exists. Adjust if your model has a different
                                    attribute. --}}
                                    Rp{{ number_format($book->rental_price ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-4 flex justify-between items-center space-x-2">
                                <a href="{{ route('member.books.show', $book) }}"
                                    class="flex flex-1 items-center justify-center gap-x-3 text-center text-base bg-[#1B3C53] hover:bg-[#1B3C53]/90 text-white px-4 py-2 rounded-md transition-colors duration-300 shadow-md">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                    </svg>
                                </a>

                                @php
                                    $availableItem = $book->items->where('status', 'available')->first();
                                @endphp

                                @if ($availableItem)
                                    <a href="{{ route('member.book-loans.create', $availableItem->id) }}"
                                        class="flex flex-1 justify-center gap-x-2 text-center text-base bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-300 shadow-md">
                                        Pinjam
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="flex-1 text-center text-base text-red-500 font-semibold py-2">Tidak
                                        Tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-lg text-gray-600">
                        <p class="text-lg font-medium mb-4">Tidak ada buku yang ditemukan sesuai kriteria Anda.</p>
                        <a href="{{ route('member.books.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Lihat Semua Buku
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-end">
                {{ $books->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>