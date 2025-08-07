<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between py-4 px-4 sm:px-6 lg:px-8 bg-white shadow-sm rounded-lg">
            <h2 class="font-bold text-2xl text-[#1B3C53] leading-tight">
                {{ __('Member Dashboard') }}
            </h2>
            <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Jelajahi Buku
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen"> {{-- Added min-h-screen for better visual --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Greeting & Tutorial --}}
            <div class="bg-gradient-to-br from-[#d2c1b6] to-[#e0d0c5] text-[#1B3C53] rounded-xl shadow-lg p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold mb-2 flex items-center">
                        Hai, {{ $user->name }} <span class="ml-2 text-3xl animate-wave">👋</span>
                    </h2>
                    <p class="mb-4 text-base sm:text-lg font-medium">Berikut panduan singkat untuk meminjam buku:</p>
                    <ol class="list-decimal pl-5 space-y-2 text-sm sm:text-base">
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-2">📚</span> Kunjungi halaman <strong class="font-semibold">Katalog Buku</strong>.
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-2">👉</span> Pilih buku yang tersedia lalu klik <strong class="font-semibold">Pinjam Buku Ini</strong>.
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
                        ['title' => 'Total Loans', 'count' => $totalLoans, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path></svg>', 'bg' => 'bg-white', 'text' => 'text-gray-800'],
                        ['title' => 'Currently Borrowed', 'count' => $borrowedCount, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                        ['title' => 'Returned', 'count' => $returnedCount, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                        ['title' => 'Cancelled', 'count' => $cancelledCount, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
                        ['title' => 'Payment Pending', 'count' => $paymentPending, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.592 1L21 12m-6 0h4m2 0h2M4 20h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                        ['title' => 'Admin Validation', 'count' => $adminValidation, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.007 12.007 0 002 12c0 2.755 1.05 5.495 3.04 7.955L12 22l6.96-2.045A12.007 12.007 0 0022 12c0-2.755-1.05-5.495-3.04-7.955z"></path></svg>', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                    ];
                @endphp

                @foreach ($cardData as $card)
                    <div class="{{ $card['bg'] }} {{ $card['text'] }} rounded-xl shadow-md p-6 flex flex-col items-center justify-center text-center transform transition-all duration-300 hover:scale-105 hover:shadow-lg cursor-pointer">
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
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-blue-50 text-blue-800 uppercase tracking-wider">
                                <tr>
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
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $loan->bookItem->book->title }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeColor }}">
                                                {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('member.book-loans.show', $loan->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-base mb-4">Anda belum meminjam buku apa pun.</p>
                        <a href="{{ route('member.books.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z" clip-rule="evenodd" />
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
            0% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
        .animate-wave {
            animation: wave 2.5s infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }
    </style>
</x-app-layout>
