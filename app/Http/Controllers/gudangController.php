<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Customer; // Pastikan ini diimpor
use App\Models\Product;  // Pastikan ini diimpor

class GudangController extends Controller
{
    public function index()
    {
        $client = new Client();

        try {
            $response = $client->get('http://127.0.0.1:8000/api/kasir/closing/');
            $transactions = json_decode($response->getBody()->getContents());

            foreach ($transactions as $transaction) {
                // Ambil nama customer dan produk
                $transaction->customer_name = $this->getCustomerName($transaction->customer);
                $transaction->product_name = $this->getProductName($transaction->produk);
            }

            return view('gudang.index', compact('transactions'));
        } catch (\Exception $e) {
            Log::error('Gagal menghubungi API Django saat mengambil data transaksi: ' . $e->getMessage());
            return redirect()->route('gudang.index')->with('error', 'Gagal menghubungi API Django.');
        }
    }

    private function getCustomerName($customerId)
    {
        $customer = Customer::find($customerId);
        return $customer ? $customer->name : 'Unknown';
    }

    private function getProductName($productId)
    {
        $product = Product::find($productId);
        return $product ? $product->name : 'Unknown';
    }
}