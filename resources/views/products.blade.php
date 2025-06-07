<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="flex">
        <nav class="w-64 bg-blue-500 text-white p-5">
            <img src="logo.png" alt="Logo" class="max-w-full h-auto mb-4">
            <a href="/gudang" class="block py-2 hover:bg-blue-600">Sell</a>
            <a href="/products" class="block py-2 hover:bg-blue-600">Products</a>
            <a href="/expenses" class="block py-2 hover:bg-blue-600">Expenses</a>
        </nav>
        <div class="flex-1 p-5">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Products</h1>
                <button onclick="toggleForm()" class="bg-red-500 text-white px-4 py-2 rounded">Tambah Produk</button>
            </div>

            <!-- Form untuk menambahkan data produk -->
            <form id="addProductForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label class="block mb-1" for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="nama" class="border border-gray-300 rounded p-2 w-full" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1" for="current_stock">Current Stock:</label>
        <input type="number" id="current_stock" name="jumlah" class="border border-gray-300 rounded p-2 w-full" required>
    </div>
    <div class="mb-4">
        <label class="block mb-1" for="product_image">Product Image:</label>
        <input type="file" id="product_image" name="gambar" class="border border-gray-300 rounded p-2 w-full">
    </div>
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpam</button>
    <button type="button" onclick="toggleForm()" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</button>
</form>

            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Product Image</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Product Name</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Current Stock</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="border border-gray-300 p-2">
                                <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" class="w-16 h-auto">
                            </td>
                            <td class="border border-gray-300 p-2">{{ $product->product_name }}</td>
                            <td class="border border-gray-300 p-2">{{ $product->current_stock }}</td>
                            <td class="border border-gray-300 p-2">
                                <button class="bg-blue-500 text-white px-4 py-1 rounded">Actions</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-5"></div>
        </div>
    </div>

    <script>
        function toggleForm() {
            const form = document.getElementById('addProductForm');
            form.classList.toggle('hidden');
        }

        async function submitForm(event) {
            event.preventDefault(); // Mencegah form dari pengiriman default

            const formData = new FormData(document.getElementById('addProductForm'));

            try {
                const response = await fetch('http://127.0.0.1:8000/api/gudang/produk/', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('Produk berhasil ditambahkan:', data);
                    location.reload(); // Opsional
                } else {
                    const errorData = await response.json();
                    console.error('Error:', errorData);
                    alert('Gagal menambahkan produk: ' + errorData.detail);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        }
    </script>
</body>
</html>