<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto p-5">
        <h1 class="text-2xl font-bold mb-4">Edit Produk</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('/products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1" for="product_name">Nama Produk:</label>
                <input type="text" id="product_name" name="nama" value="{{ $product->nama }}" class="border border-gray-300 rounded p-2 w-full" required>
                @error('nama')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1" for="product_price">Harga:</label>
                <input type="number" id="product_price" name="harga" value="{{ $product->harga }}" class="border border-gray-300 rounded p-2 w-full" required>
                @error('harga')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1" for="product_stock">Stok:</label>
                <input type="number" id="product_stock" name="jumlah" value="{{ $product->jumlah }}" class="border border-gray-300 rounded p-2 w-full" required>
                @error('jumlah')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1" for="product_image">Gambar Produk:</label>
                <input type="file" id="product_image" name="gambar" class="border border-gray-300 rounded p-2 w-full">
                <img src="{{ asset('storage/products/' . $product->gambar) }}" alt="Gambar Produk" class="w-32 h-32 mt-2">
                @error('gambar')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</a>
        </form>
    </div>

</body>
</html>