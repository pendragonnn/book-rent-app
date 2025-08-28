<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Add New User') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-lg rounded-xl p-8 border border-[#d2c1b6]">
        <form method="POST" action="{{ route('admin.users.store') }}">
          @csrf

          {{-- Name --}}
          <div class="mb-6">
            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
              placeholder="Enter full name" required>
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Email --}}
          <div class="mb-6">
            <label for="email" class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
              placeholder="example@email.com" required>
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Password --}}
          <div class="mb-6">
            <label for="password" class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
            <input type="password" name="password" id="password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
              placeholder="Minimum 8 characters" required>
            @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Role --}}
          <div class="mb-6">
            <label for="role_id" class="block text-sm font-semibold text-gray-800 mb-1">Role</label>
            <select name="role_id" id="role_id"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]"
              required>
              <option value="">-- Select Role --</option>
              @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                  {{ ucfirst($role->name) }}
                </option>
              @endforeach
            </select>
            @error('role_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Buttons --}}
          <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('admin.users.index') }}"
              class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-full hover:bg-gray-600 transition">
              Cancel
            </a>
            <button type="submit"
              class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#1B3C53] rounded-full hover:bg-[#162f42] transition">
              Save User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
