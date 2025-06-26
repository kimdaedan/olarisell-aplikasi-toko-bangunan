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
                <h1 class="text-2xl font-bold">POS</h1>
                <a href="/kasir" class="bg-green-500 text-white px-4 py-2 rounded">Kasir</a>
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
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Export Excel</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Print</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Export PDF</button>
                </div>
            </div>

            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Action</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Date</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Customer Name</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Product Name</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Quantity</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Payment Method</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td class="border border-gray-300 p-2">
                            <button class="bg-blue-500 text-white px-4 py-1 rounded">Actions</button>
                        </td>
                        <td class="border border-gray-300 p-2">{{ $transaction->tanggal }}</td>
                        <td class="border border-gray-300 p-2">{{ $transaction->customer_name }}</td> <!-- Nama customer -->
                        <td class="border border-gray-300 p-2">{{ $transaction->product_name }}</td> <!-- Nama produk -->
                        <td class="border border-gray-300 p-2">{{ $transaction->qty }}</td>
                        <td class="border border-gray-300 p-2">{{ $transaction->payment_method }}</td>
                        <td class="border border-gray-300 p-2">Rp {{ number_format($transaction->total_transaksi, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>