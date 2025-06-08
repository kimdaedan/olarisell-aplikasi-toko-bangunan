@extends('layouts.app')

@section('title', 'Selamat Datang di Aplikasi Kasir')

@section('content')
<div class="bg-cover bg-center h-screen" style="background-image: url('toko.jpg');">
    <div class="container mx-auto mt-10 text-center bg-white bg-opacity-75 p-6 rounded">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang di OLARISELL</h1>
        <p class="text-lg mb-8">Kelola transaksi penjualan dan data customer Anda dengan mudah.</p>

        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">Fitur Utama</h2>
            <ul class="list-disc list-inside text-left mx-auto max-w-lg">
                <li>Manajemen Data Customer</li>
                <li>Pengelolaan Transaksi Penjualan</li>
                <li>Laporan Penjualan yang Mudah Dipahami</li>
            </ul>
        </div>

        <div class="flex justify-center mt-4">
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded shadow-md hover:bg-blue-700 transition">Login</a>
        </div>
    </div>
</div>
@endsection