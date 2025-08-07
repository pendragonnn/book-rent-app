<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between py-4 px-4 sm:px-6 lg:px-8 bg-white shadow-sm rounded-lg">
            <h2 class="font-bold text-2xl text-[#1B3C53] leading-tight">
                {{ __('Pinjaman Buku Saya') }}
            </h2>
            {{-- Optional: Add a quick action button, e.g., to browse books --}}
            <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Jelajahi Buku
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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
                <h3 class="text-xl font-bold text-[#1B3C53] mb-5">Daftar Pinjaman Saya</h3>
                {{-- The table itself will be managed by DataTables --}}
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table id="loans-table" class="min-w-full text-sm divide-y divide-gray-200">
                        <thead class="bg-blue-50 text-blue-800 uppercase tracking-wider">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold">Judul Buku</th>
                                <th class="text-left px-4 py-3 font-semibold">Tanggal Pinjam</th>
                                <th class="text-left px-4 py-3 font-semibold">Tanggal Kembali</th>
                                <th class="text-left px-4 py-3 font-semibold">Status</th>
                                <th class="text-left px-4 py-3 font-semibold">Bukti Pembayaran</th>
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
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $loan->bookItem->book->title ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $statusColor }}">
                                            {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($loan->payment_proof)
                                            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-1 sm:space-y-0 sm:space-x-2">
                                                <a href="{{ asset('storage/' . $loan->payment_proof) }}" target="_blank"
                                                   class="text-blue-600 hover:text-blue-800 underline text-sm flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    Lihat Bukti
                                                </a>

                                                @if ($loan->status === 'payment_pending' || $loan->status === 'admin_validation')
                                                    <button onclick="openReuploadModal({{ $loan->id }})" class="text-xs text-yellow-600 hover:text-yellow-800 underline flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        Ubah Gambar
                                                    </button>
                                                @endif
                                            </div>
                                        @elseif ($loan->status === 'payment_pending')
                                            <button onclick="openUploadModal({{ $loan->id }})"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
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
                                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                              </svg>
                                              Lihat
                                            </a>

                                            @if ($loan->status === 'payment_pending' || $loan->status === 'admin_validation')
                                                <button onclick="openCancelModal({{ $loan->id }})"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Batal
                                                </button>
                                            @endif

                                            @if ($loan->status === 'borrowed')
                                                <form action="{{ route('member.book-loans.return', $loan->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h10m-9 4h8a2 2 0 002-2V8a2 2 0 00-2-2H7a2 2 0 00-2 2v11a2 2 0 002 2z" />
                                                        </svg>
                                                        Kembalikan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- This empty state will be hidden by DataTables, as DataTables has its own "No matching records found" --}}
                                {{-- But it's good to keep for non-JS scenarios or initial load --}}
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-600">
                                        <p class="text-lg font-medium mb-4">Anda belum memiliki pinjaman buku.</p>
                                        <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                <input type="file" name="payment_proof" class="w-full mb-4 border border-gray-300 rounded-md px-3 py-2 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeUploadModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
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
                    <input type="file" name="payment_proof" required class="border border-gray-300 rounded-md w-full px-3 py-2 focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeReuploadModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-300">
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
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin membatalkan pinjaman ini? Tindakan ini tidak dapat dibatalkan.</p>

            <form id="cancelForm" method="POST">
                @csrf
                @method('PUT')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeCancelModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
                        Tidak, Kembali
                    </button>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors duration-300">
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

            $(document).ready(function() {
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
                            targets: 3, // Target the 'Status' column
                            render: function(data, type, row) {
                                // For filtering/sorting, use the raw status value (e.g., 'payment_pending')
                                if (type === 'filter' || type === 'sort') {
                                    return row[3].toLowerCase().replace(/ /g, '_'); // Assuming row[3] contains the status text
                                }
                                return data; // For display, return the HTML badge
                            }
                        }
                    ]
                });

                // Custom Global Search Input
                $('#global-search').on('keyup change', function() {
                    table.search(this.value).draw();
                });

                // Filter by Status
                $('#filter-status').on('change', function() {
                    let selected = $(this).val();
                    if (selected) {
                        // Search exact match in column 3 (Status).
                        // Note: DataTables' search is case-sensitive by default for exact matches.
                        // We convert the selected value to match the format in the table for filtering.
                        table.column(3).search(selected, true, false).draw();
                    } else {
                        // Clear filter for column 3
                        table.column(3).search('').draw();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
