<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
      {{ __('Loan Details') }}
    </h2>
  </x-slot>

  <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6">
      <h3 class="text-lg font-semibold mb-4">Book Info</h3>
      <p><strong>Title:</strong> {{ $bookLoan->bookItem->book->title }}</p>
      <p><strong>Author:</strong> {{ $bookLoan->bookItem->book->author }}</p>

      <h3 class="text-lg font-semibold mt-6 mb-4">Loan Info</h3>
      <p><strong>Loan Date:</strong> {{ $bookLoan->loan_date }}</p>
      <p><strong>Due Date:</strong> {{ $bookLoan->due_date }}</p>
      <p><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $bookLoan->status)) }}</p>
      <p><strong>Total Price:</strong> Rp{{ number_format($bookLoan->total_price, 0, ',', '.') }}</p>

      <div class="mt-6">
        <a href="{{ route('member.book-loans.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
          Back
        </a>
        @if ($bookLoan->status === 'payment_pending')
        <a href="{{ route('member.book-loans.edit', $bookLoan) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded ml-2">
          Edit Loan
        </a>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
