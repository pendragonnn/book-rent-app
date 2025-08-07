<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between py-4 px-4 sm:px-6 lg:px-8 bg-white shadow-sm rounded-lg">
            <h2 class="font-bold text-2xl text-[#1B3C53] leading-tight">
                {{ __('Katalog Buku') }}
            </h2>
            {{-- Optional: Add a button to go back to dashboard or another relevant page --}}
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0L3 9.414a1 1 0 010-1.414l5.293-5.293a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Filter & Search Section --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h3 class="text-xl font-bold text-[#1B3C53] mb-5">Cari dan Filter Buku</h3>
                <form method="GET" class="flex flex-col md:flex-row items-center gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full md:flex-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] placeholder-gray-500 transition-colors duration-200"
                        placeholder="Cari berdasarkan judul atau penulis...">

                    <select name="category" class="w-full md:w-1/4 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] transition-colors duration-200">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-md transition-colors duration-300 shadow-md flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    {{-- Clear Filter Button --}}
                    @if(request('search') || request('category'))
                        <a href="{{ route('member.books.index') }}" class="w-full md:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-md transition-colors duration-300 shadow-md flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Book Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($books as $book)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-102 hover:shadow-xl flex flex-col">
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
                                <p class="text-sm text-gray-700 mt-2">Tersedia: <span class="font-semibold {{ $book->availableItemsCount() > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $book->availableItemsCount() }}</span></p>
                            </div>

                            {{-- Rental Price --}}
                            <div class="mt-4 flex items-center justify-between bg-[#F9F3EF] p-3 rounded-lg shadow-inner">
                                <span class="text-base font-semibold text-gray-800">Harga Rental:</span>
                                <span class="text-xl font-bold text-blue-600">
                                    {{-- Assuming $book->rental_price exists. Adjust if your model has a different attribute. --}}
                                    Rp{{ number_format($book->rental_price ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-4 flex justify-between items-center space-x-2">
                                <a href="{{ route('member.books.show', $book) }}"
                                   class="flex-1 text-center text-base bg-[#1B3C53] hover:bg-[#1B3C53]/90 text-white px-4 py-2 rounded-md transition-colors duration-300 shadow-md">
                                    Detail
                                </a>

                                @php
                                    $availableItem = $book->items->where('status', 'available')->first();
                                @endphp

                                @if ($availableItem)
                                    <a href="{{ route('member.book-loans.create', $availableItem->id) }}"
                                       class="flex-1 text-center text-base bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-300 shadow-md">
                                        Pinjam
                                    </a>
                                @else
                                    <span class="flex-1 text-center text-base text-red-500 font-semibold py-2">Tidak Tersedia</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-lg text-gray-600">
                        <p class="text-lg font-medium mb-4">Tidak ada buku yang ditemukan sesuai kriteria Anda.</p>
                        <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Lihat Semua Buku
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-center">
                {{ $books->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
