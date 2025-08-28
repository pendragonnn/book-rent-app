<x-app-layout>
  <x-slot:title>
        {{ __('Loan Detail') }} - {{ config('app.name') }}
    </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Book Loan Detail') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700"> {{ session('success') }} </div>
      @endif

      @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700"> {{ session('error') }} </div>
      @endif
      <div class="bg-white border border-[#D2C1B6] rounded-xl shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

          {{-- Cover Buku --}}
          <div class="flex justify-center items-start">
            @if($bookLoan->bookItem)
              <img src="{{ asset('covers/' . $bookLoan->bookItem->book->cover_image) }}"
                alt="{{ $bookLoan->bookItem->book->title }}"
                class="w-full max-w-[180px] h-auto rounded-md shadow-md object-cover">
            @else
              <div class="w-40 h-60 bg-gray-200 flex items-center justify-center rounded shadow-md text-gray-500">
                No Cover
              </div>
            @endif
          </div>

          {{-- Info Detail --}}
          <div class="md:col-span-2 space-y-6 text-[#4B4B4B]">

            {{-- Informasi Buku --}}
            <div class="border-b border-[#E5DDD7] pb-4">
              <h3 class="text-lg font-semibold text-[#1B3C53] mb-2">📘 Book Information</h3>
              @if($bookLoan->bookItem)
                <p><span class="font-medium">Title:</span> {{ $bookLoan->bookItem->book->title }}</p>
                <p><span class="font-medium">Author:</span> {{ $bookLoan->bookItem->book->author }}</p>
                <p><span class="font-medium">Book Item Code:</span> {{ $bookLoan->bookItem->id }}</p>
                <p><span class="font-medium">Category:</span> {{ $bookLoan->bookItem->book->category->name ?? '-- Category Data Deleted --' }}</p>
              @else
              -- Book Data Deleted --
              @endif
            </div>

            {{-- Informasi Peminjaman --}}
            <div class="border-b border-[#E5DDD7] pb-4">
              <h3 class="text-lg font-semibold text-[#1B3C53] mb-2">📅 Loan Information</h3>
              <p><span class="font-medium">Loan Date:</span> {{ $bookLoan->loan_date }}</p>
              <p><span class="font-medium">Due Date:</span> {{ $bookLoan->due_date }}</p>
              <p>
                <span class="font-medium">Loan Duration:</span>
                {{ \Carbon\Carbon::parse($bookLoan->loan_date)->diffInDays(\Carbon\Carbon::parse($bookLoan->due_date)) }}
                hari
              </p>
              <p><span class="font-medium">Status:</span>
                <span class="inline-block px-2 py-1 bg-[#D2C1B6] text-white rounded text-xs">
                  {{ ucfirst(str_replace('_', ' ', $bookLoan->status)) }}
                </span>
              </p>
              <p><span class="font-medium">Loan Price:</span> Rp
                {{ number_format($bookLoan->loan_price, 0, ',', '.') }}
              </p>
              <p><span class="font-medium">Receipt ID:</span> {{ $bookLoan->receipts->first()->id ?? '-' }}</p>
            </div>

            {{-- Informasi Peminjam --}}
            <div class="bg-[#F9F3EF] border border-[#D2C1B6] rounded-lg p-4">
              <h3 class="text-lg font-semibold text-[#1B3C53] mb-2">🙍‍♂️ User Information</h3>
              <p><span class="font-medium">Name:</span> {{ $user->name ?? '-' }}</p>
              <p><span class="font-medium">Email:</span> {{ $user->email ?? '-' }}</p>
              <p><span class="font-medium">ID User:</span> {{ $user->id ?? '-' }}</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center sm:flex-row gap-3 pt-4">
              <a href="{{ route('admin.book-loans.index') }}"
                class="inline-block bg-[#1B3C53] hover:bg-[#153042] text-white px-5 py-2 rounded-full text-sm transition-all duration-200">
                ← Back to List
              </a>

              <div class="flex justify-between items-center gap-x-2">

                <a href="{{ route('admin.book-loans.edit', $bookLoan) }}"
                  class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-full text-sm  transition-colors duration-300 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>
                  Edit
                </a>

                <button 
                  data-bookLoan-id="{{ $bookLoan->id }}" 
                  data-bookLoan-name="{{ $bookLoan->title }}"
                  data-delete-url="{{ route('admin.book-loans.destroy', $bookLoan->id) }}"
                  class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full text-sm transition-colors duration-300 flex items-center delete-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                  </svg>
                  Delete 
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">

      <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Peminjaman</h2>
      <p class="text-sm text-gray-600 mb-3">
        Anda akan menghapus peminjaman ini
      </p>
      <p class="text-sm text-gray-600 mb-3">
        Untuk melanjutkan, ketik kalimat berikut:
        <span class="font-semibold block mt-1">
          saya mengetahui bahwa penghapusan ini akan mempengaruhi data lain dan saya sudah memeriksanya
        </span>
      </p>

      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')

        <input type="text" name="delete_confirmation" id="deleteConfirmation" required
          placeholder="Ketik konfirmasi di sini..."
          class="w-full rounded-md border-gray-300 shadow-sm focus:ring-[#1B3C53] focus:border-[#1B3C53] mb-4">

        <div class="flex justify-end gap-2">
          <button type="button" id="cancelDelete" class="px-4 py-2 rounded-md border text-gray-700 hover:bg-gray-100">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
            Hapus
          </button>
        </div>
      </form>
    </div>
  </div>
  
  @push('scripts')
  <script>
    // Modal functionality
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const bookLoanNameSpan = document.getElementById('bookLoanName');
    const deleteConfirmation = document.getElementById('deleteConfirmation');
    const cancelDelete = document.getElementById('cancelDelete');

    // Event listener untuk tombol delete
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
        const btn = e.target.classList.contains('delete-btn') ? e.target : e.target.closest('.delete-btn');
        const bookLoanId = btn.dataset.bookLoanId;
        const bookLoanName = btn.dataset.bookLoanName;
        const deleteUrl = btn.dataset.deleteUrl;

        // Set form action dan user name
        deleteForm.action = deleteUrl;
        // bookLoanNameSpan.textContent = bookLoanName;

        // Reset form
        deleteConfirmation.value = '';

        // Show modal
        deleteModal.classList.remove('hidden');
      }
    });

    // Close modal ketika cancel
    cancelDelete.addEventListener('click', function () {
      deleteModal.classList.add('hidden');
    });

    // Close modal ketika klik overlay
    deleteModal.addEventListener('click', function (e) {
      if (e.target === deleteModal) {
        deleteModal.classList.add('hidden');
      }
    });

    // Close modal dengan ESC key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
        deleteModal.classList.add('hidden');
      }
    });
  </script>
  @endpush
</x-app-layout>