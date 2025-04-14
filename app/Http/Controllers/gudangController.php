<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class gudangController extends Controller
{
    public function index()
    {
        // Ambil data dari model jika diperlukan
        return view('gudang');
    }
}