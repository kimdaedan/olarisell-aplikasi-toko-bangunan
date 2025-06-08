<?php

namespace App\Http\Controllers;

use App\Models\Kasir; // Pastikan mengimpor model Kasir
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        if ($query) {
            $produk = Kasir::where('nama', 'LIKE', "%{$query}%")->get(); // Mengambil produk yang cocok
        } else {
            $produk = Kasir::all(); // Ambil semua produk jika tidak ada pencarian
        }

        return view('kasir.index', compact('produk'));
    }
}