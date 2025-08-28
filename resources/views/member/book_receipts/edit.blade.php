<x-app-layout>
  {{-- Define the title for the browser tab --}}
    <x-slot:title>
        {{ __('Edit Receipt') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Edit Book Loan Receipt') }} #{{ $receipt->id }}
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
        <h3 class="text-lg font-semibold text-[#1B3C53] mb-4">Edit Receipt Information</h3>

        <form action="{{ route('member.book-receipts.update', $receipt->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            {{-- Payment Method --}}
            <div class="space-y-2">
              <label for="payment_method" class="block font-medium text-sm text-[#1B3C53]">Payment Method</label>
              <select name="payment_method" id="payment_method" required
                class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
                <option value="bank_transfer" {{ $receipt->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank
                  Transfer</option>
                <option value="ewallet" {{ $receipt->payment_method == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                <option value="cash" {{ $receipt->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
              </select>
              @error('payment_method') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Total Price --}}
            <div class="space-y-2">
              <label for="total_price" class="block font-medium text-sm text-[#1B3C53]">Total Price</label>
              <input type="number" name="total_price" id="total_price" readonly required
                value="{{ old('total_price', $receipt->total_price) }}"
                class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
              @error('total_price') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Payment Proof --}}
          <div class="space-y-2 mt-4">
            <label for="payment_proof" class="block font-medium text-sm text-[#1B3C53]">Payment Proof</label>
            @if($receipt->payment_proof)
              <div class="mb-2">
                <p class="text-sm text-gray-600">Current Proof:</p>
                <a href="{{ asset('storage/' . $receipt->payment_proof) }}" target="_blank"
                  class="text-blue-500 underline text-sm">
                  View Current Proof
                </a>
                <img src="{{ asset('storage/' . $receipt->payment_proof) }}" alt="">
              </div>
            @endif
            <input type="file" name="payment_proof" id="payment_proof"
              class="mt-1 block w-full rounded-md border-[#d2c1b6] shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53]">
            @error('payment_proof') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          <div class="flex justify-end gap-3 pt-6">
            <a href="javascript:history.back()"
              class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-full text-sm transition">
              Cancel
            </a>
            <button type="submit"
              class="px-4 py-2 bg-[#1B3C53] hover:bg-[#162f42] text-white rounded-full text-sm transition">
              Update Receipt
            </button>
          </div>
        </form>
      </div>

      {{-- Loans in this receipt --}}
      <div class="bg-white border border-[#d2c1b6] shadow-md rounded-xl p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-[#1B3C53]">Loans in this receipt</h3>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">No</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Buku</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Loan Date</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Due Date</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Harga</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Status</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-[#1B3C53] uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach($receipt->loans as $index => $loan)
                <tr>
                  <td class="px-4 py-3">{{ $index + 1 }}</td>
                  <td class="px-4 py-3">
                    {{ $loan->bookItem->book->title ?? 'N/A' }}
                  </td>
                  <td class="px-4 py-3">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                  <td class="px-4 py-3">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                  <td class="px-4 py-3">Rp{{ number_format($loan->loan_price, 0, ',', '.') }}</td>
                  <td class="px-4 py-3">
                    @php
                      $statusColor = match ($loan->status) {
                        'payment_pending' => 'bg-blue-500',
                        'admin_validation' => 'bg-indigo-500',
                        'borrowed' => 'bg-yellow-500',
                        'returned' => 'bg-green-500',
                        'cancelled' => 'bg-red-500',
                        default => 'bg-gray-400',
                      };
                    @endphp
                    <span
                      class="text-white flex text-center items-center justify-center px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                      {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                    </span>
                  </td>
                  <td>
                  @if ($loan->status === 'admin_validation')
                    <form action=" {{ route('member.book-loans.cancelLoan', $loan->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin membatalkan peminjaman ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                      class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                      </svg>
                                      Cancel
                                    </button>
                                    </form>
                  @endif
                  </td>
                </tr>
              @endforeach
              <tr class="font-semibold">
                <td colspan="4" class="px-4 py-3 text-right">Total:</td>
                <td class="px-4 py-3">Rp{{ number_format($receipt->total_price, 0, ',', '.') }}</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>