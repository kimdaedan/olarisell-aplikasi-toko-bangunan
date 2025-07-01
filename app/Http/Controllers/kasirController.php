<?php

namespace App\Http\Controllers;

use App\Models\Product; // Model untuk produk
use App\Models\kasir; // Model untuk produk
use App\Models\Customer; // Model untuk customer
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Ambil produk berdasarkan pencarian
        if ($query) {
            $produk = Kasir::where('nama', 'LIKE', "%{$query}%")->get();
        } else {
            $produk = Kasir::all();
        }

        // Ambil semua customer untuk ditampilkan
        $customers = Customer::all(); // Gunakan model Customer

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
