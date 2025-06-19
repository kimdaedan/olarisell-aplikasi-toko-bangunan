<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $client;

    public function __construct()
    {
        // Buat instance Guzzle client
        $this->client = new Client();
    }

    // Menampilkan form untuk menambah customer
    public function create()
    {
        return view('customers.create'); // Pastikan file ini ada
    }

    // Menyimpan data customer ke API Django
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        // Kirim data ke API Django
        $response = $this->client->post('http://127.0.0.1:8000/api/kasir/customer/', [
            'json' => $request->only(['nama', 'alamat', 'no_telepon'])
        ]);

        if ($response->getStatusCode() === 201) {
            return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan customer.');
        }
    }

    // Menampilkan daftar customer
    public function index()
    {
        // Ambil data customer dari API Django
        $response = $this->client->get('http://127.0.0.1:8000/api/kasir/customer/');
        $customers = json_decode($response->getBody());

        return view('customers.index', compact('customers')); // Pastikan view ini ada
    }
}