<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;

class gudangController extends Controller
{
    public function index()
    {
        // Ambil data transaksi beserta relasi kasirCustomer
        $transactions = TransaksiDetail::with('kasirCustomer')->get();

        return view('gudang.index', compact('transactions'));
    }
}
