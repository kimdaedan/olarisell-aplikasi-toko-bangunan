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
            const form = document.getElementById('addExpenseForm');
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
                <h1 class="text-2xl font-bold">POS</h1>
                <div>
                    <a href="/kasir" class="bg-green-500 text-white px-4 py-2 rounded">Kasir</a> <!-- Tombol Kasir -->
                    <button onclick="toggleForm()" class="bg-red-500 text-white px-4 py-2 rounded ml-2">Tambah</button> <!-- Tombol Tambah -->
                </div>
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

            <!-- Form untuk menambahkan data -->
            <div id="addExpenseForm" class="hidden mb-4 p-4 border border-gray-300 rounded bg-white">
                <h2 class="text-xl font-bold mb-2">Tambah Pengeluaran</h2>
                <form action="{{ url('/expenses') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1" for="date">Tanggal:</label>
                        <input type="datetime-local" id="date" name="date" class="border border-gray-300 rounded p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1" for="category">Kategori Pengeluaran:</label>
                        <input type="text" id="category" name="category" class="border border-gray-300 rounded p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1" for="amount">Jumlah:</label>
                        <input type="number" id="amount" name="amount" class="border border-gray-300 rounded p-2 w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1" for="status">Status Pembayaran:</label>
                        <select id="status" name="status" class="border border-gray-300 rounded p-2 w-full" required>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
                    <button type="button" onclick="toggleForm()" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</button>
                </form>
            </div>

            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Date</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Expense Category</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Total Amount</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Payment Status</th>
                        <th class="border border-gray-300 p-2 bg-blue-500 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $expense->date }}</td>
                            <td class="border border-gray-300 p-2">{{ $expense->category }}</td>
                            <td class="border border-gray-300 p-2">{{ number_format($expense->amount, 2) }}</td>
                            <td class="border border-gray-300 p-2">{{ $expense->payment_status }}</td>
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