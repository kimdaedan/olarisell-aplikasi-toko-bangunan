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
    Schema::table('transaksi_detail', function (Blueprint $table) {
        $table->unsignedBigInteger('customer_id')->after('id'); // Atur sesuai kebutuhan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('transaksi_detail', function (Blueprint $table) {
        $table->dropColumn('customer_id');
    });
}
};
