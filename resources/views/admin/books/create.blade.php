<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Book') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 border border-[#D2C1B6]">
                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Author --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Author</label>
                        <input type="text" name="author" value="{{ old('author') }}"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @error('author') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none">{{ old('description') }}</textarea>
                        @error('description') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Publisher --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Publisher</label>
                        <input type="text" name="publisher" value="{{ old('publisher') }}"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('publisher') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Year --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Year</label>
                        <input type="text" name="year" maxlength="4" value="{{ old('year') }}"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('year') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- ISBN --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @error('isbn') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" required
                                class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rental Price --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rental Price (Rp)</label>
                        <input type="number" name="rental_price" min="0" value="{{ old('rental_price') }}"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @error('rental_price') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Stock --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" min="0" value="{{ old('stock') }}"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @error('stock') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Cover Image --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cover Image</label>
                        <input type="file" name="cover_image"
                               class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm file:border file:rounded file:mr-4 file:py-2 file:px-4 file:bg-blue-50 file:text-blue-700">
                        @error('cover_image') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ route('admin.books.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-[#1B3C53] text-white text-sm font-medium rounded hover:bg-[#162e3f]">
                            Save Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
