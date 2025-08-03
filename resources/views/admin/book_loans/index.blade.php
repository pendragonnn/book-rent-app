<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Book Loan List') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route('admin.book-loans.create') }}"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
          + Add Book Loan
        </a>
        <!-- Filter by Status -->
        <div>
          <label for="filter-status" class="mr-2 font-medium text-sm">Filter by Status:</label>
          <select id="filter-status" class="border rounded px-2 py-1 text-sm">
            <option value="">All Statuses</option>
            @foreach ($statuses as $status)
        <option value="{{ ucwords(str_replace('_', ' ', $status)) }}">
          {{ ucwords(str_replace('_', ' ', $status)) }}
        </option>
      @endforeach
          </select>
        </div>
      </div>

      <div class="bg-white overflow-x-auto shadow-xl sm:rounded-lg p-4">
        <table id="loans-table" class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2 text-left">User</th>
              <th class="px-4 py-2 text-left">Book</th>
              <th class="px-4 py-2 text-left">Loan Date</th>
              <th class="px-4 py-2 text-left">Due Date</th>
              <th class="px-4 py-2 text-left">Total Price</th>
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
            <tr>
              <td class="px-4 py-2">{{ $loan->user->name }}</td>
              <td class="px-4 py-2">{{ $loan->bookItem->book->title }}</td>
              <td class="px-4 py-2">{{ $loan->loan_date }}</td>
              <td class="px-4 py-2">{{ $loan->due_date }}</td>
              <td class="px-4 py-2">Rp{{ number_format($loan->total_price, 0, ',', '.') }}</td>
              <td class="px-4 py-2">
              <span class="text-white px-2 py-1 rounded text-xs font-semibold {{ $badgeColor }}">
                {{ $statusDisplay }}
              </span>
              </td>
              <td class="px-4 py-2 space-x-2">
              <a href="{{ route('admin.book-loans.show', $loan) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                View
              </a>
              @if ($loan->status === 'admin_validation')
            <form action="{{ route('admin.book-loans.update', $loan) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="borrowed">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
            Approve
            </button>
            </form>

          @endif
              <a href="{{ route('admin.book-loans.edit', $loan) }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                Edit
              </a>
              <button onclick="openDeleteModal({{ $loan->id }})"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
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

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-semibold mb-4 text-red-600">Are you sure?</h2>
      <p class="mb-4 text-gray-700">This action will permanently delete the loan.</p>

      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeDeleteModal()"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Cancel
          </button>
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
            Delete
          </button>
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
      zeroRecords: "No matching loans found",
      info: "Showing _START_ to _END_ of _TOTAL_ loans",
      paginate: {
        previous: "Prev",
        next: "Next"
      }
      }
    });

    $('#filter-status').on('change', function () {
      let selected = $(this).val();
      if (selected) {
      table.column(5).search(selected, true, false).draw();
      } else {
      table.column(5).search('').draw();
      }
    });
    </script>
  @endpush
</x-app-layout>