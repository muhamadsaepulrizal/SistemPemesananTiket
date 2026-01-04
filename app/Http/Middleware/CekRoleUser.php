<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRoleUser
{
    /**
     * Tangani request masuk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('pesan_error', 'Silakan login terlebih dahulu.');
        }

        if (auth()->user()->role !== 'user') {
            return redirect()->route('admin.dashboard')->with('pesan_error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
