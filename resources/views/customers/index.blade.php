<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Manajemen Customer</title>
    {{-- Font Awesome untuk Ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .table-container::-webkit-scrollbar { height: 8px; }
        .table-container::-webkit-scrollbar-thumb { background-color: #A0AEC0; border-radius: 4px; }
    </style>
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
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Customer</h1>
                <div class="flex items-center space-x-2">
                    <a href="/kasir" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                        <i class="fas fa-calculator mr-2"></i>Kasir
                    </a>
                <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Customer
                </a>
            </div>
            </div>

            {{-- Notifikasi --}}
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

            {{-- Tabel Customer --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                {{-- Form Pencarian --}}
                <div class="mb-4">
                    <form action="{{ route('customers.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" placeholder="Cari berdasarkan nama atau alamat..." class="border border-gray-300 rounded-l-lg p-2 w-full focus:ring-2 focus:ring-blue-500" value="{{ request('search') }}">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-lg"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="overflow-x-auto table-container">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">#</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Nama Customer</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Alamat</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">No. Telepon</th>
                                <th class="border-b-2 border-gray-300 p-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50 border-b border-gray-200">
                                    <td class="p-3 text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="p-3 text-gray-700 font-medium">{{ $customer->nama }}</td>
                                    <td class="p-3 text-gray-700">{{ $customer->alamat }}</td>
                                    <td class="p-3 text-gray-700">{{ $customer->no_telepon }}</td>
                                    <td class="p-3">
                                        <div class="flex space-x-3">
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus customer ini?');">
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
                                        @if(request('search'))
                                            Customer dengan nama atau alamat "{{ request('search') }}" tidak ditemukan.
                                        @else
                                            Tidak ada data customer yang ditemukan.
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
