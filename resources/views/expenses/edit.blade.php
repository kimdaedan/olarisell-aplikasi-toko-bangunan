@extends('layouts.app')

@section('content')
<div class="p-5">
    <h2 class="text-2xl font-bold mb-4">Edit Pengeluaran</h2>
    <form action="{{ url('/expenses/' . $expense->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="date" class="block mb-1">Tanggal:</label>
            <input type="datetime-local" id="date" name="date" value="{{ $expense->date }}" class="border border-gray-300 rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="category" class="block mb-1">Kategori Pengeluaran:</label>
            <input type="text" id="category" name="category" value="{{ $expense->category }}" class="border border-gray-300 rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="amount" class="block mb-1">Jumlah:</label>
            <input type="number" id="amount" name="amount" value="{{ $expense->amount }}" class="border border-gray-300 rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block mb-1">Status Pembayaran:</label>
            <select id="status" name="status" class="border border-gray-300 rounded p-2 w-full" required>
                <option value="paid" {{ $expense->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ $expense->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            </select>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Perbarui</button>
    </form>
</div>
@endsection