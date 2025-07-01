<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client(['base_uri' => 'http://127.0.0.1:8000/api/']);

        try {
            // Ambil semua parameter filter dari request
            $queryParams = [
                'page' => $request->input('page', 1),
                'customer_name' => $request->input('search'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ];

            // Kirim permintaan ke API dengan parameter query
            // array_filter akan menghapus parameter yang kosong (null)
            $response = $client->get('kasir/closing/', [
                'query' => array_filter($queryParams)
            ]);

            $data = json_decode($response->getBody()->getContents());

            $transactions = new LengthAwarePaginator(
                $data->results,
                $data->count,
                25, // Jumlah item per halaman
                $queryParams['page'],
                // 'path' dan 'query' penting agar link paginasi tetap membawa parameter filter
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

    // ... (metode edit, update, destroy Anda tetap sama) ...
}
