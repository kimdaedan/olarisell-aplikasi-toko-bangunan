<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Product Order Page with Dynamic Category Products</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&family=Roboto+Mono:wght@700&display=swap');
    .font-robotoslab {
      font-family: 'Roboto Slab', serif;
    }
    .font-robotomono {
      font-family: 'Roboto Mono', monospace;
    }
  </style>
</head>
<body class="bg-white text-black">
  <!-- Header -->
  <header class="flex items-center justify-between bg-[#f9ec4a] px-4 sm:px-6 md:px-8 h-14 border-b border-black select-none">
    <div class="flex items-center space-x-3">
      <a href="/gudang" aria-label="Menu" class="text-black text-2xl focus:outline-none">
        <i class="fas fa-bars"></i>
      </a>
      <div class="flex items-center space-x-0.5 font-robotomono font-bold text-[18px] leading-none">
        <img src="images/logo.png" alt="Olarisell Logo" class="h-10"/>
      </div>
    </div>
    <input class="flex-grow max-w-[300px] rounded-md border border-black bg-[#f9ec4a] px-3 py-1 text-black text-[14px] font-robotomono focus:outline-none focus:ring-1 focus:ring-black" placeholder="Nama Pelanggan" type="text"/>
    <div class="flex items-center space-x-4 text-black text-xl">
      <button aria-label="Search" class="focus:outline-none">
        <i class="fas fa-search"></i>
      </button>
      <button aria-label="Scan" class="focus:outline-none">
        <i class="fas fa-qrcode"></i>
      </button>
      <button aria-label="Lock" class="focus:outline-none">
        <i class="fas fa-lock"></i>
      </button>
      <button aria-label="User" class="focus:outline-none">
        <img alt="User profile icon" class="rounded-full" decoding="async" height="24" loading="lazy" src="https://storage.googleapis.com/a1aa/image/82b6a55a-909d-4079-a458-3b43dd834233.jpg" width="24"/>
      </button>
    </div>
  </header>

  <main class="flex h-[calc(100vh-56px)]">
    <!-- Products Grid -->
    <section class="flex-grow overflow-auto p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="products-grid">
      <!-- Products will be dynamically inserted here -->
    </section>

    <!-- Order Summary -->
    <aside class="w-72 border-l border-black flex flex-col">
      <div class="bg-[#f9ec4a] px-4 py-3 font-robotomono font-extrabold text-[14px]">
        <p id="order-title">New Order</p>
        <p class="text-[12px] font-normal" id="order-date"><!-- Empty initially --></p>
      </div>
      <div class="flex-grow overflow-auto px-4 py-3 space-y-6" id="order-items">
        <!-- Initially empty -->
        <p class="text-center text-black/50 font-robotomono text-[14px] mt-10" id="empty-order-text">No items added</p>
      </div>
      <div class="px-4 py-3 border-t border-black font-robotomono font-extrabold text-[14px] flex justify-between" id="subtotal-container" style="display:none;">
        <span>Subtotal</span>
        <span id="subtotal-amount">Rp.0</span>
      </div>
      <div class="p-4">
        <button class="w-full bg-[#f9ec4a] rounded-full py-2 px-4 font-robotomono font-bold text-[14px] flex items-center justify-center space-x-2 hover:bg-yellow-300 focus:outline-none" id="pay-now-btn" type="button" disabled>
          <i class="fas fa-hand-holding-usd text-lg"></i>
          <span>Pay Now</span>
        </button>
      </div>
    </aside>
  </main>

  <script>
    // Elements
    const productsGrid = document.getElementById('products-grid');
    const orderItemsContainer = document.getElementById('order-items');
    const emptyOrderText = document.getElementById('empty-order-text');
    const subtotalContainer = document.getElementById('subtotal-container');
    const subtotalAmount = document.getElementById('subtotal-amount');
    const payNowBtn = document.getElementById('pay-now-btn');
    const orderDate = document.getElementById('order-date');

    // Store order items in an object keyed by product id
    const order = {};

    // Format number to Indonesian Rupiah format with dot as thousand separator
    function formatRupiah(number) {
      return 'Rp.' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Update order date to current date in format "Monday, 25 April 200"
    function updateOrderDate() {
      const now = new Date();
      const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
      let formatted = now.toLocaleDateString('en-US', options);
      formatted = formatted.replace(/\d{4}/, (year) => year.slice(0, 3));
      orderDate.textContent = formatted;
    }

    // Render order items in the sidebar
    function renderOrder() {
      orderItemsContainer.innerHTML = '';
      const keys = Object.keys(order);
      if (keys.length === 0) {
        emptyOrderText.style.display = 'block';
        subtotalContainer.style.display = 'none';
        payNowBtn.disabled = true;
        orderDate.textContent = '';
        return;
      }
      emptyOrderText.style.display = 'none';
      subtotalContainer.style.display = 'flex';
      payNowBtn.disabled = false;
      updateOrderDate();

      let subtotal = 0;
      keys.forEach((id) => {
        const item = order[id];
        subtotal += item.price * item.quantity;

        const itemDiv = document.createElement('div');

        const topRow = document.createElement('div');
        topRow.className = 'flex items-center space-x-2 mb-1';

        const trashBtn = document.createElement('button');
        trashBtn.className = 'text-yellow-400 text-lg focus:outline-none';
        trashBtn.setAttribute('aria-label', 'Delete item');
        trashBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
        trashBtn.addEventListener('click', () => {
          delete order[id];
          renderOrder();
        });

        const nameP = document.createElement('p');
        nameP.className = 'font-robotomono font-bold text-[14px]';
        nameP.textContent = item.name;

        topRow.appendChild(trashBtn);
        topRow.appendChild(nameP);

        const priceP = document.createElement('p');
        priceP.className = 'font-robotomono text-[12px] text-black/70 mb-1';
        priceP.textContent = '@' + formatRupiah(item.price);

        const qtyRow = document.createElement('div');
        qtyRow.className = 'flex items-center space-x-3 text-black text-lg font-robotomono font-bold';

        const minusBtn = document.createElement('button');
        minusBtn.className = 'focus:outline-none';
        minusBtn.setAttribute('aria-label', 'Decrease quantity');
        minusBtn.textContent = '−';
        minusBtn.addEventListener('click', () => {
          if (item.quantity > 1) {
            item.quantity--;
            renderOrder();
          }
        });

        const qtySpan = document.createElement('span');
        qtySpan.className = 'text-[14px] font-normal';
        qtySpan.textContent = item.quantity;

        const plusBtn = document.createElement('button');
        plusBtn.className = 'focus:outline-none';
        plusBtn.setAttribute('aria-label', 'Increase quantity');
        plusBtn.textContent = '+';
        plusBtn.addEventListener('click', () => {
          item.quantity++;
          renderOrder();
        });

        const totalPriceSpan = document.createElement('span');
        totalPriceSpan.className = 'ml-auto text-[14px] font-normal';
        totalPriceSpan.textContent = formatRupiah(item.price * item.quantity);

        qtyRow.appendChild(minusBtn);
        qtyRow.appendChild(qtySpan);
        qtyRow.appendChild(plusBtn);
        qtyRow.appendChild(totalPriceSpan);

        itemDiv.appendChild(topRow);
        itemDiv.appendChild(priceP);
        itemDiv.appendChild(qtyRow);

        orderItemsContainer.appendChild(itemDiv);
      });

      subtotalAmount.textContent = formatRupiah(subtotal);
    }

    // Add product to order or increase quantity if already added
    function addToOrder(id, name, price) {
      if (order[id]) {
        order[id].quantity++;
      } else {
        order[id] = { name, price, quantity: 1 };
      }
      renderOrder();
    }

    // Fetch products from Django backend
    async function fetchProducts() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/gudang/produk/');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const products = await response.json();
        return products;
      } catch (error) {
        console.error('Error fetching products:', error);
        return [];
      }
    }

    // Render products in the grid from Django backend
    async function renderProducts() {
      productsGrid.innerHTML = '<p class="col-span-3 text-center py-10">Loading products...</p>';

      const products = await fetchProducts();

      if (products.length === 0) {
        productsGrid.innerHTML = '<p class="col-span-3 text-center py-10">No products available</p>';
        return;
      }

      productsGrid.innerHTML = '';

      products.forEach((product) => {
        const div = document.createElement('div');
        div.className = 'bg-[#f9ec4a] rounded-xl p-4 flex flex-col items-center cursor-pointer product-item';
        div.setAttribute('data-id', product.id);
        div.setAttribute('data-name', product.nama);  // Assuming 'nama' is the field name from Django
        div.setAttribute('data-price', product.harga); // Assuming 'harga' is the field name from Django

        const imgWrapper = document.createElement('div');
        imgWrapper.className = 'bg-white rounded-md p-4 w-full flex justify-center';

        const img = document.createElement('img');
        img.className = 'product-image h-24 object-contain';
        // Assuming your Django API returns a URL for the image
        img.src = product.gambar || 'https://via.placeholder.com/100'; // Assuming 'gambar' is the field name
        img.alt = product.nama || 'Product image';
        img.decoding = 'async';
        img.loading = 'lazy';

        imgWrapper.appendChild(img);
        div.appendChild(imgWrapper);

        const p = document.createElement('p');
        p.className = 'font-robotomono font-extrabold text-[12px] mt-2 text-center leading-tight';
        p.textContent = product.nama;

        const priceP = document.createElement('p');
        priceP.className = 'font-robotomono font-bold text-[14px] mt-1';
        priceP.textContent = formatRupiah(product.harga);

        div.appendChild(p);
        div.appendChild(priceP);

        div.addEventListener('click', () => {
          addToOrder(product.id, product.nama, product.harga);
        });

        productsGrid.appendChild(div);
      });
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', () => {
      renderProducts();
    });
  </script>
</body>
</html>