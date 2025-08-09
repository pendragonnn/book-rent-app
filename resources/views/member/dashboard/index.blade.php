<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-white">
            <h2 class="font-bold text-xl text-[#1B3C53] leading-tight">
                {{ __('Member Dashboard') }}
            </h2>
            <a href="{{ route('member.books.index') }}"
                class="inline-flex items-center px-4 underline text-sm font-medium rounded-md text-gray-500 hover:text-[#1B3C53] transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>

                Jelajahi Buku
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen"> {{-- Added min-h-screen for better visual --}}
        <div class="max-w-7xl mx-auto px-6 space-y-8">

            {{-- Greeting & Tutorial --}}
            <div
                class="bg-gradient-to-br from-[#d2c1b6] to-[#e0d0c5] text-[#1B3C53] rounded-xl shadow-lg p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold mb-2 flex items-center">
                        Hai, {{ $user->name }} <span class="ml-2 text-3xl animate-wave">👋</span>
                    </h2>
                    <p class="mb-4 text-base sm:text-lg font-medium">Berikut panduan singkat untuk meminjam buku:</p>
                    <ol class="list-decimal pl-5 space-y-2 text-sm sm:text-base">
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-2">📚</span> Kunjungi halaman <strong
                                class="font-semibold ml-1">Katalog Buku</strong>.
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-2">👉</span> Pilih buku yang tersedia lalu klik <strong
                                class="font-semibold ml-1">Pinjam Buku Ini</strong>.
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-2">🗓️</span> Tentukan tanggal pinjam dan tanggal kembali.
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-2">💰</span> Upload bukti pembayaran.
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-2">✅</span> Tunggu konfirmasi dari admin.
                        </li>
                    </ol>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                {{-- Custom Card Component (assuming x-dashboard-card exists and can be styled) --}}
                {{-- If x-dashboard-card is a simple component, you might need to adjust its internal structure --}}
                {{-- For demonstration, I'm showing the structure that x-dashboard-card *should* render --}}

                @php
                    $cardData = [
                        ['title' => 'Total Loans', 'count' => $totalLoans, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path></svg>', 'bg' => 'bg-white', 'text' => 'text-gray-800'],
                        ['title' => 'Currently Borrowed', 'count' => $borrowedCount, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                        ['title' => 'Returned', 'count' => $returnedCount, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                        ['title' => 'Cancelled', 'count' => $cancelledCount, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
                        ['title' => 'Payment Pending', 'count' => $paymentPending, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-8"> <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" /> </svg>', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                        ['title' => 'Admin Validation', 'count' => $adminValidation, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                    ];
                @endphp

                @foreach ($cardData as $card)
                    <div
                        class="{{ $card['bg'] }} {{ $card['text'] }} rounded-xl shadow-md p-6 flex flex-col items-center justify-center text-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
                        <div class="text-3xl mb-3">
                            {!! $card['icon'] !!} {{-- Render SVG icon --}}
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
                    <div class="overflow-x-auto">
                        <table id="recent-loans-table" class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-blue-50 text-blue-800 uppercase tracking-wider">
                                <tr>
                                    <th>No</th>
                                    <th class="text-left px-4 py-3 font-semibold">Buku</th>
                                    <th class="text-left px-4 py-3 font-semibold">Tanggal Pinjam</th>
                                    <th class="text-left px-4 py-3 font-semibold">Tanggal Kembali</th>
                                    <th class="text-left px-4 py-3 font-semibold">Status</th>
                                    <th class="text-left px-4 py-3 font-semibold">Aksi</th> {{-- Added Action column --}}
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($recentLoans as $loan)
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
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $loan->bookItem->book->title }}</td>
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeColor }}">
                                                {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                            </span>
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

                                            <a href="{{ route('member.book-loans.index') }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium">Lihat tabel peminjaman</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-base mb-4">Anda belum meminjam buku apa pun.</p>
                        <a href="{{ route('member.books.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Mulai Pinjam Sekarang!
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