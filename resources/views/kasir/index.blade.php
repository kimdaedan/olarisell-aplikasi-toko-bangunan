<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OLARISELL - Kasir</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Font Awesome untuk Ikon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Select2 untuk dropdown pencarian --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Custom scrollbar & Select2 style override */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .select2-container .select2-selection--single { height: 42px; border-radius: 0.5rem; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 42px; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 40px; }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-blue-600 text-white shadow-md p-4 flex justify-between items-center">
                {{-- Logo Aplikasi --}}
                <img src="{{ asset('logo.png') }}" alt="Logo OLARISELL" class="h-10">
                <div class="flex items-center space-x-6">
                    <a href="{{ route('gudang.index') }}" class="hover:text-blue-200 transition duration-300">
                        <i class="fas fa-warehouse mr-2"></i>Gudang
                    </a>
                     <a href="{{ route('customers.create') }}" class="hover:text-blue-200 transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i>Tambah Customer
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-red-200 transition duration-300">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </header>

            <div class="flex flex-1 p-6 gap-6 overflow-hidden">
                <!-- Product Grid -->
                <div class="w-2/3 flex flex-col">
                    <div class="mb-4">
                        <input type="text" id="search-product" placeholder="Cari produk berdasarkan nama..." class="p-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div id="product-list" class="flex-1 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 overflow-y-auto p-2">
                        @foreach($produk as $item)
                        <div class="product-card cursor-pointer bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-300" onclick="addProduct({{ $item->id }}, '{{ addslashes($item->nama) }}', {{ $item->harga }}, {{ $item->jumlah }})">
                            <img src="{{ $item->gambar }}" alt="{{ $item->nama }}" class="h-20 w-20 object-cover mr-4">
                            <div class="p-3">
                                <h4 class="font-semibold text-gray-800 truncate product-name">{{ $item->nama }}</h4>
                                <p class="text-gray-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">Stok: {{ $item->jumlah }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Closing / Cart Section -->
                <div class="w-1/3 bg-white rounded-lg shadow-md flex flex-col p-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-4 mb-4">Keranjang</h3>
                    <div id="selected-products" class="flex-1 overflow-y-auto pr-2">
                        <p class="text-gray-500 text-center mt-10">Keranjang masih kosong.</p>
                    </div>
                    <div class="border-t pt-4 mt-4">
                        <div class="mb-4">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Pilih Customer</label>
                            <select id="customer_name" name="customer_id" class="w-full p-2 border border-gray-300 rounded-lg select2">
                                <option value="">-- Tanpa Customer --</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option value="cash">Cash</option>
                                <option value="debit_bca">Debit BCA</option>
                                <option value="debit_mandiri">Debit Mandiri</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                        <div class="flex justify-between items-center text-xl font-bold text-gray-800 mb-4">
                            <span>Total:</span>
                            <span id="total-price">Rp 0</span>
                        </div>
                        <button id="submit-transaction" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-300">
                            <i class="fas fa-check-circle mr-2"></i>Proses & Cetak
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JQuery & Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                placeholder: 'Cari atau pilih customer',
                allowClear: true
            });

            // Objek untuk menyimpan produk yang dipilih
            const cart = {};

            // Fungsi untuk menambah produk ke keranjang
            window.addProduct = function(id, name, price, stock) {
                if (stock <= 0) {
                    alert('Stok produk ini habis!');
                    return;
                }
                if (cart[id]) {
                    if (cart[id].quantity < stock) {
                        cart[id].quantity++;
                    } else {
                        alert('Jumlah pesanan melebihi stok yang tersedia.');
                    }
                } else {
                    cart[id] = { name, price, quantity: 1, id, stock };
                }
                renderCart();
            };

            // Fungsi untuk merender ulang tampilan keranjang
            function renderCart() {
                const selectedProductsDiv = $('#selected-products');
                selectedProductsDiv.empty();
                let totalPrice = 0;

                if (Object.keys(cart).length === 0) {
                    selectedProductsDiv.html('<p class="text-gray-500 text-center mt-10">Keranjang masih kosong.</p>');
                    $('#total-price').text('Rp 0');
                    return;
                }

                for (const id in cart) {
                    const { name, price, quantity, stock } = cart[id];
                    totalPrice += price * quantity;

                    const productHtml = `
                        <div class="flex items-center border-b py-3">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">${name}</p>
                                <p class="text-sm text-gray-600">Rp ${price.toLocaleString('id-ID')}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button onclick="decrement(${id})" class="text-gray-500 hover:text-red-500 text-lg transition-colors">-</button>
                                <span class="font-semibold w-8 text-center">${quantity}</span>
                                <button onclick="increment(${id})" class="text-gray-500 hover:text-green-500 text-lg transition-colors">+</button>
                            </div>
                        </div>
                    `;
                    selectedProductsDiv.append(productHtml);
                }

                $('#total-price').text(`Rp ${totalPrice.toLocaleString('id-ID')}`);
            }

            // Fungsi untuk menambah kuantitas
            window.increment = function(id) {
                if (cart[id].quantity < cart[id].stock) {
                    cart[id].quantity++;
                    renderCart();
                } else {
                    alert('Jumlah pesanan melebihi stok yang tersedia.');
                }
            };

            // Fungsi untuk mengurangi kuantitas atau menghapus produk
            window.decrement = function(id) {
                if (cart[id].quantity > 1) {
                    cart[id].quantity--;
                } else {
                    delete cart[id];
                }
                renderCart();
            };

            // Fungsi pencarian produk (client-side)
            $('#search-product').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.product-card').each(function() {
                    const productName = $(this).find('.product-name').text().toLowerCase();
                    $(this).toggle(productName.includes(searchTerm));
                });
            });

            // Mengirim transaksi ke API Django
            $('#submit-transaction').click(function() {
                if (Object.keys(cart).length === 0) {
                    alert('Keranjang kosong, silakan pilih produk terlebih dahulu.');
                    return;
                }

                const selectedProducts = Object.values(cart).map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                    price: item.price
                }));

                const payload = {
                    customer: $('#customer_name').val() || null, // Kirim null jika tidak ada customer
                    products: selectedProducts,
                    payment_method: $('#payment_method').val(),
                };

                // Menonaktifkan tombol untuk mencegah klik ganda
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');

                $.ajax({
                    url: 'http://127.0.0.1:8000/api/kasir/closing/', // URL API Django
                    method: 'POST',
                    contentType: 'application/json', // Penting untuk API Django
                    data: JSON.stringify(payload), // Mengubah data menjadi string JSON
                    success: function(response) {
                        alert('Transaksi berhasil disimpan!');
                        location.reload(); // Muat ulang halaman setelah sukses
                    },
                    error: function(xhr) {
                        const errorData = xhr.responseJSON;
                        let errorMessage = 'Terjadi kesalahan saat menyimpan transaksi.';
                        if (errorData && errorData.error) {
                            errorMessage = errorData.error;
                        } else if (errorData) {
                             errorMessage = Object.values(errorData).flat().join('\n');
                        }
                        alert('Error: ' + errorMessage);
                        // Mengaktifkan kembali tombol jika terjadi error
                        $('#submit-transaction').prop('disabled', false).html('<i class="fas fa-check-circle mr-2"></i>Proses & Cetak');
                    }
                });
            });
        });
    </script>

</body>
</html>
