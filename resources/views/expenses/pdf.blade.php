<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengeluaran PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Daftar Pengeluaran</h1>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->date }}</td>
                <td>{{ $expense->category }}</td>
                <td>Rp {{ number_format($expense->amount, 2, ',', '.') }}</td>
                <td>{{ $expense->payment_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>