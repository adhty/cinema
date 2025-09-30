<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // kalau user belum login → langsung balikin ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // kalau user login tapi bukan admin → forbidden
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
