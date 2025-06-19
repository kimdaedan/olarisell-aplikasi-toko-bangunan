<?php

namespace App\Http\Controllers;

use App\Models\KasirTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transactions = KasirTransaksi::with('customer', 'products')->get();
        return response()->json($transactions);
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_date' => 'required|date',
            'contact_number' => 'required|string',
            'location' => 'required|string',
            'payment_method' => 'required|string',
            'total' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Membuat transaksi baru
        $transaction = KasirTransaksi::create($validated);

        // Menyimpan relasi produk
        foreach ($validated['products'] as $product) {
            $transaction->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return response()->json(['message' => 'Transaksi berhasil dibuat', 'transaction' => $transaction], 201);
    }

    // Menutup transaksi
    public function close($id)
    {
        $transaction = KasirTransaksi::findOrFail($id);

        // Menutup transaksi dan mengupdate stok produk
        $transaction->closeTransaction();

        return response()->json(['message' => 'Transaksi berhasil ditutup']);
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaction = KasirTransaksi::with('customer', 'products')->findOrFail($id);
        return response()->json($transaction);
    }

    // Mengupdate transaksi
    public function update(Request $request, $id)
    {
        $transaction = KasirTransaksi::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'sometimes|required|exists:customers,id',
            'payment_date' => 'sometimes|required|date',
            'contact_number' => 'sometimes|required|string',
            'location' => 'sometimes|required|string',
            'payment_method' => 'sometimes|required|string',
            'total' => 'sometimes|required|numeric',
        ]);

        $transaction->update($validated);
        return response()->json(['message' => 'Transaksi berhasil diperbarui', 'transaction' => $transaction]);
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus']);
    }
}