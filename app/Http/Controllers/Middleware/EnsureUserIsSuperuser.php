<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsSuperuser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sudah login dan memiliki status superuser.
        // Ganti 'is_superuser' dengan nama kolom yang sesuai di tabel users Anda jika berbeda.
        if (!Auth::check() || !Auth::user()->is_superuser) {
            // Jika bukan superuser, kembalikan ke halaman sebelumnya dengan pesan error.
            return back()->with('error', 'Anda tidak memiliki hak akses untuk melakukan tindakan ini.');
        }

        // Jika superuser, izinkan untuk melanjutkan.
        return $next($request);
    }
}
