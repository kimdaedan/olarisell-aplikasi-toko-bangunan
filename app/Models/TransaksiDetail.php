<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'kasir_closing'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'produk_id',        // Menggunakan snake_case untuk konsistensi
        'customer_id',
        'qty',
        'payment_method',
        'total_transaksi',
    ];

    // Relasi dengan model Product
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id'); // Sesuaikan dengan nama kolom yang benar
    }

    // Relasi dengan model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id'); // Sesuaikan dengan nama kolom yang benar
    }
}