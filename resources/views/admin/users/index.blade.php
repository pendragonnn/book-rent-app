<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('User List') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

      {{-- Add Button --}}
      <div class="flex justify-between items-center">
        <a href="{{ route('admin.users.create') }}"
          class="inline-block bg-[#1B3C53] hover:bg-[#162f44] text-white px-4 py-2 rounded-md text-sm font-medium">
          + Add New User
        </a>
      </div>

      {{-- Success Message --}}
      @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md">
          {{ session('success') }}
        </div>
      @endif

      {{-- Table --}}
      <div class="bg-white border border-[#D2C1B6] shadow rounded-lg overflow-x-auto p-4">
        <table id="users-table" class="min-w-full divide-y divide-[#E4D7CF] text-sm text-[#333]">
          <thead class="bg-[#d2c1b6] text-white">
            <tr>
              <th class="px-4 py-3 text-left font-semibold">Name</th>
              <th class="px-4 py-3 text-left font-semibold">Email</th>
              <th class="px-4 py-3 text-left font-semibold">Role</th>
              <th class="px-4 py-3 text-left font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#F0E6DD]">
            @forelse ($users as $user)
              <tr class="hover:bg-[#f8f4f2] transition">
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
                <td class="px-4 py-2 space-x-2 flex">
                  <a href="{{ route('admin.users.edit', $user) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-xs">
                    Edit
                  </a>
                  <button onclick="openDeleteModal({{ $user->id }})"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-xs">
                    Delete
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-4 py-4 text-center text-gray-500">No users found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Delete Modal --}}
  <div id="deleteModal"
    class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h2 class="text-xl font-bold mb-3 text-[#B91C1C]">Are you sure?</h2>
      <p class="mb-4 text-[#444]">This will permanently delete the user.</p>
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <div class="flex justify-end space-x-2">
          <button type="button" onclick="closeDeleteModal()"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
            Cancel
          </button>
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
            Delete
          </button>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
      function openDeleteModal(userId) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/users/${userId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
      }

      function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
      }

      $(document).ready(function () {
        $('#users-table').DataTable({
          responsive: true,
          language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "No matching users found",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            paginate: {
              previous: "Prev",
              next: "Next"
            }
          }
        });
      });
    </script>
  @endpush
</x-app-layout>
