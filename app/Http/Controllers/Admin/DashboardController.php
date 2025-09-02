<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookLoanReceipt;
use App\Models\User;
use App\Models\Book;
use App\Models\BookLoan;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // User & Book Stats
        $totalUsers = User::where('role_id', 2)->count();
        $totalBooks = Book::count();
        $totalCategories = Category::count();

        // Loan Stats
        $totalLoans = BookLoan::count();
        $loanValidation = BookLoan::where('status', 'admin_validation')->count();
        $loanBorrowed = BookLoan::where('status', 'borrowed')->count();
        $loanReturned = BookLoan::where('status', 'returned')->count();
        $loanCancelled = BookLoan::where('status', 'cancelled')->count();

        // Receipt Stats
        $totalReceipts = BookLoanReceipt::count();
        $receiptPending = BookLoanReceipt::where('status', 'pending')->count();
        $receiptVerified = BookLoanReceipt::where('status', 'verified')->count();
        $receiptRejected = BookLoanReceipt::where('status', 'rejected')->count();
        $receiptCancelled = BookLoanReceipt::where('status', 'cancelled')->count();

        // Recent Receipts
        $recentLoans = BookLoanReceipt::with(['user'])
            ->latest()
            ->take(5)
            ->get();

        // Top Borrowed Books
        $topBooks = DB::table('book_loans')
            ->join('book_items', 'book_loans.book_item_id', '=', 'book_items.id')
            ->join('books', 'book_items.book_id', '=', 'books.id')
            ->select(
                'books.id',
                'books.title',
                DB::raw('COUNT(book_loans.id) as total_borrowed')
            )
            ->where('book_loans.status', ['borrowed', 'returned']) // hanya yang masih dipinjam
            ->groupBy('books.id', 'books.title')
            ->orderByDesc('total_borrowed')
            ->get();

        // Recent Activity (mix of recent loans, receipts, etc.)
        $recentActivity = collect();

        // Recent loan receipts
        $recentReceipts = BookLoanReceipt::with(['user'])
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($receipt) {
                return [
                    'type' => 'receipt',
                    'message' => "Receipt {$receipt->receipt_number} " . ($receipt->status === 'verified' ? 'verified' : 'submitted'),
                    'user' => $receipt->user ? $receipt->user->name : 'Unknown User',
                    'time' => $receipt->updated_at,
                    'status' => $receipt->status,
                    'icon' => $receipt->status === 'verified' ? 'check' : 'document'
                ];
            });

        // Recent loans
        $recentLoanActivities = BookLoan::with(['user', 'receipts.user'])
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($loan) {
                // Get the user from receipts (if any)
                $receiptUser = $loan->receipts->first() ? $loan->receipts->first()->user : null;

                return [
                    'type' => 'loan',
                    'message' => "Book loan " . ($loan->status === 'returned' ? 'returned' : 'created'),
                    'user' => $receiptUser
                        ? $receiptUser->name
                        : ($loan->user ? $loan->user->name : 'Unknown User'),
                    'time' => $loan->updated_at,
                    'status' => $loan->status,
                    'icon' => $loan->status === 'returned' ? 'check-circle' : 'book',
                ];
            });

        $recentActivity = $recentReceipts->merge($recentLoanActivities)
            ->sortByDesc('time')
            ->take(5)
            ->values();

        // Growth calculations (compared to last month)
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $currentMonthUsers = User::where('role_id', 2)
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $lastMonthUsers = User::where('role_id', 2)
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $userGrowth = $lastMonthUsers > 0 ? round((($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;

        $currentMonthLoans = BookLoan::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $lastMonthLoans = BookLoan::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $loanGrowth = $lastMonthLoans > 0 ? round((($currentMonthLoans - $lastMonthLoans) / $lastMonthLoans) * 100, 1) : 0;

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalBooks',
            'totalCategories',
            'totalLoans',
            'loanValidation',
            'loanBorrowed',
            'loanReturned',
            'loanCancelled',
            'totalReceipts',
            'receiptPending',
            'receiptVerified',
            'receiptRejected',
            'receiptCancelled',
            'recentLoans',
            'topBooks',
            'recentActivity',
            'userGrowth',
            'loanGrowth'
        ));
    }
}