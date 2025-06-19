<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Tabel yang digunakan oleh model
    protected $table = 'transactions';

    // Kolom yang dapat diisi
    protected $fillable = [
        'customer_id',
        'payment_date',
        'contact_number',
        'location',
        'payment_method',
        'total',
    ];

    // Relasi dengan model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi dengan model Produk
    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_product')
                    ->withPivot('quantity', 'price'); // Jika ada kolom tambahan
    }

    // Method untuk menutup transaksi
    public function closeTransaction()
    {
        // Logika untuk menutup transaksi
        // Misalnya, mengupdate stok produk
        foreach ($this->products as $product) {
            $product->decrement('stock', $product->pivot->quantity);
        }

        // Kirim data ke API Django jika diperlukan
        $this->sendDataToDjango();
    }

    // Method untuk mengirim data ke API Django
    protected function sendDataToDjango()
    {
        // Implementasi pengiriman data ke API Django
        Http::post('http://127.0.0.1:8000/api/kasir/transaksi/', [
            'transaction_id' => $this->id,
            'customer_id' => $this->customer_id,
            'total' => $this->total,
            // Tambahkan data lain yang diperlukan
        ]);
    }
}