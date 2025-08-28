<x-app-layout>
    <x-slot:title>
        {{ __('Dashboard Admin') }} - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-white">
            <h2 class="font-bold text-xl text-[#1B3C53] leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <a href="{{ route('admin.book-receipts.index', ['status' => 'pending']) }}"
                class="px-4 text-sm font-medium bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                {{ $receiptPending }} Pending Requests
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-[#F9F3EF] to-[#f0e6d8] min-h-screen">
        <div class="max-w-7xl mx-auto px-6 space-y-8">

            <!-- === Key Metrics Cards === -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Books -->
                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-700">Books</h3>
                        <span
                            class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">+{{ $totalBooks }}</span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalBooks) }}</p>
                </div>

                <!-- Total Users -->
                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-700">Users</h3>
                        <span
                            class="text-xs {{ $userGrowth > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }} px-2 py-1 rounded-full">
                            {{ $userGrowth > 0 ? '+' . $userGrowth . '%' : 'Stable' }}
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalUsers) }}</p>
                </div>

                <!-- Categories -->
                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-700">Categories</h3>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCategories }}</p>
                </div>

                <!-- Loans Growth -->
                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-700">Loans</h3>
                        <span
                            class="text-xs {{ $loanGrowth > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }} px-2 py-1 rounded-full">
                            {{ $loanGrowth > 0 ? '+' . $loanGrowth . '%' : 'Stable' }}
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalLoans) }}</p>
                </div>
            </div>

            <!-- === Main Content Grid === -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- LEFT COLUMN -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Quick Actions -->
                    <div class="glass-effect rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('admin.books.create') }}"
                                class="action-card shadow-md hover:bg-gray-100 cursor-pointer p-6 rounded-md flex flex-col items-center justify-center space-y-3 transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v4m-2-2h4" />
                                    </svg>
                                </div>
                                <p
                                    class="text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">
                                    Add Book</p>
                            </a>

                            <a href="{{ route('admin.users.create') }}"
                                class="action-card shadow-md hover:bg-gray-100 cursor-pointer p-6 rounded-md flex flex-col items-center justify-center space-y-3 transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                                <div
                                    class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <p
                                    class="text-sm font-medium text-gray-700 group-hover:text-green-600 transition-colors">
                                    Add User</p>
                            </a>

                            <a href="{{ route('admin.book-receipts.create') }}"
                                class="action-card shadow-md hover:bg-gray-100 cursor-pointer p-6 rounded-md flex flex-col items-center justify-center space-y-3 transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 8v2m-1-1h2" />
                                    </svg>
                                </div>
                                <p
                                    class="text-sm font-medium text-gray-700 group-hover:text-purple-600 transition-colors">
                                    Add Receipts</p>
                            </a>

                            <a href="{{ route('admin.categories.create') }}"
                                class="action-card shadow-md hover:bg-gray-100 cursor-pointer p-6 rounded-md flex flex-col items-center justify-center space-y-3 transition-all duration-300 hover:shadow-lg hover:scale-105 group">
                                <div
                                    class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8v2m-1-1h2" />
                                    </svg>
                                </div>
                                <p
                                    class="text-sm font-medium text-gray-700 group-hover:text-orange-600 transition-colors">
                                    Add Categories</p>
                            </a>

                        </div>
                    </div>

                    <!-- Receipt & Loan Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="glass-effect rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Receipt Statistics</h3>
                            <ul class="space-y-2 text-sm">
                                <li class="flex justify-between"><span>Total</span> <span>{{ $totalReceipts }}</span>
                                </li>
                                <li class="flex justify-between text-yellow-600"><span>Pending</span>
                                    <span>{{ $receiptPending }}</span>
                                </li>
                                <li class="flex justify-between text-green-600"><span>Verified</span>
                                    <span>{{ $receiptVerified }}</span>
                                </li>
                                <li class="flex justify-between text-red-600"><span>Rejected</span>
                                    <span>{{ $receiptRejected }}</span>
                                </li>
                                <li class="flex justify-between text-gray-600"><span>Cancelled</span>
                                    <span>{{ $receiptCancelled }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="glass-effect rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Statistics</h3>
                            <ul class="space-y-2 text-sm">
                                <li class="flex justify-between"><span>Total</span> <span>{{ $totalLoans }}</span></li>
                                <li class="flex justify-between text-blue-600"><span>Admin Validation</span>
                                    <span>{{ $loanValidation }}</span>
                                </li>
                                <li class="flex justify-between text-yellow-600"><span>Borrowed</span>
                                    <span>{{ $loanBorrowed }}</span>
                                </li>
                                <li class="flex justify-between text-green-600"><span>Returned</span>
                                    <span>{{ $loanReturned }}</span>
                                </li>
                                <li class="flex justify-between text-gray-600"><span>Cancelled</span>
                                    <span>{{ $loanCancelled }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Top Borrowed Books -->
                    <div class="glass-effect rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Borrowed Books</h3>
                        @if($topBooks->count())
                            <ul class="divide-y divide-gray-100">
                                @foreach($topBooks as $book)
                                    <li class="flex justify-between py-2">
                                        <span>{{ $book->title }} </span>
                                        <span class="font-bold text-indigo-600">{{ $book->total_borrowed }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm">No data yet.</p>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="space-y-6">
                    <!-- Recent Activity -->
                    <div class="glass-effect rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                        <div class="space-y-3">
                            @if(isset($recentActivity) && $recentActivity->count() > 0)
                                @foreach($recentActivity as $activity)
                                    <div class="p-3 rounded-lg hover:bg-gray-50 flex justify-between">
                                        <div>
                                            {{-- {{ dd($recentActivity) }} --}}
                                            <p class="font-medium text-gray-700">{{ $activity['message'] }}</p>
                                            {{-- Besok ini wajib dibenerin nuuu jangan lupa --}}
                                            <p class="text-xs text-gray-500">By {{ $activity['user'] }}</p>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $activity['time']->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-sm">No recent activity.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for reusable styles -->
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .hover-scale {
            transition: transform .2s;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .action-card {
            @apply p-4 text-center rounded-lg border-2 border-dashed border-gray-200 hover:bg-gray-100 transition;
            display: block;
        }
    </style>
</x-app-layout>