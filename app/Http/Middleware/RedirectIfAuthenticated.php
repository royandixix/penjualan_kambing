<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Redirect user jika sudah login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin' => redirect('/admin'),
                'user'  => redirect('/user'),
                default => redirect('/'),
            };
        }

        return $next($request);
    }
}
