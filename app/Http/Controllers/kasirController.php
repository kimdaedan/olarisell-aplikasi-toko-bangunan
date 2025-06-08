<?php

namespace App\Http\Controllers;

use App\Models\Kasir; // Model untuk produk
use App\Models\KasirCustomer; // Model untuk customer
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $produk = Kasir::where('nama', 'LIKE', "%{$query}%")->get();
        } else {
            $produk = Kasir::all();
        }

        $customers = kasir::all(); // Ambil semua customer untuk ditampilkan

        return view('kasir.index', compact('produk', 'customers'));
    }
}