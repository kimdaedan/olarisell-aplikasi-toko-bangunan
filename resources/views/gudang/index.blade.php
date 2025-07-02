<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Gudang</title>
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

        /* Style khusus untuk mode cetak */
        @media print {
            /* Sembunyikan semua elemen yang memiliki kelas 'no-print' */
            .no-print {
                display: none !important;
            }
            /* Pastikan konten utama mengisi seluruh halaman cetak */
            body, .main-content {
                margin: 0;
                padding: 0;
                background-color: white;
            }
            /* Hapus bayangan dan border dari area yang akan dicetak */
            .printable-area {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }
            /* Pastikan tabel menggunakan seluruh lebar */
            table {
                width: 100%;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        {{-- Sidebar Navigasi (akan disembunyikan saat print) --}}
        <nav class="w-64 bg-blue-600 text-white p-5 shadow-lg no-print">
            <div class="mb-10">
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="max-w-full h-auto mb-4 rounded">
            </div>
            <a href="{{ route('gudang.index') }}" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold">
                <i class="fas fa-warehouse mr-2"></i>Sell
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
        <div class="flex-1 p-8 overflow-y-auto main-content">
            <div class="flex justify-between items-center mb-6 no-print">
                <h1 class="text-3xl font-bold text-gray-800">Riwayat Transaksi</h1>
                <a href="/kasir" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                    <i class="fas fa-cash-register mr-2"></i>Halaman Kasir
                </a>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 no-print" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 no-print" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6 printable-area">
                {{-- PERBAIKAN: Menambahkan kembali form filter --}}
                <form action="{{ route('gudang.index') }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-end no-print">
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                        <input type="text" name="search" id="search" placeholder="Cari nama customer..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" value="{{ request('search') }}">
                    </div>
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" value="{{ request('start_date') }}">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" value="{{ request('end_date') }}">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700"><i class="fas fa-filter mr-1"></i> Filter</button>
                        <a href="{{ route('gudang.index') }}" class="w-full text-center bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600" title="Reset Filter"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </form>

                <div class="flex justify-end items-center mb-4 no-print">
                    <div>
                        <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
                        <button onclick="window.print()" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-print mr-1"></i> Print</button>
                        <a href="{{-- route('gudang.exportPdf') --}}" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-file-pdf mr-1"></i> Export PDF</a>
                    </div>
                </div>

                <div class="overflow-x-auto table-container">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700 no-print">Action</th>
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
                                <td class="p-3 no-print">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('gudang.edit', $transaction->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit Payment Method">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('gudang.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
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
                                <tr>
                                    <td colspan="7" class="text-center p-6 text-gray-500">
                                        Tidak ada data transaksi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(isset($grandTotal))
                        <tfoot>
                            <tr class="bg-gray-200 font-bold">
                                <td colspan="6" class="p-3 text-right text-gray-800 no-print">Total Keseluruhan:</td>
                                <td class="p-3 text-gray-900">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </td>
                                <td class="p-3 no-print"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                @if($transactions->hasPages())
                <div class="mt-6 no-print">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
