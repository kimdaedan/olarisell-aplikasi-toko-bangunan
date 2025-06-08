@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-6">Tambah Data Customer</h2>

    <form action="{{ route('customers.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-green-500">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-green-500">
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" name="phone" id="phone" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-green-500">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection