<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
  public function index(Request $request)
  {
    $query = Book::with('category');

    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('title', 'like', '%' . $request->search . '%')
          ->orWhere('author', 'like', '%' . $request->search . '%');
      });
    }

    if ($request->filled('category')) {
      $query->where('category_id', $request->category);
    }

    $books = $query->paginate(8);
    $categories = Category::all();

    return view('member.books.index', compact('books', 'categories'));
  }

  public function show($id)
  {
    $book = Book::with('category')->findOrFail($id);
    return view('member.books.show', compact('book'));
  }
}
