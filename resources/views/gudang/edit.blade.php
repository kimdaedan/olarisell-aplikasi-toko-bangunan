<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Edit Transaksi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        {{-- Sidebar Navigasi --}}
        <nav class="w-64 bg-blue-600 text-white p-5 shadow-lg">
            <div class="mb-10">
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="max-w-full h-auto mb-4 rounded">
            </div>
            <a href="{{ route('gudang.index') }}" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold">
                <i class="fas fa-warehouse mr-2"></i>Gudang
            </a>
            <a href="{{ route('products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-box-open mr-2"></i>Products
            </a>
            <a href="{{ route('expenses.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-file-invoice-dollar mr-2"></i>Expenses
            </a>
            <a href="{{ route('customers.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-users mr-2"></i>Customers
            </a>
        </nav>

        {{-- Konten Utama --}}
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Metode Pembayaran</h1>
                <a href="{{ route('gudang.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <div class="p-6 border border-gray-200 rounded-lg bg-white shadow-md max-w-lg mx-auto">
                {{-- Pastikan variabel $transaction ada sebelum menampilkan form --}}
                @if(isset($transaction))
                <form action="{{ route('gudang.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Metode PUT untuk update --}}

                    <div class="space-y-4">
                        {{-- Menampilkan detail transaksi yang tidak bisa diubah --}}
                        <div class="p-4 bg-gray-50 rounded-lg border">
                            <p><strong>Produk:</strong> {{ $transaction->product_name }}</p>
                            <p><strong>Customer:</strong> {{ $transaction->customer_name ?? 'N/A' }}</p>
                            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d M Y, H:i') }}</p>
                            <p><strong>Total:</strong> Rp {{ number_format($transaction->total_transaksi, 0, ',', '.') }}</p>
                        </div>

                        {{-- Input untuk mengubah metode pembayaran --}}
                        <div>
                            <label class="block text-gray-700 mb-1 font-semibold" for="payment_method">Metode Pembayaran:</label>
                            <select id="payment_method" name="payment_method" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500" required>
                                <option value="cash" {{ $transaction->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="debit_bca" {{ $transaction->payment_method == 'debit_bca' ? 'selected' : '' }}>Debit BCA</option>
                                <option value="debit_mandiri" {{ $transaction->payment_method == 'debit_mandiri' ? 'selected' : '' }}>Debit Mandiri</option>
                                <option value="qris" {{ $transaction->payment_method == 'qris' ? 'selected' : '' }}>QRIS</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-lg shadow-md transition duration-300">
                            <i class="fas fa-save mr-2"></i>Update Metode
                        </button>
                    </div>
                </form>
                @else
                <p class="text-center text-red-500">Data transaksi tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
