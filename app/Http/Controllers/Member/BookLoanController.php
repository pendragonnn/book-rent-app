<?php

namespace App\Http\Controllers\Member;

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
        $loans = BookLoan::with(['receipts', 'bookItem.book'])
            ->whereHas('receipts', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('member.book_loans.index', compact('loans'));
    }

    public function create($id)
    {
        $users = User::where('role_id', 2)->get();
        $bookItems = BookItem::with('book')->findOrFail($id);
        return view('member.book_loans.create', compact('users', 'bookItems'));
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
            'loan_price' => $totalPrice,
        ]);

        $bookItem->update(['status' => 'reserved']);

        return redirect()->route('member.book-loans.index')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function show(BookLoan $bookLoan)
    {
        $bookLoan->load(['user', 'bookItem.book']);
        return view('member.book_loans.show', compact('bookLoan'));
    }

    public function edit(BookLoan $bookLoan)
    {
        $users = User::where('role_id', 2)->get();
        $bookLoan->load(['user', 'bookItem.book']);
        $bookItems = BookItem::where('status', 'available')->get();
        $statuses = ['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'];
        return view('member.book_loans.edit', compact('bookLoan', 'statuses', 'users', 'bookItems'));
    }

    public function update(Request $request, BookLoan $bookLoan)
    {
        // dd($request->toArray());
        // dd($request->loan_price);
        $status = $request->status;

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
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'status' => 'required|string|in:admin_validation',
            'loan_price' => 'required|numeric'
        ]);

        $bookLoan->update($validated);

        // dd($bookLoan->toArray());

        if ($bookLoan->receipt_id) {
            $receipt = $bookLoan->receipts()->first();
            if ($receipt) {
                $totalPrice = BookLoan::where('receipt_id', $bookLoan->receipt_id)->where('status', 'admin_validation')->sum('loan_price');
                $receipt->update(['total_price' => $totalPrice]);
            }
        }

        if ($validated['status'] === 'borrowed') {
            $bookLoan->bookItem->update(['status' => 'borrowed']);
        }

        return redirect()->route('member.book-loans.index')->with('success', 'Loan updated.');
    }

    public function destroy(BookLoan $bookLoan)
    {
        $bookLoan->delete();
        return redirect()->route('member.book-loans.index')->with('success', 'Loan deleted.');
    }

    public function returnLoan(BookLoan $bookLoan)
    {
        if (!$bookLoan->receipts()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        // cek status dulu
        if ($bookLoan->status !== 'borrowed') {
            return back()->with('error', 'Only borrowed books can be returned.');
        }

        // update status loan
        $bookLoan->update([
            'status' => 'returned',
        ]);

        // update status book item
        $bookLoan->bookItem->update([
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', 'Book has been successfully returned.');
    }

    public function cancelLoan(BookLoan $bookLoan)
    {
        // cek user pemilik
        if (!$bookLoan->receipts()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        // hanya boleh cancel ketika masih admin_validation
        if ($bookLoan->status !== 'admin_validation') {
            return back()->with('error', 'Hanya pinjaman yang menunggu validasi admin yang bisa dibatalkan.');
        }

        // update loan status
        $bookLoan->update(['status' => 'cancelled']);

        // update book item status
        if ($bookLoan->bookItem) {
            $bookLoan->bookItem->update(['status' => 'available']);
        }

        // update total_price di receipt
        foreach ($bookLoan->receipts as $receipt) {
            $newTotal = $receipt->total_price - $bookLoan->loan_price;
            $receipt->update(['total_price' => max(0, $newTotal)]);

            // kalau semua loan di receipt cancelled → receipt juga rejected
            if ($receipt->loans()->where('status', '!=', 'cancelled')->count() === 0) {
                $receipt->update(['status' => 'cancelled']);
            }
        }

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }


}
