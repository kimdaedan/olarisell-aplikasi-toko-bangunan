<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->date('date'); // Kolom tanggal
            $table->string('category'); // Kolom kategori
            $table->decimal('amount', 10, 2); // Kolom jumlah
            $table->string('payment_status'); // Kolom status pembayaran
            $table->timestamps(); // Kolom untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses'); // Menghapus tabel jika rollback
    }
};