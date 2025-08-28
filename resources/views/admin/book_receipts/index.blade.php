<x-app-layout>
  <x-slot:title>
        {{ __('Book receipts') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Book Loan Receipts') }}
    </h2>
  </x-slot>

  <div class="py-8" style="background-color: #F9F3EF">
    <div class="max-w-7xl mx-auto px-6">
      <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route('admin.book-receipts.create') }}"
          class="bg-[#1B3C53] hover:bg-[#163145] text-white font-semibold py-2 px-4 rounded text-sm shadow transition">
          + Add Book Receipt
        </a>

        <!-- Filter by Status -->
        <div>
          <label for="filter-status" class="mr-2 font-medium text-sm text-[#1B3C53]">Filter by Status:</label>
          <select id="filter-status" class="border border-[#d2c1b6] rounded px-2 py-1 text-sm">
            <option value="">All Statuses</option>
            @foreach ($statuses as $status)
              <option value="{{ ucwords(str_replace('_', ' ', $status)) }}">
                {{ ucwords(str_replace('_', ' ', $status)) }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700"> {{ session('success') }} </div>
      @endif

      @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700"> {{ session('error') }} </div>
      @endif

      <div class="bg-white border border-[#d2c1b6] overflow-x-auto shadow-lg md:rounded-lg p-4">
        <table id="receipts-table" class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-blue-50 text-blue-800 uppercase">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">User</th>
              <th class="px-4 py-2 text-left">Created At</th>
              <th class="px-4 py-2 text-left">Payment Method</th>
              <th class="px-4 py-2 text-left">Total Price</th>
              <th class="px-4 py-2 text-left">Payment Proof</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach ($receipts as $receipt)
              @php
                $statusDisplay = ucwords(str_replace('_', ' ', $receipt->status));
                $badgeColor = match ($receipt->status) {
                  'pending' => 'bg-blue-500',
                  'paid' => 'bg-green-500',
                  'verified' => 'bg-indigo-500',
                  'rejected' => 'bg-red-500',
                  default => 'bg-gray-500',
                };
              @endphp
              <tr class="hover:bg-gray-50 transition font-semibold">
                <td></td>
                <td class="px-4 py-2 {{ $receipt->user ? '' : 'italic text-gray-500' }}">
                  {{ $receipt->user?->name ?? 'User Deleted' }}
                </td>


                <td class="px-4 py-2">
                  {{ $receipt->created_at->format('d M Y')}}
                </td>
                <td class="px-4 py-2">{{ ucwords(str_replace('_', ' ', $receipt->payment_method)) }}</td>
                <td class="px-4 py-2">
                  @if ($receipt->status === 'cancelled' || $receipt->status === 'rejected')
                    -
                  @else
                    Rp{{ number_format($receipt->total_price, 0, ',', '.') }}
                  @endif
                </td>
                <td class="px-4 py-2">
                  @if ($receipt->payment_proof)
                    <a href="{{ asset('storage/' . $receipt->payment_proof) }}" target="_blank"
                      class="text-[#1B3C53] underline text-sm">[View Proof]</a>
                  @else
                    <span class="text-red-500 font-medium text-sm">Not Uploaded</span>
                  @endif
                </td>
                <td class="px-4 py-2">
                  <span
                    class="text-white flex items-center justify-center text-center px-2 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeColor }}">
                    {{ $statusDisplay }}
                  </span>
                </td>
                <td class="px-4 py-2 flex">
                  <a href="{{ route('admin.book-receipts.show', $receipt) }}"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex flex-wrap items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Detail
                  </a>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>

      let table = $('#receipts-table').DataTable({
        responsive: true,
        processing: true,
        paging: true,
        info: true,
        language: {
          search: "Search:",
          lengthMenu: "Show _MENU_ entries",
          zeroRecords: "No receipts found",
          info: "Showing _START_ to _END_ of _TOTAL_ loans",
          paginate: {
            previous: "Prev",
            next: "Next"
          }
        },
        columnDefs: [
          {
            searchable: false,
            orderable: false,
            targets: [0, 2, 3, 4, 5, 7]
          }
        ],
        order: [[2, 'desc']]
      }).on('order.dt search.dt', function () {
        let table = $('#receipts-table').DataTable();
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1;
        });
      }).draw();

      $('#filter-status').on('change', function () {
        let selected = $(this).val();
        if (selected) {
          table.column(6).search(selected, true, false).draw();
        } else {
          table.column(6).search('').draw();
        }
      });
    </script>
  @endpush
</x-app-layout>