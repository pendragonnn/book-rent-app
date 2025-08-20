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
            'book_loan_ids' => 'required|array',
            'book_loan_ids.*' => 'exists:book_loans,id',
            'payment_proof' => 'required|image|max:2048',
        ]);

        $file = $request->file('payment_proof');
        $path = $file->store('payment_proofs', 'public');

        $receipt = BookLoanReceipt::create([
            'user_id' => Auth::id(),
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        foreach ($request->book_loan_ids as $loanId) {
            BookLoanReceiptItem::create([
                'receipt_id' => $receipt->id,
                'book_loan_id' => $loanId,
            ]);
        }

        return redirect()->route('receipts.show', $receipt->id)
            ->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $receipt = BookLoanReceipt::findOrFail($id);
        $receipt->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'approved') {
            foreach ($receipt->items as $item) {
                $item->bookLoan->update(['status' => 'active']);
            }
        }

        return back()->with('success', 'Status pembayaran diperbarui.');
    }
}
