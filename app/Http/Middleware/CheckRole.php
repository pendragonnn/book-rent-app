<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if ($user->role_id == 1) {
            return $next($request);
        }

        if ($role === 'member' && $user->role_id == 2) {
            return $next($request);
        }

        return response()->view('errors.unauthorized');
    }
}
