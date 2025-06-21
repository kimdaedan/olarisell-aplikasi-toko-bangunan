<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('kasir_transaksis', function (Blueprint $table) {
        $table->string('customer_name')->nullable(); // Tambahkan kolom untuk nama customer
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('kasir_transaksis', function (Blueprint $table) {
        $table->dropColumn('customer_name'); // Hapus kolom saat rollback
    });
}
};
