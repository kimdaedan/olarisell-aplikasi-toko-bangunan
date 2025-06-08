<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    use HasFactory;

    protected $table = 'gudang_produk';

    protected $fillable = [
        'nama', 'harga', 'stok', 'gambar', // Tambahkan kolom gambar
    ];
}