<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan
    protected $table = 'gudang_pengeluaran';

    protected $fillable = [
        'date',
        'category',
        'amount',
        'payment_status',
    ];
}