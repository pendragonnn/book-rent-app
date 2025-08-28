<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Edit Book') }}
    </h2>
  </x-slot>

  <div class="py-10 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white shadow-lg rounded-2xl p-8 border border-[#D2C1B6]">
        <form method="POST" action="{{ route('admin.books.update', $book->id) }}" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          {{-- Title --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Title</label>
            <input type="text" name="title" value="{{ old('title', $book->title) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
                   required>
            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Author --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Author</label>
            <input type="text" name="author" value="{{ old('author', $book->author) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
                   required>
            @error('author') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Description --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Description</label>
            <textarea name="description" rows="3"
                      class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">{{ old('description', $book->description) }}</textarea>
            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Publisher --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Publisher</label>
            <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('publisher') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Year --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Year</label>
            <input type="text" name="year" maxlength="4" value="{{ old('year', $book->year) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('year') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- ISBN --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">ISBN</label>
            <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('isbn') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Category --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Category</label>
            <select name="category_id"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
                    required>
              <option value="">-- Select Category --</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
            @error('category_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Rental Price --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Rental Price (Rp)</label>
            <input type="number" name="rental_price" min="0" value="{{ old('rental_price', $book->rental_price) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
                   required>
            @error('rental_price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Stock --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Stock</label>
            <input type="number" name="stock" min="0" value="{{ old('stock', $book->items->count()) }}"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
                   required>
            @error('stock') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Cover Image --}}
          <div>
            <label class="block text-sm font-semibold text-[#1B3C53]">Cover Image</label>
            <input type="file" name="cover_image"
                   class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @if ($book->cover_image)
              <img src="{{ asset('covers/'.$book->cover_image) }}" alt="Cover" class="mt-3 w-24 h-32 object-cover rounded shadow">
            @endif
            @error('cover_image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Buttons --}}
          <div class="flex justify-end gap-3 pt-4">
            <a href="javascript:history.back()"
               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded-full transition">
              Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-[#1B3C53] hover:bg-[#153042] text-white text-sm rounded-full transition">
              Update Book
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
