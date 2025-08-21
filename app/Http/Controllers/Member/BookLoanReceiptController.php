<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookLoanReceipt;
use App\Models\BookLoanReceiptItem;
use App\Models\BookLoan;
use Illuminate\Support\Facades\Auth;
use App\Models\BookItem;

class BookLoanReceiptController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:bank_transfer,ewallet,cash',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('member.cart.index')
                ->with('error', 'Cart masih kosong.');
        }

        $file = $request->file('payment_proof');
        $path = $file->store('payment_proofs', 'public');

        $totalPrice = collect($cart)->sum(function ($item) {
            return $item['total_price'];
        });

        $receipt = BookLoanReceipt::create([
            'user_id' => Auth::id(),
            'payment_method' => $request->payment_method,
            'total_price' => $totalPrice,
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {

            $bookLoan = BookLoan::create([
                'user_id' => Auth::id(),
                'book_item_id' => $item['book_item_id'],
                'loan_date' => $item['loan_date'],
                'due_date' => $item['due_date'],
                'status' => 'payment_pending',
                'loan_price' => $item['total_price'],
            ]);

            $bookItem = BookItem::findOrFail($item['book_item_id']);

            $bookItem->update(['status' => 'reserved']);

            BookLoanReceiptItem::create([
                'receipt_id' => $receipt->id,
                'loan_id' => $bookLoan->id,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('member.book-loans.index')
            ->with('success', 'Checkout berhasil! Menunggu validasi admin.');
    }
}
