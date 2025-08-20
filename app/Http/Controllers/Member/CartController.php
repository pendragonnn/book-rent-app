<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookItem;
use Carbon;

class CartController extends Controller
{
  public function addToCart(Request $request)
  {
    $cart = session()->get('cart', []);

    $bookItemId = $request->book_item_id; 
    $bookItem = BookItem::with('book')->findOrFail($bookItemId);

    foreach ($cart as $item) {
        if ($item['book_item_id'] == $bookItem->id) {
            return redirect()->route('member.cart.index')
                ->with('error', 'Buku "' . $bookItem->book->title . '" sudah ada di cart.');
        }
    }

    $dailyPrice = $bookItem->book->rental_price;

    $start = \Carbon\Carbon::parse($request->loan_date);
    $end = \Carbon\Carbon::parse($request->due_date);
    $days = $start->diffInDays($end);
    $quantity = $request->quantity;

    $totalPrice = $dailyPrice * $days;

    $cart[] = [
      'id' => uniqid(),
      'book_item_id' => $bookItemId,
      'loan_date' => $start,
      'due_date' => $end,
      'days' => $days,
      'quantity'=> $quantity,
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
}
