{{-- resources/views/book_loans/show.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Book Loan Detail') }}
    </h2>
  </x-slot>

  <div class="py-10">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-lg rounded-xl p-6 space-y-8 border border-[#D2C1B6]">

        {{-- Section: User Information --}}
        <div>
          <h3 class="text-lg font-semibold text-slate-700 mb-3 border-b pb-1">Borrower Information</h3>
          <div class="space-y-1 text-sm text-gray-600">
            <p><span class="font-medium text-gray-800">Name:</span> {{ $bookLoan->user->name }}</p>
            <p><span class="font-medium text-gray-800">Email:</span> {{ $bookLoan->user->email }}</p>
          </div>
        </div>

        {{-- Section: Book Information --}}
        <div>
          <h3 class="text-lg font-semibold text-slate-700 mb-3 border-b pb-1">Book Information</h3>
          <div class="space-y-1 text-sm text-gray-600">
            <p><span class="font-medium text-gray-800">Title:</span> {{ $bookLoan->bookItem->book->title }}</p>
            <p><span class="font-medium text-gray-800">Author:</span> {{ $bookLoan->bookItem->book->author }}</p>
            <p><span class="font-medium text-gray-800">ISBN:</span> {{ $bookLoan->bookItem->book->isbn ?? '-' }}</p>
          </div>

          @if ($bookLoan->bookItem->book->cover_image)
            <div class="mt-4">
              <p class="text-sm font-medium text-gray-600 mb-2">Cover Image:</p>
              <img src="{{ asset('covers/' . $bookLoan->bookItem->book->cover_image) }}"
                   alt="Book Cover"
                   class="w-40 h-auto rounded-md shadow-md border">
            </div>
          @endif
        </div>

        {{-- Section: Loan Information --}}
        <div>
          <h3 class="text-lg font-semibold text-slate-700 mb-3 border-b pb-1">Loan Details</h3>
          <div class="space-y-1 text-sm text-gray-600">
            <p><span class="font-medium text-gray-800">Loan Date:</span> {{ $bookLoan->loan_date }}</p>
            <p><span class="font-medium text-gray-800">Due Date:</span> {{ $bookLoan->due_date }}</p>
            <p><span class="font-medium text-gray-800">Total Price:</span> Rp{{ number_format($bookLoan->total_price, 0, ',', '.') }}</p>

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
              <span class="font-medium text-gray-800">Status:</span>
              <span class="inline-block text-white px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColor }}">
                {{ ucwords(str_replace('_', ' ', $bookLoan->status)) }}
              </span>
            </p>
          </div>
        </div>

        {{-- Action: Back Button --}}
        <div class="flex justify-end pt-4 border-t">
          <a href="{{ route('admin.book-loans.index') }}"
             class="inline-flex items-center bg-gray-700 text-white text-sm px-4 py-2 rounded hover:bg-gray-800 transition-all">
            ← Back to List
          </a>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>
