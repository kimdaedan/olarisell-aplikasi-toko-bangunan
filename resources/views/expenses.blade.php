<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLARISELL</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Fungsi untuk toggle form
        function toggleForm() {
            const form = document.getElementById('addExpenseForm');
            form.classList.toggle('hidden');
        }

        // Fungsi untuk memuat data dari Django backend
        async function loadExpenses() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/gudang/pengeluaran/');
                const expenses = response.data;
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = '';

                expenses.forEach(expense => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border border-gray-300 p-2">${expense.date}</td>
                        <td class="border border-gray-300 p-2">${expense.category}</td>
                        <td class="border border-gray-300 p-2">${parseFloat(expense.amount).toFixed(2)}</td>
                        <td class="border border-gray-300 p-2">${expense.payment_status}</td>
                        <td class="border border-gray-300 p-2">
                            <button class="bg-blue-500 text-white px-4 py-1 rounded">Actions</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } catch (error) {
                console.error('Error loading expenses:', error);
            }
        }

        // Fungsi untuk menambahkan pengeluaran baru
        async function addExpense(event) {
            event.preventDefault();

            const formData = {
                date: document.getElementById('date').value,
                category: document.getElementById('category').value,
                amount: document.getElementById('amount').value,
                payment_status: document.getElementById('status').value
            };

            try {
                const response = await axios.post('http://127.0.0.1:8000/api/gudang/pengeluaran/', formData);
                if (response.status === 201) {
                    alert('Pengeluaran berhasil ditambahkan!');
                    toggleForm();
                    loadExpenses();
                }
            } catch (error) {
                console.error('Error adding expense:', error);
                alert('Gagal menambahkan pengeluaran');
            }
        }

        // Memuat data saat halaman dimuat
        document.addEventListener('DOMContentLoaded', loadExpenses);
    </script>
</head>
<body class="bg-gray-100">
    <!-- ... (bagian nav dan header tetap sama) ... -->

    <!-- Form untuk menambahkan data -->
    <div id="addExpenseForm" class="hidden mb-4 p-4 border border-gray-300 rounded bg-white">
        <h2 class="text-xl font-bold mb-2">Tambah Pengeluaran</h2>
        <form id="expenseForm" onsubmit="addExpense(event)">
            <div class="mb-4">
                <label class="block mb-1" for="date">Tanggal:</label>
                <input type="datetime-local" id="date" name="date" class="border border-gray-300 rounded p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1" for="category">Kategori Pengeluaran:</label>
                <input type="text" id="category" name="category" class="border border-gray-300 rounded p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1" for="amount">Jumlah:</label>
                <input type="number" id="amount" name="amount" class="border border-gray-300 rounded p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1" for="status">Status Pembayaran:</label>
                <select id="status" name="status" class="border border-gray-300 rounded p-2 w-full" required>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
            <button type="button" onclick="toggleForm()" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</button>
        </form>
    </div>

    <!-- Tabel expenses -->
    <table class="min-w-full border-collapse border border-gray-200">
        <thead>
            <tr>
                <th class="border border-gray-300 p-2 bg-blue-500 text-white">Date</th>
                <th class="border border-gray-300 p-2 bg-blue-500 text-white">Expense Category</th>
                <th class="border border-gray-300 p-2 bg-blue-500 text-white">Total Amount</th>
                <th class="border border-gray-300 p-2 bg-blue-500 text-white">Payment Status</th>
                <th class="border border-gray-300 p-2 bg-blue-500 text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data akan diisi secara dinamis oleh JavaScript -->
        </tbody>
    </table>
</body>
</html>