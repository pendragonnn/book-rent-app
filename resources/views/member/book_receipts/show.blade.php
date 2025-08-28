<x-app-layout>
  <x-slot name="header">
    {{-- Define the title for the browser tab --}}
    <x-slot:title>
      {{ __('Receipt Detail') }} - {{ config('app.name') }}
  </x-slot>
  <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
    {{ __('Receipt Detail') }} #{{ $receipt->id }}
  </h2>
  </x-slot>

  <div class="py-8" style="background-color:#F9F3EF">
    <div class="max-w-6xl mx-auto px-6">

      {{-- flash message --}}
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

      {{-- SUMMARY --}}
      <div class="bg-white border border-[#d2c1b6] rounded-xl shadow-md p-6 mb-6">
        <div class="grid md:grid-cols-3 gap-6">
          <div>
            <h3 class="text-sm font-semibold text-[#1B3C53] mb-2">User</h3>
            <p class="text-sm text-gray-700">
              <span class="font-medium">Name:</span> {{ $receipt->user->name ?? '-' }}
            </p>
            <p class="text-sm text-gray-700">
              <span class="font-medium">Email:</span> {{ $receipt->user->email ?? '-' }}
            </p>
          </div>

          <div>
            <h3 class="text-sm font-semibold text-[#1B3C53] mb-2">Receipt Info</h3>
            <p class="text-sm text-gray-700"><span class="font-medium">ID:</span> #{{ $receipt->id }}</p>
            <p class="text-sm text-gray-700"><span class="font-medium">Payment Method:</span>
              {{ $receipt->payment_method ?? '-' }}</p>
            <p class="text-sm text-gray-700">
              <span class="font-medium">Created At:</span>
              {{ optional($receipt->created_at)->format('d M Y H:i') }}
            </p>
          </div>

          <div>
            @php
              $statusMap = [
                'pending' => 'bg-blue-500',
                'verified' => 'bg-indigo-500',
                'paid' => 'bg-green-600',
                'rejected' => 'bg-red-500',
              ];
              $badge = $statusMap[$receipt->status] ?? 'bg-gray-500';
            @endphp
            <h3 class="text-sm font-semibold text-[#1B3C53] mb-2">Payment</h3>
            <p class="text-sm text-gray-700">
              <span class="font-medium">Total:</span>
              Rp{{ number_format($receipt->total_price, 0, ',', '.') }}
            </p>
            <div class="mt-2">
              <span class="inline-block text-white px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                {{ ucwords(str_replace('_', ' ', $receipt->status)) }}
              </span>
            </div>
          </div>
        </div>
      </div>

      {{-- PAYMENT PROOF --}}
      <div class="bg-white border border-[#d2c1b6] rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-sm font-semibold text-[#1B3C53] mb-3">Payment Proof</h3>
        @if ($receipt->payment_proof)
          <div class="flex items-start gap-4">
            <a href="{{ asset('storage/' . $receipt->payment_proof) }}" target="_blank"
              class="text-[#1B3C53] underline text-sm">View / Download</a>
            <div class="border rounded-lg overflow-hidden">
              <img src="{{ asset('storage/' . $receipt->payment_proof) }}" alt="Payment Proof"
                class="max-h-56 object-contain" onerror="this.style.display='none'">
            </div>
          </div>
        @else
          <p class="text-sm text-gray-600">Tidak ada bukti pembayaran.</p>
        @endif
      </div>

      {{-- LOANS IN THIS RECEIPT --}}
      <div class="bg-white border border-[#d2c1b6] rounded-xl shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-semibold text-[#1B3C53]">Loans in this receipt</h3>
          <span class="text-xs text-gray-500">Total items: {{ $receipt->loans->count() }}</span>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-blue-50 text-blue-800">
              <tr>
                <th class="px-4 py-2 text-left">#</th>
                <th class="px-4 py-2 text-left">Book Title</th>
                <th class="px-4 py-2 text-left">Item ID</th>
                <th class="px-4 py-2 text-left">Loan Date</th>
                <th class="px-4 py-2 text-left">Due Date</th>
                <th class="px-4 py-2 text-left">Loan Price</th>
                <th class="px-4 py-2 text-left">Loan Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse ($receipt->loans as $i => $loan)
                @php
                  $loanBadge = match ($loan->status ?? null) {
                    'payment_pending' => 'bg-blue-500',
                    'admin_validation' => 'bg-indigo-500',
                    'borrowed' => 'bg-yellow-500',
                    'returned' => 'bg-green-500',
                    'cancelled' => 'bg-red-500',
                    default => 'bg-gray-500',
                  };
                @endphp
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2">{{ $i + 1 }}</td>
                  <td class="px-4 py-2 font-medium">
                    {{ optional($loan->bookItem->book)->title ?? '-' }}
                  </td>
                  <td class="px-4 py-2">#{{ $loan->book_item_id }}</td>
                  <td class="px-4 py-2">{{ $loan->loan_date }}</td>
                  <td class="px-4 py-2">{{ $loan->due_date }}</td>
                  <td class="px-4 py-2">Rp{{ number_format($loan->loan_price, 0, ',', '.') }}</td>
                  <td class="px-4 py-2">
                    <span
                      class="text-white px-3 flex text-center items-center justify-center py-1 rounded-full text-xs font-semibold {{ $loanBadge }}">
                      {{ ucwords(str_replace('_', ' ', $loan->status ?? '-')) }}
                    </span>

                  </td>

                </tr>
              @empty
                <tr>
                  <td colspan="7" class="px-4 py-6 text-center text-gray-500">No Loans in this receipt.</td>
                </tr>
              @endforelse
            </tbody>
            @if ($receipt->loans->count())
              <tfoot class="bg-gray-50">
                <tr>
                  <td colspan="5" class="px-4 py-3 text-right font-semibold">Total</td>
                  <td class="px-4 py-3 font-semibold">
                    Rp{{ number_format($receipt->total_price, 0, ',', '.') }}
                  </td>
                  <td></td>


                </tr>
              </tfoot>
            @endif
          </table>
        </div>
      </div>

      {{-- ACTIONS --}}
      <div class="flex items-center flex-col justify-center md:justify-between md:flex-row-reverse gap-y-3 md:gap-y-0">
        <div class="flex gap-x-3 items-center justify-between">
          @if($receipt->status == "pending")
            <a href="{{ route('member.book-receipts.edit', $receipt, $receipt->id) }}"
              class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-full text-sm">
              Update Receipt
            </a>

            <form action="{{ route('member.book-receipts.cancel', $receipt, $receipt->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to cancel this receipt?')">
              @csrf
              @method('PUT')
              <button type="submit"
                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-full text-sm transition">
                Cancel Receipt
              </button>
            </form>

          @endif



          {{-- <form action="{{ route('member.book-receipts.destroy', $receipt, $receipt->id) }}" method="POST"
            onsubmit="return confirm('Yakin hapus receipt ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-md transition">
              Delete
            </button>
          </form> --}}
        </div>
        <a href="{{ route('member.book-receipts.index') }}"
          class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-full text-sm">
          ← Back to Receipts
        </a>
      </div>

    </div>
  </div>
</x-app-layout>