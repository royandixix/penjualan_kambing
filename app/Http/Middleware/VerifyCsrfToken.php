<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Daftar URI yang bebas dari CSRF.
     */
    protected $except = [
        // Tambahkan URI jika ingin dikecualikan
    ];
}
