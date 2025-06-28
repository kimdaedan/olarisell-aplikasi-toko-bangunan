<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class GudangController extends Controller
{
    protected $client;

    public function __construct()
    {
        // Inisialisasi Guzzle Client dengan base URI ke API Django Anda
        $this->client = new Client(['base_uri' => 'http://127.0.0.1:8000/api/']);
    }

    /**
     * Menampilkan daftar riwayat transaksi dengan paginasi.
     */
    public function index(Request $request)
    {
        try {
            $currentPage = $request->input('page', 1);

            // Kirim permintaan ke API dengan parameter 'page'
            $response = $this->client->get('kasir/closing/', [
                'query' => ['page' => $currentPage]
            ]);

            $data = json_decode($response->getBody()->getContents());

            // Buat Paginator Laravel secara manual
            $transactions = new LengthAwarePaginator(
                $data->results,
                $data->count,
                25, // Jumlah item per halaman, sesuaikan jika perlu
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            $grandTotal = $data->grand_total ?? 0;

        } catch (\Exception $e) {
            Log::error('Gagal mengambil data transaksi dari Django: ' . $e->getMessage());
            // Jika gagal, set default value agar halaman tidak error
            $transactions = new LengthAwarePaginator([], 0, 25);
            $grandTotal = 0;
            return back()->with('error', 'Gagal menghubungi API Django.');
        }

        return view('gudang.index', compact('transactions', 'grandTotal'));
    }

    /**
     * Menampilkan form untuk mengedit metode pembayaran.
     */
    public function edit($id)
    {
        $transaction = null;
        try {
            $response = $this->client->get("kasir/closing/{$id}/");
            $transaction = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error("Gagal mengambil transaksi (ID: {$id}): " . $e->getMessage());
            return redirect()->route('gudang.index')->with('error', 'Transaksi tidak ditemukan di server.');
        }
        return view('gudang.edit', compact('transaction'));
    }

    /**
     * Mengupdate metode pembayaran di API Django.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['payment_method' => 'required|string']);

        try {
            $this->client->put("kasir/closing/{$id}/", [
                'json' => ['payment_method' => $request->payment_method]
            ]);
            return redirect()->route('gudang.index')->with('success', 'Metode pembayaran berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error("Gagal update transaksi (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate data di server.');
        }
    }

    /**
     * Menghapus transaksi dari API Django.
     * Ini adalah metode yang hilang yang menyebabkan error.
     */
    public function destroy($id)
    {
        try {
            // Mengirim permintaan DELETE ke endpoint detail di Django
            $this->client->delete("kasir/closing/{$id}/");
            return redirect()->route('gudang.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus transaksi (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data dari server.');
        }
    }
}
