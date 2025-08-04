<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Admin Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

      {{-- Summary Cards --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-blue-100 p-4 rounded shadow">
          <div class="text-blue-600 font-bold text-lg">{{ $totalUsers }}</div>
          <div class="text-sm text-gray-600">Total Users</div>
        </div>
        <div class="bg-green-100 p-4 rounded shadow">
          <div class="text-green-600 font-bold text-lg">{{ $totalBooks }}</div>
          <div class="text-sm text-gray-600">Total Books</div>
        </div>
        <div class="bg-yellow-100 p-4 rounded shadow">
          <div class="text-yellow-600 font-bold text-lg">{{ $totalLoans }}</div>
          <div class="text-sm text-gray-600">Total Book Loans</div>
        </div>
        <div class="bg-red-100 p-4 rounded shadow">
          <div class="text-red-600 font-bold text-lg">{{ $loanStatusCounts['admin_validation'] }}</div>
          <div class="text-sm text-gray-600">Pending Approvals</div>
        </div>
      </div>

      {{-- Status Summary --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-100 p-4 rounded shadow">
          <div class="text-red-600 font-bold text-lg">{{ $loanStatusCounts['cancelled'] }}</div>
          <div class="text-sm text-gray-600">Cancelled Loans</div>
        </div>
        <div class="bg-blue-100 p-4 rounded shadow">
          <div class="text-blue-600 font-bold text-lg">{{ $loanStatusCounts['payment_pending'] }}</div>
          <div class="text-sm text-gray-600">Payment Pending</div>
        </div>
        <div class="bg-yellow-100 p-4 rounded shadow">
          <div class="text-yellow-600 font-bold text-lg">{{ $loanStatusCounts['borrowed'] }}</div>
          <div class="text-sm text-gray-600">Borrowed Books</div>
        </div>
        <div class="bg-green-100 p-4 rounded shadow">
          <div class="text-green-600 font-bold text-lg">{{ $loanStatusCounts['returned'] }}</div>
          <div class="text-sm text-gray-600">Returned Books</div>
        </div>
      </div>

      {{-- Recent Loans --}}
      <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Recent Book Loans</h3>
        <table class="w-full text-sm text-left">
          <thead>
            <tr class="text-gray-600 border-b">
              <th class="py-2">User</th>
              <th>Book</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentLoans as $loan)
        <tr class="border-b hover:bg-gray-50">
          <td class="py-2">{{ $loan->user->name }}</td>
          <td>{{ $loan->bookItem->book->title }}</td>
          <td>{{ ucwords(str_replace('_', ' ', $loan->status)) }}</td>
          <td>{{ $loan->created_at->format('d M Y') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="py-4 text-center text-gray-500">No recent loans</td>
        </tr>
      @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</x-app-layout>