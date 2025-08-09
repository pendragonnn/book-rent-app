<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold text-[#1B3C53] leading-tight">
      {{ __('Edit Loan') }}
    </h2>
  </x-slot>

  <div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="bg-white shadow-lg rounded-2xl p-8 border border-[#d2c1b6]">
        <form method="POST" action="{{ route('member.book-loans.update', $bookLoan) }}">
          @csrf
          @method('PUT')

          <h1>Targed Loan ID: {{ $bookLoan->id }}</h1>

          <div class="mb-6">
            <label class="block text-sm font-medium text-[#1B3C53] mb-1" for="loan_date">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', $bookLoan->loan_date) }}"
              class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:ring-[#1B3C53] focus:border-[#1B3C53]">
          </div>

          <div class="mb-6">
            <label class="block text-sm font-medium text-[#1B3C53] mb-1" for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $bookLoan->due_date) }}"
              class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 focus:ring-[#1B3C53] focus:border-[#1B3C53]">
          </div>

          <div class="flex justify-end space-x-3">
            <a href="{{ route('member.book-loans.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2.5 rounded-lg transition-all duration-200">
              Cancel
            </a>
            <button type="submit"
                    class="bg-[#1B3C53] hover:bg-[#163040] text-white px-5 py-2.5 rounded-lg transition-all duration-200">
              Update Loan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
 </x-app-layout>
