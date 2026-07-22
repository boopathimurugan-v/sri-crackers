<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect('/admin/login');
        }

        if (!\Illuminate\Support\Facades\Auth::user()->is_admin) {
            \Illuminate\Support\Facades\Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/admin/login')->withErrors(['email' => 'Access denied. Admins only.']);
        }

        return $next($request);
    }
}
