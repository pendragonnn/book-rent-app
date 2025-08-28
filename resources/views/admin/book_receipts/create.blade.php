<x-app-layout>
  <x-slot:title>
        {{ __('Add Receipt') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Create Book Loan Receipt') }}
    </h2>
  </x-slot>

  <div class="py-10" style="background-color: #F9F3EF">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      
      @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          {{ session('success') }}
        </div>
      @endif
      
      @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          {{ session('error') }}
        </div>
      @endif

      <div class="bg-white border border-[#d2c1b6] shadow-md rounded-xl p-6 mb-6">
        <h3 class="text-lg font-semibold text-[#1B3C53] mb-4">Add Book to Cart</h3>
        
        <form action="{{ route('admin.book-receipts.add-to-cart') }}" method="POST" class="space-y-4">
          @csrf

          <div class="grid grid-cols-1 gap-4">
            {{-- Book Item --}}
            <div class="space-y-2">
              <label for="book_item_id" class="block font-medium text-sm text-[#1B3C53]">Book Item</label>
              <select name="book_item_id" id="book_item_id" required
                      class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
                <option value="">-- Pilih Book Item --</option>
                @foreach ($bookItems as $item)
                  <option value="{{ $item->id }}" data-price="{{ $item->book->rental_price }}" 
                          {{ old('book_item_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->book->title }} (ID: {{ $item->id }}) - Rp{{ number_format($item->book->rental_price, 0, ',', '.') }}/Day
                  </option>
                @endforeach
              </select>
              @error('book_item_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Loan Date --}}
            <div class="space-y-2">
              <label for="loan_date" class="block font-medium text-sm text-[#1B3C53]">Loan Date</label>
              <input type="date" name="loan_date" id="loan_date" required
                     value="{{ old('loan_date', date('Y-m-d')) }}"
                     class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
              @error('loan_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Due Date --}}
            <div class="space-y-2">
              <label for="due_date" class="block font-medium text-sm text-[#1B3C53]">Due Date</label>
              <input type="date" name="due_date" id="due_date" required
                     value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}"
                     class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
              @error('due_date') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="flex justify-end pt-4">
            <button type="submit"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
              Add to Cart
            </button>
          </div>
        </form>
      </div>

      @if(count($cart) > 0)
      <div class="bg-white border border-[#d2c1b6] shadow-md rounded-xl p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-[#1B3C53]">Items in Cart ({{ count($cart) }})</h3>
          <form action="{{ route('admin.book-receipts.clear-cart') }}" method="POST">
            @csrf
            <button type="submit" class="text-red-500 text-sm hover:text-red-700">
              Empty Cart
            </button>
          </form>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">No</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Book</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Loan Date</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Due Date</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Loan Price</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @php $total = 0; @endphp
              @foreach($cart as $index => $item)
              @php $total += $item['total_price']; @endphp
              <tr>
                <td class="px-4 py-3">{{ $index + 1 }}</td>
                <td class="px-4 py-3">{{ $item['book_title'] }}</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item['loan_date'])->format('d M Y') }}</td>
                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item['due_date'])->format('d M Y') }}</td>
                <td class="px-4 py-3">Rp{{ number_format($item['total_price'], 0, ',', '.') }}</td>
                <td class="px-4 py-3">
                  <form action="{{ route('admin.book-receipts.remove-from-cart', $index) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                      </svg>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
              <tr class="font-semibold">
                <td colspan="5" class="px-4 py-3 text-right">Total:</td>
                <td class="px-4 py-3">Rp{{ number_format($total, 0, ',', '.') }}</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="mt-6 pt-4 border-t border-[#d2c1b6]">
          <h3 class="text-lg font-semibold text-[#1B3C53] mb-4">Add Receipt</h3>
          
          <form action="{{ route('admin.book-receipts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              {{-- Payment Method --}}
              <div class="space-y-2">
                <label for="payment_method" class="block font-medium text-sm text-[#1B3C53]">Payment Method</label>
                <select name="payment_method" id="payment_method" required
                        class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
                  <option value="">-- Choose Payment Method --</option>
                  <option value="bank_transfer">Bank Transfer</option>
                  <option value="ewallet">E-Wallet</option>
                  <option value="cash">Cash</option>
                </select>
                {{-- User --}}
            <div class="space-y-2">
              <label for="user_id" class="block font-medium text-sm text-[#1B3C53]">User</label>
              <select name="user_id" id="user_id" required
                      class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
                <option value="">-- Pilih User --</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                  </option>
                @endforeach
              </select>
              @error('user_id') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
                @error('payment_method') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
              </div>

              {{-- Payment Proof --}}
              <div class="space-y-2">
                <label for="payment_proof" class="block font-medium text-sm text-[#1B3C53]">Payment Proof (Optional)</label>
                <input type="file" name="payment_proof" id="payment_proof"
                       class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
                @error('payment_proof') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
              </div>
            </div>

            <div class="flex justify-end gap-3 pt-6">
              <a href="{{ route('admin.book-receipts.index') }}"
                 class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-full text-sm transition">
                Cancel
              </a>
              <button type="submit"
                      class="px-4 py-2 bg-[#1B3C53] hover:bg-[#162f42] text-white rounded-full text-sm transition">
                Create Receipt
              </button>
            </div>
          </form>
        </div>
      </div>
      @else
      <div class="bg-white border border-[#d2c1b6] shadow-md rounded-xl p-6 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <p class="mt-4 text-gray-500">Cart Empty. Add Book to Make Receipt.</p>
      </div>
      @endif
    </div>
  </div>

  @push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <script>
    
    // Calculate price based on dates
    document.addEventListener('DOMContentLoaded', function() {
      const loanDateInput = document.getElementById('loan_date');
      const dueDateInput = document.getElementById('due_date');
      const bookSelect = document.getElementById('book_item_id');
      
      function updatePriceEstimate() {
        if (loanDateInput.value && dueDateInput.value && bookSelect.value) {
          const start = new Date(loanDateInput.value);
          const end = new Date(dueDateInput.value);
          const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
          
          if (days > 0) {
            const selectedOption = bookSelect.options[bookSelect.selectedIndex];
            const dailyPrice = parseFloat(selectedOption.getAttribute('data-price'));
            const totalPrice = dailyPrice * days;
            
            // You can display this estimate somewhere if needed
            console.log('Estimated price:', totalPrice);
          }
        }
      }
      
      loanDateInput.addEventListener('change', updatePriceEstimate);
      dueDateInput.addEventListener('change', updatePriceEstimate);
      bookSelect.addEventListener('change', updatePriceEstimate);
    });

    $(document).ready(function() {
      $('#book_item_id').select2({
        placeholder: "Search Book Item ID...",
        allowClear: true
      });
    });
    
    $(document).ready(function() {
      $('#user_id').select2({
        placeholder: "Search User Name...",
        allowClear: true
      });
    });
  </script>
  @endpush
</x-app-layout>