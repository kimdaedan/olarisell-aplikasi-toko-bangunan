<?php

namespace App\Http\Controllers;

use App\Models\Product; // Model untuk produk
use App\Models\Customer; // Model untuk customer
use Illuminate\Http\Request;
use GuzzleHttp\Client; // Pastikan untuk menggunakan GuzzleHttp

class KasirController extends Controller
{
    protected $client;

    public function __construct()
    {
        // Buat instance Guzzle client
        $this->client = new Client();
    }

    public function index(Request $request)
    {
        $query = $request->input('search');

        // Ambil produk dari API Django
        $response = $this->client->get('http://127.0.0.1:8000/api/gudang/produk/');
        $produk = json_decode($response->getBody());

        // Filter produk berdasarkan pencarian jika ada
        if ($query) {
            $produk = array_filter($produk, function($item) use ($query) {
                return stripos($item->nama, $query) !== false; // Pencarian tidak case-sensitive
            });
        }

        // Ambil semua customer dari API
        $customers = $this->getCustomers(); // Mengambil data customer dari API

        return view('kasir.index', compact('produk', 'customers'));
    }

    protected function getCustomers()
    {
        // Ambil customer dari API
    $response = $this->client->get('http://127.0.0.1:8000/api/kasir/customer/');
    return json_decode($response->getBody()); // Mengembalikan objek
}

    public function closeTransaction(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|date',
        ]);

        // Simpan transaksi ke gudang
        foreach ($request->products as $product) {
            // Kirim data ke API Django untuk memindahkan produk ke gudang
            $this->client->post('http://127.0.0.1:8000/api/gudang/produk/', [
                'json' => [
                    'nama' => $product['name'],
                    'jumlah' => $product['quantity'],
                    'harga' => $product['price'],
                    'customer_id' => $request->customer_id,
                    'payment_method' => $request->payment_method,
                    'payment_date' => $request->payment_date,
                ]
            ]);
        }

        return response()->json(['success' => 'Transaksi berhasil dipindahkan.']);
    }
}