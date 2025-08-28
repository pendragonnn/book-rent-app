<?php

namespace App\Http\Controllers\Member;

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
    $statuses = ['pending', 'verified', 'paid', 'rejected', 'cancelled']; // status receipt
    $receipts = BookLoanReceipt::with(['user', 'items.loan.bookItem.book'])
      ->orderBy('created_at', 'desc')
      ->where('user_id', Auth::user()->id)
      ->get();

    return view('member.book_receipts.index', compact('receipts', 'statuses'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'payment_method' => 'required|string|in:bank_transfer,ewallet,cash',
      'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
      return redirect()->route('member.cart.index')
        ->with('error', 'Cart masih kosong.');
    }


    $file = $request->file('payment_proof');
    $path = $file->store('payment_proofs', 'public');

    $totalPrice = collect($cart)->sum(fn($item) => $item['total_price']);

    // buat receipt
    $receipt = BookLoanReceipt::create([
      'user_id' => Auth::id(),
      'payment_method' => $request->payment_method,
      'total_price' => $totalPrice,
      'payment_proof' => $path,
      'status' => 'pending',
    ]);

    // dd($receipt);

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

    session()->forget('cart');

    return redirect()->route('member.cart.index')
      ->with('success', 'Pembuatan Receipt Berhasil!');
  }


  public function show($receipt)
  {
    $receipt = BookLoanReceipt::with(['user', 'items.loan.bookItem.book'])->where('id', $receipt)->first();
    // dd($receipt);
    return view('member.book_receipts.show', compact('receipt'));
  }

  public function edit(BookLoanReceipt $receipt, $id)
  {
    $receipt = $receipt->get()->where('id', $id)->first();
    $cart = session()->get('admin_cart', []);
    $bookItems = BookItem::where('status', 'available')->get();
    $users = User::where('role_id', 2)->get();
    $statuses = ['pending', 'verified', 'paid', 'rejected'];

    return view('member.book_receipts.edit', compact('receipt', 'cart', 'bookItems', 'statuses', 'users'));
  }

  public function update(Request $request, BookLoanReceipt $receipt, $id)
  {
    // dd($request->toArray());
    $receiptTarget = $receipt->first()->where('id', $id)->first();

    $validated = $request->validate([
      'payment_method' => 'required|string|in:bank_transfer,ewallet,cash',
      'total_price' => 'required|numeric|min:0',
      'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    $updateData = [
      'payment_method' => $validated['payment_method'],
      'total_price' => $validated['total_price'],
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

    return redirect()->route('member.book-receipts.index')
      ->with('success', 'Receipt updated successfully.');
  }

  public function destroy(BookLoanReceipt $receipt, $id)
  {
    $receiptTarget = $receipt->first()->where('id', $id)->first();

    foreach ($receiptTarget->loans as $loan) {
      if ($loan->bookItem) {
        $loan->bookItem->update(['status' => 'available']);
      }

      $loan->delete();
    }

    $receiptTarget->delete();
    return redirect()->route('member.book-receipts.index')
      ->with('success', 'Receipt deleted.');
  }

  public function cancel(BookLoanReceipt $receipt, $id)
  {
    $receiptTarget = $receipt->first()->where('id', $id)->first();

    // cancel semua loans
    foreach ($receiptTarget->loans as $loan) {
      $loan->update(['status' => 'cancelled']);
      if ($loan->bookItem) {
        $loan->bookItem->update(['status' => 'available']);
      }
    }

    $receiptTarget->update([
      'status' => 'cancelled',
    ]);

    return redirect()->route('member.book-receipts.index')
      ->with('success', 'Receipt berhasil dibatalkan.');
  }

}
