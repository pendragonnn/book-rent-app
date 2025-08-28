<x-app-layout>
  <x-slot:title>
        {{ __('Detail Receipt') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Receipt Detail') }} #{{ $receipt->id }}
    </h2>
  </x-slot>

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
              @foreach($receipt->items as $i => $item)
                @if($item->loan)
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $i + 1 }}</td>
                    <td class="px-4 py-2 font-medium {{ $item->loan->bookItem ?? 'text-gray-500 italic'}}">
                      {{-- {{ dd($item->loan->bookItem->book->title)}} --}}
                      {{ optional($item->loan->bookItem->book)->title ?? 'Book Data Deleted' }}
                    </td>
                    <td class="px-4 py-2">#{{ $item->loan->book_item_id }}</td>
                    <td class="px-4 py-2">{{ $item->loan->loan_date }}</td>
                    <td class="px-4 py-2">{{ $item->loan->due_date }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($item->loan->loan_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                      @php
                        $statusColor = match ($item->loan->status) {
                          'payment_pending' => 'bg-blue-500',
                          'admin_validation' => 'bg-indigo-500',
                          'borrowed' => 'bg-yellow-500',
                          'returned' => 'bg-green-500',
                          'cancelled' => 'bg-red-500',
                          default => 'bg-gray-400',
                        };
                      @endphp
                      <span class="text-white px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                        {{ ucwords(str_replace('_', ' ', $item->loan->status)) }}
                      </span>
                    </td>
                  </tr>
                @else
                  <tr class="bg-red-50">
                    <td class="px-4 py-2">{{ $i + 1 }}</td>
                    <td colspan="6" class="px-4 py-2 text-center text-sm text-red-600 italic">
                      Loan Data Deleted
                    </td>
                  </tr>
                @endif
              @endforeach

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

      {{-- APPROVEMENT (hanya muncul kalau status pending) --}}
      @if ($receipt->status === 'pending')
        <div class="bg-white border border-[#d2c1b6] rounded-xl shadow-md p-6 mb-6">
          <h3 class="text-base text-center font-semibold text-[#1B3C53] mb-3">Approve this receipt?</h3>
          <div class="flex items-center justify-center gap-3">
            <form action="{{ route('admin.book-receipts.verify', $receipt->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="status" value="verified">
              <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-full text-sm transition-colors duration-300 flex items-center">
                Verify
              </button>
            </form>

            <form action="{{ route('admin.book-receipts.verify', $receipt->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="status" value="rejected">
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full text-sm transition-colors duration-300 flex items-center">
                Reject
              </button>
            </form>
          </div>
        </div>
      @endif


      {{-- ACTIONS --}}
      <div class="py-3 mb-6">
        <div class="flex items-center justify-between">
          <a href="{{ route('admin.book-receipts.index') }}"
            class="inline-block bg-[#1B3C53] hover:bg-[#153042] text-white px-5 py-2 rounded-full text-sm transition-all duration-200">
            ← Back to Receipts
          </a>
          <div class="flex gap-2">
            <a href="{{ route('admin.book-receipts.edit', $receipt->id) }}"
              class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-full text-sm  transition-colors duration-300 flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>
              Edit
            </a>
            <!-- Tombol Delete -->
            <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full text-sm transition-colors duration-300 flex items-center"
              data-modal-target="deleteModal-{{ $receipt->id }}" data-modal-toggle="deleteModal-{{ $receipt->id }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                  </svg>
              Delete
            </button>
          </div>
        </div>
      </div>


    </div>
  </div>

  <!-- Modal Delete -->
  <div id="deleteModal-{{ $receipt->id }}" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">

      <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Receipt</h2>
      <p class="text-sm text-gray-600 mb-3">
        Untuk melanjutkan, ketik kalimat berikut:
        <span class="font-semibold block mt-1">
          saya mengetahui bahwa penghapusan ini akan mempengaruhi data lain dan saya sudah memeriksanya
        </span>
      </p>

      <form action="{{ route('admin.book-receipts.destroy', $receipt->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <input type="text" name="delete_confirmation" required placeholder="Ketik konfirmasi di sini..."
          class="w-full rounded-md border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53] mb-4">

        <div class="flex justify-end gap-2">
          <button type="button" data-modal-hide="deleteModal-{{ $receipt->id }}"
            class="px-4 py-2 rounded-md border text-gray-700 hover:bg-gray-100">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
            Hapus
          </button>
        </div>
      </form>
    </div>
  </div>


  @stack('script')
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll("[data-modal-toggle]").forEach(btn => {
        btn.addEventListener("click", () => {
          const target = document.getElementById(btn.dataset.modalTarget);
          target.classList.remove("hidden");
        });
      });

      document.querySelectorAll("[data-modal-hide]").forEach(btn => {
        btn.addEventListener("click", () => {
          const target = document.getElementById(btn.dataset.modalHide);
          target.classList.add("hidden");
        });
      });
    });
  </script>


</x-app-layout>