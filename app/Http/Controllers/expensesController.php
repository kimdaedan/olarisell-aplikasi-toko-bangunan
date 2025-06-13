<?php

namespace App\Http\Controllers;

use App\Models\Expenses; // Pastikan ini ada
use Illuminate\Http\Request;
use GuzzleHttp\Client;

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
    }
}