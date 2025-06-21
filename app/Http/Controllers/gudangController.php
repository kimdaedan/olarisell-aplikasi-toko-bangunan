<?php

namespace App\Http\Controllers;

use App\Models\Gudang; // Model untuk transaksi
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi dari model
        $transactions = Gudang::all();

        // Kembalikan view dengan data transaksi
        return view('gudang.index', compact('transactions'));
    }

    public function show($id)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Gudang::findOrFail($id);

        // Kembalikan view dengan data transaksi
        return view('gudang.show', compact('transaction'));
    }

    public function create()
    {
        // Tampilkan form untuk menambah transaksi baru
        return view('gudang.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|date',
        ]);

        // Simpan transaksi baru ke database
        Gudang::create($request->all());

        return redirect()->route('gudang.index')->with('success', 'Transaksi berhasil disimpan.');
    }
}