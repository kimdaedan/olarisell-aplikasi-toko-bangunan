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
        $response = $this->client->get('http://127.0.0.1:8000/api/customers/');
        return json_decode($response->getBody()); // Mengembalikan objek
    }
    public function handleKasir(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'customer_id' => 'required|integer',
            'products' => 'required|array',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
        ]);
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

    // Memastikan ada produk sebelum mengakses id
    if (empty($request->products) || !isset($request->products[0]['id'])) {
        return response()->json(['message' => 'Produk tidak ditemukan.'], 400);
    }

    // Mempersiapkan data untuk dikirim ke API closing
    $closingData = [
        'customer_id' => $request->customer_id,
        'produk_id' => $request->products[0]['id'], // Ambil produk ID dari produk pertama
        'qty' => array_sum(array_column($request->products, 'quantity')), // Total qty
        'payment_method' => $request->payment_method,
        'total_transaksi' => $total,
        'tanggal' => now(), // Menambahkan tanggal saat ini
    ];

    // Kirim data ke API closing
    $response = $this->client->post('http://127.0.0.1:8000/api/kasir/closing/', [
        'json' => $closingData,
    ]);

    // Periksa respons dari API
    if ($response->getStatusCode() !== 201) {
        return response()->json(['message' => 'Gagal menutup transaksi di API closing.'], 500);
    }

    return response()->json(['message' => 'Transaksi berhasil ditutup!']);
}
    protected function getCustomerById($id)
    {
        $response = $this->client->get("http://127.0.0.1:8000/api/customers/{$id}/");
        return json_decode($response->getBody()); // Mengembalikan objek customer
    }
}