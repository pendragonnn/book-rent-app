<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Book Loan List') }}
    </h2>
  </x-slot>

  <div class="py-8" style="background-color: #F9F3EF">
    <div class="max-w-7xl mx-auto px-6">
      <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route('admin.book-loans.create') }}"
          class="bg-[#1B3C53] hover:bg-[#163145] text-white font-semibold py-2 px-4 rounded text-sm shadow transition">
          + Add Book Loan
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
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-4 rounded-md my-2">
      {{ session('success') }}
      </div>
    @endif

      <div class="bg-white border border-[#d2c1b6] overflow-x-auto shadow-lg md:rounded-lg p-4">
        <table id="loans-table" class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-blue-50 text-blue-800 uppercase">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">User</th>
              <th class="px-4 py-2 text-left">Book Title</th>
              <th class="px-4 py-2 text-left">Created at</th>
              <th class="px-4 py-2 text-left">Loan Date</th>
              <th class="px-4 py-2 text-left">Due Date</th>
              <th class="px-4 py-2 text-left">Total Price</th>
              <th class="px-4 py-2 text-left">Payment Proof</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach ($loans as $loan)
            @php
            $statusDisplay = ucwords(str_replace('_', ' ', $loan->status));
            $badgeColor = match ($loan->status) {
            'payment_pending' => 'bg-blue-500',
            'admin_validation' => 'bg-indigo-500',
            'borrowed' => 'bg-yellow-500',
            'returned' => 'bg-green-500',
            'cancelled' => 'bg-red-500',
            default => 'bg-gray-500',
            };
          @endphp
            <tr class="hover:bg-gray-50 transition font-semibold">
              <td></td>
              <td class="px-4 py-2">{{ $loan->user->name }}</td>
              <td class="px-4 py-2">{{ $loan->bookItem->book->title }}</td>
              <td class="px-4 py-2">{{ $loan->bookItem->book->created_at }}</td>
              <td class="px-4 py-2">{{ $loan->loan_date }}</td>
              <td class="px-4 py-2">{{ $loan->due_date }}</td>
              <td class="px-4 py-2">Rp{{ number_format($loan->loan_price, 0, ',', '.') }}</td>
              <td class="px-4 py-2">
              @if ($loan->payment_proof)
            <span class="text-green-600 font-medium text-sm">Paid</span>
            <a href="{{ asset('storage/' . $loan->payment_proof) }}" target="_blank"
            class="text-[#1B3C53] underline text-sm">[View Proof]</a>
          @else
            <span class="text-red-500 font-medium text-sm">Unpaid</span>
          @endif
              </td>
              <td class="px-4 py-">
              <span
                class="text-white flex items-center justify-center text-center px-2 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeColor }}">
                {{ $statusDisplay }}
              </span>
              </td>
              <td class="px-4 py-2 gap-3 flex flex-wrap">
              <a href="{{ route('admin.book-loans.show', $loan->id) }}"
                class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Detail
              </a>

              @if ($loan->status === 'admin_validation')
            <form action="{{ route('admin.book-loans.update', $loan) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="borrowed">
            <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-xs flex items-center transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="size-4 mr-1">
              <path stroke-linecap="round" stroke-linejoin="round"
              d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
            </svg>

            Approve
            </button>
            </form>

            <form action="{{ route('admin.book-loans.update', $loan) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="cancelled">
            <button type="submit"
            class="bg-orange-400 hover:bg-orange-500 text-white px-3 py-1 rounded-md text-xs transition-colors duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="size-4 mr-1">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>

            Cancel
            </button>
            </form>
          @endif

              <a href="{{ route('admin.book-loans.edit', $loan) }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="size-4 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>

                Edit
              </a>
              <button onclick="openDeleteModal({{ $loan->id }})"
                class="bg-red-600 hover:bg-red-700 text-white rounded-md px-3 py-1 text-xs transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="size-4 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>

                Delete
              </button>
              </td>
            </tr>
      @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md border border-[#d2c1b6]">
      <h2 class="text-xl font-semibold mb-4 text-red-600">Are you sure?</h2>
      <p class="mb-4 text-[#1B3C53]">This action will permanently delete the loan.</p>
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeDeleteModal()"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Cancel</button>
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Delete</button>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    function openDeleteModal(loanId) {
      const form = document.getElementById('deleteForm');
      form.action = `/admin/book-loans/${loanId}`;
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('flex');
      document.getElementById('deleteModal').classList.add('hidden');
    }

    let table = $('#loans-table').DataTable({
      responsive: true,
      processing: true,
      paging: true,
      info: true,
      language: {
      search: "Search:",
      lengthMenu: "Show _MENU_ entries",
      zeroRecords: "No loans found",
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
        targets: 0
      }
      ],
      order: [[3, 'desc']]
    }).on('order.dt search.dt', function () {
      let table = $('#loans-table').DataTable();
      table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
      });
    }).draw();

    $('#filter-status').on('change', function () {
      let selected = $(this).val();
      if (selected) {
      table.column(8).search(selected, true, false).draw();
      } else {
      table.column(8).search('').draw();
      }
    });
    </script>
  @endpush
</x-app-layout>