<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-white">
            <h2 class="font-bold text-xl text-[#1B3C53] leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            {{-- Optional: Add a quick action button for admin, e.g., to view pending loans --}}
            <a href="{{ route('admin.book-loans.index', ['status' => 'admin_validation']) }}"
                class="inline-flex items-center px-4 text-sm font-medium underline text-red-500">

                <x-heroicon-o-exclamation-circle class="w-5 h-5 mr-1" />
                Lihat Permintaan Tertunda
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-7xl mx-auto px-6 space-y-8">

            {{-- Admin Reminder: Pending Loan Requests --}}
            <div
                class="bg-gradient-to-br from-[#d2c1b6] to-[#e0d0c5] text-[#1B3C53] rounded-xl shadow-lg p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold mb-2 flex items-center">
                        Halo Admin! <span class="ml-2 text-3xl animate-wave">👋</span>
                    </h2>
                    <p class="mb-4 text-base sm:text-lg font-medium">
                        Anda memiliki <strong
                            class="text-red-600">{{ $loanStatusCounts['admin_validation'] ?? 0 }}</strong> permintaan
                        peminjaman buku yang perlu divalidasi.
                    </p>
                    <a href="{{ route('admin.book-loans.index', ['status' => 'admin_validation']) }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 mr-2">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        Tinjau Sekarang
                    </a>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @php
                    $adminCardData = [
                        ['title' => 'Total Users', 'count' => $totalUsers, 'icon' => 'heroicon-o-user', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                        ['title' => 'Total Books', 'count' => $totalBooks, 'icon' => 'heroicon-o-book-open', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                        ['title' => 'Total Loans', 'count' => $totalLoans, 'icon' => 'heroicon-o-clipboard-document-list', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                        ['title' => 'Pending Approvals', 'count' => $loanStatusCounts['admin_validation'] ?? 0, 'icon' => 'heroicon-o-clock', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
                        ['title' => 'Cancelled Loans', 'count' => $loanStatusCounts['cancelled'] ?? 0, 'icon' => 'heroicon-o-x-circle', 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
                        ['title' => 'Payment Pending', 'count' => $loanStatusCounts['payment_pending'] ?? 0, 'icon' => 'heroicon-o-credit-card', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                        ['title' => 'Borrowed Books', 'count' => $loanStatusCounts['borrowed'] ?? 0, 'icon' => 'heroicon-o-arrow-right-on-rectangle', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                        ['title' => 'Returned Books', 'count' => $loanStatusCounts['returned'] ?? 0, 'icon' => 'heroicon-o-check-circle', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                    ];
                @endphp


                @foreach ($adminCardData as $card)
                    <div
                        class="{{ $card['bg'] }} {{ $card['text'] }} rounded-xl shadow-md p-6 flex flex-col items-center justify-center text-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
                        <div class="text-3xl mb-3">
                            <x-dynamic-component :component="$card['icon']" class="w-8 h-8" />
                        </div>

                        <h4 class="text-lg font-semibold mb-1">{{ $card['title'] }}</h4>
                        <p class="text-4xl font-bold">{{ $card['count'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Recent Loans Table --}}
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-xl font-bold text-[#1B3C53] mb-5">Pinjaman Buku Terbaru</h3>

                @if ($recentLoans->count())
                    <div class="overflow-x-auto border-gray-200">
                        <table id="recent-loans-table" class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-blue-50 text-blue-800 uppercase">
                                <tr>
                                    <th class="text-left px-4 py-3 font-semibold">No</th>
                                    <th class="text-left px-4 py-3 font-semibold">Pengguna</th>
                                    <th class="text-left px-4 py-3 font-semibold">Buku</th>
                                    <th class="text-left px-4 py-3 font-semibold">Status</th>
                                    <th class="text-left px-4 py-3 font-semibold">Tanggal</th>
                                    <th class="text-left px-4 py-3 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentLoans as $loan)
                                    @php
                                        $badgeColor = match ($loan->status) {
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
                                        <td class="px-4 py-3 ">{{ $loan->user->name }}</td>
                                        <td class="px-4 py-3 ">{{ $loan->bookItem->book->title }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeColor }}">
                                                {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#2196F3"
                                                class="size-6">
                                                <path d="M11.625 16.5a1.875 1.875 0 1 0 0-3.75 1.875 1.875 0 0 0 0 3.75Z" />
                                                <path fill-rule="evenodd"
                                                    d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6 16.5c.66 0 1.277-.19 1.797-.518l1.048 1.048a.75.75 0 0 0 1.06-1.06l-1.047-1.048A3.375 3.375 0 1 0 11.625 18Z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                            </svg>

                                            <a href="{{ route('admin.book-loans.index') }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium">Lihat tabel peminjaman</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada pinjaman terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-base mb-4">Tidak ada pinjaman buku terbaru.</p>
                        <a href="{{ route('admin.book-loans.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kelola Pinjaman
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Custom CSS for wave animation --}}
    <style>
        @keyframes wave {
            0% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(14deg);
            }

            20% {
                transform: rotate(-8deg);
            }

            30% {
                transform: rotate(14deg);
            }

            40% {
                transform: rotate(-4deg);
            }

            50% {
                transform: rotate(10deg);
            }

            60% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .animate-wave {
            animation: wave 2.5s infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }
    </style>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>

            $('#recent-loans-table').DataTable({
                responsive: true,
                processing: true,
                paging: false,
                info: false,
                searching: false,
                order: [[4, 'asc']]
            }).on('order.dt search.dt', function () {
                let table = $('#recent-loans-table').DataTable();
                table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        </script>
    @endpush
</x-app-layout>