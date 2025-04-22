<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan model Product diimpor
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    // Metode untuk menampilkan daftar produk
    public function index()
    {
        $products = Product::all(); // Ambil semua produk dari database
        return view('products.index', compact('products')); // Kirim data ke tampilan
    }

    // Metode untuk menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
            'product_name' => 'required|string|max:255',
            'current_stock' => 'required|integer|min:0',
        ]);

        // Mengunggah gambar
        $imageName = time() . '.' . $request->product_image->extension();
        $request->product_image->move(public_path('images'), $imageName);

        Product::create([
            'product_name' => $request->product_name,
            'current_stock' => $request->current_stock,
            'product_image' => $imageName, // Simpan nama gambar
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }
}