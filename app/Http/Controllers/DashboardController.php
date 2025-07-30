<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role_id == 2) {
            return redirect()->route('member.dashboard');
        }

        Auth::logout();
        return redirect()->route('login')->withErrors(['role' => 'Akses tidak diizinkan.']);
    }
}
