<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Pengeluaran</title>
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
            body,
            .main-content {
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
    <script>
        // Fungsi untuk menampilkan/menyembunyikan form
        function toggleForm() {
            const form = document.getElementById('addExpenseForm');
            form.classList.toggle('hidden');
        }

        // Fungsi untuk konfirmasi sebelum menghapus
        function confirmDelete(event) {
            if (!confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?")) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        {{-- Sidebar Navigasi (akan disembunyikan saat print) --}}
        <nav class="w-64 bg-blue-600 text-white p-5 shadow-lg no-print">
            <div class="mb-10">
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="max-w-full h-auto mb-4 rounded">
            </div>
            <a href="{{ route('gudang.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-warehouse mr-2"></i>Sell
            </a>
            <a href="{{ route('products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-box-open mr-2"></i>Products
            </a>
            <a href="{{ route('expenses.index') }}" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold">
                <i class="fas fa-file-invoice-dollar mr-2"></i>Expenses
            </a>
            <a href="{{ route('customers.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-users mr-2"></i>Customers
            </a>
        </nav>

        {{-- Konten Utama --}}
        <div class="flex-1 p-8 overflow-y-auto main-content">
            <div class="flex justify-between items-center mb-6 no-print">
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Pengeluaran</h1>
                <div class="flex items-center space-x-2">
                    <a href="/kasir" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                        <i class="fas fa-calculator mr-2"></i>Kasir
                    </a>
                    <button onclick="toggleForm()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Tambah Pengeluaran
                    </button>
                </div>
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
            @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 no-print" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Form untuk menambahkan pengeluaran baru (default tersembunyi) --}}
            <div id="addExpenseForm" class="hidden mb-6 p-6 border border-gray-300 rounded-lg bg-white shadow-md no-print">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Tambah Pengeluaran Baru</h2>
                <form action="{{ url('/expenses') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 mb-1" for="date">Tanggal:</label>
                            <input type="date" id="date" name="date" class="border border-gray-300 rounded p-2 w-full" required>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1" for="category">Kategori Pengeluaran:</label>
                            <input type="text" id="category" name="category" class="border border-gray-300 rounded p-2 w-full" placeholder="Contoh: Biaya Operasional" required>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1" for="amount">Jumlah:</label>
                            <input type="number" id="amount" name="amount" class="border border-gray-300 rounded p-2 w-full" placeholder="Contoh: 150000" required>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1" for="status">Status Pembayaran:</label>
                            <select id="status" name="status" class="border border-gray-300 rounded p-2 w-full" required>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-5 py-2 rounded shadow-md transition duration-300">Simpan</button>
                        <button type="button" onclick="toggleForm()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold px-5 py-2 rounded shadow-md transition duration-300 ml-2">Batal</button>
                    </div>
                </form>
            </div>

            {{-- Tabel untuk menampilkan daftar pengeluaran --}}
            <div class="bg-white rounded-lg shadow-md p-6 printable-area">
                {{-- Form Filter Tanggal --}}
                <form action="{{ route('expenses.index') }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end no-print">
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
                        <a href="{{ route('expenses.index') }}" class="w-full text-center bg-gray-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-gray-600" title="Reset Filter"><i class="fas fa-sync-alt"></i></a>
                    </div>
                </form>

                {{-- Tombol Aksi Ekspor dan Print --}}
                <div class="flex justify-end items-center mb-4 no-print">
                    <div>
                        <button class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
                        <button onclick="window.print()" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-print mr-1"></i> Print</button>
                        <a href="{{-- route('expenses.exportPdf') --}}" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm transition duration-300"><i class="fas fa-file-pdf mr-1"></i> Export PDF</a>
                    </div>
                </div>

                <div class="overflow-x-auto table-container">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700 no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                            <tr class="hover:bg-gray-50 border-b border-gray-200">
                                <td class="p-3 text-gray-700">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                                <td class="p-3 text-gray-700 font-medium">{{ $expense->category }}</td>
                                <td class="p-3 text-gray-700">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    @if($expense->payment_status == 'paid')
                                    <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Paid</span>
                                    @else
                                    <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Unpaid</span>
                                    @endif
                                </td>
                                <td class="p-3 no-print">
                                    <div class="flex space-x-3 items-center">
                                        @if($expense->payment_status == 'unpaid')
                                        <a href="{{ url('/expenses/' . $expense->id . '/edit') }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @else
                                        <span class="text-gray-400 cursor-not-allowed" title="Tidak bisa diedit karena sudah lunas">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        @endif
                                        <form action="{{ url('/expenses/' . $expense->id) }}" method="POST" onsubmit="confirmDelete(event);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center p-6 text-gray-500">
                                    Tidak ada data pengeluaran yang ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if(isset($grandTotal) && $expenses->isNotEmpty())
                        <tfoot>
                            <tr class="bg-gray-200 font-bold">
                                <td colspan="2" class="p-3 text-right text-gray-800">Total Pengeluaran:</td>
                                <td class="p-3 text-gray-900">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </td>
                                <td colspan="2" class="p-3 no-print"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                @if($expenses instanceof \Illuminate\Pagination\Paginator && $expenses->hasPages())
                <div class="mt-6 no-print">
                    {{ $expenses->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>