<?php

namespace App\Http\Controllers;

use App\Models\BookLoanReceipt;
use Illuminate\Http\Request;
use App\Models\BookLoan;
use App\Models\BookLoanReceiptItem;

// app/Http/Controllers/BookLoanReceiptController.php
class BookLoanReceiptController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'loan_ids' => 'required|array',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();

        $loans = BookLoan::whereIn('id', $request->loan_ids)
            ->where('user_id', $user->id)
            ->where('status', 'payment_pending')
            ->get();

        if ($loans->isEmpty()) {
            return back()->withErrors('No valid loans selected.');
        }

        $totalPrice = $loans->sum('loan_price');

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payments', 'public');
        }

        $receipt = BookLoanReceipt::create([
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'total_price' => $totalPrice,
            'payment_proof' => $paymentProofPath,
            'status' => 'pending',
        ]);

        foreach ($loans as $loan) {
            BookLoanReceiptItem::create([
                'receipt_id' => $receipt->id,
                'loan_id' => $loan->id,
            ]);

            $loan->update(['status' => 'admin_validation']);
        }

        return redirect()->route('receipts.show', $receipt->id)->with('success', 'Receipt created!');
    }

    public function approve($id)
    {
        $receipt = BookLoanReceipt::findOrFail($id);

        $receipt->update(['status' => 'verified']);

        foreach ($receipt->items as $item) {
            $item->loan->update(['status' => 'borrowed']);
        }

        return back()->with('success', 'Receipt approved!');
    }

    public function reject($id)
    {
        $receipt = BookLoanReceipt::findOrFail($id);

        $receipt->update(['status' => 'rejected']);

        foreach ($receipt->items as $item) {
            $item->loan->update(['status' => 'payment_pending']);
        }

        return back()->with('error', 'Receipt rejected!');
    }
}

