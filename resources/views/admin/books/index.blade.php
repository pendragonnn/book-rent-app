<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book List') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <a href="{{ route('admin.books.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    + Add New Book
                </a>

                <!-- Filter by Category -->
                <div>
                    <label for="filter-category" class="mr-2 font-medium text-sm">Filter by Category:</label>
                    <select id="filter-category" class="border rounded px-2 py-1 text-sm">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white overflow-x-auto shadow-xl sm:rounded-lg p-4">
                <table id="books-table" class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Title</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Author</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Category</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Price</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Stock Available</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Total Stock</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($books as $book)
                            <tr>
                                <td class="px-4 py-2">{{ $book->title }}</td>
                                <td class="px-4 py-2">{{ $book->author }}</td>
                                <td class="px-4 py-2">{{ $book->category->name ?? '-' }}</td>
                                <td class="px-4 py-2">Rp{{ number_format($book->rental_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $book->items->where('status', 'borrowed')->count() }}</td>
                                <td class="px-4 py-2">{{ $book->items->count() }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.books.show', $book) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                        View
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>
                                    <button onclick="openDeleteModal({{ $book->id }})"
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

    <!-- Scripts -->
    @push('scripts')
        {{-- jQuery & DataTables --}}
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
                processing: true,
                paging: true,
                info: true,
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
                    // Search exact match in column 2 (Category)
                    table.column(2).search('^' + selected + '$', true, false).draw();
                } else {
                    table.column(2).search('').draw();
                }
            });

        </script>
    @endpush
</x-app-layout>