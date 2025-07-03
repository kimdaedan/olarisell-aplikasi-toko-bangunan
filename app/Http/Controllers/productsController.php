<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    /**
     * Guzzle HTTP Client instance.
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * API endpoint for products in Django.
     * @var string
     */
    protected $apiEndpoint = 'gudang/produk/'; // Make sure this URL is correct

    public function __construct()
    {
        // Initialize the Guzzle Client for all methods in this controller
        $this->client = new Client(['base_uri' => 'http://127.0.0.1:8000/api/']);
    }

    /**
     * Display a listing of the products, with search functionality.
     */
    public function index(Request $request)
    {
        try {
            // Delegate searching to the Django API
            $queryParams = [
                'search' => $request->input('search')
            ];

            $response = $this->client->get($this->apiEndpoint, [
                'query' => array_filter($queryParams)
            ]);

            $products = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error('Failed to fetch products from Django: ' . $e->getMessage());
            $products = []; // Set products to an empty array on failure
            return back()->with('error', 'Failed to connect to the API server.');
        }

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // This method just shows the view with the form
        // The form is on the index page, so we can redirect there
        return redirect()->route('products.index');
    }

    /**
     * Store a newly created product via the Django API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $multipart = [
            ['name' => 'nama', 'contents' => $request->nama],
            ['name' => 'jumlah', 'contents' => $request->jumlah],
            ['name' => 'harga', 'contents' => $request->harga],
        ];

        if ($request->hasFile('gambar')) {
            $multipart[] = [
                'name' => 'gambar',
                'contents' => fopen($request->file('gambar')->getRealPath(), 'r'),
                'filename' => $request->file('gambar')->getClientOriginalName(),
            ];
        }

        try {
            $this->client->post($this->apiEndpoint, [
                'multipart' => $multipart
            ]);
            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Failed to create product via API: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan produk ke server.');
        }
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        try {
            $response = $this->client->get($this->apiEndpoint . $id . '/');
            $product = json_decode($response->getBody()->getContents());
            return view('products.edit', compact('product'));
        } catch (\Exception $e) {
            Log::error("Failed to fetch product (ID: {$id}): " . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Update the specified product via the Django API.
     * NOTE: Standard HTML forms do not support PUT with multipart/form-data.
     * We send a POST request and rely on the @method('PUT') directive in the form,
     * which Laravel uses to spoof the method. Django REST Framework handles this.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'jumlah' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // We must send as a POST request to handle file uploads with a spoofed PUT method.
        // This is a common pattern for updating resources with files.
        try {
            $multipart = [
                ['name' => 'nama', 'contents' => $request->nama],
                ['name' => 'harga', 'contents' => $request->harga],
                ['name' => 'jumlah', 'contents' => $request->jumlah],
            ];

            if ($request->hasFile('gambar')) {
                $multipart[] = [
                    'name' => 'gambar',
                    'contents' => fopen($request->file('gambar')->getRealPath(), 'r'),
                    'filename' => $request->file('gambar')->getClientOriginalName(),
                ];
            }

            // Send as POST, but Django will treat it as PUT because of the form's @method('PUT')
            $this->client->post($this->apiEndpoint . $id . '/', [
                'multipart' => $multipart,
            ]);

            return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Failed to update product (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui produk.');
        }
    }

    /**
     * Remove the specified product from the Django API.
     */
    public function destroy($id)
    {
        try {
            $this->client->delete($this->apiEndpoint . $id . '/');
            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Failed to delete product (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus produk.');
        }
    }

    /**
     * Handle the request to add stock to a product.
     */
    public function addStock(Request $request)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $validated['product_id'];
        $quantity = $validated['quantity'];

        try {
            // 2. Kirim permintaan POST ke API Django
            // URL-nya adalah .../produk/{id}/add_stock/
            $this->client->post("gudang/produk/{$productId}/add_stock/", [
                'json' => [
                    'quantity' => $quantity
                ]
            ]);

            // 3. Jika berhasil, kembali dengan pesan sukses
            return redirect()->route('products.index')->with('success', 'Stok berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambah stok via API: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghubungi server untuk menambah stok.');
        }
    }
}
