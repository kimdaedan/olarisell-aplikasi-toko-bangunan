<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller // Nama class sebaiknya PascalCase
{
    public function index()
    {
        $expenses = Expenses::all(); // Sesuaikan dengan nama model yang benar
        return view('expenses', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:10',
        ]);

        Expenses::create([
            'date' => $request->date,
            'category' => $request->category,
            'payment_status' => $request->status, // Pastikan nama kolom di database sesuai
        ]);

        // Hanya satu return statement yang akan dieksekusi
        return redirect()->route('expenses.index')->with('success', 'Expenses added successfully.');
    }
}