<?php

use Illuminate\Support\Facades\Route;
// Import semua controller yang akan digunakan dengan nama yang konsisten
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Rute Aplikasi Web
|--------------------------------------------------------------------------
*/

//================================================
// RUTE PUBLIK (Dapat diakses tanpa perlu login)
//================================================

// Rute untuk halaman utama/landing page
Route::get('/', function () {
    return view('landing');
})->name('welcome');

// Rute untuk menampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Rute untuk memproses data login yang dikirim dari form
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    //rite untuk tampilan landing page
Route::get('/landing', function () {
    return view('landing'); // Mengembalikan tampilan warehouse
});


//================================================
// RUTE TERPROTEKSI (Harus login untuk mengakses)
//================================================

// Semua rute di dalam grup ini akan dijaga oleh middleware 'auth' bawaan Laravel.
// Siapapun yang belum login akan otomatis dialihkan ke halaman 'login'.
Route::middleware(['auth'])->group(function () {

    // Rute untuk logout (hanya bisa diakses jika sudah login)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    // Rute untuk halaman Kasir (hanya menampilkan halaman)
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');

    // Rute untuk semua fungsionalitas Gudang (index, edit, update, destroy)
    Route::resource('gudang', GudangController::class)->only([
        'index', 'edit', 'update', 'destroy'
    ]);

    // Rute untuk semua fungsionalitas Products, Expenses, dan Customers
    // Route::resource secara otomatis membuat rute untuk:
    // index, create, store, show, edit, update, dan destroy.
    Route::resource('products', ProductsController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('customers', CustomerController::class);

});
