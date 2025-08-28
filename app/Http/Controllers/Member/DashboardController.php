<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\BookLoan;
use App\Models\BookLoanReceipt;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // === LOAN STATISTICS ===
        $totalLoans = BookLoan::whereHas('receipts', fn($q) => $q->where('user_id', $user->id))->count();

        $activeLoans = BookLoan::whereHas('receipts', fn($q) => $q->where('user_id', $user->id))
            ->where('status', 'borrowed')
            ->count();

        $returnedLoans = BookLoan::whereHas('receipts', fn($q) => $q->where('user_id', $user->id))
            ->where('status', 'returned')
            ->count();

        $totalSpent = BookLoanReceipt::where('user_id', $user->id)
            ->where('status', 'verified')
            ->sum('total_price');

        // === CURRENT ACTIVE LOANS ===
        $currentLoans = BookLoan::with('bookItem.book')
            ->whereHas('receipts', fn($q) => $q->where('user_id', $user->id))
            ->whereIn('status', ['borrowed', 'admin_validation'])
            ->get();

        // === RECENT RECEIPTS ===
        $recentReceipts = BookLoanReceipt::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // === SIMPLE NOTIFICATIONS (dummy example, bisa ambil dari tabel lain) ===
        $notifications = [
            [
                'message' => 'You have ' . $activeLoans . ' active loan(s)',
                'time' => now()->subMinutes(10),
            ],
            [
                'message' => 'Last receipt total Rp ' . number_format(optional($recentReceipts->first())->total_price ?? 0, 0, ',', '.'),
                'time' => now()->subHours(1),
            ]
        ];

        return view('member.dashboard.index', compact(
            'user',
            'totalLoans',
            'activeLoans',
            'returnedLoans',
            'totalSpent',
            'currentLoans',
            'recentReceipts',
            'notifications'
        ));
    }


}
