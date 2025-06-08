<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'kasir_customer'; // Nama tabel

    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
    ];
}
