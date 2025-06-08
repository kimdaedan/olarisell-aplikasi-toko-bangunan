<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex flex-col h-screen">

<header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <img src="logo.png" alt="Logo" class="h-10">
    <div class="flex items-center">
        <form action="{{ route('kasir.index') }}" method="GET" class="mr-2">
            <input type="text" name="search" placeholder="Cari Produk..." class="p-2 rounded border border-gray-300">
        </form>
        <a href="{{ route('customers.create') }}" class="bg-white text-blue-600 px-4 py-2 rounded">Tambah Data Customer</a>
        <a href="{{ route('gudang.index') }}" class="bg-white text-blue-600 px-4 py-2 rounded ml-2">Gudang</a>
    </div>
    <img src="user-icon.png" alt="Pengguna" class="h-10">
</header>

<div class="flex flex-1 p-4">
    <div class="flex-1 bg-gray-100 p-4 rounded mr-2">
        <h3 class="text-lg font-semibold">Produk</h3>
        <ul>
            @foreach($produk as $item)
                <li>
                    <a href="{{ route('product.show', $item->id) }}" class="flex items-center mb-4 border-b border-gray-300 pb-2">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" class="h-20 w-20 object-cover mr-4">
                        <div class="flex-1">
                            <div class="font-semibold">{{ $item->nama }}</div>
                            <div class="text-gray-700">Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                            <div class="text-gray-700">Stok: {{ $item->stok }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bg-gray-200 p-4 rounded w-1/3">
        <h3 class="text-lg font-semibold">Closing</h3>
        <p class="mt-4 text-xl font-bold">Total: Rp 0</p>
        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Hitung Harga</button>
    </div>
</div>

</body>
</html>