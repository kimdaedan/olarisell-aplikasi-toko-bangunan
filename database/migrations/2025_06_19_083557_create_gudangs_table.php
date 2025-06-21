<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGudangsTable extends Migration
{
    public function up()
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama produk
            $table->integer('jumlah'); // Jumlah produk
            $table->decimal('harga', 10, 2); // Harga produk
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('gudangs');
    }
}
