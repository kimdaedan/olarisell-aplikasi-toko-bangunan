<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL - Aplikasi Kasir Modern</title>
    {{-- Font Awesome untuk Ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-hero {
            background-color: #1E40AF; /* blue-800 */
            background-image:
                linear-gradient(to right, rgba(30, 64, 175, 0.95), rgba(59, 130, 246, 0.9)),
                url('https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="h-10 mr-3">
                <span class="text-xl font-bold text-gray-800"></span>
            </div>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                Login
            </a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-hero text-white">
        <div class="container mx-auto px-6 py-24 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">Solusi Point of Sale Modern untuk Bisnis Toko Bangunan Anda</h1>
            <p class="text-lg md:text-xl text-blue-200 mb-8 max-w-3xl mx-auto">
                Kelola penjualan, produk, dan data customer dengan lebih cepat, mudah, dan efisien. Fokus pada pengembangan bisnis Anda, biarkan OLARISELL yang mengurus transaksinya.
            </p>
            <a href="{{ route('login') }}" class="bg-white text-blue-700 font-bold px-8 py-3 rounded-full shadow-xl hover:bg-gray-200 transition-transform transform hover:scale-105 duration-300">
                Mulai Sekarang
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800">Fitur Unggulan Kami</h2>
                <p class="text-gray-600 mt-2">Semua yang Anda butuhkan dalam satu aplikasi.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-16 w-16 bg-blue-600 text-white rounded-full mx-auto mb-4">
                        <i class="fas fa-cash-register fa-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Transaksi Cepat</h3>
                    <p class="text-gray-600">Proses penjualan dengan antarmuka kasir yang modern, intuitif, dan sangat responsif.</p>
                </div>
                <!-- Feature 2 -->
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-16 w-16 bg-blue-600 text-white rounded-full mx-auto mb-4">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Manajemen Customer</h3>
                    <p class="text-gray-600">Simpan dan kelola data pelanggan Anda dengan mudah untuk membangun loyalitas.</p>
                </div>
                <!-- Feature 3 -->
                <div class="text-center p-6 bg-gray-50 rounded-lg shadow-lg">
                    <div class="flex items-center justify-center h-16 w-16 bg-blue-600 text-white rounded-full mx-auto mb-4">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Laporan Penjualan</h3>
                    <p class="text-gray-600">Dapatkan wawasan dari riwayat transaksi dan total pendapatan secara akurat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} OLARISELL. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
