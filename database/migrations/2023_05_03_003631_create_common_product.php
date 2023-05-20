<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('common_unit');
            $table->string('kode', 100);
            $table->string('nama_produk', 200);
            $table->string('kemasan', 50)->nullable();
            $table->double('harga_toko');
            $table->double('harga_eceran');
            $table->string('gambar', 200)->nullable();
            $table->integer('merk_id')->nullable();
            $table->double('stok_awal')->nullable();
            $table->double('stok_akhir')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_product');
    }
};
