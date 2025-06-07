<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function toggleForm() {
            const form = document.getElementById('addProductForm');
            form.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100">

    <div class="flex">
        <nav class="w-64 bg-blue-500 text-white p-5">
            <img src="logo.png" alt="Logo" class="max-w-full h-auto mb-4"> <!-- Ganti dengan URL logo Anda -->
            <a href="/gudang" class="block py-2 hover:bg-blue-600">Sell</a>
            <a href="/products" class="block py-2 hover:bg-blue-600">Products</a>
            <a href="/expenses" class="block py-2 hover:bg-blue-600">Expenses</a>
        </nav>

        <div class="flex-1 p-5">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Produk</h1>
                <<div>
                    <a href="/kasir" class="bg-green-500 text-white px-4 py-2 rounded">Kasir</a> <!-- Tombol Kasir -->
                    <button onclick="toggleForm()" class="bg-red-500 text-white px-4 py-2 rounded ml-2">Tambah</button> <!-- Tombol Tambah -->
                </div>
            </div>

            <!-- Form untuk menambahkan data produk -->
            <div id="addProductForm" class="hidden mb-4 p-4 border border-gray-300 rounded bg-white">
                <h2 class="text-xl font-bold mb-2">Tambah Produk</h2>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1" for="product_image">Gambar Produk:</label>
                        <input type="file" id="product_image" name="gambar" class="border border-gray-300 rounded p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1" for="product_name">Nama Produk:</label>
                        <input type="text" id="product_name" name="nama" class="border border-gray-300 rounded p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1" for="product_price">Harga:</label>
                        <input type="number" id="product_price" name="harga" class="border border-gray-300 rounded p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1" for="product_stock">Stok:</label>
                        <input type="number" id="product_stock" name="jumlah" class="border border-gray-300 rounded p-2 w-full" required>
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="toggleForm()" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</button>
                </form>
            </div>

            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Gambar</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Nama Produk</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Harga</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Stok</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="border border-gray-300 p-2">
                                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama }}" class="w-16 h-auto">
                            </td>
                            <td class="border border-gray-300 p-2">{{ $product->nama }}</td>
                            <td class="border border-gray-300 p-2">{{ number_format($product->harga, 2) }}</td>
                            <td class="border border-gray-300 p-2">{{ $product->jumlah }}</td>
                            <td class="border border-gray-300 p-2">
                                <button class="bg-blue-500 text-white px-4 py-1 rounded">Actions</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Bagian bawah tabel dikosongkan -->
            <div class="mt-5"></div>
        </div>
    </div>
</body>
</html>