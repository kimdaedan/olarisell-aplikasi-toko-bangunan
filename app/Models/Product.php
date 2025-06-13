<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'gudang_produk'; // Jika tabel Anda bernama 'gudang_produk'

    protected $fillable = [
        'nama',
        'jumlah',
        'harga',
        'gambar',
    ];
}