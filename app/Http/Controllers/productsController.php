<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client; // Import Guzzle client
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function index()
{
    $client = new Client();
    try {
        $response = $client->get('http://127.0.0.1:8000/api/gudang/produk/');
        $products = json_decode($response->getBody(), true); // Mengubah respons JSON ke array
    } catch (RequestException $e) {
        return redirect()->back()->with('error', 'Gagal mengambil data produk: ' . $e->getMessage());
    }

    return view('products.index', compact('products'));
}
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Buat instance Guzzle client
        $client = new Client();

        try {
            // Handle file upload
            if ($request->hasFile('gambar')) {
                // Baca file gambar dan encode ke base64
                $imagePath = $request->file('gambar')->getRealPath();
                $imageData = base64_encode(file_get_contents($imagePath));

                // Kirim data produk ke Django
                $response = $client->post('http://127.0.0.1:8000/api/gudang/produk/', [
                    'json' => [
                        'nama' => $request->nama,
                        'jumlah' => $request->jumlah,
                        'harga' => $request->harga,
                        'gambar' => $imageData, // Kirim gambar sebagai base64
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                ]);
                // Tambahkan log untuk melihat status respons
            Log::info('Response: ', ['status' => $response->getStatusCode(), 'body' => $response->getBody()->getContents()]);

                // Cek status response
                if ($response->getStatusCode() === 201) {
                    return redirect()->route('products.index')
                                     ->with('success', 'Produk berhasil ditambahkan ke Django.');
                } else {
                    return redirect()->route('products.index')
                                     ->with('error', 'Gagal menambahkan produk ke Django. Status: ' . $response->getStatusCode());
                }
            }
        } catch (RequestException $e) {
            // Menangani kesalahan saat mengirim ke Django
            return redirect()->route('products.index')
                             ->with('error', 'Gagal menghubungi Django: ' . $e->getMessage());
        }
    }
}