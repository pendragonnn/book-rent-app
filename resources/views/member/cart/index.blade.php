@php
    $totalHarga = collect($cart)->sum('total_price');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1B3C53] leading-tight">
            Keranjang Peminjaman
        </h2>
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
            <table class="w-full border-collapse border border-[#d2c1b6]">
                <thead>
                    <tr class="bg-[#F9F3EF]">
                        <th class="border border-[#d2c1b6] p-2">No</th>
                        <th class="border border-[#d2c1b6] p-2">Judul Buku</th>
                        <th class="border border-[#d2c1b6] p-2">Tanggal Pinjam</th>
                        <th class="border border-[#d2c1b6] p-2">Tanggal Kembali</th>
                        <th class="border border-[#d2c1b6] p-2">Hari</th>
                        <th class="border border-[#d2c1b6] p-2">Total Harga</th>
                        <th class="border border-[#d2c1b6] p-2">Aksi</th>
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
                        <td class="border border-[#d2c1b6] p-2 text-center">{{ $item['days'] }} hari</td>
                        <td class="border border-[#d2c1b6] p-2">Rp{{ number_format($item['total_price'], 0, ',', '.') }}
                        </td>
                        <td class="border border-[#d2c1b6] p-2 text-center">
                            <form action="{{ route('member.cart.remove', $index) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                </tr> @endforeach
                </tbody>
            </table>

            {{-- Total harga --}}
            <div class="mt-4 flex justify-between items-center">
                <span class="text-lg font-semibold">Total: Rp{{ number_format($totalHarga, 0, ',', '.') }}</span>

                <button type="button" onclick="document.getElementById('checkoutModal').classList.remove('hidden')"
                    class="bg-[#1B3C53] hover:bg-[#162d42] text-white px-4 py-2 rounded-lg transition">
                    ✅ Checkout & Bayar
                </button>
            </div>
        @else
            <p class="text-center text-gray-600">Keranjang kosong.</p>
        @endif
    </div>
    </div>
</x-app-layout>



{{-- Modal --}}
<div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
        <h2 class="text-xl font-bold mb-4">Konfirmasi Pembayaran</h2>

        <h3 class="font-semibold mb-2">Ringkasan</h3>
        <ul class="mb-4 list-disc pl-5 text-sm">
            @foreach ($cart as $item)
                <li>{{ \App\Models\BookItem::find($item['book_item_id'])->book->title }}
                    ({{ $item['days'] }} hari) -
                    Rp{{ number_format($item['total_price'], 0, ',', '.') }}
                </li>
            @endforeach
        </ul>

        <p class="font-semibold mb-4">Total: Rp{{ number_format($totalHarga, 0, ',', '.') }}</p>

        <form action="{{ route('member.receipts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Metode pembayaran --}}
            <label class="block font-medium mb-1">Metode Pembayaran:</label>
            <div class="grid grid-cols-2 gap-2 mb-4">
                <label class="border p-3 rounded-lg cursor-pointer flex items-center gap-2">
                    <input type="radio" name="payment_method" value="transfer" required> Transfer Bank
                </label>
                <label class="border p-3 rounded-lg cursor-pointer flex items-center gap-2">
                    <input type="radio" name="payment_method" value="ewallet" required> E-Wallet
                </label>
                <label class="border p-3 rounded-lg cursor-pointer flex items-center gap-2">
                    <input type="radio" name="payment_method" value="cash" required> COD
                </label>
            </div>

            {{-- Upload bukti pembayaran --}}
            <label class="block font-medium mb-1">Upload Bukti Pembayaran:</label>
            <input type="file" name="payment_proof" class="mb-4 border p-2 w-full rounded">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('checkoutModal').classList.add('hidden')"
                    class="px-4 py-2 border rounded-lg">Batal</button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    Konfirmasi Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>