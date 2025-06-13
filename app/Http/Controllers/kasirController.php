<?php

namespace App\Http\Controllers;

use App\Models\Product; // Model untuk produk
use App\Models\kasir; // Model untuk produk
use App\Models\Customer; // Model untuk customer
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Ambil produk berdasarkan pencarian
        if ($query) {
            $produk = Kasir::where('nama', 'LIKE', "%{$query}%")->get();
        } else {
            $produk = Kasir::all();
        }

        // Ambil semua customer untuk ditampilkan
        $customers = Customer::all(); // Gunakan model Customer

        return view('kasir.index', compact('produk', 'customers'));
    }
}