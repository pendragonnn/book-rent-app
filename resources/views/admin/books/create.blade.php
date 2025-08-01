<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Book') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300" required>
                        @error('title') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Author --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Author</label>
                        <input type="text" name="author" value="{{ old('author') }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300" required>
                        @error('author') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Description</label>
                        <textarea name="description" rows="3"
                                  class="form-textarea w-full mt-1 rounded-md shadow-sm border-gray-300">{{ old('description') }}</textarea>
                        @error('description') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Publisher --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Publisher</label>
                        <input type="text" name="publisher" value="{{ old('publisher') }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300">
                        @error('publisher') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Year --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Year</label>
                        <input type="text" name="year" maxlength="4" value="{{ old('year') }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300">
                        @error('year') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- ISBN --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300">
                        @error('isbn') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Category</label>
                        <select name="category_id" class="form-select w-full mt-1 rounded-md shadow-sm border-gray-300" required>
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
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Rental Price (Rp)</label>
                        <input type="number" name="rental_price" min="0" value="{{ old('rental_price') }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300" required>
                        @error('rental_price') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Stock</label>
                        <input type="number" name="stock" min="0" value="{{ old('stock') }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300" required>
                        @error('stock') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Cover Image --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Cover Image</label>
                        <input type="file" name="cover_image"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300">
                        @error('cover_image') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.books.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
                            Save Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
