<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $table = 'gudang_produk'; // Nama tabel sesuai dengan yang ada di database

    protected $fillable = [
        'nama',
        'jumlah',
        'harga',
        'gambar',
    ];
}