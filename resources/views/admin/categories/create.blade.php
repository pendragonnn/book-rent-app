<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
            {{ __('Add New Category') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-md border border-[#d2c1b6]">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-[#1B3C53] mb-1">
                            Category Name
                        </label>
                        <input type="text" name="name" id="name"
                               class="w-full rounded-xl border border-[#d2c1b6] px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1B3C53]"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('admin.categories.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-[#1B3C53] text-white text-sm font-medium rounded hover:bg-[#162e3f]">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
