<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#d2c1b6] shadow-md rounded-2xl p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="form-input w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#1B3C53] focus:ring-[#1B3C53]" required>
                        @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-input w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#1B3C53] focus:ring-[#1B3C53]" required>
                        @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Role</label>
                        <select name="role_id"
                            class="form-select w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#1B3C53] focus:ring-[#1B3C53]" required>
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">New Password (optional)</label>
                        <input type="password" name="password"
                            class="form-input w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#1B3C53] focus:ring-[#1B3C53]">
                        @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-full hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-[#1B3C53] text-white text-sm font-medium rounded-full hover:bg-[#162e3f] transition">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
