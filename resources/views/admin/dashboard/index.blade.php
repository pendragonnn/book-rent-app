<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between py-4 px-4 sm:px-6 lg:px-8 bg-white shadow-sm rounded-lg">
            <h2 class="font-bold text-2xl text-[#1B3C53] leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            {{-- Optional: Add a quick action button for admin, e.g., to view pending loans --}}
            <a href="{{ route('admin.book-loans.index', ['status' => 'admin_validation']) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Lihat Permintaan Tertunda
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[#F9F3EF] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Admin Reminder: Pending Loan Requests --}}
            <div class="bg-gradient-to-br from-[#d2c1b6] to-[#e0d0c5] text-[#1B3C53] rounded-xl shadow-lg p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold mb-2 flex items-center">
                        Halo Admin! <span class="ml-2 text-3xl animate-wave">👋</span>
                    </h2>
                    <p class="mb-4 text-base sm:text-lg font-medium">
                        Anda memiliki <strong class="text-red-600">{{ $loanStatusCounts['admin_validation'] ?? 0 }}</strong> permintaan peminjaman buku yang perlu divalidasi.
                    </p>
                    <a href="{{ route('admin.book-loans.index', ['status' => 'admin_validation']) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Tinjau Sekarang
                    </a>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @php
                    $adminCardData = [
                        ['title' => 'Total Users', 'count' => $totalUsers, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.146-1.28-.423-1.848M13 16H7m6 0v-2m6 2v-2a3 3 0 00-3-3H4a3 3 0 00-3 3v2m3-2h4m-4 0v-2m4 2v-2m-4-2H7m6 0h4m-4 0v-2m-4-2H7m6 0h4m-4 0v-2m-4-2H7m6 0h4m-4 0v-2"></path></svg>', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                        ['title' => 'Total Books', 'count' => $totalBooks, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path></svg>', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                        ['title' => 'Total Loans', 'count' => $totalLoans, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                        ['title' => 'Pending Approvals', 'count' => $loanStatusCounts['admin_validation'] ?? 0, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
                        ['title' => 'Cancelled Loans', 'count' => $loanStatusCounts['cancelled'] ?? 0, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
                        ['title' => 'Payment Pending', 'count' => $loanStatusCounts['payment_pending'] ?? 0, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.592 1L21 12m-6 0h4m2 0h2M4 20h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                        ['title' => 'Borrowed Books', 'count' => $loanStatusCounts['borrowed'] ?? 0, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                        ['title' => 'Returned Books', 'count' => $loanStatusCounts['returned'] ?? 0, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                    ];
                @endphp

                @foreach ($adminCardData as $card)
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
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $loan->user->name }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $loan->bookItem->book->title }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm {{ $badgeColor }}">
                                                {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($loan->created_at)->format('d M Y') }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('admin.book-loans.show', $loan->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat Detail</a>
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
                        <a href="{{ route('admin.book-loans.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414 1.414a1 1 0 011.414 0L10 9.172l4.172-4.172a1 1 0 011.414 1.414L11.414 10l4.172 4.172a1 1 0 01-1.414 1.414L10 11.414l-4.172 4.172a1 1 0 01-1.414-1.414L8.586 10 4.414 5.828a1 1 0 010-1.414z" clip-rule="evenodd" />
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