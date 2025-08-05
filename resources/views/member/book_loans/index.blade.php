<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('My Book Loans') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2">Title</th>
              <th class="px-4 py-2">Loan Date</th>
              <th class="px-4 py-2">Due Date</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Payment Proof</th>
              <th class="px-4 py-2">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse ($loans as $loan)
            @php
            $statusColor = match ($loan->status) {
            'payment_pending' => 'bg-blue-500',
            'admin_validation' => 'bg-indigo-500',
            'borrowed' => 'bg-yellow-500',
            'returned' => 'bg-green-500',
            'cancelled' => 'bg-red-500',
            default => 'bg-gray-500',
            };
          @endphp
            <tr>
              <td class="px-4 py-2">
              {{ $loan->bookItem->book->title ?? '-' }}
              </td>
              <td class="px-4 py-2">{{ $loan->loan_date }}</td>
              <td class="px-4 py-2">{{ $loan->due_date }}</td>
              <td class="px-4 py-2">
              <span class="px-2 py-1 text-white text-xs font-semibold rounded {{ $statusColor }}">
                {{ ucwords(str_replace('_', ' ', $loan->status)) }}
              </span>
              </td>
              <td class="px-4 py-2">
              @if ($loan->payment_proof)
              <div class="flex items-center space-x-2">
              <a href="{{ asset('storage/' . $loan->payment_proof) }}" target="_blank"
              class="text-blue-600 underline text-sm">
              View Proof
              </a>

              @if ($loan->status === 'admin_validation')
            <button onclick="openReuploadModal({{ $loan->id }})" class="text-xs text-yellow-600 underline">
            Update Image
            </button>
            @endif
              </div>
          @elseif ($loan->status === 'payment_pending')

            <button onclick="openUploadModal({{ $loan->id }})"
            class="bg-green-600 text-white px-2 py-1 text-xs rounded hover:bg-green-700">
            Upload
            </button>
          @else
            <span class="text-gray-400 text-xs">-</span>
          @endif
              </td>

              <td class="px-4 py-2">
              <a href="{{ route('member.books.show', $loan->bookItem->book_id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-xs rounded">
                View Book
              </a>
              @if ($loan->status === 'payment_pending' || $loan->status === 'admin_validation')
            <button onclick="openCancelModal({{ $loan->id }})"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded ml-2">
            Cancel
            </button>
          @endif

              @if ($loan->status === 'borrowed')
            <form action="{{ route('member.book-loans.return', $loan->id) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 text-xs rounded">
            Return Book
            </button>
            </form>
          @endif

              </td>
            </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-gray-600">
          You don't have any book loans yet.
          </td>
        </tr>
      @endforelse
          </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6">
          {{ $loans->links() }}
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Upload -->
  <div id="uploadModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Payment Proof</h2>

      <form id="uploadForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="payment_proof" class="w-full mb-4 border rounded px-2 py-1" required>

        <div class="flex justify-end gap-2">
          <button type="button" onclick="closeUploadModal()"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Cancel
          </button>
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Upload
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Re-upload Modal -->
  <div id="reuploadModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
      <h2 class="text-lg font-semibold mb-4">Update Payment Proof</h2>
      <form id="reuploadForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
          <input type="file" name="payment_proof" required class="border rounded w-full px-3 py-2">
        </div>
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeReuploadModal()"
            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Cancel Confirmation Modal -->
  <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
      <h2 class="text-lg font-bold mb-4 text-red-600">Cancel Loan</h2>
      <p class="text-gray-700 mb-6">Are you sure you want to cancel this loan? This action cannot be undone.</p>

      <form id="cancelForm" method="POST">
        @csrf
        @method('PUT')
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeCancelModal()"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            No, Go Back
          </button>
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
            Yes, Cancel It
          </button>
        </div>
      </form>
    </div>
  </div>



  @push('scripts')
    <script>
    function openUploadModal(loanId) {
      const form = document.getElementById('uploadForm');
      form.action = `/member/book-loans/${loanId}/upload-payment-proof`;
      document.getElementById('uploadModal').classList.remove('hidden');
      document.getElementById('uploadModal').classList.add('flex');
    }

    function closeUploadModal() {
      document.getElementById('uploadModal').classList.add('hidden');
    }

    function openReuploadModal(loanId) {
      const form = document.getElementById('reuploadForm');
      form.action = `/member/book-loans/${loanId}/upload-payment-proof`;
      document.getElementById('reuploadModal').classList.remove('hidden');
      document.getElementById('reuploadModal').classList.add('flex');
    }

    function closeReuploadModal() {
      document.getElementById('reuploadModal').classList.add('hidden');
    }

    function openCancelModal(loanId) {
      const form = document.getElementById('cancelForm');
      form.action = `/member/book-loans/${loanId}/cancel`;
      document.getElementById('cancelModal').classList.remove('hidden');
      document.getElementById('cancelModal').classList.add('flex');
    }

    function closeCancelModal() {
      document.getElementById('cancelModal').classList.remove('flex');
      document.getElementById('cancelModal').classList.add('hidden');
    }

    </script>
  @endpush


</x-app-layout>