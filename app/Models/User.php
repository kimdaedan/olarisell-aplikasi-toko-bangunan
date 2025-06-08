<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'auth_user'; // Menyebutkan nama tabel yang sesuai

    protected $fillable = [
        'username', 'password', 'first_name', 'last_name', 'email', 'is_superuser', 'is_staff', 'date_joined',
    ];

    protected $hidden = [
        'password', // Menyembunyikan password dari model
    ];

    // Jika menggunakan hashing untuk password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}