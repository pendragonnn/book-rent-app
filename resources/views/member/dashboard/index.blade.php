<x-app-layout>
    {{-- Define the title for the browser tab --}}
    <x-slot:title>
        {{ __('Dashboard Member') }} - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between bg-white">
            <h2 class="font-bold text-xl text-[#1B3C53] leading-tight">
                {{ __('User Dashboard') }}
            </h2>
            <a href="{{ route('member.book-loans.index') }}"
               class="px-4 text-sm font-medium bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                {{ $activeLoans }} Active Loans
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-[#F9F3EF] to-[#f0e6d8] min-h-screen">
        <div class="max-w-7xl mx-auto px-6 space-y-8">

            <!-- === Key Metrics Cards === -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <h3 class="font-semibold text-gray-700">Total Loans</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalLoans }}</p>
                </div>

                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <h3 class="font-semibold text-gray-700">Active Loans</h3>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $activeLoans }}</p>
                </div>

                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <h3 class="font-semibold text-gray-700">Returned</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $returnedLoans }}</p>
                </div>

                <div class="glass-effect rounded-xl p-6 hover-scale">
                    <h3 class="font-semibold text-gray-700">Total Spent</h3>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- === Main Content Grid === -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- LEFT COLUMN -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Current Loans -->
                    <div class="glass-effect rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Currently Borrowed Books</h3>
                        @if($currentLoans->count())
                            <ul class="divide-y divide-gray-100">
                                @foreach($currentLoans as $loan)
                                    <li class="flex items-center justify-between py-2">
                                        <div>
                                            <p class="font-medium text-gray-700">{{ $loan->bookItem->book->title }}</p>
                                            <p class="text-xs text-gray-500">Due: {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}</p>

                                        </div>
                                        <span class="text-sm px-2 py-1 rounded-lg
                                            {{ $loan->status === 'borrowed' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                            {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm">No active loans.</p>
                        @endif
                    </div>

                    <!-- Recent Receipts -->
                    <div class="glass-effect rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Receipts</h3>
                        @if($recentReceipts->count())
                            <ul class="divide-y divide-gray-100">
                                @foreach($recentReceipts as $receipt)
                                    <li class="flex items-center justify-between py-2">
                                        <div>
                                            <p class="font-medium text-gray-700">Receipt ID: #{{ $receipt->id }}</p>
                                            <p class="text-xs text-gray-500">Total: Rp {{ number_format($receipt->total_price, 0, ',', '.') }}</p>
                                        </div>
                                        <span class="text-sm px-2 py-1 rounded-lg 
                                            {{ $receipt->status === 'verified' ? 'bg-green-100 text-green-700' : 
                                               ($receipt->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($receipt->status) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 text-sm">No receipts yet.</p>
                        @endif
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="space-y-6">
                    <!-- Notifications -->
                    <div class="glass-effect rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Notifications</h3>
                        <div class="space-y-3">
                            @forelse($notifications as $note)
                                <div class="p-3 rounded-lg hover:bg-gray-50 flex justify-between">
                                    <div>
                                        <p class="font-medium text-gray-700">{{ $note['message'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $note['time']->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No notifications.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .hover-scale { transition: transform .2s; }
        .hover-scale:hover { transform: scale(1.02); }
    </style>
</x-app-layout>
