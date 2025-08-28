<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookItem;
use App\Models\BookLoanReceipt;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BookLoanReceiptItem;
use App\Models\BookLoan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookLoanReceiptController extends Controller
{
  public function index()
  {
    $statuses = ['pending', 'verified', 'paid', 'rejected']; // status receipt
    $receipts = BookLoanReceipt::with(['user', 'items.loan.bookItem.book'])
      ->orderBy('created_at', 'desc')
      ->get();

    return view('admin.book_receipts.index', compact('receipts', 'statuses'));
  }

  public function create()
  {
    $cart = session()->get('admin_cart', []);
    $users = User::where('role_id', 2)->get();
    $bookItems = BookItem::where('status', 'available')->get();
    return view('admin.book_receipts.create', compact('users', 'bookItems', 'cart'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'payment_method' => 'required|string|in:bank_transfer,ewallet,cash',
      'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
    ]);

    $cart = session()->get('admin_cart', []);
    if (empty($cart)) {
      return redirect()->route('admin.book-receipts.create')
        ->with('error', 'Cart masih kosong.');
    }

    $file = $request->file('payment_proof');
    $path = $file->store('payment_proofs', 'public');

    $totalPrice = collect($cart)->sum(fn($item) => $item['total_price']);

    // buat receipt
    $receipt = BookLoanReceipt::create([
      'user_id' => $request->user_id,
      'payment_method' => $request->payment_method,
      'total_price' => $totalPrice,
      'payment_proof' => $path,
      'status' => 'pending',
    ]);

    foreach ($cart as $item) {
      $bookLoan = BookLoan::create([
        'book_item_id' => $item['book_item_id'],
        'receipt_id' => $receipt->id,
        'loan_date' => $item['loan_date'],
        'due_date' => $item['due_date'],
        'loan_price' => $item['total_price'],
      ]);

      BookLoanReceiptItem::create([
        'receipt_id' => $receipt->id,
        'loan_id' => $bookLoan->id,
      ]);

      $bookItem = BookItem::findOrFail($item['book_item_id']);
      $bookItem->update(['status' => 'reserved']);
    }

    session()->forget('admin_cart');

    return redirect()->route('admin.book-receipts.index')
      ->with('success', 'Pembuatan Receipt Berhasil!');
  }

  public function addToCart(Request $request)
  {
    $request->validate([
      'book_item_id' => 'required|exists:book_items,id',
      'loan_date' => 'required|date',
      'due_date' => 'required|date|after:loan_date',
    ]);

    $cart = session()->get('admin_cart', []);
    $bookItem = BookItem::with('book')->findOrFail($request->book_item_id);

    // dd($bookItem->book->toArray());
    // Check if book item already in cart
    foreach ($cart as $item) {
      // dd($item['book_title'] == $bookItem->book->title);
      if ($item['book_title'] == $bookItem->book->title) {
        return redirect()->back()
          ->with('error', 'Buku "' . $bookItem->book->title . '" sudah ada di cart.');
      }
    }

    // Calculate rental price
    $dailyPrice = $bookItem->book->rental_price;
    $start = Carbon::parse($request->loan_date);
    $end = Carbon::parse($request->due_date);
    $days = $start->diffInDays($end);
    $totalPrice = $dailyPrice * $days;

    // Add to cart
    $cart[] = [
      'id' => uniqid(),
      'book_item_id' => $bookItem->id,
      'book_title' => $bookItem->book->title,
      'loan_date' => $request->loan_date,
      'due_date' => $request->due_date,
      'days' => $days,
      'total_price' => $totalPrice,
    ];

    session()->put('admin_cart', $cart);

    return redirect()->back()
      ->with('success', 'Buku berhasil ditambahkan ke cart.');
  }

  public function removeFromCart($index)
  {
    $cart = session()->get('admin_cart', []);
    if (isset($cart[$index])) {
      unset($cart[$index]);
      session()->put('admin_cart', array_values($cart)); // Reindex array
    }
    return back()->with('success', 'Item berhasil dihapus dari cart.');
  }


  public function show($receipt)
  {
    $receipt = BookLoanReceipt::with(['user', 'items.loan.bookItem.book'])->where('id', $receipt)->first();
    // ($receipt->items->toArray());
    return view('admin.book_receipts.show', compact('receipt'));
  }

  public function edit(BookLoanReceipt $receipt, $id)
  {
    $receipt = $receipt->get()->where('id', $id)->first();
    $cart = session()->get('admin_cart', []);
    $bookItems = BookItem::where('status', 'available')->get();
    $users = User::where('role_id', 2)->get();
    $statuses = ['pending', 'verified', 'paid', 'rejected'];

    return view('admin.book_receipts.edit', compact('receipt', 'cart', 'bookItems', 'statuses', 'users'));
  }

  public function update(Request $request, BookLoanReceipt $receipt, $id)
  {
    // dd($request->toArray());
    $receiptTarget = $receipt->first()->where('id', $id)->first();

    $validated = $request->validate([
      'user_id' => 'required|exists:users,id',
      'status' => 'required|in:pending,verified,paid,rejected',
      'payment_method' => 'required|string|in:bank_transfer,ewallet,cash',
      'total_price' => 'required|numeric|min:0',
      'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    $updateData = [
      'user_id' => $validated['user_id'],
      'payment_method' => $validated['payment_method'],
      'total_price' => $validated['total_price'],
      'status' => $validated['status'],
    ];

    if ($request->hasFile('payment_proof')) {
      $file = $request->file('payment_proof');
      $path = $file->store('payment_proofs', 'public');

      if ($receipt->payment_proof && \Storage::disk('public')->exists($receipt->payment_proof)) {
        \Storage::disk('public')->delete($receipt->payment_proof);
      }

      $updateData['payment_proof'] = $path;
    }

    $receiptTarget->update($updateData);

    if ($validated['status'] === 'rejected') {
      foreach ($receiptTarget->loans as $loan) {
        $loan->update(['status' => 'cancelled']);
        if ($loan->bookItem) {
          $loan->bookItem->update(['status' => 'available']);
        }
      }
    }

    return redirect()->route('admin.book-receipts.index')
      ->with('success', 'Receipt updated successfully.');
  }

  public function destroy(BookLoanReceipt $receipt, $id, Request $request)
  {
    $receiptTarget = $receipt->first()->where('id', $id)->first();

    // Validasi konfirmasi
    $confirmationText = "saya mengetahui bahwa penghapusan ini akan mempengaruhi data lain dan saya sudah memeriksanya";
    if ($request->input('delete_confirmation') !== $confirmationText) {
      return redirect()->back()
        ->with('error', 'Konfirmasi penghapusan salah. Harap ketik kalimat dengan benar.');
    }

    // Cek apakah masih ada loan dengan status borrowed
    $hasBorrowed = $receiptTarget->loans()->where('status', 'borrowed')->exists();
    if ($hasBorrowed) {
      return redirect()->route('admin.book-receipts.index')
        ->with('error', 'Tidak bisa menghapus receipt karena masih ada peminjaman yang sedang berlangsung.');
    }

    // Update book items jadi available, hapus loans
    foreach ($receiptTarget->loans as $loan) {
      if ($loan->bookItem) {
        $loan->bookItem->update(['status' => 'available']);
      }
      $loan->delete();
    }

    $receiptTarget->delete();

    return redirect()->route('admin.book-receipts.index')
      ->with('success', 'Receipt berhasil dihapus.');
  }


  public function clearCart()
  {
    session()->forget('admin_cart');
    return redirect()->back()->with('success', 'Cart telah dikosongkan.');
  }

  public function verify(Request $request, BookLoanReceipt $receipt)
  {
    $validated = $request->validate([
      'status' => 'required|in:pending,verified,paid,rejected',
    ]);

    // Update status receipt
    $receipt->update(['status' => $validated['status']]);

    // Update status book loans berdasarkan status receipt
    if ($validated['status'] === 'verified' || $validated['status'] === 'paid') {
      // hanya update loan yg masih admin_validation
      foreach ($receipt->loans()->where('status', 'admin_validation')->get() as $loan) {
        $loan->update(['status' => 'borrowed']);

        if ($loan->bookItem) {
          $loan->bookItem->update(['status' => 'borrowed']);
        }
      }
    } elseif ($validated['status'] === 'rejected') {
      foreach ($receipt->loans as $loan) {
        $loan->update(['status' => 'cancelled']);

        if ($loan->bookItem) {
          $loan->bookItem->update(['status' => 'available']);
        }
      }
    }


    return redirect()->route('admin.book-receipts.index')
      ->with('success', 'Receipt updated successfully.');
  }

}
