<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class GudangController extends Controller
{
    /**
     * Guzzle HTTP Client instance.
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Base URI untuk API endpoint transaksi di Django.
     * @var string
     */
    protected $apiEndpoint = 'kasir/closing/';

    public function __construct()
    {
        // Inisialisasi Guzzle Client dengan base URI ke API Django Anda
        $this->client = new Client(['base_uri' => 'http://127.0.0.1:8000/api/']);
    }

    /**
     * Menampilkan daftar riwayat transaksi dengan filter dan paginasi.
     */
    public function index(Request $request)
    {
        try {
            // Mengambil semua parameter filter dari request
            $queryParams = [
                'page' => $request->input('page', 1),
                'customer_name' => $request->input('search'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ];

            // Menghapus parameter yang kosong agar tidak dikirim ke API
            $filteredParams = array_filter($queryParams);

            // Mengirim permintaan ke API dengan parameter query
            $response = $this->client->get($this->apiEndpoint, [
                'query' => $filteredParams
            ]);

            $data = json_decode($response->getBody()->getContents());

            // Membuat Paginator Laravel secara manual dari data API
            $transactions = new LengthAwarePaginator(
                $data->results ?? [], // Data untuk halaman ini
                $data->count ?? 0,    // Jumlah total semua data
                25,                   // Jumlah item per halaman (sesuaikan dengan Django)
                $queryParams['page'], // Halaman saat ini
                ['path' => $request->url(), 'query' => $request->query()]
            );

            $grandTotal = $data->grand_total ?? 0;

        } catch (\Exception $e) {
            Log::error('Gagal mengambil data transaksi dari Django: ' . $e->getMessage());
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
        try {
            // Mengambil data dari API
            $response = $this->client->get($this->apiEndpoint . $id . '/');
            $transaction = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error("Gagal mengambil transaksi (ID: {$id}): " . $e->getMessage());
            return redirect()->route('gudang.index')->with('error', 'Transaksi tidak ditemukan di server.');
        }
        // Menampilkan view dengan data yang sudah didapat
        return view('gudang.edit', compact('transaction'));
    }

    /**
     * Mengupdate metode pembayaran di API Django.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['payment_method' => 'required|string']);

        try {
            // Mengirim permintaan PUT ke API Django
            $response = $this->client->put($this->apiEndpoint . $id . '/', [
                'json' => ['payment_method' => $request->payment_method]
            ]);

            return redirect()->route('gudang.index')->with('success', 'Metode pembayaran berhasil diupdate.');

        } catch (\Exception $e) {
            // --- DEBUGGING ---
            // Jika terjadi error saat mengirim data, baris ini akan menghentikan program
            // dan menampilkan pesan error yang spesifik dari Guzzle.
            //dd($e->getMessage());

            Log::error("Gagal update transaksi (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate data di server.');
        }
    }

    /**
     * Menghapus transaksi dari API Django.
     */
    public function destroy($id)
    {
        try {
            // Mengirim permintaan DELETE ke API Django
            $this->client->delete($this->apiEndpoint . $id . '/');
            return redirect()->route('gudang.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus transaksi (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data dari server.');
        }
    }


}
