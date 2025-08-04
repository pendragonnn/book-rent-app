<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\BookLoan;

class DashboardController extends Controller
{
  public function index()
  {
    $totalUsers = User::where('role_id', 2)->count(); // Only normal users
    $totalBooks = Book::count();
    $totalLoans = BookLoan::count();

    $recentLoans = BookLoan::with(['user', 'bookItem.book'])->latest()->take(5)->get();

    $loanStatusCounts = [
      'cancelled' => BookLoan::where('status', 'cancelled')->count(),
      'payment_pending' => BookLoan::where('status', 'payment_pending')->count(),
      'borrowed' => BookLoan::where('status', 'borrowed')->count(),
      'returned' => BookLoan::where('status', 'returned')->count(),
      'admin_validation' => BookLoan::where('status', 'admin_validation')->count()
    ];

    return view('admin.dashboard.index', compact(
      'totalUsers',
      'totalBooks',
      'totalLoans',
      'recentLoans',
      'loanStatusCounts'
    ));
  }
}
