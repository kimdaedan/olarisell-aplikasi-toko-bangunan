<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class KasirController extends Controller
{
    /**
     * Menampilkan halaman kasir dengan data produk dan customer dari API.
     */
    public function index()
    {
        $client = new Client();
        $produk = [];
        $customers = [];

        try {
            // Ganti URL ini sesuai dengan endpoint produk Anda di Django
            $produkResponse = $client->get('http://127.0.0.1:8000/api/gudang/produk/');
            $produk = json_decode($produkResponse->getBody()->getContents());

            // Ganti URL ini sesuai dengan endpoint customer Anda di Django
            $customerResponse = $client->get('http://127.0.0.1:8000/api/customers/');
            $customers = json_decode($customerResponse->getBody()->getContents());

        } catch (\Exception $e) {
            Log::error('Gagal mengambil data awal kasir dari Django: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat data dari server. Pastikan server API Django berjalan.');
        }

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