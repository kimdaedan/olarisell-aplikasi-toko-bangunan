<?php

namespace App\Http\Controllers;

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

    public function index(Request $request)
    {
        // Ambil data produk dari API Django
        $response = $this->client->get('http://127.0.0.1:8000/api/gudang/produk/');
        $products = json_decode($response->getBody());

        // Jika ada parameter pencarian
    if ($request->has('search')) {
        $search = $request->input('search');
        $products = array_filter($products, function($product) use ($search) {
            return stripos($product->nama, $search) !== false; // Mencari nama produk yang mengandung string pencarian
        });
    }

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

        // Kirim data ke API Django
        try {
            $response = $this->client->post('http://127.0.0.1:8000/api/gudang/produk/', [
                'multipart' => [
                    [
                        'name' => 'nama',
                        'contents' => $request->nama,
                    ],
                    [
                        'name' => 'jumlah',
                        'contents' => $request->jumlah,
                    ],
                    [
                        'name' => 'harga',
                        'contents' => $request->harga,
                    ],
                    [
                        'name' => 'gambar',
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

    public function edit($id)
    {
        // Ambil data produk dari API Django untuk diedit
        try {
            $response = $this->client->get('http://127.0.0.1:8000/api/gudang/produk/' . $id . '/');
            $product = json_decode($response->getBody());

            return view('products.edit', compact('product'));
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi API Django saat mengambil data produk: ' . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'Gagal mengambil data produk.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input untuk produk
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:0',
        ]);

        try {
            $data = [
                'nama' => $request->nama,
                'harga' => $request->harga,
                'jumlah' => $request->jumlah,
            ];

            // Update gambar jika ada
            if ($request->hasFile('gambar')) {
                $data['gambar'] = fopen($request->file('gambar')->getRealPath(), 'r');
                $filename = $request->file('gambar')->getClientOriginalName();
            }

            $multipartData = [
                [
                    'name' => 'nama',
                    'contents' => $data['nama'],
                ],
                [
                    'name' => 'harga',
                    'contents' => $data['harga'],
                ],
                [
                    'name' => 'jumlah',
                    'contents' => $data['jumlah'],
                ],
            ];

            // Hanya tambahkan gambar jika ada
            if ($request->hasFile('gambar')) {
                $multipartData[] = [
                    'name' => 'gambar',
                    'contents' => $data['gambar'],
                    'filename' => $filename,
                ];
            }

            $response = $this->client->put('http://127.0.0.1:8000/api/gudang/produk/' . $id . '/', [
                'multipart' => $multipartData,
            ]);

            return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi API Django saat memperbarui produk: ' . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'Gagal menghubungi API Django.');
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->client->delete('http://127.0.0.1:8000/api/gudang/produk/' . $id . '/');

            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi API Django saat menghapus produk: ' . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'Gagal menghubungi API Django.');
        }
    }
}