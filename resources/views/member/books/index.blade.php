
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 sm:px-6 lg:px-8">
            @forelse ($books as $book)
                <div class="bg-white p-4 shadow rounded-lg">
                    <img src="{{ asset('storage/covers/' . ($book->cover_image ?? 'default.jpg')) }}" alt="{{ $book->title }}" class="w-full h-40 object-cover rounded mb-2">
                    <h3 class="text-lg font-bold">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-600">{{ Str::limit($book->description, 100) }}</p>
                    <p class="text-sm text-gray-500 mt-2">Kategori: {{ $book->category->name ?? '-' }}</p>
                    <p class="text-sm text-gray-800 font-semibold">Harga Sewa: Rp{{ number_format($book->rental_price, 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Tidak ada buku.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>

