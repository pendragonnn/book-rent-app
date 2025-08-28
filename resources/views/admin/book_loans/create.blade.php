<x-app-layout>
  <x-slot:title>
        {{ __('Create Loan') }} - {{ config('app.name') }}
    </x-slot>
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

          {{-- Receipt (Optional) --}}
          <div class="space-y-2">
            <label for="receipt_id" class="block font-medium text-sm text-[#1B3C53]">Receipt</label>
            <select name="receipt_id" id="receipt_id"
              class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
              <option value="">-- Create New Receipt --</option>
              @foreach ($receipts as $receipt)
                <option value="{{ $receipt->id }}" {{ old('receipt_id') == $receipt->id ? 'selected' : '' }}>
                  Receipt #{{ $receipt->id }} - {{ $receipt->user->name }} (Total: Rp{{ number_format($receipt->total_price, 0, ',', '.') }})
                </option>
              @endforeach
            </select>
            @error('receipt_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Loan Date --}}
          <div class="space-y-2">
            <label for="loan_date" class="block font-medium text-sm text-[#1B3C53]">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', date('Y-m-d')) }}"
              class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('loan_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Due Date --}}
          <div class="space-y-2">
            <label for="due_date" class="block font-medium text-sm text-[#1B3C53]">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"      class="mt-1 block w-full
              rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('due_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div> 
            

          {{-- Buttons --}}
          <div class="flex justify-end gap-3 pt-6 border-t border-[#d2c1b6]">
            <a href="{{ route('admin.book-loans.index') }}"
              class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-full text-sm transition">
              Cancel
            </a>
            <button type="submit"
              class="px-4 py-2 bg-[#1B3C53] hover:bg-[#162f42] text-white rounded-full text-sm transition">
              Create Loan
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
  @push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <script>
    $(document).ready(function() {
      $('#book_item_id').select2({
        placeholder: "Search Book Item...",
        allowClear: true
      });
    });
    
    $(document).ready(function() {
      $('#user_id').select2({
        placeholder: "Search User...",
        allowClear: true
      });
    });
    
    $(document).ready(function() {
      $('#receipt_id').select2({
        placeholder: "Search Receipt ID...",
        allowClear: true
      });
    });
  </script>
  @endpush
</x-app-layout>