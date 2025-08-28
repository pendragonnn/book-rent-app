<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-[#1B3C53] leading-tight">
      {{ __('Edit Cart Item') }}
    </h2>
  </x-slot>

  <div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      @if($errors->any())
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
      <ul>
        @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
    @endif
      <div class="bg-white shadow-lg rounded-2xl p-8 border border-[#d2c1b6]">
        <form method="POST" action="{{ route('member.cart.update', $bookLoan) }}">
          @csrf
          @method('PUT')

          <div class="mb-6">
            <label class="block text-sm font-medium text-[#1B3C53] mb-1" for="loan_date">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', $bookLoan->loan_date) }}"
              class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:ring-[#1B3C53] focus:border-[#1B3C53]">
          </div>

          <div class="mb-6">
            <label class="block text-sm font-medium text-[#1B3C53] mb-1" for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $bookLoan->due_date) }}"
              class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:ring-[#1B3C53] focus:border-[#1B3C53]">
          </div>

          <p class="mt-1 text-sm text-gray-500">
            Harga per hari: Rp {{ number_format($bookLoan->bookItem->book->rental_price, 2) }}
          </p>

          <div class="mb-6">
            <label class="block text-sm font-medium text-[#1B3C53] mb-1" for="total_price">Total Price</label>
            <input type="text" id="total_price" disabled value="Rp. {{ old('total_price', $bookLoan->total_price)}}"
              class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 bg-gray-100">
          </div>

          <div class="flex justify-end space-x-3">
            <a href="{{ route('member.book-loans.index') }}"
              class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2.5 rounded-lg transition-all duration-200">
              Cancel
            </a>
            <button type="submit"
              class="bg-[#1B3C53] hover:bg-[#163040] text-white px-5 py-2.5 rounded-lg transition-all duration-200">
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
        const totalPriceInput = document.getElementById('total_price');

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
          
          // Format mata uang
          totalPriceInput.value = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
          }).format(totalPrice);
        }

        loanDateInput.addEventListener('change', calculateTotal);
        dueDateInput.addEventListener('change', calculateTotal);
        
        calculateTotal();
      });
    </script>
  @endpush
</x-app-layout>