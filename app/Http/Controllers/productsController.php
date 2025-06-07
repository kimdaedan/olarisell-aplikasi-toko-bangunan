<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan model Product diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk menggunakan HTTP client

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
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Membuat instance produk baru
        $product = new Product();
        $product->nama = $request->input('nama');
        $product->jumlah = $request->input('jumlah');
        $product->harga = $request->input('harga');

        // Menyimpan gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName(); // Menyimpan dengan timestamp
            $file->move(public_path('images'), $filename); // Pindahkan ke folder public/images
            $product->gambar = 'images/' . $filename; // Simpan path di database
        }

        // Simpan produk ke database
        $product->save();

        // Kirim data ke API Django
        $response = Http::post('http://localhost:8000/api/gudang/product', [
            'nama' => $product->nama,
            'jumlah' => $product->jumlah,
            'harga' => $product->harga,
            'gambar' => $product->gambar,
        ]);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan dan terkirim ke API.');
        } else {
            return redirect()->route('products.index')->with('error', 'Produk berhasil ditambahkan, tetapi gagal terkirim ke API.');
        }
    }
}