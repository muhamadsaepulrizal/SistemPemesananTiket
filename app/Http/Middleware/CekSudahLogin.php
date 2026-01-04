<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekSudahLogin
{
    /**
     * Tangani request masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('pesan_error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
