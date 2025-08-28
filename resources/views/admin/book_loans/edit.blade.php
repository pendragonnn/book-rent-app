<x-app-layout>
  <x-slot:title>
        {{ __('Edit Loan') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Edit Book Loan') }}
    </h2>
  </x-slot>

  <div class="py-10" style="background-color: #F9F3EF">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white border border-[#d2c1b6] shadow-md rounded-xl p-8 space-y-6">

        <form method="POST" action="{{ route('admin.book-loans.update', $bookLoan) }}" class="space-y-5">
          @csrf
          @method('PUT')

          {{-- User
          <div class="space-y-2">
            <label for="user_id" class="block text-sm font-medium text-[#1B3C53]">User</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]" required>
              @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $bookLoan->user_id == $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
            @error('user_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div> --}}

          {{-- Book Item --}}
          <div class="space-y-2 hidden">
            <label for="book_item_id" class="block text-sm font-medium text-[#1B3C53]">Book</label>
            <select name="book_item_id" id="book_item_id" class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]" required>
              @foreach ($bookItems as $item)
                <option value="{{ $item->id }}" {{ $bookLoan->book_item_id == $item->id ? 'selected' : '' }}>
                  {{ $item->book->title }}
                </option>
              @endforeach
            </select>
            @error('book_item_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Loan Date --}}
          <div class="space-y-2">
            <label for="loan_date" class="block text-sm font-medium text-[#1B3C53]">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" value="{{ $bookLoan->loan_date }}"
                   class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('loan_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Due Date --}}
          <div class="space-y-2">
            <label for="due_date" class="block text-sm font-medium text-[#1B3C53]">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ $bookLoan->due_date }}"
                   class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('due_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <p class="mt-1 text-sm text-gray-500">
            Harga per hari: Rp {{ number_format($bookLoan->bookItem->book->rental_price, 2) }}
          </p>

          <div class="mb-6">
            <label class="block text-sm font-medium text-[#1B3C53] mb-1" for="loan_price">Total Price</label>
            <input type="text" name="loan_price" id="loan_price" readonly value="Rp. {{ old('loan_price', $bookLoan->loan_price)}}"
              class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 bg-gray-100">
          </div>

          {{-- Status --}}
          <div class="space-y-2">
            <label for="status" class="block text-sm font-medium text-[#1B3C53]">Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]" required>
              @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ $bookLoan->status === $status ? 'selected' : '' }}>
                  {{ ucwords(str_replace('_', ' ', $status)) }}
                </option>
              @endforeach
            </select>
            @error('status') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Buttons --}}
          <div class="flex justify-end gap-3 pt-6 border-t border-[#d2c1b6]">
            <a href="javascript:history.back()"
               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-full text-sm transition">
              Cancel
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-[#1B3C53] hover:bg-[#162f42] text-white rounded-full text-sm transition">
              Update Loan
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const loanDateInput = document.getElementById('loan_date');
        const dueDateInput = document.getElementById('due_date');
        const totalPriceInput = document.getElementById('loan_price');

        const pricePerDay = {{ $bookLoan->bookItem->book->rental_price }};

        function calculateTotal() {
          const loanDate = new Date(loanDateInput.value);
          const dueDate = new Date(dueDateInput.value);
          
          // Validasi tanggal
          if (!loanDateInput.value || !dueDateInput.value) return;
          if (loanDate > dueDate) return;

          const diffTime = dueDate - loanDate;
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
          
          const totalPrice = diffDays * pricePerDay;
          
          
          totalPriceInput.value = totalPrice
        }

        loanDateInput.addEventListener('change', calculateTotal);
        dueDateInput.addEventListener('change', calculateTotal);
        
        calculateTotal();
      });
    </script>
  @endpush
</x-app-layout>
