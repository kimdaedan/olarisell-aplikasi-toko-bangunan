<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Gudang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jumlah',
        'harga',
    ];

    protected static $client;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::$client = new Client(); // Inisialisasi Guzzle client
    }

    public static function getClosingData()
    {
        // Ambil data dari API kasir
        $response = self::$client->get('http://127.0.0.1:8000/api/kasir/closing/');
        return json_decode($response->getBody(), true); // Mengembalikan data sebagai array
    }
}