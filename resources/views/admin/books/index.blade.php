<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Book List') }}
    </h2>
  </x-slot>

  <div class="py-10 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Header Actions --}}
      <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route('admin.books.create') }}"
          class="bg-[#1B3C53] hover:bg-[#162f44] text-white font-semibold py-2 px-4 rounded shadow text-sm">
          + Add New Book
        </a>

        {{-- Filter --}}
        <div>
          <label for="filter-category" class="mr-2 font-medium text-sm text-[#1B3C53]">Filter by Category:</label>
          <select id="filter-category"
            class="border-gray-300 rounded px-3 py-1 text-sm focus:ring-[#D2C1B6] focus:border-[#D2C1B6]">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
        <option value="{{ $category->name }}">{{ $category->name }}</option>
      @endforeach
          </select>
        </div>
      </div>

      {{-- Success Message --}}
        @if (session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md my-6">
        {{ session('success') }}
      </div>
    @endif

      {{-- Table --}}
      <div class="bg-white shadow-xl sm:rounded-lg p-4 border border-[#D2C1B6]">
        <div class="overflow-x-auto">
          <table id="books-table" class="min-w-full text-sm text-left">
            <thead class="bg-[#D2C1B6] text-white">
              <tr>
                <th class="px-4 py-3 font-semibold">Title</th>
                <th class="px-4 py-3 font-semibold">Author</th>
                <th class="px-4 py-3 font-semibold">Category</th>
                <th class="px-4 py-3 font-semibold">Price</th>
                <th class="px-4 py-3 font-semibold">Available</th>
                <th class="px-4 py-3 font-semibold">Total</th>
                <th class="px-4 py-3 font-semibold">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @foreach ($books as $book)
          <tr class="hover:bg-[#F9F3EF] transition">
          <td class="px-4 py-2 text-gray-800">{{ $book->title }}</td>
          <td class="px-4 py-2 text-gray-700">{{ $book->author }}</td>
          <td class="px-4 py-2 text-gray-700">{{ $book->category->name ?? '-' }}</td>
          <td class="px-4 py-2 text-gray-700">Rp{{ number_format($book->rental_price, 0, ',', '.') }}</td>
          <td class="px-4 py-2 text-center">{{ $book->items->where('status', 'available')->count() }}</td>
          <td class="px-4 py-2 text-center">{{ $book->items->count() }}</td>
          <td class="px-4 py-2 flex gap-1">
            <a href="{{ route('admin.books.show', $book) }}"
            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
            View
            </a>
            <a href="{{ route('admin.books.edit', $book) }}"
            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
            Edit
            </a>
            <button onclick="openDeleteModal({{ $book->id }})"
            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
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
  </div>

  {{-- Delete Confirmation Modal --}}
  <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-semibold mb-4 text-red-600">Are you sure?</h2>
      <p class="mb-4 text-gray-700">This action will permanently delete the book.</p>

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

  {{-- Scripts --}}
  @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
    function openDeleteModal(bookId) {
      const form = document.getElementById('deleteForm');
      form.action = `/admin/books/${bookId}`;
      document.getElementById('deleteModal').classList.remove('hidden');
      document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
    }

    let table = $('#books-table').DataTable({
      responsive: true,
      paging: true,
      info: true,
      processing: true,
      language: {
      search: "Search:",
      lengthMenu: "Show _MENU_ entries",
      zeroRecords: "No matching books found",
      info: "Showing _START_ to _END_ of _TOTAL_ books",
      paginate: {
        previous: "Prev",
        next: "Next"
      }
      }
    });

    $('#filter-category').on('change', function () {
      let selected = $(this).val();
      if (selected) {
      table.column(2).search('^' + selected + '$', true, false).draw();
      } else {
      table.column(2).search('').draw();
      }
    });
    </script>
  @endpush
</x-app-layout>