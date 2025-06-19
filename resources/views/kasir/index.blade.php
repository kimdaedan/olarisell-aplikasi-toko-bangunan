<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body class="flex flex-col h-screen">

<header class="bg-blue-600 text-white p-4 flex justify-between items-center">
    <img src="logo.png" alt="Logo" class="h-10">
    <div class="flex items-center">
        <form action="{{ route('kasir.index') }}" method="GET" class="mr-2">
            <input type="text" name="search" placeholder="Cari Produk..." class="p-2 rounded border border-gray-300 bg-white text-black" value="{{ request('search') }}">
        </form>
        <a href="{{ route('customers.create') }}" class="bg-white text-blue-600 px-4 py-2 rounded">Tambah Data Customer</a>
        <a href="{{ route('gudang.index') }}" class="bg-white text-blue-600 px-4 py-2 rounded ml-2">Gudang</a>
    </div>
    <img src="user.png" alt="Pengguna" class="h-10">
</header>

<div class="flex flex-1 p-4">
    <div class="flex-1 bg-gray-100 p-4 rounded mr-2">
        <h3 class="text-lg font-semibold">Produk</h3>
        <ul id="product-list">
            @foreach($produk as $item)
                <li>
                    <a href="#" class="flex items-center mb-4 border-b border-gray-300 pb-2" onclick="addProduct('{{ $item->nama }}', {{ $item->harga }})">
                        <img src="{{ $item->gambar }}" alt="{{ $item->nama }}" class="h-20 w-20 object-cover mr-4">
                        <div class="flex-1">
                            <div class="font-semibold">{{ $item->nama }}</div>
                            <div class="text-gray-700">Harga: Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                            <div class="text-gray-700">Stok: {{ $item->jumlah }}</div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-gray-200 p-4 rounded w-1/3">
        <h3 class="text-lg font-semibold">Closing</h3>

        <div id="selected-products" class="mb-4"></div>

        <div class="mb-4">
            <label for="customer_name" class="block text-sm font-medium text-gray-700">Pilih Customer</label>
            <select id="customer_name" name="customer_id" class="mt-1 block w-full p-2 border border-gray-300 rounded select2">
    <option value="">Pilih Customer</option>
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
    @endforeach
</select>
        </div>

        <div class="mb-4">
            <label for="payment_method" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
            <input type="text" id="payment_method" name="payment_method" placeholder="Masukkan Metode Pembayaran" class="mt-1 block w-full p-2 border border-gray-300 rounded">
        </div>

        <div class="mb-4">
            <label for="payment_date" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" id="payment_date" name="payment_date" class="mt-1 block w-full p-2 border border-gray-300 rounded" value="{{ date('Y-m-d') }}" readonly>
        </div>

        <p id="total-price" class="mt-4 text-xl font-bold">Total: Rp 0</p>
        <button id="submit-transaction" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Closing</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Pilih Customer',
            allowClear: true
        });

        const products = {};

        window.addProduct = function(name, price) {
            if (!products[name]) {
                products[name] = { price: price, quantity: 1 };
            } else {
                products[name].quantity++;
            }
            renderProducts();
        };

        function renderProducts() {
            $('#selected-products').empty();
            let totalPrice = 0;

            for (const name in products) {
                const { price, quantity } = products[name];
                const productTotal = price * quantity;
                totalPrice += productTotal;

                const productHtml = `
                    <div class="flex justify-between items-center border-b border-gray-300 py-2">
                        <div>${name}</div>
                        <div>Rp ${price.toLocaleString()}</div>
                        <div>x <span class="quantity">${quantity}</span></div>
                        <div>
                            <button onclick="increment('${name}')" class="bg-green-500 text-white px-2 py-1 rounded">+</button>
                            <button onclick="decrement('${name}')" class="bg-yellow-500 text-white px-2 py-1 rounded">-</button>
                            <button onclick="removeProduct('${name}')" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </div>
                    </div>
                `;
                $('#selected-products').append(productHtml);
            }

            $('#total-price').text(`Total: Rp ${totalPrice.toLocaleString()}`);
        }

        window.increment = function(name) {
            products[name].quantity++;
            renderProducts();
        };

        window.decrement = function(name) {
            if (products[name].quantity > 1) {
                products[name].quantity--;
            } else {
                removeProduct(name);
            }
            renderProducts();
        };

        window.removeProduct = function(name) {
            delete products[name];
            renderProducts();
        };

        $('input[name="search"]').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('#product-list li').each(function() {
                const productName = $(this).text().toLowerCase();
                $(this).toggle(productName.includes(searchTerm));
            });
        });

        $('#submit-transaction').click(function() {
            const selectedProducts = Object.keys(products).map(name => ({
                name: name,
                quantity: products[name].quantity,
                price: products[name].price
            }));

            const customerId = $('#customer_name').val();
            const paymentMethod = $('#payment_method').val();
            const paymentDate = $('#payment_date').val();

            $.ajax({
                url: '{{ route("kasir.closeTransaction") }}',
                method: 'POST',
                data: {
                    customer_id: customerId,
                    products: selectedProducts,
                    payment_method: paymentMethod,
                    payment_date: paymentDate,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Transaksi berhasil ditutup!');
                    // Reset data setelah berhasil
                    products = {};
                    $('#selected-products').empty();
                    $('#total-price').text('Total: Rp 0');
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>

</body>
</html>