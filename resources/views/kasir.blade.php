<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .logo {
            position: absolute;
            top: 10px;
            left: 20px;
            height: 50px; /* Sesuaikan ukuran logo */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="bg-blue-600 text-white p-5 relative">
        <img src="logo.png" alt="Logo" class="logo"> <!-- Ganti dengan URL logo Anda -->
        <h1 class="text-center text-2xl font-bold">Aplikasi Kasir</h1>
        <div class="absolute top-5 right-5">
            <a href="/gudang" class="bg-green-500 text-white px-4 py-2 rounded">Gudang</a>
        </div>
    </div>

    <div class="container mx-auto mt-5">
        <div class="bg-white rounded-lg shadow-md mb-5">
            <div class="p-5">
                <h5 class="font-semibold mb-4">Pilih Item</h5>
                <div class="flex space-x-2">
                    <input type="text" class="flex-1 p-2 border border-gray-300 rounded" placeholder="Nama Customer">
                    <input type="text" class="flex-1 p-2 border border-gray-300 rounded" placeholder="Nama Produk / SKU / Bar Kode">
                    <input type="number" class="w-1/4 p-2 border border-gray-300 rounded" placeholder="Jumlah">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Item</button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md mb-5">
            <div class="p-5">
                <h5 class="font-semibold mb-4">Daftar Item</h5>
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 p-2">Produk</th>
                            <th class="border border-gray-300 p-2">Jumlah</th>
                            <th class="border border-gray-300 p-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 p-2">Contoh Produk</td>
                            <td class="border border-gray-300 p-2">2</td>
                            <td class="border border-gray-300 p-2">20.00</td>
                        </tr>
                        <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                    </tbody>
                </table>
                <div class="font-bold text-lg mt-4">
                    Total: 20.00
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md text-center p-5">
            <button class="bg-gray-300 text-black px-4 py-2 rounded">Other</button>
            <button class="bg-green-500 text-white px-4 py-2 rounded">Cash</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded">Batal</button>
        </div>
    </div>
</body>
</html>