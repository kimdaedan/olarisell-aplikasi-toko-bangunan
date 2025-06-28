<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GudangController extends Controller
{
    /**
     * Menampilkan daftar transaksi dari API Django.
     */
    public function index()
    {
        $client = new Client();
        $transactions = []; // Default value jika API gagal

        try {
            // 1. Ambil data dari API Django menggunakan URL yang benar
            // URL yang benar adalah '/api/kasir/closing/' sesuai konfigurasi urls.py di Django.
            $response = $client->get('http://127.0.0.1:8000/api/kasir/closing/');

            // 2. Decode JSON dan langsung gunakan
            $transactions = json_decode($response->getBody()->getContents());

        } catch (\Exception $e) {
            // Tangani error jika API tidak bisa dihubungi atau ada masalah lain
            Log::error('Gagal menghubungi API Django saat mengambil data transaksi: ' . $e->getMessage());
            // Kembalikan ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Gagal terhubung ke server data. Silakan coba lagi nanti.');
        }

        // 3. Kirim data yang sudah lengkap ke view
        return view('gudang.index', compact('transactions'));
    }
}
