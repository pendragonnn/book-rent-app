<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\BookLoan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalLoans = BookLoan::where('user_id', $user->id)->count();
        $borrowedCount = BookLoan::where('user_id', $user->id)->where('status', 'borrowed')->count();
        $returnedCount = BookLoan::where('user_id', $user->id)->where('status', 'returned')->count();
        $paymentPending = BookLoan::where('user_id', $user->id)->where('status', 'payment_pending')->count();
        $adminValidation = BookLoan::where('user_id', $user->id)->where('status', 'admin_validation')->count();
        $cancelledCount = BookLoan::where('user_id', $user->id)->where('status', 'cancelled')->count();

        $recentLoans = BookLoan::with('bookItem.book')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('member.dashboard.index', compact(
            'user',
            'totalLoans',
            'borrowedCount',
            'returnedCount',
            'cancelledCount',
            'recentLoans',
            'adminValidation',
            'paymentPending',
        ));
    }
}
