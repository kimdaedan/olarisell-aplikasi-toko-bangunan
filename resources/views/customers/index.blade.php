@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-6">Daftar Customer</h2>

    @if(session('success'))
        <div class="bg-green-200 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="border-b px-6 py-3 text-left">Nama</th>
                <th class="border-b px-6 py-3 text-left">Alamat</th>
                <th class="border-b px-6 py-3 text-left">No Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td class="border-b px-6 py-4">{{ $customer->nama }}</td>
                    <td class="border-b px-6 py-4">{{ $customer->alamat }}</td>
                    <td class="border-b px-6 py-4">{{ $customer->no_telepon }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('customers.create') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded">Tambah Customer</a>
        <a href="{{ route('kasir.index') }}" class="ml-4 inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded">Kembali</a>
    </div>
</div>
@endsection