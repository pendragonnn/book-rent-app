<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-white">
            <h2 class="font-bold text-xl text-[#1B3C53] leading-tight">
                {{ __('Pinjaman Buku Saya') }}
            </h2>
            {{-- Optional: Add a quick action button, e.g., to browse books --}}
            <a href="{{ route('member.books.index') }}"
                class="inline-flex items-center px-4 text-sm font-medium underline text-gray-500 hover:text-[#1B3C53] transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                Jelajahi Buku
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-7xl mx-auto px-6 space-y-8">

            {{-- Filter & Search Section --}}
            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h3 class="text-xl font-bold text-[#1B3C53] mb-5">Cari dan Filter Pinjaman</h3>
                <div class="flex flex-col md:flex-row items-center gap-4">
                    {{-- Search Input (for DataTables global search) --}}
                    <div class="w-full md:flex-1">
                        <label for="global-search" class="sr-only">Cari Pinjaman:</label>
                        <input type="search" id="global-search"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] placeholder-gray-500 transition-colors duration-200"
                            placeholder="Cari berdasarkan judul buku...">
                    </div>

                    {{-- Filter by Status (for DataTables column search) --}}
                    <div class="w-full md:w-1/4">
                        <label for="filter-status" class="sr-only">Filter berdasarkan Status:</label>
                        <select id="filter-status"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 text-[#1B3C53] transition-colors duration-200">
                            <option value="">Semua Status</option>
                            <option value="payment_pending">Menunggu Pembayaran</option>
                            <option value="admin_validation">Validasi Admin</option>
                            <option value="borrowed">Dipinjam</option>
                            <option value="returned">Dikembalikan</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Loans Table --}}
            <div class="bg-white shadow-lg rounded-xl p-6 overflow-x-auto">
                {{-- The table itself will be managed by DataTables --}}
                <div class="overflow-x-auto">
                    <table id="loans-table" class="min-w-full text-sm divide-y divide-gray-200">
                        <thead class="bg-blue-50 text-blue-800 uppercase tracking-wider">
                            <tr>
                                <th>No</th>
                                <th class="text-left px-4 py-3 font-semibold">Book Title</th>
                                <th class="text-left px-4 py-3 font-semibold">Created at</th>
                                <th class="text-left px-4 py-3 font-semibold">Loan Date</th>
                                <th class="text-left px-4 py-3 font-semibold">Due Date</th>
                                <th class="text-left px-4 py-3 font-semibold">Total Price</th>
                                <th class="text-left px-4 py-3 font-semibold">Status</th>
                                <th class="text-left px-4 py-3 font-semibold">Payment Proof</th>
                                <th class="text-left px-4 py-3 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($loans as $loan)
                                @php
                                    $statusColor = match ($loan->status) {
                                        'payment_pending' => 'bg-blue-500',
                                        'admin_validation' => 'bg-indigo-500',
                                        'borrowed' => 'bg-yellow-500',
                                        'returned' => 'bg-green-500',
                                        'cancelled' => 'bg-red-500',
                                        default => 'bg-gray-400',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td></td>
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $loan->bookItem->book->title ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        Rp{{ number_format($loan->loan_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="text-center flex items-center justify-center text-white px-2 py-1 rounded-full text-xs font-semibold shadow-sm {{ $statusColor }}">
                                            {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($loan->payment_proof)
                                            <div
                                                class="flex flex-col sm:flex-row items-start sm:items-center space-y-1 sm:space-y-0 sm:space-x-2">
                                                <a href="{{ asset('storage/' . $loan->payment_proof) }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 underline text-sm flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    Lihat Bukti
                                                </a>

                                                @if ($loan->status === 'payment_pending' || $loan->status === 'admin_validation')
                                                    <button onclick="openReuploadModal({{ $loan->id }})"
                                                        class="text-xs text-yellow-600 hover:text-yellow-800 underline flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        Ubah Gambar
                                                    </button>
                                                @endif
                                            </div>
                                        @elseif ($loan->status === 'payment_pending')
                                            <button onclick="openUploadModal({{ $loan->id }})"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                Upload
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2"> {{-- Use flex-wrap for responsiveness --}}
                                            <a href="{{ route('member.book-loans.show', $loan->id) }}"
                                                class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </a>

                                            @if ($loan->status === 'payment_pending' || $loan->status === 'admin_validation')
                                                <button onclick="openCancelModal({{ $loan->id }})"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Cancel
                                                </button>
                                            @endif

                                            @if ($loan->status === 'payment_pending')
                                                <a href="{{ route('member.book-loans.edit', $loan) }}"
                                                    class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" class="size-3 mr-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                    </svg>
                                                    Edit Date
                                                </a>
                                            @endif

                                            @if ($loan->status === 'borrowed')
                                                <form action="{{ route('member.book-loans.return', $loan->id) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 10h18M7 15h10m-9 4h8a2 2 0 002-2V8a2 2 0 00-2-2H7a2 2 0 00-2 2v11a2 2 0 002 2z" />
                                                        </svg>
                                                        Return
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- This empty state will be hidden by DataTables, as DataTables has its own "No matching
                                records found" --}}
                                {{-- But it's good to keep for non-JS scenarios or initial load --}}
                                <tr>
                                    <td></td>
                                    <td colspan="8" class="text-center py-8 text-gray-600">
                                        <p class="text-lg font-medium mb-4">Anda belum memiliki pinjaman buku.</p>
                                        <a href="{{ route('member.books.index') }}"
                                            class="inline-flex gap-x-2 items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                            </svg>

                                            Mulai Pinjam Buku!
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- No Laravel pagination needed here, DataTables handles it --}}
            </div>
        </div>
    </div>

    {{-- Modals (Upload, Re-upload, Cancel) --}}
    <!-- Modal Upload -->
    <div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
            <h2 class="text-xl font-bold text-[#1B3C53] mb-4">Upload Bukti Pembayaran</h2>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="payment_proof"
                    class="w-full mb-4 border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200"
                    required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeUploadModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Re-upload Modal -->
    <div id="reuploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
            <h2 class="text-xl font-bold text-[#1B3C53] mb-4">Perbarui Bukti Pembayaran</h2>
            <form id="reuploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <input type="file" name="payment_proof" required
                        class="border border-gray-300 rounded-md w-full px-3 py-2 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeReuploadModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-300">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h2 class="text-xl font-bold mb-4 text-red-600">Batalkan Pinjaman</h2>
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin membatalkan pinjaman ini? Tindakan ini tidak dapat
                dibatalkan.</p>

            <form id="cancelForm" method="POST">
                @csrf
                @method('PUT')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeCancelModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                        Tidak, Kembali
                    </button>
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                        Ya, Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        {{-- jQuery & DataTables --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
            function openUploadModal(loanId) {
                const form = document.getElementById('uploadForm');
                form.action = `/member/book-loans/${loanId}/upload-payment-proof`;
                document.getElementById('uploadModal').classList.remove('hidden');
                document.getElementById('uploadModal').classList.add('flex');
            }

            function closeUploadModal() {
                document.getElementById('uploadModal').classList.add('hidden');
                document.getElementById('uploadModal').classList.remove('flex'); // Ensure flex is removed
            }

            function openReuploadModal(loanId) {
                const form = document.getElementById('reuploadForm');
                form.action = `/member/book-loans/${loanId}/upload-payment-proof`;
                document.getElementById('reuploadModal').classList.remove('hidden');
                document.getElementById('reuploadModal').classList.add('flex');
            }

            function closeReuploadModal() {
                document.getElementById('reuploadModal').classList.add('hidden');
                document.getElementById('reuploadModal').classList.remove('flex'); // Ensure flex is removed
            }

            function openCancelModal(loanId) {
                const form = document.getElementById('cancelForm');
                form.action = `/member/book-loans/${loanId}/cancel`;
                document.getElementById('cancelModal').classList.remove('hidden');
                document.getElementById('cancelModal').classList.add('flex');
            }

            function closeCancelModal() {
                document.getElementById('cancelModal').classList.add('hidden');
                document.getElementById('cancelModal').classList.remove('flex'); // Ensure flex is removed
            }

            $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.warn("DataTables suppressed error:", message);
};

            $(document).ready(function () {
                let table = $('#loans-table').DataTable({
                    responsive: true,
                    processing: true,
                    paging: true,
                    info: true,
                    // Disable DataTables' default search input as we're using a custom one
                    searching: true, // Keep this true to enable search functionality
                    dom: 'lrtip', // 'l'ength changing input, 'r'processing display, 't'able, 'i'nfo, 'p'agination
                    language: {
                        search: "Cari:", // This will still be used internally but not displayed
                        lengthMenu: "Tampilkan _MENU_ entri",
                        zeroRecords: "Tidak ada pinjaman yang cocok ditemukan",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pinjaman",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Selanjutnya"
                        }
                    },
                    // Column definitions to ensure correct data for search/filter if needed
                    // For example, if 'Status' column (index 3) needs to be filtered by its raw value:
                    columnDefs: [
                        {
                            targets: 6, // Target the 'Status' column
                            render: function (data, type, row) {
                                // For filtering/sorting, use the raw status value (e.g., 'payment_pending')
                                if (type === 'filter' || type === 'sort') {
                                    return row[6].toLowerCase().replace(/ /g, '_'); // Assuming row[3] contains the status text
                                }
                                return data; // For display, return the HTML badge
                            }
                        }
                    ],
                });

                $.fn.dataTable.ext.errMode = 'none';


                table.on('order.dt search.dt draw.dt', function () {
                    let i = 1;
                    table.column(0, { search: 'applied', order: 'applied', page: 'current' }).nodes().each(function (cell) {
                        cell.innerHTML = i++;
                    });
                }).draw();

                // Custom Global Search Input
                $('#global-search').on('keyup change', function () {
                    table.search(this.value).draw();
                });

                // Filter by Status
                $('#filter-status').on('change', function () {
                    let selected = $(this).val();
                    if (selected) {
                        // Search exact match in column 3 (Status).
                        // Note: DataTables' search is case-sensitive by default for exact matches.
                        // We convert the selected value to match the format in the table for filtering.
                        table.column(6).search(selected, true, false).draw();
                    } else {
                        // Clear filter for column 6
                        table.column(6).search('').draw();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>