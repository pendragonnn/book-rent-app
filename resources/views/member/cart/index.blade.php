@php
    $totalHarga = collect($cart)->sum('total_price');
@endphp

<x-app-layout>
    {{-- Define the title for the browser tab --}}
    <x-slot:title>
        {{ __('My Cart') }} - {{ config('app.name') }}
        </x-slot>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
                    My Cart
                </h2>

                <a href="{{ route('member.books.index') }}"
                    class="inline-flex items-center px-4 underline text-sm font-medium rounded-md text-gray-500 hover:text-[#1B3C53] transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>

                    Add Book
                </a>
            </div>
        </x-slot>

        <div class="py-6 bg-[#F9F3EF] min-h-screen">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md border border-[#d2c1b6]">
                @if (session('success'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-700"> {{ session('success') }} </div>

                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-700"> {{ session('error') }} </div>
                @endif

                @if (count($cart) > 0)
                    <form class="flex justify-end items-center my-3" action="{{ route('member.cart.clear') }}" method="POST"
                        onsubmit="return confirm('Are you sure want to empty the cart?');">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="text-red-500 border border-red-100 hover:underline hover:border hover:border-red-500 px-6 py-2 rounded-full transition">
                            Empty the Cart
                        </button>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-[#d2c1b6]">
                            <thead>
                                <tr class="bg-[#F9F3EF]">
                                    <th class="border border-[#d2c1b6] p-2">No</th>
                                    <th class="border border-[#d2c1b6] p-2">Book Title</th>
                                    <th class="border border-[#d2c1b6] p-2">Loan Date</th>
                                    <th class="border border-[#d2c1b6] p-2">Return Date</th>
                                    <th class="border border-[#d2c1b6] p-2">Total Days</th>
                                    <th class="border border-[#d2c1b6] p-2">Loan Price</th>
                                    <th class="border border-[#d2c1b6] p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody> @foreach ($cart as $index => $item)
                                <tr>
                                    <td class="border border-[#d2c1b6] p-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border border-[#d2c1b6] p-2">
                                        {{ \App\Models\BookItem::find($item['book_item_id'])->book->title }}
                                    </td>
                                    <td class="border border-[#d2c1b6] p-2">
                                        {{ \Carbon\Carbon::parse($item['loan_date'])->format('d M Y') }}
                                    </td>
                                    <td class="border border-[#d2c1b6] p-2">
                                        {{ \Carbon\Carbon::parse($item['due_date'])->format('d M Y') }}
                                    </td>
                                    <td class="border border-[#d2c1b6] p-2 text-center">{{ $item['days'] }} days</td>
                                    <td class="border border-[#d2c1b6] p-2">
                                        Rp{{ number_format($item['total_price'], 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="p-2 text-center flex flex-col md:flex-row items-center justify-between gap-3">

                                        <form action="{{ route('member.cart.remove', $index) }}" method="POST"
                                            onsubmit="return confirm('Are you sure want to delete this loan item from the cart?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-700 hover:underline">
                                                Delete
                                            </button>
                                        </form>

                                        {{-- {{dd($item)}} --}}

                                        <!-- Tombol Edit -->
                                        <button type="button"
                                            onclick="openEditModal('{{ $item['id'] }}', '{{ $item['loan_date'] }}', '{{ $item['due_date'] }}')"
                                            class="text-blue-900 hover:underline">
                                            Edit Date
                                        </button>

                                    </td>
                            </tr> @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Total harga --}}
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-semibold">Total: Rp{{ number_format($totalHarga, 0, ',', '.') }}</span>

                        <button type="button" onclick="document.getElementById('checkoutModal').classList.remove('hidden')"
                            class="bg-[#1B3C53] hover:bg-[#162d42] text-white px-4 py-2 rounded-full transition">
                            Checkout
                        </button>
                    </div>
                @else
                    <p class="text-center text-gray-600">The Cart is Empty.</p>
                @endif
            </div>
        </div>
</x-app-layout>



{{-- Modal --}}
<div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative my-8 overflow-y-auto max-h-[90vh]">
        {{-- Close Button --}}
        <button type="button" onclick="document.getElementById('checkoutModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            ✕
        </button>

        {{-- Header --}}
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold">Complete Your Order</h2>
            <p class="text-gray-600 text-sm">Choose your payment method</p>
        </div>

        {{-- User Info --}}
        <div class="mb-4 border rounded-lg p-4 bg-gray-50">
            <p class="font-semibold">{{ Auth::user()->name }}</p>
            <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
        </div>

        {{-- Order Summary --}}
        <div class="mb-6 border rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <tbody>
                    @foreach ($cart as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                {{ \App\Models\BookItem::find($item['book_item_id'])->book->title }}
                                <span class="text-xs text-gray-500">({{ $item['days'] }} days)</span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                Rp{{ number_format($item['total_price'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="px-4 py-2 font-semibold text-right">Total:</td>
                        <td class="px-4 py-2 font-bold text-right">
                            Rp{{ number_format($totalHarga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Payment Methods --}}
        <form action="{{ route('member.receipts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <h3 class="font-semibold mb-3 text-center">Payment Methods</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- Opsi 1: Bank Transfer -->
                    <div>
                        <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer"
                            class="hidden peer" required>
                        <label for="bank_transfer"
                            class="border p-4 rounded-xl cursor-pointer transition flex flex-col items-center border-gray-200 peer-checked:border-green-600 peer-checked:ring-2 peer-checked:ring-green-600">
                            <span class="font-semibold">Bank Transfer</span>
                            <span class="text-xs text-gray-500">BCA, Mandiri, BNI</span>
                        </label>
                    </div>

                    <!-- Opsi 2: E-Wallet -->
                    <div>
                        <input type="radio" name="payment_method" id="ewallet" value="ewallet" class="hidden peer"
                            required>
                        <label for="ewallet"
                            class="border p-4 rounded-xl cursor-pointer transition flex flex-col items-center border-gray-200 peer-checked:border-green-600 peer-checked:ring-2 peer-checked:ring-green-600">
                            <span class="font-semibold">E-Wallet</span>
                            <span class="text-xs text-gray-500">GoPay, OVO, DANA</span>
                        </label>
                    </div>

                    <!-- Opsi 3: Cash on Delivery -->
                    <div>
                        <input type="radio" name="payment_method" id="cash" value="cash" class="hidden peer" required>
                        <label for="cash"
                            class="border p-4 rounded-xl cursor-pointer transition flex flex-col items-center border-gray-200 peer-checked:border-green-600 peer-checked:ring-2 peer-checked:ring-green-600">
                            <span class="font-semibold">Cash on Delivery</span>
                            <span class="text-xs text-gray-500">Bayar saat diterima</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Upload Bukti Pembayaran --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">Payment Proof Upload:</label>
                <input type="file" name="payment_proof" class="border p-2 w-full rounded">
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-2">
                <button type="button" class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded-full"
                    onclick="document.getElementById('checkoutModal').classList.add('hidden')">Cancel</button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-full">
                    Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>


<div id="editCartModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
        <h2 class="text-xl font-bold mb-4">Edit Loan Cart</h2>


        <form action="{{ route('member.cart.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hidden ID item -->
            <input type="hidden" name="id" id="editCartId">

            <!-- Loan Date -->
            <label class="block font-medium mb-1">Loan Date:</label>
            <input type="date" name="loan_date" id="editLoanDate" class="mb-3 border p-2 w-full rounded" required>

            <!-- Due Date -->
            <label class="block font-medium mb-1">Due Date:</label>
            <input type="date" name="due_date" id="editDueDate" class="mb-3 border p-2 w-full rounded" required>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="document.getElementById('editCartModal').classList.add('hidden')"
                    class="bg-gray-200 hover:bg-gray-300 text-black px-4 py-2 rounded-full">Cancel</button>
                <button type="submit" class="bg-green-200 hover:bg-green-300 text-black px-4 py-2 rounded-full">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, loanDate, dueDate) {
        document.getElementById('editCartId').value = id;
        document.getElementById('editLoanDate').value = loanDate;
        document.getElementById('editDueDate').value = dueDate;
        document.getElementById('editCartModal').classList.remove('hidden');
    }
</script>