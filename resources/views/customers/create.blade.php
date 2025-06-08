@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-6">Tambah Data Customer</h2>

    <form action="{{ route('customers.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="nama" id="nama" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" name="alamat" id="alamat" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="no_telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-blue-500">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('kasir.index') }}" class="ml-4 inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded">Kembali</a>
        </div>
    </form>
</div>
@endsection