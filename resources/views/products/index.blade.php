<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Produk</title>
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
        // Fungsi untuk menampilkan/menyembunyikan form
        function toggleForm() {
            const form = document.getElementById('addProductForm');
            form.classList.toggle('hidden');
        }

        // Fungsi untuk konfirmasi sebelum menghapus
        function confirmDelete(event) {
            if (!confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
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
            <a href="/products" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold font-bold">
                <i class="fas fa-box-open mr-2"></i>Products
            </a>
            <a href="/expenses" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-file-invoice-dollar mr-2"></i>Expenses
            </a>
            <a href="/customers" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 ">
                <i class="fas fa-users mr-2"></i>Customers
            </a>
        </nav>

        {{-- Konten Utama --}}
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Produk</h1>
                <div class="flex items-center space-x-2">
                    <a href="/kasir" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                        <i class="fas fa-calculator mr-2"></i>Kasir
                    </a>
                    <button onclick="toggleForm()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </button>
                </div>
            </div>

            {{-- Notifikasi Sukses, Error, dan Validasi --}}
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

            {{-- Form untuk menambahkan produk baru (default tersembunyi) --}}
            <div id="addProductForm" class="hidden mb-6 p-6 border border-gray-300 rounded-lg bg-white shadow-md">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Tambah Produk Baru</h2>
                <form action="{{ url('/products') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-gray-600 mb-1" for="nama">Nama Produk:</label>
                            <input type="text" id="nama" name="nama" class="border border-gray-300 rounded p-2 w-full" required>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1" for="harga">Harga:</label>
                            <input type="number" id="harga" name="harga" class="border border-gray-300 rounded p-2 w-full" placeholder="Contoh: 50000" required>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1" for="jumlah">Stok:</label>
                            <input type="number" id="jumlah" name="jumlah" class="border border-gray-300 rounded p-2 w-full" placeholder="Contoh: 100" required>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1" for="gambar">Gambar Produk:</label>
                            <input type="file" id="gambar" name="gambar" class="border border-gray-300 rounded p-2 w-full">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-5 py-2 rounded shadow-md transition duration-300">Simpan</button>
                        <button type="button" onclick="toggleForm()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold px-5 py-2 rounded shadow-md transition duration-300 ml-2">Batal</button>
                    </div>
                </form>
            </div>

            {{-- Tabel untuk menampilkan daftar produk --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                {{-- Fitur Pencarian --}}
                <div class="mb-4">
                    <form action="{{ url('/products') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" placeholder="Cari produk..." class="border border-gray-300 rounded-l-md p-2 w-full" value="{{ request('search') }}">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="overflow-x-auto table-container">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Gambar</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Nama Produk</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Harga</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 border-b border-gray-200">
                                <td class="p-3">
                                    {{-- PERBAIKAN PENTING: Menampilkan gambar dengan benar dari storage dan memberi placeholder --}}
                                    <img src="{{ $product->gambar }}" alt="Gambar Produk" class="w-16 h-16">
                                </td>
                                <td class="p-3 text-gray-700 font-medium">{{ $product->nama }}</td>
                                <td class="p-3 text-gray-700">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="p-3 text-gray-700 text-center">{{ $product->jumlah }}</td>
                                <td class="p-3">
                                <td class="p-3">
                                    @if(Auth::user() && Auth::user()->is_superuser)
                                    <div class="flex space-x-3">
                                        <a href="{{ url('/products/' . $product->id . '/edit') }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('/products/' . $product->id) }}" method="POST" onsubmit="confirmDelete(event);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center p-6 text-gray-500">
                                    {{-- Pesan disesuaikan jika sedang melakukan pencarian --}}
                                    @if(request('search'))
                                    Produk dengan nama "{{ request('search') }}" tidak ditemukan.
                                    @else
                                    Tidak ada data produk yang ditemukan.
                                    @endif
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