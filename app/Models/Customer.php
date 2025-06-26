<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'kasir_customer'; // Nama tabel
    protected $fillable = ['name']; // Pastikan field yang ingin diisi ada di sini



}
