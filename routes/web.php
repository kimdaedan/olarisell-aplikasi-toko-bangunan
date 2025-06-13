<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\kasirController;
use App\Http\Controllers\gudangController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\expensesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;




// Rute untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk resource products


// Rute untuk resource sales
Route::resource('sales', SaleController::class);

// Rute untuk tampilan kasir
Route::get('/kasir', function () {
    return view('kasir'); // Mengembalikan tampilan cashier
});

//rite untuk tampilan gudang
Route::get('/gudang', function () {
    return view('gudang'); // Mengembalikan tampilan warehouse
});


//untuk kasir
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::get('/kasir/cari', [KasirController::class, 'cariProduk'])->name('kasir.cari');
Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');

// untuk gudang
Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');

// untuk products
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');

Route::get('/products/{id}', [ProductsController::class, 'show'])->name('product.show');

// untuk expenses


Route::get('/expenses', [expensesController::class, 'index'])->name('expenses.index');
Route::post('/expenses', [expensesController::class, 'store']);

// untuk customer
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');


//rite untuk tampilan landing page
Route::get('/landing', function () {
    return view('landing'); // Mengembalikan tampilan warehouse
});

//untuk loginnya

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



//landing juga
Route::get('/', function () {
    return view('landing');
})->name('landing');