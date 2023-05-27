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
        Schema::create('return_jual_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('head_id')->unsigned();
            $table->foreign('head_id')->references('id')->on('return_jual_head');
            $table->integer('produk_id')->unsigned();
            $table->foreign('produk_id')->references('id')->on('common_product');
            $table->double('qty');
            $table->double('harga');
            $table->double('sub_total');
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
        Schema::dropIfExists('return_jual_detail');
    }
};
