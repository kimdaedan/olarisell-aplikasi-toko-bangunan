<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Edit Produk</title>
    {{-- Font Awesome untuk Ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen">
        {{-- Sidebar Navigasi --}}
        <nav class="w-64 bg-blue-600 text-white p-5 shadow-lg">
            <div class="mb-10">
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="max-w-full h-auto mb-4 rounded">
            </div>
            <a href="{{ route('gudang.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-warehouse mr-2"></i>Gudang
            </a>
            <a href="{{ route('products.index') }}" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold">
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
                <h1 class="text-3xl font-bold text-gray-800">Edit Produk</h1>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                </a>
            </div>

            {{-- Menampilkan notifikasi dan error validasi --}}
            @if(session('success'))
                <div class="bg-green-100 border-green-400 text-green-700 border px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
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

            {{-- Form untuk mengedit produk --}}
            <div class="p-6 border border-gray-200 rounded-lg bg-white shadow-md max-w-2xl mx-auto">
                {{-- Pastikan variabel $product ada sebelum menampilkan form --}}
                @if(isset($product))
                <form action="{{ url('/products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Metode PUT untuk update --}}

                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1" for="nama">Nama Produk:</label>
                            <input type="text" id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('nama', $product->nama) }}" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 mb-1" for="harga">Harga:</label>
                                <input type="number" id="harga" name="harga" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500"
                                       value="{{ old('harga', $product->harga) }}" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1" for="jumlah">Stok:</label>
                                <input type="number" id="jumlah" name="jumlah" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500"
                                       value="{{ old('jumlah', $product->jumlah) }}" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1" for="gambar">Ganti Gambar Produk (Opsional):</label>
                            <input type="file" id="gambar" name="gambar" class="border border-gray-300 rounded-lg p-3 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>

                            @if($product->gambar)
                                <div class="mt-4">
                                    <p class="font-medium text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="Gambar Produk" class="w-32 h-32 object-cover rounded-lg shadow">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-lg shadow-md transition duration-300">
                            <i class="fas fa-save mr-2"></i>Update Produk
                        </button>
                    </div>
                </form>
                @else
                <p class="text-center text-red-500">Data produk tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
