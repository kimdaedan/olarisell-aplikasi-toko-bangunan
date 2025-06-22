<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_detail'; // Pastikan ini sesuai nama tabel

    protected $fillable = [
        'customer_id',
        'product_name',
        'quantity',
        'price',
        'total',
        'payment_method',
        'payment_date',
    ];
}