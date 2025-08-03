<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300" required>
                        @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300" required>
                        @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Role</label>
                        <select name="role_id" class="form-select w-full mt-1 rounded-md shadow-sm border-gray-300" required>
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
                               class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300">
                        @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
