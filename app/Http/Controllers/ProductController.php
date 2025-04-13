<?php

namespace App\Http\Controllers;

use App\Models\Product; // Import model Product
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua produk dari database
        $products = Product::all();
        return view('products.index', compact('products')); // Kembalikan tampilan daftar produk
    }

    public function create()
    {
        return view('products.create'); // Kembalikan tampilan formulir tambah produk
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // Buat produk baru dengan data yang sudah tervalidasi
        Product::create($validatedData);

        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}