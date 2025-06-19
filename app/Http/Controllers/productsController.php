<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan model Product ada
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    // Menampilkan produk dari database Laravel
    public function index()
    {
        // Ambil data produk dari database Laravel
        $products = Product::all(); // Ambil semua data produk

        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input untuk produk
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan produk di database Laravel
        $product = Product::create([
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'gambar' => $request->file('gambar')->store('public/products'),
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }
}