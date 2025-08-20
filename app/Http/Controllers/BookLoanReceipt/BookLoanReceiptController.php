<?php

namespace App\Http\Controllers;

use App\Models\BookLoanReceipt;
use App\Models\BookLoanReceiptItem;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookLoanReceiptController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:bank_transer,ewallet,cash', 
            'payment_proof' => 'required|image|max:2048',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('member.cart.index')
                ->with('error', 'Cart masih kosong.');
        }

        $file = $request->file('payment_proof');
        $path = $file->store('payment_proofs', 'public');

        // Hitung total harga
        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Insert ke receipts
        $receipt = BookLoanReceipt::create([
            'user_id' => Auth::id(),
            'payment_method' => $request->payment_method,
            'total_price' => $totalPrice,
            'payment_proof' => $path,
            'status' => 'admin_validation',
        ]);

        // Insert item per cart
        foreach ($cart as $item) {
            BookLoanReceiptItem::create([
                'receipt_id' => $receipt->id,
                'book_loan_id' => $item['book_loan_id'],
            ]);
        }

        // Kosongkan cart
        session()->forget('cart');

        return redirect()->route('member.book-loan.index', $receipt->id)
            ->with('success', 'Checkout berhasil! Menunggu validasi admin.');
    }

}
