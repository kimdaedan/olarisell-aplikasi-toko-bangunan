<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_detail';

    protected $fillable = [
        'customer_id',
        'product_name',
        'quantity',
        'price',
        'total',
        'payment_method',
        'payment_date',
    ];

    public function kasirCustomer()
    {
        return $this->belongsTo(Customer::class, 'id'); // Pastikan ini sesuai
    }
}