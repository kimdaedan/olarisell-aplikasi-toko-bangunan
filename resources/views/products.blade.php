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
            <img src="logo.png" alt="Logo" class="max-w-full h-auto mb-4"> <!-- Ganti dengan URL logo Anda -->
            <a href="/gudang" class="block py-2 hover:bg-blue-600">Sell</a>
            <a href="/products" class="block py-2 hover:bg-blue-600">Products</a>
            <a href="/expenses" class="block py-2 hover:bg-blue-600">Expenses</a>
        </nav>

        <div class="flex-1 p-5">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">POS</h1>
                <a href="/kasir" class="bg-green-500 text-white px-4 py-2 rounded">Kasir</a> <!-- Tombol Kasir -->
            </div>
            <div class="flex justify-between items-center mb-4">
                <span>Show
                    <select class="border border-gray-300 rounded p-1 mx-2">
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    entries
                </span>
                <div>
                    <button class="bg-red-500 text-white px-4 py-2 rounded">Tambah</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Export Excel</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Print</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Export PDF</button>
                </div>
            </div>

            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Product Image</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Products</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Current Stock</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-2">[Image]</td>
                        <td class="border border-gray-300 p-2">CS-2025-10591</td>
                        <td class="border border-gray-300 p-2">LISA - MEDITERANIA JJ 1 NO 10</td>
                        <td class="border border-gray-300 p-2">
                            <button class="bg-blue-500 text-white px-4 py-1 rounded">Actions</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2">[Image]</td>
                        <td class="border border-gray-300 p-2">CS-2025-10590</td>
                        <td class="border border-gray-300 p-2">MEDI - CENTRAL RESIDENT NO 3</td>
                        <td class="border border-gray-300 p-2">
                            <button class="bg-blue-500 text-white px-4 py-1 rounded">Actions</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2">[Image]</td>
                        <td class="border border-gray-300 p-2">CS-2025-10582</td>
                        <td class="border border-gray-300 p-2">TB KARYA ABADI SUKSES - TIBAN 6</td>
                        <td class="border border-gray-300 p-2">
                            <button class="bg-blue-500 text-white px-4 py-1 rounded">Actions</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Bagian bawah tabel dikosongkan -->
            <div class="mt-5"></div>
        </div>
    </div>
</body>
</html>