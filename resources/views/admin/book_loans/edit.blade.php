<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Book Loan') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-md rounded-lg p-6">
        <form method="POST" action="{{ route('admin.book-loans.update', $bookLoan) }}">
          @csrf
          @method('PUT')

          {{-- User --}}
          <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">User</label>
            <select name="user_id" class="form-select w-full mt-1 rounded-md shadow-sm border-gray-300" required>
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $bookLoan->user_id == $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
            @error('user_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Book Item --}}
          <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Book</label>
            <select name="book_item_id" class="form-select w-full mt-1 rounded-md shadow-sm border-gray-300" required>
              @foreach ($bookItems as $item)
                <option value="{{ $item->id }}" {{ $bookLoan->book_item_id == $item->id ? 'selected' : '' }}>
                  {{ $item->book->title }}
                </option>
              @endforeach
            </select>
            @error('book_item_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Loan Date --}}
          <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Loan Date</label>
            <input type="date" name="loan_date" value="{{ $bookLoan->loan_date }}"
              class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300">
            @error('loan_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Due Date --}}
          <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Due Date</label>
            <input type="date" name="due_date" value="{{ $bookLoan->due_date }}"
              class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300">
            @error('due_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Total Price --}}
          <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Total Price (Rp)</label>
            <input type="number" name="total_price" value="{{ $bookLoan->total_price }}"
              class="form-input w-full mt-1 rounded-md shadow-sm border-gray-300" min="0" step="1000">
            @error('total_price') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Status --}}
          <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700">Status</label>
            <select name="status" class="form-select w-full mt-1 rounded-md shadow-sm border-gray-300" required>
              @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ $bookLoan->status === $status ? 'selected' : '' }}>
                  {{ ucwords(str_replace('_', ' ', $status)) }}
                </option>
              @endforeach
            </select>
            @error('status') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Buttons --}}
          <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.book-loans.index') }}"
              class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
              Cancel
            </a>
            <button type="submit"
              class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
              Update Loan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
