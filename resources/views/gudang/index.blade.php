<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - POS</title>
    {{-- Font Awesome untuk Ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Menambahkan sedikit style tambahan untuk scrollbar yang lebih baik di tabel responsif */
        .table-container::-webkit-scrollbar {
            height: 8px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background-color: #A0AEC0;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        {{-- Sidebar Navigasi --}}
        <nav class="w-64 bg-blue-600 text-white p-5 shadow-lg">
            <div class="mb-10">
                {{-- Menggunakan logo dari file gambar di folder public --}}
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="max-w-full h-auto mb-4 rounded">
            </div>
            <a href="/gudang" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold">
                <i class="fas fa-cash-register mr-2"></i>Sell
            </a>
            <a href="/products" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-box-open mr-2"></i>Products
            </a>
            <a href="/expenses" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-file-invoice-dollar mr-2"></i>Expenses
            </a>
        </nav>

        {{-- Konten Utama --}}
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Point of Sale (POS)</h1>
                <a href="/kasir" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Buat Transaksi
                </a>
            </div>

            {{-- Notifikasi Error dari Controller --}}
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">
                        Show
                        <select class="border border-gray-300 rounded p-1 mx-2">
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        entries
                    </span>
                    <div>
                        <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
                        <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-print mr-1"></i> Print</button>
                        <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-file-pdf mr-1"></i> Export PDF</button>
                    </div>
                </div>

                {{-- Kontainer Tabel agar Responsif --}}
                <div class="overflow-x-auto table-container">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Action</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Customer Name</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Product Name</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Quantity</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Payment</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50 border-b border-gray-200">
                                {{-- Kolom Action dengan Tombol Edit & Delete --}}
                                <td class="p-3">
                                    <div class="flex space-x-2">
                                        {{-- Tombol Edit --}}
                                        <a href="#" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Tombol Delete (menggunakan form untuk keamanan) --}}
                                        <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                {{-- Data lainnya --}}
                                <td class="p-3 text-gray-700">{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d M Y, H:i') }}</td>
                                <td class="p-3 text-gray-700 font-medium">{{ $transaction->customer_name ?? 'N/A' }}</td>
                                <td class="p-3 text-gray-700">{{ $transaction->product_name ?? 'N/A' }}</td>
                                <td class="p-3 text-gray-700 text-center">{{ $transaction->qty }}</td>
                                <td class="p-3 text-gray-700">{{ ucfirst($transaction->payment_method) }}</td>
                                <td class="p-3 text-gray-800 font-bold">Rp {{ number_format($transaction->total_transaksi, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            {{-- Tampilan jika tidak ada data transaksi --}}
                            <tr>
                                <td colspan="7" class="text-center p-6 text-gray-500">
                                    Tidak ada data transaksi yang ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
