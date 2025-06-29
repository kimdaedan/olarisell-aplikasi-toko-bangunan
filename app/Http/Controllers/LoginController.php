<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Menggunakan sistem Auth bawaan Laravel
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login menggunakan database Laravel dan Bcrypt.
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Mencoba untuk melakukan otentikasi pengguna
        // Auth::attempt() secara otomatis akan melakukan hash pada input password
        // dan membandingkannya dengan hash Bcrypt di database.
        if (Auth::attempt($credentials)) {
            // Jika berhasil, buat sesi baru yang aman
            $request->session()->regenerate();

            // Arahkan ke halaman utama yang terproteksi
            return redirect()->intended('/gudang');
        }

        // 3. Jika otentikasi gagal, lempar kembali ke form login dengan pesan error
        throw ValidationException::withMessages([
            'username' => 'Username atau password yang diberikan salah.',
        ]);
    }

    /**
     * Menangani proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
