<?php

namespace App\Http\Controllers;

use App\Models\Product; // Model untuk produk
use App\Models\Customer; // Model untuk customer
use App\Models\KasirTransaksi; // Model untuk menyimpan transaksi
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

    // Ambil nama customer dari API
    $customer = $this->getCustomerById($request->customer_id);

    // Simpan transaksi ke database
    foreach ($request->products as $product) {
        KasirTransaksi::create([
            'customer_id' => $request->customer_id,
            'customer_name' => $customer->name, // Simpan nama customer
            'product_name' => $product['name'],
            'quantity' => $product['quantity'],
            'price' => $product['price'],
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
        ]);
    }

    return response()->json(['success' => 'Transaksi berhasil disimpan.']);
}

protected function getCustomerById($id)
{
    $response = $this->client->get("http://127.0.0.1:8000/api/kasir/customer/{$id}/");
    return json_decode($response->getBody()); // Mengembalikan objek customer
}
}