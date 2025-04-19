<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\kasirController;
use App\Http\Controllers\gudangController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\expensesController;



// Rute untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk resource products
Route::resource('products', ProductController::class);

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

//rite untuk tampilan gudang
Route::get('/products', function () {
    return view('products'); // Mengembalikan tampilan warehouse
});

// untuk kasir
Route::get('/kasir', [kasirController::class, 'index']);

// untuk gudang
Route::get('/gudang', [gudangController::class, 'index']);

// untuk products
Route::get('/products', [productsController::class, 'index']);

// untuk expenses
use App\Http\Controllers\ExpenseController;

Route::get('/expenses', [expensesController::class, 'index'])->name('expenses.index');
Route::post('/expenses', [expensesController::class, 'store']);
