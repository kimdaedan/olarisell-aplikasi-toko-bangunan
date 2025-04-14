<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class productsController extends Controller
{
    public function index()
    {
        return view('products');
    }

    // Anda dapat menambahkan metode lain untuk menangani logika tambah item, dll.
}