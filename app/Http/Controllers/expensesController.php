<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpensesController extends Controller
{
    /**
     * Guzzle HTTP Client instance.
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Base URI untuk API endpoint pengeluaran di Django.
     * @var string
     */
    protected $apiEndpoint = 'gudang/pengeluaran/'; // Sesuai permintaan Anda

    public function __construct()
    {
        // Inisialisasi Guzzle Client dengan base URI ke API Django Anda
        $this->client = new Client(['base_uri' => 'http://127.0.0.1:8000/api/']);
    }

    /**
     * Menampilkan daftar pengeluaran dengan filter dan paginasi dari API.
     */
    public function index(Request $request)
    {
        try {
            // Mengambil semua parameter filter dari request
            $queryParams = [
                'page' => $request->input('page', 1),
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
            $expenses = new LengthAwarePaginator(
                $data->results ?? [], // Data untuk halaman ini
                $data->count ?? 0,    // Jumlah total semua data
                25,                   // Jumlah item per halaman (sesuaikan dengan Django)
                $queryParams['page'], // Halaman saat ini
                ['path' => $request->url(), 'query' => $request->query()]
            );

            $grandTotal = $data->grand_total ?? 0;

        } catch (\Exception $e) {
            Log::error('Gagal mengambil data pengeluaran dari Django: ' . $e->getMessage());
            $expenses = new LengthAwarePaginator([], 0, 25);
            $grandTotal = 0;
            return back()->with('error', 'Gagal menghubungi API Django. Pastikan server API berjalan.');
        }

        return view('expenses.index', compact('expenses', 'grandTotal'));
    }

    /**
     * Menyimpan data pengeluaran baru ke API Django.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        try {
            $this->client->post($this->apiEndpoint, [
                'json' => [
                    'date' => $request->date,
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'payment_status' => $request->status,
                ]
            ]);
            return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambah pengeluaran ke Django: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan data ke server.');
        }
    }

    /**
     * Menampilkan form untuk mengedit pengeluaran.
     */
    public function edit($id)
    {
        try {
            // Mengambil satu data dari API berdasarkan ID
            $response = $this->client->get($this->apiEndpoint . $id . '/');
            $expense = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error("Gagal mengambil data pengeluaran (ID: {$id}): " . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Data pengeluaran tidak ditemukan.');
        }
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Mengupdate data pengeluaran di API Django.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        try {
            $this->client->put($this->apiEndpoint . $id . '/', [
                'json' => [
                    'date' => $request->date,
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'payment_status' => $request->status,
                ]
            ]);
            return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui pengeluaran (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Menghapus data pengeluaran dari API Django.
     */
    public function destroy($id)
    {
        try {
            $this->client->delete($this->apiEndpoint . $id . '/');
            return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus pengeluaran (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Mengekspor data pengeluaran ke PDF.
     */
    public function exportPdf(Request $request)
    {
        try {
             $queryParams = [
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ];

            // Ambil semua data (tanpa paginasi) dari API untuk di-render ke PDF
            $response = $this->client->get($this->apiEndpoint, [
                'query' => array_filter($queryParams)
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $expenses = isset($responseData['results']) ? $responseData['results'] : $responseData;

            $pdf = Pdf::loadView('expenses.pdf', compact('expenses'));
            return $pdf->download('laporan-pengeluaran.pdf');

        } catch (\Exception $e) {
            Log::error('Gagal mengekspor PDF pengeluaran: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Gagal membuat laporan PDF.');
        }
    }
}
