<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class WelcomeController extends Controller
{
  public function index()
  {
    $totalBooks = Book::count();
    $totalUsers = User::count();
    $latestBooks = Book::latest()->take(5)->get();
    return view('welcome', compact('latestBooks', 'totalBooks', 'totalUsers'));
  }
}

