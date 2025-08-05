<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\BookItem;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookLoanController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    $status = ['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'];

    $loans = BookLoan::with('bookItem.book')->where('user_id', $user->id)->latest()->paginate(10);

    return view('member.book_loans.index', compact('loans', 'status'));
  }

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

  public function uploadPaymentProof(Request $request, BookLoan $bookLoan)
  {
    if ($bookLoan->user_id !== Auth::id()) {
      abort(403);
    }

    $request->validate([
      'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $path = $request->file('payment_proof')->store('payment_proofs', 'public');

    $bookLoan->update([
      'payment_proof' => $path,
      'status' => 'admin_validation',
    ]);

    return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload!');
  }

  public function returnLoan(BookLoan $bookLoan)
  {
    if ($bookLoan->user_id !== Auth::id()) {
      abort(403);
    }

    if ($bookLoan->status !== 'borrowed') {
      return back()->with('error', 'Only borrowed books can be returned.');
    }

    $bookLoan->update([
      'status' => 'returned',
    ]);

    $bookLoan->bookItem->update([
      'status' => 'available',
    ]);

    return redirect()->back()->with('success', 'Book has been successfully returned.');
  }

  public function cancel(BookLoan $bookLoan)
  {
    if ($bookLoan->user_id !== Auth::id()) {
      abort(403);
    }

    if ($bookLoan->status !== 'payment_pending' && $bookLoan->status !== 'admin_validation') {
      return back()->with('error', 'You can only cancel loans that are still in payment pending status.');
    }

    $bookLoan->update(['status' => 'cancelled']);
    $bookLoan->bookItem->update(['status' => 'available']);

    return back()->with('success', 'Loan has been cancelled.');
  }


}
