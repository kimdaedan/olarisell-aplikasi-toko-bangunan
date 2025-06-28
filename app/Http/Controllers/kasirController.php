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
}
