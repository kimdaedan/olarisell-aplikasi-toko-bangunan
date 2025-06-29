<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureApiTokenIsValid
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
        // 1. Periksa apakah session 'api_token' ada dan tidak kosong.
        // Ini adalah tanda bahwa pengguna sudah berhasil login.
        if (!session()->has('api_token')) {
            // 2. Jika tidak ada, alihkan pengguna ke halaman login.
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // 3. Jika token ada, izinkan permintaan untuk melanjutkan ke halaman tujuan.
        return $next($request);
    }
}
