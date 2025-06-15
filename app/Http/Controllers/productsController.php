<?php

namespace App\Http\Controllers;

use App\Models\Product; // Jika Anda masih ingin menggunakan model ini untuk validasi
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    protected $client;

    public function __construct()
    {
        // Buat instance Guzzle client
        $this->client = new Client();
    }

    // Menampilkan produk dari database Laravel (jika diperlukan)
    public function index()
    {
        // Ambil data produk dari database Laravel (jika diperlukan)
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

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Kirim data ke API Django
            try {
                $response = $this->client->post('http://127.0.0.1:8000/api/gudang/produk/', [
                    'multipart' => [
                        [
                            'name'     => 'nama',
                            'contents' => $request->nama,
                        ],
                        [
                            'name'     => 'jumlah',
                            'contents' => $request->jumlah,
                        ],
                        [
                            'name'     => 'harga',
                            'contents' => $request->harga,
                        ],
                        [
                            'name'     => 'gambar',
                            'contents' => fopen($request->file('gambar')->getRealPath(), 'r'),
                            'filename' => $request->file('gambar')->getClientOriginalName(),
                        ],
                    ],
                ]);

                // Cek status respons
                if ($response->getStatusCode() === 201) {
                    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan ke Django.');
                } else {
                    return redirect()->route('products.index')->with('error', 'Gagal menambahkan produk ke Django.');
                }
            } catch (\Exception $e) {
                Log::error('Gagal menghubungi API Django: ' . $e->getMessage());
                return redirect()->route('products.index')->with('error', 'Gagal menghubungi API Django: ' . $e->getMessage());
            }
        }
    }
}