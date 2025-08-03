<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Create Book Loan') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded shadow">
        <form action="{{ route('admin.book-loans.store') }}" method="POST">
          @csrf

          <div class="mb-4">
            <label for="user_id" class="block font-medium text-sm text-gray-700">User</label>
            <select name="user_id" id="user_id" class="form-select w-full mt-1">
              <option value="">-- Select User --</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
            @error('user_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>

          <div class="mb-4">
            <label for="book_item_id" class="block font-medium text-sm text-gray-700">Book Item</label>
            <select name="book_item_id" id="book_item_id" class="form-select w-full mt-1">
              <option value="">-- Select Book Item --</option>
              @foreach ($bookItems as $item)
                <option value="{{ $item->id }}" {{ old('book_item_id') == $item->id ? 'selected' : '' }}>
                  {{ $item->book->title }} (ID: {{ $item->id }})
                </option>
              @endforeach
            </select>
            @error('book_item_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>

          <div class="mb-4">
            <label for="loan_date" class="block font-medium text-sm text-gray-700">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" class="form-input w-full mt-1"
              value="{{ old('loan_date', date('Y-m-d')) }}">
            @error('loan_date') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>

          <div class="mb-4">
            <label for="due_date" class="block font-medium text-sm text-gray-700">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-input w-full mt-1"
              value="{{ old('due_date') }}">
            @error('due_date') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>

          <div class="mb-4">
            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
            <select name="status" id="status" class="form-select w-full mt-1">
              <option value="">-- Select Status --</option>
              @foreach (['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'] as $status)
                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                  {{ ucwords(str_replace('_', ' ', $status)) }}
                </option>
              @endforeach
            </select>
            @error('status') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>

          <div class="mb-4">
            <label for="total_price" class="block font-medium text-sm text-gray-700">Total Price</label>
            <input type="number" name="total_price" id="total_price" class="form-input w-full mt-1"
              value="{{ old('total_price') }}" min="0" step="500">
            @error('total_price') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
          </div>

          <div class="flex justify-end">
            <a href="{{ route('admin.book-loans.index') }}"
              class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">Cancel</a>
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
