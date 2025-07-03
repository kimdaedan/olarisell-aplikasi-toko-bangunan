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


    Route::post('/products/add-stock', [ProductsController::class, 'addStock'])->name('products.addStock');


    // Rute untuk semua fungsionalitas Gudang (index, edit, update, destroy)
    Route::resource('gudang', GudangController::class)->only([
        'index', 'edit', 'update', 'destroy'

    ]);
// --- Expenses ---
    Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [ExpensesController::class, 'store'])->name('expenses.store');

    // Rute edit dan update sekarang bisa diakses semua user
    Route::get('/expenses/{expense}/edit', [ExpensesController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [ExpensesController::class, 'update'])->name('expenses.update');

    // Hanya superuser yang bisa menghapus pengeluaran
    Route::middleware(['is.superuser'])->group(function () {
        Route::delete('/expenses/{expense}', [ExpensesController::class, 'destroy'])->name('expenses.destroy');
    });
    // Rute untuk semua fungsionalitas Products, Expenses, dan Customers
    // Route::resource secara otomatis membuat rute untuk:
    // index, create, store, show, edit, update, dan destroy.
    Route::resource('products', ProductsController::class);
    Route::resource('expenses', ExpensesController::class);
    Route::resource('customers', CustomerController::class);


});
