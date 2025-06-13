<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirTransaksi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'kasir_transaksi';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'customer',
        'produk_id',
        'metode_pembayaran',
        'jumlah',
        'tanggal',
    ];

    // Jika Anda ingin mendefinisikan relasi, tambahkan metode di bawah ini
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'product');
    }
}