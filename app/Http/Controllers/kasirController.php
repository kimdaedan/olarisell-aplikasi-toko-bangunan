<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail; // Model untuk menyimpan detail transaksi
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
        $customers = $this->getCustomers();

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
            'customer_id' => 'required|integer|exists:kasir_customer,id', // Validasi ID customer
            'products' => 'required|array',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|date',
        ]);

        // Hitung total pembayaran dari produk yang dipilih
        $total = 0;
        foreach ($request->products as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        // Simpan detail transaksi di tabel transaksi_detail
        foreach ($request->products as $product) {
            $detail = new TransaksiDetail();
            $detail->customer_id = $request->customer_id;
            $detail->product_name = $product['name'];
            $detail->quantity = $product['quantity'];
            $detail->price = $product['price'];
            $detail->total = $product['price'] * $product['quantity'];
            $detail->payment_method = $request->payment_method;
            $detail->payment_date = $request->payment_date;
            $detail->save();
        }

        return response()->json(['message' => 'Transaksi berhasil ditutup!']);
    }

    protected function getCustomerById($id)
    {
        $response = $this->client->get("http://127.0.0.1:8000/api/kasir/customer/{$id}/");
        return json_decode($response->getBody()); // Mengembalikan objek customer
    }
}