<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookLoan;
use App\Models\BookItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookLoanReceipt;
class BookLoanController extends Controller
{
    public function index()
    {
        $statuses = ['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'];
        $loans = BookLoan::with(['receipts.user', 'bookItem.book'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        // dd($loans->toArray());
        return view('admin.book_loans.index', compact('loans', 'statuses'));
    }

    public function create()
    {
        $users = User::where('role_id', 2)->get();
        $bookItems = BookItem::where('status', 'available')->get();
        $receipts = BookLoanReceipt::with('user')->where('status', 'pending')->get();

        return view('admin.book_loans.create', compact('users', 'bookItems', 'receipts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_item_id' => 'required|exists:book_items,id',
            'loan_date' => 'required|date|after_or_equal:today',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'receipt_id' => 'nullable|exists:book_loan_receipts,id',
        ]);

        $bookItem = BookItem::findOrFail($validated['book_item_id']);

        if ($bookItem->status !== 'available') {
            return back()->with('error', 'Buku sudah dipinjam.');
        }

        $days = \Carbon\Carbon::parse($validated['loan_date'])
            ->diffInDays(\Carbon\Carbon::parse($validated['due_date']));

        $loanPrice = $bookItem->book->rental_price * $days;



        if (empty($validated['receipt_id'])) {
            return redirect()->route('admin.book-loans.index')
                ->with('error', 'Loan gagal ditambahkan, id receipt tidak ditemukan');
        }
        $receipt = BookLoanReceipt::findOrFail($validated['receipt_id']);
        // $receiptUser = BookLoanReceipt::findOrFail($validated['receipt_id'])->where('user_id', $validated['user_id'])->first();
        // dd($receipt->first()->user_id);
        // dd($validated['user_id']);
        $receipt->update(['status' => 'pending']);


        // dd(
        //     ['request_User_id', $validated['user_id']],
        //     ['receipt_user_id', $receipt->user_id],
        // );

        if ($receipt->user_id != $validated['user_id']) {
            return redirect()->route('admin.book-loans.index')
                ->with('error', 'Data user tidak sesuai dengan pengajuan receipt');
        }

        // --- buat loan
        $loan = BookLoan::create([
            'receipt_id' => $receipt->id,
            'book_item_id' => $bookItem->id,
            'loan_date' => $validated['loan_date'],
            'due_date' => $validated['due_date'],
            'status' => 'admin_validation',
            'loan_price' => $loanPrice,
        ]);

        // --- buat receipt item
        \App\Models\BookLoanReceiptItem::create([
            'receipt_id' => $receipt->id,
            'loan_id' => $loan->id,
        ]);

        // --- update status book item
        $bookItem->update(['status' => 'reserved']);

        // --- update total_price (pakai sum)
        $totalPrice = $receipt->loans()->sum('loan_price');
        $receipt->update(['total_price' => $totalPrice]);

        return redirect()->route('admin.book-loans.index')
            ->with('success', 'Loan berhasil dibuat & masuk ke receipt.');
    }


    public function show(BookLoan $bookLoan)
    {
        $bookLoan->load(['user', 'bookItem.book']);
        $user = $bookLoan->receipts->first()->user;
        return view('admin.book_loans.show', compact('bookLoan', 'user'));
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

        // ✅ Validasi input
        // dd($request->toArray());
        $validated = $request->validate([
            'book_item_id' => 'required|exists:book_items,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'status' => 'required|in:payment_pending,admin_validation,borrowed,returned,cancelled',
            'loan_price' => 'required|numeric|min:0'
        ]);

        // ✅ Update data book loan
        $bookLoan->update($validated);

        // ✅ Update status bookItem kalau dipinjem
        if ($validated['status'] === 'borrowed') {
            $bookLoan->bookItem->update(['status' => 'borrowed']);
        }

        // Ambil receipt yang nyambung sama bookLoan ini
        $receipt = $bookLoan->receipts()->first();

        if ($receipt) {
            // Hitung ulang total_price dari semua loan di receipt ini
            $newTotal = $receipt->items()
                ->with('loan') // relasi ke loan
                ->get()
                ->sum(fn($item) => $item->loan ? $item->loan->loan_price : 0);

            $receipt->update(['total_price' => $newTotal]);

            // Kalau semua loans sudah hilang (total_price = 0), ubah status receipt jadi rejected
            if ($newTotal === 0) {
                $receipt->update(['status' => 'rejected']);
            }
        }

        return redirect()->route('admin.book-loans.index')->with('success', 'Loan updated and receipt recalculated.');
    }


    public function destroy(BookLoan $bookLoan, Request $request)
    {
        // Validasi konfirmasi
        $confirmationText = "saya mengetahui bahwa penghapusan ini akan mempengaruhi data lain dan saya sudah memeriksanya";
        if ($request->input('delete_confirmation') !== $confirmationText) {
            return redirect()->back()
                ->with('error', 'Konfirmasi penghapusan salah. Harap ketik kalimat dengan benar.');
        }
        // 1. Balikin status book item jadi available (kalau bukan available)
        if ($bookLoan->bookItem && $bookLoan->bookItem->status !== 'available') {
            $bookLoan->bookItem->update(['status' => 'available']);
        }

        // 2. Cari receipt yang terkait sama loan ini
        $receiptItem = $bookLoan->receipts()->first(); // relasi pivot
        // $receipt = $receiptItem ? $receiptItem->receipt : null;

        // 3. Hapus loan (otomatis hapus pivot kalau cascade)
        $bookLoan->delete();

        // 4. Kalau ada receipt
        if ($receiptItem) {
            $remainingLoans = $receiptItem->items()->whereNotNull('loan_id')->count();

            if ($remainingLoans > 0) {
                // masih ada loan lain → hitung ulang total_price
                $newTotal = $receiptItem->items()
                    ->with('loan')
                    ->get()
                    ->sum(fn($item) => $item->loan ? $item->loan->loan_price : 0);

                $receiptItem->update(['total_price' => $newTotal]);
            } else {
                // udah gak ada loan → jangan bikin total_price = 0, 
                // cukup ubah status aja
                $receiptItem->update(['status' => 'rejected']);
            }
        }

        return redirect()->route('admin.book-loans.index')
            ->with('success', 'Loan deleted and receipt updated.');
    }

    public function cancelLoan(BookLoan $bookLoan)
    {
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
