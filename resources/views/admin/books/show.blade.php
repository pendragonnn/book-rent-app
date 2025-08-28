<x-app-layout>
  <x-slot name="header">
    <x-slot:title>
        {{ __('Detail Book') }} - {{ $book->title }}
    </x-slot>
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('Book Detail') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700"> {{ session('success') }} </div>
      @endif

      @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700"> {{ session('error') }} </div>
      @endif
      <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-[#D2C1B6]">
        <div class="flex flex-col items-center md:flex-row gap-8 p-6">
          {{-- Cover --}}
          <div class="flex-shrink-0">
            @php
              $coverPath = public_path('covers/' . $book->cover_image);
            @endphp

            @if ($book->cover_image && file_exists($coverPath))
              <img src="{{ asset('covers/' . $book->cover_image) }}" alt="Cover Image"
                class="w-40 h-56 object-cover rounded-xl shadow-md">
            @else
              <div
                class="w-40 h-56 bg-gray-200 flex items-center justify-center text-gray-500 rounded-xl text-center px-2 text-sm shadow-inner">
                No Cover Image Available
              </div>
            @endif
          </div>

          {{-- Book Info --}}
          <div class="flex-1 space-y-4">
            <div>
              <h3 class="text-3xl font-bold text-[#1B3C53]">{{ $book->title }}</h3>
              <p class="text-sm text-[#555] italic">by {{ $book->author }}</p>
            </div>

            <div class="text-sm text-gray-800 space-y-1">
              <p><strong>📚 Publisher:</strong> {{ $book->publisher ?? '-' }}</p>
              <p><strong>🗓 Year:</strong> {{ $book->year ?? '-' }}</p>
              <p><strong>🔖 ISBN:</strong> {{ $book->isbn ?? '-' }}</p>
              <p><strong>📂 Category:</strong> {{ $book->category->name ?? '-- Kategori sudah terhapus --' }}</p>
              <p><strong>💰 Rental Price:</strong> Rp{{ number_format($book->rental_price, 0, ',', '.') }}</p>
              <p><strong>📦 Available Stock:</strong> {{ $book->items->where('status', 'available')->count() }}</p>
              <p><strong>📊 Total Stock:</strong> {{ $book->items->count() }}</p>
            </div>

            <div>
              <p class="font-semibold text-[#1B3C53]">📝 Description:</p>
              <p class="text-justify text-sm text-gray-700">
                {{ $book->description ?? 'No description available.' }}
              </p>
            </div>

            <div class="pt-4 flex flex-col-reverse md:flex-row gap-y-3 justify-center md:justify-between items-center">
              <a href="{{ route('admin.books.index') }}"
                class="inline-block bg-[#1B3C53] hover:bg-[#153042] text-white px-5 py-2 rounded-full text-sm transition-all duration-200">
                ← Back to List
              </a>
              <div class="pt-4 flex gap-x-3 items-center">
                <a href="{{ route('admin.books.edit', $book) }}"
                  class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-full text-sm  transition-colors duration-300 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>
                  Edit
                </a>
                <button type="button" 
                  data-book-id="{{ $book->id }}" 
                  data-book-name="{{ $book->title }}"
                  data-delete-url="{{ route('admin.books.destroy', $book->id) }}"
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

  {{-- Delete Confirmation Modal --}}
  <div id="deleteModal" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">

      <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus Buku</h2>
      <p class="text-sm text-gray-600 mb-3">
        Anda akan menghapus buku: <span id="bookName" class="font-semibold"></span>
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

  <script>
    // Modal functionality
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const bookNameSpan = document.getElementById('bookName');
    const deleteConfirmation = document.getElementById('deleteConfirmation');
    const cancelDelete = document.getElementById('cancelDelete');

    // Event listener untuk tombol delete
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
        const btn = e.target.classList.contains('delete-btn') ? e.target : e.target.closest('.delete-btn');
        const bookId = btn.dataset.bookId;
        const bookName = btn.dataset.bookName;
        const deleteUrl = btn.dataset.deleteUrl;

        // Set form action dan user name
        deleteForm.action = deleteUrl;
        bookNameSpan.textContent = bookName;

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
</x-app-layout>