<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ubah dari nullable ke required
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Simpan file ke storage/app/public/images
            $path = $request->file('gambar')->store('images', 'public');

            // Buat record produk
            $product = Product::create([
                'nama' => $request->nama,
                'jumlah' => $request->jumlah,
                'harga' => $request->harga,
                'gambar' => $path // Simpan path relatif
            ]);
        }

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }
}