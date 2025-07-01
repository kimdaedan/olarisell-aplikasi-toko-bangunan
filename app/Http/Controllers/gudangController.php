<?php

namespace App\Http\Controllers;

use App\Models\GudangProduk; // Pastikan mengimpor model jika diperlukan
use App\Models\Kasir;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        $produk = Kasir::all(); // Ambil data produk dari tabel gudang_produk
        return view('gudang.index', compact('produk')); // Pastikan ada view gudang.index
    }
}