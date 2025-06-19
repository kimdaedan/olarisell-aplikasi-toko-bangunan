<?php

namespace App\Http\Controllers;

use App\Models\Transaction; // Pastikan ini ada
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return view('gudang.index', compact('transactions'));
    }
}