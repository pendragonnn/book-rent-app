<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get();

        $role = Auth::user()->role_id;

        if ($role == 1) {
            return view('admin.books.index', compact('books'));
        }

        if ($role == 2) {
            return view('member.books.index', compact('books'));
        }

        abort(403, 'Akses tidak sah.');
    }
}

