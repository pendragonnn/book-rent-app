<x-app-layout>
  {{-- Define the title for the browser tab --}}
    <x-slot:title>
        {{ __('My Receipt') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('My Book Loan Receipt List') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 space-y-8">

      {{-- Filter & Search Section --}}
      <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
        <h3 class="text-xl font-bold text-[#1B3C53] mb-5">Search and Filter Receipt</h3>
        <div class="flex flex-col md:flex-row items-center gap-4">
          {{-- Search Input (for DataTables global search) --}}
          <div class="w-full md:flex-1">
            <label for="global-search" class="sr-only">Cari Pinjaman:</label>
            <input type="search" id="global-search"
              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] placeholder-gray-500 transition-colors duration-200"
              placeholder="Search by ID...">
          </div>

          {{-- Filter by Status (for DataTables column search) --}}
          <div class="w-full md:w-1/4">
            <label for="filter-status" class="sr-only">Filter by Status:</label>

            <select id="filter-status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] transition-colors duration-200">
          <option value="">All Statuses</option>
          @foreach ($statuses as $status)
          <option value="{{ ucwords($status) }}">
            {{ ucwords($status) }}
          </option>
          @endforeach
        </select>
          </div>
        </div>
      </div>

      @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-4 rounded-md my-2">
          {{ session('success') }}
        </div>
      @endif

      <div class="bg-white border border-[#d2c1b6] overflow-x-auto shadow-lg md:rounded-lg p-4">
        <table id="receipts-table" class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-blue-50 text-blue-800 uppercase">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">ID</th>
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
                $statusDisplay = ucwords($receipt->status);
                $badgeColor = match ($receipt->status) {
                  'pending' => 'bg-blue-500',
                  'paid' => 'bg-green-500',
                  'verified' => 'bg-indigo-500',
                  'rejected' => 'bg-red-500',
                  'cancelled' => 'bg-orange-500',
                  default => 'bg-gray-500',
                };
              @endphp
              <tr class="hover:bg-gray-50 transition font-semibold">
                <td></td>
                <td class="px-4 py-2">#{{ $receipt->id ?? '-' }}</td>
                <td class="px-4 py-2">{{ $receipt->user->name ?? '-' }}</td>
                <td class="px-4 py-2">
                  {{ $receipt->created_at->format('d M Y')}}
                </td>
                <td class="px-4 py-2">{{ ucwords(str_replace('_', ' ', $receipt->payment_method)) }}</td>
                {{-- <td class="px-4 py-2">Rp{{ number_format($receipt->total_price, 0, ',', '.') }}</td> --}}
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
                <td class="px-4 py-2 gap-2">
                   <a href="{{ route('member.book-receipts.show', $receipt->id) }}"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
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
    $(document).ready(function () {
        // Inisialisasi DataTables
        let table = $('#receipts-table').DataTable({
            responsive: true,
            processing: true,
            paging: true,
            info: true,
            searching: true,
            dom: 'lrtip',
            language: {
                search: "Search receipt",
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
                    targets: 8, // Target the 'Status' column (indeks kolom ke-7)
                    render: function (data, type, row) {
                        // Untuk filtering, kita kembalikan nilai teks tanpa HTML
                        if (type === 'filter') {
                            // Asumsi 'row[7]' berisi nilai status. Pastikan ini sesuai dengan data Anda.
                            // Contoh: 'Payment Pending' menjadi 'payment_pending'
                            return $(data).text().trim().toLowerCase().replace(/ /g, '_');
                        }
                        // Untuk tampilan, kembalikan data asli (badge HTML)
                        return data;
                    }
                }
            ],
        });

        // Event handler untuk pembaruan nomor baris saat tabel di-order, di-search, atau di-draw
        table.on('order.dt search.dt draw.dt', function () {
            let i = 1;
            table.column(0, { search: 'applied', order: 'applied', page: 'current' }).nodes().each(function (cell) {
                cell.innerHTML = i++;
            });
        }).draw();

        // Event handler untuk input Global Search
        $('#global-search').on('keyup change', function () {
            // Kolom yang dicari bisa jadi bukan kolom 1. Pastikan indeks kolom ini sesuai kebutuhan.
            table.column(1).search(this.value).draw();
        });

        // Event handler untuk filter status
        $('#filter-status').on('change', function () {
            let selected = $(this).val();
            if (selected) {
                // Gunakan `.column(7)` jika filter status ada di kolom ke-8
                // Search() dengan regex 'true' dan smart-search 'false'
                table.column(7).search(selected, true, false).draw();
            } else {
                table.column(7).search('').draw();
            }
        });
    });
</script>
@endpush
</x-app-layout>