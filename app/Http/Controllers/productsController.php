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
    // Validasi data
    $request->validate([
        'product_name' => 'required|string|max:255',
        'current_stock' => 'required|integer',
        'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
    ]);

    // Membuat instance produk baru
    $product = new Product();
    $product->product_name = $request->input('product_name');
    $product->current_stock = $request->input('current_stock');

    // Menyimpan gambar
    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        $filename = time() . '_' . $file->getClientOriginalName(); // Menyimpan dengan timestamp
        $file->move(public_path('images'), $filename); // Pindahkan ke folder public/images
        $product->product_image = 'images/' . $filename; // Simpan path di database
    }

    // Simpan produk ke database
    $product->save();

    // Redirect atau kembali ke halaman sebelumnya
    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
}
}