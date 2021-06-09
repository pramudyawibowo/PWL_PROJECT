<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pesanan', 100);
            $table->string('nama_pelanggan', 50);
            $table->string('alamat_pelanggan', 50);
            $table->string('no_hp_pelanggan', 15);
            $table->string('nama_barang', 20);
            $table->unsignedBigInteger('id_kategori');
            $table->string('keluhan');
            $table->timestamps();
            $table->foreign('id_kategori')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
