<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Book Loan Detail') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-md rounded-lg p-6 space-y-6">

        {{-- User Info --}}
        <div>
          <h3 class="font-semibold text-lg text-gray-700 mb-2">Borrower Information</h3>
          <p><span class="font-medium">Name:</span> {{ $bookLoan->user->name }}</p>
          <p><span class="font-medium">Email:</span> {{ $bookLoan->user->email }}</p>
        </div>

        {{-- Book Info --}}
        <div>
          <h3 class="font-semibold text-lg text-gray-700 mb-2">Book Information</h3>
          <p><span class="font-medium">Title:</span> {{ $bookLoan->bookItem->book->title }}</p>
          <p><span class="font-medium">Author:</span> {{ $bookLoan->bookItem->book->author }}</p>
          <p><span class="font-medium">ISBN:</span> {{ $bookLoan->bookItem->book->isbn ?? '-' }}</p>

          @if ($bookLoan->bookItem->book->cover_image)
            <div class="mt-3">
              <p class="font-medium text-sm text-gray-600 mb-1">Cover Image:</p>
              <img src="{{ asset('covers/' . $bookLoan->bookItem->book->cover_image) }}"
                   alt="Book Cover"
                   class="w-40 rounded shadow">
            </div>
          @endif
        </div>

        {{-- Loan Info --}}
        <div>
          <h3 class="font-semibold text-lg text-gray-700 mb-2">Loan Details</h3>
          <p><span class="font-medium">Loan Date:</span> {{ $bookLoan->loan_date }}</p>
          <p><span class="font-medium">Due Date:</span> {{ $bookLoan->due_date }}</p>
          <p><span class="font-medium">Total Price:</span> Rp{{ number_format($bookLoan->total_price, 0, ',', '.') }}</p>

          @php
            $badgeColor = match ($bookLoan->status) {
              'payment_pending' => 'bg-blue-500',
              'admin_validation' => 'bg-indigo-500',
              'borrowed' => 'bg-yellow-500',
              'returned' => 'bg-green-500',
              'cancelled' => 'bg-red-500',
              default => 'bg-gray-500',
            };
          @endphp

          <p>
            <span class="font-medium">Status:</span>
            <span class="inline-block text-white px-2 py-1 rounded text-xs font-semibold {{ $badgeColor }}">
              {{ ucwords(str_replace('_', ' ', $bookLoan->status)) }}
            </span>
          </p>
        </div>

        {{-- Back Button --}}
        <div class="flex justify-end">
          <a href="{{ route('admin.book-loans.index') }}"
             class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm">
            Back to List
          </a>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>
