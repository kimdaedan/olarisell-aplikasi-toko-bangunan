<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'gudang_produk';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama',    // Nama produk
        'jumlah',  // Jumlah stok
        'harga',   // Harga produk
        'gambar'   // Path gambar produk
    ];

    // Menentukan bahwa model harus menggunakan timestamps
    public $timestamps = true; // Jika tabel memiliki kolom created_at dan updated_at
}