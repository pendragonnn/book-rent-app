<x-app-layout>
    <x-slot:title>
        {{ __('Book Categories') }} - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
            {{ __('Category List') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <a href="{{ route('admin.categories.create') }}"
                    class="bg-[#1B3C53] hover:bg-[#162f44] text-white font-semibold py-2 px-4 rounded text-sm shadow transition">
                    + Add New Category
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-700"> {{ session('success') }} </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-700"> {{ session('error') }} </div>
            @endif

            <div class="bg-white border border-[#d2c1b6] p-4 md:rounded-lg shadow-md mt-4">
                <table id="categories-table" class="min-w-full text-sm">
                    <thead class="bg-blue-50 text-blue-800 uppercase">
                        <tr>
                            <th class="px-4 py-2 text-left w-12">No</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e4dcd7]">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 transition font-semibold">
                                <td class="px-4 py-2"></td>
                                <td class="px-4 py-2">{{ $category->name }}</td>
                                <td class="px-4 py-2 flex gap-1">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        Edit
                                    </a>
                                    <!-- Tombol Delete -->
                                    <button type="button"
                                        class="bg-red-600 hover:bg-red-700 text-white rounded-md px-3 py-1 text-xs transition-colors duration-300 flex items-center delete-btn"
                                        data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}"
                                        data-delete-url="{{ route('admin.categories.destroy', $category->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-gray-500 text-center">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="deleteModal" tabindex="-1"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">

            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Kategori</h2>
            <p class="text-sm text-gray-600 mb-3">
                Anda akan menghapus kategori: <span id="categoryName" class="font-semibold"></span>
            </p>
            <p class="text-sm text-gray-600 mb-3">
                Untuk melanjutkan, ketik kalimat berikut:
                <span class="font-semibold block mt-1">
                    saya mengetahui bahwa penghapusan ini akan mempengaruhi data lain dan saya sudah memeriksanya
                </span>
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <input type="text" name="delete_confirmation" id="deleteConfirmation" required
                    placeholder="Ketik konfirmasi di sini..."
                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53] mb-4">

                <div class="flex justify-end gap-2">
                    <button type="button" id="cancelDelete"
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

    <!-- Scripts -->
    @push('scripts')
        {{-- jQuery & DataTables --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
            // Modal functionality
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            const categoryNameSpan = document.getElementById('categoryName');
            const deleteConfirmation = document.getElementById('deleteConfirmation');
            const cancelDelete = document.getElementById('cancelDelete');

            // Event listener untuk tombol delete
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
                    const btn = e.target.classList.contains('delete-btn') ? e.target : e.target.closest('.delete-btn');
                    const userId = btn.dataset.userId;
                    const categoryName = btn.dataset.categoryName;
                    const deleteUrl = btn.dataset.deleteUrl;

                    // Set form action dan user name
                    deleteForm.action = deleteUrl;
                    categoryNameSpan.textContent = categoryName;

                    // Reset form
                    deleteConfirmation.value = '';

                    // Show modal
                    deleteModal.classList.remove('hidden');
                }
            });

            // Close modal ketika cancel
            cancelDelete.addEventListener('click', function () {
                deleteModal.classList.add('hidden');
            });

            // Close modal ketika klik overlay
            deleteModal.addEventListener('click', function (e) {
                if (e.target === deleteModal) {
                    deleteModal.classList.add('hidden');
                }
            });

            // Close modal dengan ESC key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    deleteModal.classList.add('hidden');
                }
            });

            $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
                console.warn("DataTables suppressed error:", message);
            };

            $.fn.dataTable.ext.errMode = 'none';
            function openDeleteModal(categoryId) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/categories/${categoryId}`;
                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteModal').classList.add('flex');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            $('#categories-table').DataTable({
                responsive: true,
                processing: true,
                paging: true,
                info: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No categories found",
                    info: "Showing _START_ to _END_ of _TOTAL_ categories",
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
                order: [[1, 'asc']]
            }).on('order.dt search.dt', function () {
                let table = $('#categories-table').DataTable();
                table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();


        </script>
    @endpush
</x-app-layout>