<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'product_name',
        'quantity',
        'price',
        'payment_method',
        'payment_date',
    ];
}