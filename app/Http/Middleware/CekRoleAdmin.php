<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRoleAdmin
{
    /**
     * Tangani request masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('pesan_error', 'Silakan login terlebih dahulu.');
        }

        if (auth()->user()->role !== 'admin') {
            return redirect()->route('beranda')->with('pesan_error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
