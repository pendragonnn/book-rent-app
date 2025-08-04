<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Member Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        {{ "Hallo, $user->name"}}
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <!-- Card: Total Loans -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
          <p class="text-sm font-medium text-gray-600">Total Loans</p>
          <p class="text-2xl font-bold text-gray-900">{{ $totalLoans }}</p>
        </div>

        <!-- Card: Borrowed -->
        <div class="bg-yellow-100 p-6 rounded-lg shadow text-center">
          <p class="text-sm font-medium text-yellow-700">Currently Borrowed</p>
          <p class="text-2xl font-bold text-yellow-800">{{ $borrowedCount }}</p>
        </div>

        <!-- Card: Returned -->
        <div class="bg-green-100 p-6 rounded-lg shadow text-center">
          <p class="text-sm font-medium text-green-700">Returned</p>
          <p class="text-2xl font-bold text-green-800">{{ $returnedCount }}</p>
        </div>

        <!-- Card: Cancelled -->
        <div class="bg-red-100 p-6 rounded-lg shadow text-center">
          <p class="text-sm font-medium text-red-700">Cancelled</p>
          <p class="text-2xl font-bold text-red-800">{{ $cancelledCount }}</p>
        </div>

        <!-- Card: Payment Pending -->
        <div class="bg-red-100 p-6 rounded-lg shadow text-center">
          <p class="text-sm font-medium text-red-700">Payment Pending</p>
          <p class="text-2xl font-bold text-red-800">{{ $paymentPending }}</p>
        </div>

        <!-- Card: Admin Validation -->
        <div class="bg-red-100 p-6 rounded-lg shadow text-center">
          <p class="text-sm font-medium text-red-700">Admin Validation</p>
          <p class="text-2xl font-bold text-red-800">{{ $adminValidation }}</p>
        </div>
      </div>

      <!-- Recent Loans Table -->
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Loans</h3>

        @if ($recentLoans->count())
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
          <tr>
          <th class="text-left px-4 py-2">Book</th>
          <th class="text-left px-4 py-2">Loan Date</th>
          <th class="text-left px-4 py-2">Due Date</th>
          <th class="text-left px-4 py-2">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y">
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
        <tr>
        <td class="px-4 py-2">{{ $loan->bookItem->book->title }}</td>
        <td class="px-4 py-2">{{ $loan->loan_date }}</td>
        <td class="px-4 py-2">{{ $loan->due_date }}</td>
        <td class="px-4 py-2">
          <span class="text-white px-2 py-1 rounded text-xs font-semibold {{ $badgeColor }}">
          {{ ucwords(str_replace('_', ' ', $loan->status)) }}
          </span>
        </td>
        </tr>
      @endforeach
        </tbody>
        </table>
      </div>
    @else
      <p class="text-gray-500 text-sm">You haven’t borrowed any books yet.</p>
    @endif
      </div>
    </div>
  </div>
</x-app-layout>