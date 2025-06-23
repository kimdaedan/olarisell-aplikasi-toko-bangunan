<?php

namespace App\Http\Controllers;

use App\Models\Expenses; // Pastikan model ini ada
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade as PDF;

class ExpensesController extends Controller
{
    public function index()
    {
        // Ambil data pengeluaran dari database
        $expenses = Expenses::all(); // Ambil semua data pengeluaran

        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        // Validasi dan kirim data ke Django
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:10',
        ]);

        // Buat instance Guzzle client
        $client = new Client();

        // Kirim data ke Django
        try {
            $response = $client->post('http://127.0.0.1:8000/api/gudang/pengeluaran/', [
                'json' => [
                    'date' => $request->date,
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'payment_status' => $request->status,
                ]
            ]);

            // Cek status response
            if ($response->getStatusCode() === 201) {
                return redirect()->route('expenses.index')->with('success', 'Expenses added successfully.');
            } else {
                return redirect()->route('expenses.index')->with('error', 'Failed to add expenses to Django.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi API Django saat menambah pengeluaran: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Gagal menghubungi API Django.');
        }
    }

    public function destroy($id)
    {
        $client = new Client();

        try {
            $response = $client->delete('http://127.0.0.1:8000/api/gudang/pengeluaran/' . $id . '/'); // Ganti dengan endpoint yang sesuai

            if ($response->getStatusCode() === 204) { // 204 No Content
                return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus.');
            } else {
                return redirect()->route('expenses.index')->with('error', 'Gagal menghapus pengeluaran.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi API Django saat menghapus pengeluaran: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Gagal menghubungi API Django.');
        }
    }

    public function edit($id)
    {
        $expense = Expenses::findOrFail($id);
        return view('expenses.edit', compact('expense'));
    }

   public function exportPdf()
{
    // Buat instance Guzzle client
    $client = new Client();

    try {
        // Ambil data pengeluaran dari API Django
        $response = $client->get('http://127.0.0.1:8000/api/gudang/pengeluaran/');

        if ($response->getStatusCode() === 200) {
            $expenses = json_decode($response->getBody()->getContents(), true); // Mengambil data sebagai array

            // Buat PDF dari view
            $pdf = PDF::loadView('expenses.pdf', compact('expenses'));

            // Unduh file PDF
            return $pdf->download('expenses.pdf');
        } else {
            return redirect()->route('expenses.index')->with('error', 'Gagal mengambil data pengeluaran dari Django.');
        }
    } catch (\Exception $e) {
        Log::error('Gagal menghubungi API Django saat mengekspor PDF: ' . $e->getMessage());
        return redirect()->route('expenses.index')->with('error', 'Gagal menghubungi API Django.');
    }
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:10',
        ]);

        // Buat instance Guzzle client
        $client = new Client();

        // Mengupdate pengeluaran di Django
        try {
            $response = $client->put('http://127.0.0.1:8000/api/gudang/pengeluaran/' . $id . '/', [
                'json' => [
                    'date' => $request->date,
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'payment_status' => $request->status,
                ]
            ]);

            // Cek status response
            if ($response->getStatusCode() === 200) {
                return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui.');
            } else {
                return redirect()->route('expenses.index')->with('error', 'Gagal memperbarui pengeluaran di Django.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi API Django saat memperbarui pengeluaran: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Gagal menghubungi API Django.');
        }
    }
}
