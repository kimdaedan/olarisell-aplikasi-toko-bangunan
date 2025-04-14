<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class kasirController extends Controller
{
    public function index()
    {
        return view('kasir');
    }

    // Anda dapat menambahkan metode lain untuk menangani logika tambah item, dll.
}