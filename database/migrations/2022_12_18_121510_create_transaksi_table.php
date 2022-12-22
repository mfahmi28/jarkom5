<?php

use Brick\Math\BigInteger;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status');
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('cabang_id');
            $table->unsignedBigInteger('maker_id');
            $table->unsignedBigInteger('reciever_id')->nullable();

            $table->text('description')->nullable();

            $table->bigInteger('tax')->default(0);

            $table->bigInteger('sort_subtotal')->default(0);

            $table->date('estimated_date');
            $table->date('expired_date');

            $table->dateTime('recieved_at')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('cabang_id')->references('id')->on('cabang')->onDelete('cascade');
            $table->foreign('maker_id')->references('id')->on('users');
            $table->foreign('reciever_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
