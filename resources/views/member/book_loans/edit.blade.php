<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
      {{ __('Edit Loan') }}
    </h2>
  </x-slot>

  <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6">
      <form method="POST" action="{{ route('member.book-loans.update', $bookLoan) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Loan Date</label>
          <input type="date" name="loan_date" value="{{ old('loan_date', $bookLoan->loan_date) }}"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Due Date</label>
          <input type="date" name="due_date" value="{{ old('due_date', $bookLoan->due_date) }}"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>

        <div class="flex justify-end space-x-2">
          <a href="{{ route('member.book-loans.index') }}"
             class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Cancel
          </a>
          <button type="submit"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Update Loan
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
