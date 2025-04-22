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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->string('product_name'); // Kolom nama produk
            $table->integer('current_stock')->default(0); // Kolom stok saat ini
            $table->string('product_image')->nullable(); // Kolom gambar produk
            $table->timestamps(); // Kolom untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products'); // Menghapus tabel jika rollback
    }
};