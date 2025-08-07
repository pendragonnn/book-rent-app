<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
            {{ __('Category List') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <a href="{{ route('admin.categories.create') }}"
               class="inline-block bg-[#1B3C53] hover:bg-[#162e3f] text-white px-4 py-2 rounded-md text-sm transition">
                + Add New Category
            </a>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-[#d2c1b6] p-4 rounded-xl shadow-md">
                <table id="categories-table" class="min-w-full text-sm">
                    <thead class="bg-[#d2c1b6] text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e4dcd7]">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-[#f0e9e5]">
                                <td class="px-4 py-2">{{ $category->name }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm transition">
                                        Edit
                                    </a>
                                    <button onclick="openDeleteModal({{ $category->id }})"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-2 text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4 text-red-600">Are you sure?</h2>
            <p class="mb-4 text-gray-700">This action will permanently delete the category.</p>

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
            function openDeleteModal(categoryId) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/categories/${categoryId}`;
                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteModal').classList.add('flex');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            $(document).ready(function () {
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
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
