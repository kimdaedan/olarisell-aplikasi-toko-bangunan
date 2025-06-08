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

    /**
     * Scope untuk produk yang tersedia (jumlah > 0)
     */
    public function scopeAvailable($query)
    {
        return $query->where('jumlah', '>', 0);
    }

    /**
     * Scope untuk pencarian produk
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where('nama', 'like', '%'.$keyword.'%');
    }

    /**
     * Format harga untuk tampilan
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Path gambar produk
     */
    public function getImagePathAttribute()
    {
        return $this->gambar ? asset('storage/products/'.$this->gambar) : asset('images/default-product.png');
    }
}