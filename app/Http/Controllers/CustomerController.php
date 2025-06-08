<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Menampilkan form untuk menambah customer
    public function create()
    {
        return view('customers.create'); // Pastikan file ini ada
    }

    // Menyimpan data customer ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        Customer::create($request->only(['nama', 'alamat', 'no_telepon']));

        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan!');
    }

    // Menampilkan daftar customer
    public function index()
    {
        $customers = Customer::all(); // Mengambil semua data customer
        return view('customers.index', compact('customers')); // Pastikan view ini ada
    }
}