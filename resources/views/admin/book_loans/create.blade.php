<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Create Book Loan') }}
    </h2>
  </x-slot>

  <div class="py-10" style="background-color: #F9F3EF">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white border border-[#d2c1b6] shadow-md rounded-xl p-8 space-y-6">

        <form action="{{ route('admin.book-loans.store') }}" method="POST" class="space-y-5">
          @csrf

          {{-- User --}}
          <div class="space-y-2">
            <label for="user_id" class="block font-medium text-sm text-[#1B3C53]">User</label>
            <select name="user_id" id="user_id"
                    class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
              <option value="">-- Select User --</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
            @error('user_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Book Item --}}
          <div class="space-y-2">
            <label for="book_item_id" class="block font-medium text-sm text-[#1B3C53]">Book Item</label>
            <select name="book_item_id" id="book_item_id"
                    class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
              <option value="">-- Select Book Item --</option>
              @foreach ($bookItems as $item)
                <option value="{{ $item->id }}" {{ old('book_item_id') == $item->id ? 'selected' : '' }}>
                  {{ $item->book->title }} (ID: {{ $item->id }})
                </option>
              @endforeach
            </select>
            @error('book_item_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Loan Date --}}
          <div class="space-y-2">
            <label for="loan_date" class="block font-medium text-sm text-[#1B3C53]">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date"
                   value="{{ old('loan_date', date('Y-m-d')) }}"
                   class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('loan_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Due Date --}}
          <div class="space-y-2">
            <label for="due_date" class="block font-medium text-sm text-[#1B3C53]">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                   class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('due_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Status --}}
          <div class="space-y-2">
            <label for="status" class="block font-medium text-sm text-[#1B3C53]">Status</label>
            <select name="status" id="status"
                    class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
              <option value="">-- Select Status --</option>
              @foreach (['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'] as $status)
                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                  {{ ucwords(str_replace('_', ' ', $status)) }}
                </option>
              @endforeach
            </select>
            @error('status') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Total Price --}}
          <div class="space-y-2">
            <label for="total_price" class="block font-medium text-sm text-[#1B3C53]">Total Price (Rp)</label>
            <input type="number" name="total_price" id="total_price" value="{{ old('total_price') }}"
                   min="0" step="500"
                   class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('total_price') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Buttons --}}
          <div class="flex justify-end gap-3 pt-6 border-t border-[#d2c1b6]">
            <a href="{{ route('admin.book-loans.index') }}"
               class="px-4 py-2 bg-[#d2c1b6] hover:bg-[#c7b4a8] text-white rounded-md text-sm transition">
              Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-[#1B3C53] hover:bg-[#162f42] text-white rounded-md text-sm transition">
              Create Loan
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</x-app-layout>
