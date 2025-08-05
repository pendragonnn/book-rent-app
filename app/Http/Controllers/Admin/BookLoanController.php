<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookLoan;
use App\Models\BookItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookLoanController extends Controller
{
    public function index()
    {
        $statuses = ['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'];
        $loans = BookLoan::with(['user', 'bookItem.book'])->latest()->get();
        return view('admin.book_loans.index', compact('loans', 'statuses'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get();
        $bookItems = BookItem::where('status', 'available')->get();
        return view('admin.book_loans.create', compact('users', 'bookItems'));
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

        $start = \Carbon\Carbon::parse($validated['loan_date']);
        $end = \Carbon\Carbon::parse($validated['due_date']);
        $days = $start->diffInDays($end);

        $pricePerDay = $bookItem->book->rental_price;
        $totalPrice = $pricePerDay * $days;

        $loan = BookLoan::create([
            'user_id' => Auth::id(),
            'book_item_id' => $bookItem->id,
            'loan_date' => $validated['loan_date'],
            'due_date' => $validated['due_date'],
            'status' => 'payment_pending',
            'total_price' => $totalPrice,
        ]);

        $bookItem->update(['status' => 'reserved']);

        return redirect()->route('member.dashboard')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function show(BookLoan $bookLoan)
    {
        $bookLoan->load(['user', 'bookItem.book']);
        return view('admin.book_loans.show', compact('bookLoan'));
    }

    public function edit(BookLoan $bookLoan)
    {
        $users = User::where('role_id', 2)->get();
        $bookLoan->load(['user', 'bookItem.book']);
        $bookItems = BookItem::where('status', 'available')->get();
        $statuses = ['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'];
        return view('admin.book_loans.edit', compact('bookLoan', 'statuses', 'users', 'bookItems'));
    }

    public function update(Request $request, BookLoan $bookLoan)
    {
        $status = $request->input('status');

        if ($status === 'borrowed' && $bookLoan->status === 'admin_validation') {
            $bookLoan->update(['status' => 'borrowed']);
            $bookLoan->bookItem->update(['status' => 'borrowed']);
            return redirect()->route('admin.book-loans.index')->with('success', 'Loan approved.');
        }

        if ($status === 'cancelled' && $bookLoan->status === 'admin_validation') {
            $bookLoan->update(['status' => 'cancelled']);
            $bookLoan->bookItem->update(['status' => 'available']);
            return redirect()->route('admin.book-loans.index')->with('success', 'Loan cancelled.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_item_id' => 'required|exists:book_items,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'status' => 'required|in:payment_pending,admin_validation,borrowed,returned,cancelled',
            'total_price' => 'required|numeric|min:0'
        ]);

        $bookLoan->update($validated);

        if ($validated['status'] === 'borrowed') {
            $bookLoan->bookItem->update(['status' => 'borrowed']);
        }

        return redirect()->route('admin.book-loans.index')->with('success', 'Loan updated.');
    }

    public function destroy(BookLoan $bookLoan)
    {
        $bookLoan->delete();
        return redirect()->route('admin.book-loans.index')->with('success', 'Loan deleted.');
    }
}
