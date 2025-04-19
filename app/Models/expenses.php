<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    // Pastikan kolom yang diizinkan untuk mass assignment dicantumkan di sini
    protected $fillable = ['date', 'category', 'payment_status'];
}