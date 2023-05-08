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
        Schema::create('receive_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('head_id')->unsigned();
            $table->foreign('head_id')->references('id')->on('receive_head');
            $table->integer('produk_id')->unsigned();
            $table->foreign('produk_id')->references('id')->on('common_product');
            $table->integer('qty');
            $table->double('harga');
            $table->double('sub_total');
            $table->integer('status_item')->nullable();
            $table->float('diskitem_persen')->nullable();
            $table->double('diskitem_rupiah')->nullable();
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
        Schema::dropIfExists('receive_detail');
    }
};
