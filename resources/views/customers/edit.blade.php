<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Edit Customer</title>
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
            <a href="/gudang" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-cash-register mr-2"></i>Sell
            </a>
            <a href="/products" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-box-open mr-2"></i>Products
            </a>
            <a href="/expenses" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700">
                <i class="fas fa-file-invoice-dollar mr-2"></i>Expenses
            </a>
            <a href="/customers" class="block py-2.5 px-4 rounded transition duration-200 bg-blue-700 font-bold">
                <i class="fas fa-users mr-2"></i>Customers
            </a>
        </nav>

        {{-- Konten Utama --}}
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Data Customer</h1>
                <a href="{{ route('customers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                </a>
            </div>

            {{-- Menampilkan error validasi jika ada --}}
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

            {{-- Form untuk mengedit customer --}}
            <div class="p-6 border border-gray-200 rounded-lg bg-white shadow-md">
                {{-- Pastikan variabel $customer ada sebelum menampilkan form --}}
                @if($customer)
                <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Metode PUT untuk menandakan ini adalah proses update --}}

                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1" for="nama">Nama Customer:</label>
                            <input type="text" id="nama" name="nama" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('nama', $customer->nama) }}" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1" for="alamat">Alamat:</label>
                            <input type="text" id="alamat" name="alamat" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('alamat', $customer->alamat) }}" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1" for="no_telepon">No. Telepon:</label>
                            <input type="text" id="no_telepon" name="no_telepon" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('no_telepon', $customer->no_telepon) }}" required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-lg shadow-md transition duration-300">
                            <i class="fas fa-save mr-2"></i>Update Data
                        </button>
                    </div>
                </form>
                @else
                <p class="text-center text-red-500">Data customer tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
