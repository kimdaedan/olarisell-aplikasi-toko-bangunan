<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Product Order Page with Dynamic Category Products
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
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
   <!-- Sidebar -->
   <nav class="w-40 border-r border-black px-3 py-4 select-none font-robotomono font-bold text-[14px]">
    <ul class="space-y-4">
     <li>
      <button aria-controls="cat-submenu" aria-expanded="false" class="flex items-center space-x-2 text-black w-full focus:outline-none" id="cat-btn" type="button">
       <i class="fas fa-chevron-right transition-transform duration-200" id="cat-icon">
       </i>
       <span>
        CAT
       </span>
      </button>
      <ul class="mt-2 space-y-3 pl-6 font-extrabold text-[13px] hidden" id="cat-submenu">
       <li class="flex items-center space-x-2 cursor-default">
        <i class="fas fa-paint-roller text-[14px]">
        </i>
        <span>
         Cat air
        </span>
       </li>
       <li class="flex items-center space-x-2 cursor-default">
        <i class="fas fa-paint-roller text-[14px]">
        </i>
        <span>
         Cat minyak
        </span>
       </li>
      </ul>
     </li>
     <li>
      <button aria-controls="semen-submenu" aria-expanded="false" class="flex items-center space-x-2 text-black w-full focus:outline-none" id="semen-btn" type="button">
       <i class="fas fa-chevron-right transition-transform duration-200" id="semen-icon">
       </i>
       <span>
        SEMEN
       </span>
      </button>
      <ul class="mt-2 space-y-3 pl-6 font-extrabold text-[13px] hidden" id="semen-submenu">
       <li class="cursor-default">
        Semen Portland
       </li>
       <li class="cursor-default">
        Semen putih
       </li>
       <li class="cursor-default">
        Semen Portland Pozzolan
       </li>
       <li class="cursor-default">
        Semen Portland Composite
       </li>
      </ul>
     </li>
     <li>
      <button aria-controls="besi-submenu" aria-expanded="false" class="flex items-center space-x-2 text-black font-bold text-[14px] w-full focus:outline-none" id="besi-btn" type="button">
       <i class="fas fa-chevron-right transition-transform duration-200" id="besi-icon">
       </i>
       <span>
        BESI
       </span>
      </button>
     </li>
     <li>
      <button aria-controls="pasir-submenu" aria-expanded="false" class="flex items-center space-x-2 text-black font-bold text-[14px] w-full focus:outline-none" id="pasir-btn" type="button">
       <i class="fas fa-chevron-right transition-transform duration-200" id="pasir-icon">
       </i>
       <span>
        PASIR
       </span>
      </button>
     </li>
    </ul>
   </nav>
   <!-- Products Grid -->
   <section class="flex-grow overflow-auto p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="products-grid">
    <!-- Products will be dynamically inserted here -->
   </section>
   <!-- Order Summary -->
   <aside class="w-72 border-l border-black flex flex-col">
    <div class="bg-[#f9ec4a] px-4 py-3 font-robotomono font-extrabold text-[14px]">
     <p id="order-title">
      New Order
     </p>
     <p class="text-[12px] font-normal" id="order-date">
      <!-- Empty initially -->
     </p>
    </div>
    <div class="flex-grow overflow-auto px-4 py-3 space-y-6" id="order-items">
     <!-- Initially empty -->
     <p class="text-center text-black/50 font-robotomono text-[14px] mt-10" id="empty-order-text">No items added</p>
    </div>
    <div class="px-4 py-3 border-t border-black font-robotomono font-extrabold text-[14px] flex justify-between" id="subtotal-container" style="display:none;">
     <span>
      Subtotal
     </span>
     <span id="subtotal-amount">
      Rp.0
     </span>
    </div>
    <div class="p-4">
     <button class="w-full bg-[#f9ec4a] rounded-full py-2 px-4 font-robotomono font-bold text-[14px] flex items-center justify-center space-x-2 hover:bg-yellow-300 focus:outline-none" id="pay-now-btn" type="button" disabled>
      <i class="fas fa-hand-holding-usd text-lg">
      </i>
      <span>
       Pay Now
      </span>
     </button>
    </div>
   </aside>
  </main>
  <script>
   // Toggle submenu function
   function toggleMenu(buttonId, submenuId, iconId) {
     const btn = document.getElementById(buttonId);
     const submenu = document.getElementById(submenuId);
     const icon = document.getElementById(iconId);
     btn.addEventListener('click', () => {
       const expanded = btn.getAttribute('aria-expanded') === 'true';
       btn.setAttribute('aria-expanded', !expanded);
       if (!expanded) {
         submenu?.classList.remove('hidden');
         icon.classList.remove('fa-chevron-right');
         icon.classList.add('fa-chevron-down');
         icon.style.transform = 'rotate(0deg)';
       } else {
         submenu?.classList.add('hidden');
         icon.classList.remove('fa-chevron-down');
         icon.classList.add('fa-chevron-right');
         icon.style.transform = 'rotate(0deg)';
       }
     });
   }
   toggleMenu('cat-btn', 'cat-submenu', 'cat-icon');
   toggleMenu('semen-btn', 'semen-submenu', 'semen-icon');

   // Data for products by category
   const productsData = {
  cat: [
    {
      id: '1',
      name: 'CAT JOTUN',
      price: 300000,
      img: 'images/cat/jotun.png',
      alt: 'Jotun paint can with red and yellow label and thumbs up logo'
    },
    {
      id: '2',
      name: 'CAT NIPPON',
      price: 100000,
      img: 'images/cat/nippon.png',
      alt: 'Avian paint can with blue label and wooden chair in background'
    },
    {
      id: '3',
      name: 'CAT AVIAN',
      price: 100000,
      img: 'images/cat/avian.png',
      alt: 'Avian paint can with blue label and wooden chair in background'
    },
    {
      id: '4',
      name: 'CAT PFFPAINT',
      price: 100000,
      img: 'images/cat/pffpaint.png',
      alt: 'Avian paint can with blue label and wooden chair in background'
    },
    // Add more products here...
  ],
  semen: [
    {
      id: 's1',
      name: 'Semen Putih',
      price: 120000,
      img: 'images/semen/semenputih.png',
      alt: 'Bag of Semen Portland cement with white background'
    },
    {
      id: 's2',
      name: 'Semen Tiga Roda',
      price: 130000,
      img: 'images/semen/sementigaroda.png',
      alt: 'Bag of Semen putih cement with white background'
    },
    {
      id: 's3',
      name: 'Semen gresik',
      price: 130000,
      img: 'images/semen/semengresik.png',
      alt: 'Bag of Semen putih cement with white background'
    },
    {
      id: 's4',
      name: 'Semen Holcim',
      price: 130000,
      img: 'images/semen/semenholcim.png',
      alt: 'Bag of Semen putih cement with white background'
    },
    // Add more products here...
  ],
  besi: [
    {
      id: 'b1',
      name: 'Besi Hollow',
      price: 150000,
      img: 'images/besi/besihollow.png',
      alt: 'Besi Hollow metal pipe 1 with white background'
    },
    {
      id: 'b2',
      name: 'Besi Siku',
      price: 115000,
      img: 'images/besi/besisiku.png',
      alt: 'Besi Hollow metal pipe 1 with white background'
    },
    {
      id: 'b3',
      name: 'Besi Beton',
      price: 120000,
      img: 'images/besi/besibeton.png',
      alt: 'Besi Hollow metal pipe 1 with white background'
    },
    {
      id: 'b4',
      name: 'Plat Besi',
      price: 125000,
      img: 'images/besi/platbesi.png',
      alt: 'Besi Hollow metal pipe 1 with white background'
    },
    // Add more products here...
  ],
  pasir: [
    {
      id: 'p1',
      name: 'Pasir Beton',
      price: 100000,
      img: 'images/pasir/pasirbeton.png',
      alt: 'Bag of Pasir Putih sand with white background'
    },
    {
      id: 'p2',
      name: 'Pasir Urug',
      price: 85000,
      img: 'images/pasir/pasirurug.png',
      alt: 'Bag of Pasir Putih sand with white background'
    },
    {
      id: 'p3',
      name: 'Pasir Coklat Belitung',
      price: 90000,
      img: 'images/pasir/pasircoklatbelitung.png',
      alt: 'Bag of Pasir Putih sand with white background'
    },
    {
      id: 'p4',
      name: 'Pasir Mundu',
      price: 85000,
      img: 'images/pasir/pasirMundu.png',
      alt: 'Bag of Pasir Putih sand with white background'
    },
    // Add more products here...
  ]
};

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

   // Render products in the grid based on selected category
   function renderProducts(category) {
     productsGrid.innerHTML = '';
     const products = productsData[category];
     if (!products) return;
     products.forEach((product) => {
       const div = document.createElement('div');
       div.className = 'bg-[#f9ec4a] rounded-xl p-4 flex flex-col items-center cursor-pointer product-item';
       div.setAttribute('data-id', product.id);
       div.setAttribute('data-name', product.name);
       div.setAttribute('data-price', product.price);

       const imgWrapper = document.createElement('div');
       imgWrapper.className = 'bg-white rounded-md p-4';

       const img = document.createElement('img');
       img.className = 'product-image';
       img.src = product.img;
       img.alt = product.alt;
       img.decoding = 'async';
       img.loading = 'lazy';
       img.width = 100;
       img.height = 100;

       imgWrapper.appendChild(img);
       div.appendChild(imgWrapper);

       const p = document.createElement('p');
       p.className = 'font-robotomono font-extrabold text-[12px] mt-2 text-center leading-tight';
       p.innerHTML = product.name.replace(/\n/g, '<br/>');

       div.appendChild(p);

       div.addEventListener('click', () => {
         addToOrder(product.id, product.name, product.price);
       });

       productsGrid.appendChild(div);
     });
   }

   // Initial render with 'cat' category
   renderProducts('cat');

   // Toggle submenu function for sidebar menus
   function setupToggleMenu(buttonId, submenuId, iconId) {
     const btn = document.getElementById(buttonId);
     const submenu = document.getElementById(submenuId);
     const icon = document.getElementById(iconId);
     btn.addEventListener('click', () => {
       const expanded = btn.getAttribute('aria-expanded') === 'true';
       btn.setAttribute('aria-expanded', !expanded);
       if (!expanded) {
         submenu?.classList.remove('hidden');
         icon.classList.remove('fa-chevron-right');
         icon.classList.add('fa-chevron-down');
         icon.style.transform = 'rotate(0deg)';
       } else {
         submenu?.classList.add('hidden');
         icon.classList.remove('fa-chevron-down');
         icon.classList.add('fa-chevron-right');
         icon.style.transform = 'rotate(0deg)';
       }
     });
   }
   setupToggleMenu('cat-btn', 'cat-submenu', 'cat-icon');
   setupToggleMenu('semen-btn', 'semen-submenu', 'semen-icon');

   // Category buttons for changing product grid
   document.getElementById('cat-btn').addEventListener('click', () => {
     renderProducts('cat');
   });
   document.getElementById('semen-btn').addEventListener('click', () => {
     renderProducts('semen');
   });

   // Add event listeners for BESI and PASIR buttons to load their products
   document.getElementById('besi-btn').addEventListener('click', () => {
     renderProducts('besi');
     // Toggle arrow icon and aria-expanded manually for BESI
     const btn = document.getElementById('besi-btn');
     const icon = document.getElementById('besi-icon');
     const expanded = btn.getAttribute('aria-expanded') === 'true';
     btn.setAttribute('aria-expanded', !expanded);
     if (!expanded) {
       icon.classList.remove('fa-chevron-right');
       icon.classList.add('fa-chevron-down');
       icon.style.transform = 'rotate(0deg)';
     } else {
       icon.classList.remove('fa-chevron-down');
       icon.classList.add('fa-chevron-right');
       icon.style.transform = 'rotate(0deg)';
     }
   });
   document.getElementById('pasir-btn').addEventListener('click', () => {
     renderProducts('pasir');
     // Toggle arrow icon and aria-expanded manually for PASIR
     const btn = document.getElementById('pasir-btn');
     const icon = document.getElementById('pasir-icon');
     const expanded = btn.getAttribute('aria-expanded') === 'true';
     btn.setAttribute('aria-expanded', !expanded);
     if (!expanded) {
       icon.classList.remove('fa-chevron-right');
       icon.classList.add('fa-chevron-down');
       icon.style.transform = 'rotate(0deg)';
     } else {
       icon.classList.remove('fa-chevron-down');
       icon.classList.add('fa-chevron-right');
       icon.style.transform = 'rotate(0deg)';
     }
   });
  </script>
 </body>
</html>