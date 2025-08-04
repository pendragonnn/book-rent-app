<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\BookItem;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookLoanController extends Controller
{
  public function create(BookItem $bookItem)
  {
    if ($bookItem->status !== 'available') {
      return redirect()->route('member.catalog.index')->with('error', 'Buku tidak tersedia.');
    }

    return view('member.book_loans.create', compact('bookItem'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'book_item_id' => 'required|exists:book_items,id',
      'loan_date' => 'required|date|after_or_equal:today',
      'due_date' => 'required|date|after_or_equal:loan_date',
    ]);

    $bookItem = BookItem::findOrFail($validated['book_item_id']);

    if ($bookItem->status !== 'available') {
      return back()->with('error', 'Buku sudah dipinjam.');
    }

    $loan = BookLoan::create([
      'user_id' => Auth::id(),
      'book_item_id' => $bookItem->id,
      'loan_date' => $validated['loan_date'],
      'due_date' => $validated['due_date'],
      'status' => 'payment_pending',
      'total_price' => $bookItem->book->rental_price,
    ]);

    $bookItem->update(['status' => 'reserved']);

    return redirect()->route('member.dashboard')->with('success', 'Peminjaman berhasil diajukan.');
  }
}
