<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookItem;
use Carbon\Carbon;

class CartController extends Controller
{
  public function addToCart(Request $request)
  {
    $cart = session()->get('cart', []);

    $bookItemId = $request->book_item_id;
    $bookItem = BookItem::with('book')->findOrFail($bookItemId);

    foreach ($cart as $item) {
      if ($item['book_title'] == $bookItem->book->title) {
        return redirect()->route('member.cart.index')
          ->with('error', 'Buku "' . $bookItem->book->title . '" sudah ada di cart.');
      }
    }

    $dailyPrice = $bookItem->book->rental_price;

    $start = \Carbon\Carbon::parse($request->loan_date);
    $end = \Carbon\Carbon::parse($request->due_date);
    $days = $start->diffInDays($end);

    $totalPrice = $dailyPrice * $days;

    $cart[] = [
      'id' => uniqid(),
      'book_item_id' => $bookItemId,
      'book_title' => $bookItem->book->title,
      'loan_date' => $start,
      'due_date' => $end,
      'days' => $days,
      'total_price' => $totalPrice,
    ];

    session()->put('cart', $cart);

    return redirect()->route('member.cart.index')
      ->with('success', 'Buku berhasil ditambahkan ke cart.');
  }

  public function index()
  {
    $cart = session()->get('cart', []);
    return view('member.cart.index', compact('cart'));
  }

  public function remove($index)
  {
    $cart = session()->get('cart', []);
    if (isset($cart[$index])) {
      unset($cart[$index]);
      session()->put('cart', $cart);
    }
    return back()->with('success', 'Item berhasil dihapus dari keranjang.');
  }

  public function clearCart()
  {
    session()->forget('cart');
    return redirect()->back()->with('success', 'Cart telah dikosongkan.');
  }

  public function updateCart(Request $request)
  {
    $cart = session()->get('cart', []);
    $updatedItemId = $request->id;
    // dd($updatedItemId);
    $loanDate = Carbon::parse($request->input('loan_date'));
    $dueDate = Carbon::parse($request->input('due_date'));

    if ($dueDate->lt($loanDate)) {
      return redirect()->back()->with('error', 'Tanggal kembali tidak boleh lebih awal dari tanggal pinjam.');
    }

    $itemFound = false;
    foreach ($cart as $key => $item) {
      if ($item['id'] === $updatedItemId) {
        $bookItem = BookItem::with('book')->findOrFail($item['book_item_id']);
        $dailyPrice = $bookItem->book->rental_price;

        $days = $loanDate->diffInDays($dueDate);
        $totalPrice = $dailyPrice * $days;

        $cart[$key]['loan_date'] = $loanDate;
        $cart[$key]['due_date'] = $dueDate;
        $cart[$key]['days'] = $days;
        $cart[$key]['total_price'] = $totalPrice;

        $itemFound = true;
        break;
      }
    }

    if ($itemFound) {
      session()->put('cart', $cart);
      return redirect()->back()->with('success', 'Keranjang berhasil diperbarui.');
    } else {
      return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }
  }
}
