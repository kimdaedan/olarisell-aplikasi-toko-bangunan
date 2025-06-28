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
    </style>
    <script>
        // Fungsi ini tetap sama untuk menampilkan/menyembunyikan form
        function toggleForm() {
            const form = document.getElementById('addExpenseForm');
            form.classList.toggle('hidden');
        }

        // Fungsi ini tetap sama untuk konfirmasi sebelum menghapus
        function confirmDelete(event) {
            if (!confirm("Apakah Anda yakin ingin menghapus pengeluaran ini?")) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        {{-- Sidebar Navigasi --}}
        <nav class="w-64 bg-blue-600 text-white p-5 shadow-lg">
            <div class="mb-10">
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="max-w-full h-auto mb-4 rounded">
            </div>
            <a href="/gudang" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-cash-register mr-2"></i>Sell
            </a>
            <a href="/products" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-box-open mr-2"></i>Products
            </a>
            <a href="/expenses" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold">
                <i class="fas fa-file-invoice-dollar mr-2"></i>Expenses
            </a>
        </nav>

        {{-- Konten Utama --}}
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Pengeluaran</h1>
                <div>
                    <a href="/kasir" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                        <i class="fas fa-calculator mr-2"></i>Kasir
                    </a>
                    <button onclick="toggleForm()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300 ml-2">
                        <i class="fas fa-plus mr-2"></i>Tambah Pengeluaran
                    </button>
                </div>
            </div>

            {{-- Blok untuk menampilkan notifikasi sukses atau error --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Blok untuk menampilkan error validasi --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form untuk menambahkan pengeluaran baru (default tersembunyi) --}}
            <div id="addExpenseForm" class="hidden mb-6 p-6 border border-gray-300 rounded-lg bg-white shadow-md">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Tambah Pengeluaran Baru</h2>
                <form action="{{ url('/expenses') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-600 mb-1" for="date">Tanggal:</label>
                            <input type="date" id="date" name="date" class="border border-gray-300 rounded p-2 w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 mb-1" for="category">Kategori Pengeluaran:</label>
                            <input type="text" id="category" name="category" class="border border-gray-300 rounded p-2 w-full" placeholder="Contoh: Biaya Operasional" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 mb-1" for="amount">Jumlah:</label>
                            <input type="number" id="amount" name="amount" class="border border-gray-300 rounded p-2 w-full" placeholder="Contoh: 150000" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 mb-1" for="status">Status Pembayaran:</label>
                            {{-- PERUBAHAN: Mengubah name menjadi 'status' agar sesuai dengan controller --}}
                            <select id="status" name="status" class="border border-gray-300 rounded p-2 w-full" required>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-2">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-5 py-2 rounded shadow-md transition duration-300">Simpan</button>
                        <button type="button" onclick="toggleForm()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold px-5 py-2 rounded shadow-md transition duration-300 ml-2">Batal</button>
                    </div>
                </form>
            </div>

            {{-- Tabel untuk menampilkan daftar pengeluaran --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                 <div class="overflow-x-auto table-container">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                                <tr class="hover:bg-gray-50 border-b border-gray-200">
                                    <td class="p-3 text-gray-700">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                                    <td class="p-3 text-gray-700 font-medium">{{ $expense->category }}</td>
                                    <td class="p-3 text-gray-700">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                    <td class="p-3">
                                        {{-- Tampilan status yang lebih baik (Badge) --}}
                                        @if($expense->payment_status == 'paid')
                                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                                Paid
                                            </span>
                                        @else
                                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                                Unpaid
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <div class="flex space-x-2">
                                            {{-- Tombol Edit dan Hapus hanya menggunakan ikon agar lebih rapi --}}
                                            <a href="{{ url('/expenses/' . $expense->id . '/edit') }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
