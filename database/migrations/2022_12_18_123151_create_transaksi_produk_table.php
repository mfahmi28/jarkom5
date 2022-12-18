<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('produk_id');
            $table->bigInteger('qty');
            $table->bigInteger('locked_price');
            $table->bigInteger('locked_total');
            $table->foreign('transaksi_id')->references('id')->on('transaksi');
            $table->foreign('produk_id')->references('id')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_produk');
    }
}
