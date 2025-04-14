<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CashierController;


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