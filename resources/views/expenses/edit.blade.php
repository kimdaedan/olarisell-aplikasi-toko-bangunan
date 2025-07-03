<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Edit Pengeluaran</title>
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
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Edit Pengeluaran</h1>
                <a href="{{ route('expenses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow-md transition duration-300">
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

            {{-- Form untuk mengedit pengeluaran --}}
            <div class="p-6 border border-gray-200 rounded-lg bg-white shadow-md max-w-2xl mx-auto">
                @if(isset($expense))
                <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1">Tanggal:</label>
                            {{-- Dibuat readonly agar tidak bisa diubah --}}
                            <input type="text" value="{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}" class="border border-gray-300 rounded-lg p-3 w-full bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Kategori Pengeluaran:</label>
                            <input type="text" value="{{ $expense->category }}" class="border border-gray-300 rounded-lg p-3 w-full bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1">Jumlah:</label>
                            <input type="text" value="Rp {{ number_format($expense->amount, 0, ',', '.') }}" class="border border-gray-300 rounded-lg p-3 w-full bg-gray-100" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1 font-semibold" for="status">Ubah Status Pembayaran:</label>
                            <select id="status" name="status" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500" required>
                                {{-- Opsi 'unpaid' hanya ditampilkan jika statusnya memang unpaid --}}
                                @if($expense->payment_status == 'unpaid')
                                <option value="unpaid" selected>Unpaid</option>
                                @endif
                                {{-- Opsi 'paid' selalu ada --}}
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-lg shadow-md transition duration-300">
                            <i class="fas fa-save mr-2"></i>Update Status
                        </button>
                    </div>
                </form>
                @else
                <p class="text-center text-red-500">Data pengeluaran tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>