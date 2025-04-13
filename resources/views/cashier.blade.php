<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Sederhana</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .total {
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Aplikasi Kasir</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pilih Item</h5>
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Nama Produk / SKU / Bar Kode">
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" placeholder="Jumlah">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary">Tambah Item</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Daftar Item</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Contoh Produk</td>
                            <td>2</td>
                            <td>20.00</td>
                        </tr>
                        <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                    </tbody>
                </table>
                <div class="total">
                    Total: 20.00
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <button class="btn btn-success">Cash</button>
                <button class="btn btn-secondary">Kembali</button>
                <button class="btn btn-danger">Batal</button>
            </div>
        </div>
    </div>
</body>
</html>