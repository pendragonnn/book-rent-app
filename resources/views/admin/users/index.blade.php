<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
      {{ __('User List') }}
    </h2>
  </x-slot>

  <div class="py-8 bg-[#F9F3EF] min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

      {{-- Add Button --}}
      <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <a href="{{ route('admin.users.create') }}"
          class="bg-[#1B3C53] hover:bg-[#162f44] text-white font-semibold py-2 px-4 rounded text-sm shadow transition">
          + Add New User
        </a>
      </div>

      {{-- Success Message --}}
      @if (session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-4 rounded-md">
      {{ session('success') }}
      </div>
    @endif

      {{-- Table --}}
      <div class="bg-white border border-[#D2C1B6] shadow sm:rounded-lg overflow-x-auto mt-4 p-4">
        <table id="users-table" class="min-w-full divide-y divide-[#E4D7CF] text-sm text-[#333]">
          <thead class="bg-blue-50 text-blue-800 uppercase">
            <tr>
              <th class="px-4 py-3 text-left">No</th>
              <th class="px-4 py-3 text-left font-semibold">Name</th>
              <th class="px-4 py-3 text-left font-semibold">Register At</th>
              <th class="px-4 py-3 text-left font-semibold">Email</th>
              <th class="px-4 py-3 text-left font-semibold">Role</th>
              <th class="px-4 py-3 text-left font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#F0E6DD]">
            @forelse ($users as $user)
        <tr class="hover:bg-gray-50 transition font-semibold">
          <td></td>
          <td class="px-4 py-2">{{ $user->name }}</td>
          <td class="px-4 py-2">{{ $user->created_at }}</td>
          <td class="px-4 py-2">{{ $user->email }}</td>
          <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
          <td class="px-4 py-2 flex gap-1">
          <a href="{{ route('admin.users.edit', $user) }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded-md transition-colors duration-300 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="size-4 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            Edit
          </a>
          <button onclick="openDeleteModal({{ $user->id }})"
            class="bg-red-600 hover:bg-red-700 text-white rounded-md px-3 py-1 text-xs transition-colors duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="size-4 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
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
  <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
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

    $('#users-table').DataTable({
      responsive: true,
      processing: true,
      paging: true,
      info: true,
      language: {
      search: "Search:",
      lengthMenu: "Show _MENU_ entries",
      zeroRecords: "No user found",
      info: "Showing _START_ to _END_ of _TOTAL_ users",
      paginate: {
        previous: "Prev",
        next: "Next"
      }
      },
      columnDefs: [
      {
        searchable: false,
        orderable: false,
        targets: 0 
      }
      ],
      order: [[1, 'asc']] 
    }).on('order.dt search.dt', function () {
      let table = $('#users-table').DataTable();
      table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
      cell.innerHTML = i + 1;
      });
    }).draw();
    </script>
  @endpush
</x-app-layout>