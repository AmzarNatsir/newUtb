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
        Schema::create('receive_head', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_id')->unsigned();
            $table->foreign('po_id')->references('id')->on('po_head');
            $table->integer('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('common_supplier');
            $table->string('nomor_receive', 50);
            $table->date('tanggal_receive');
            $table->text('keterangan')->nullable();
            $table->float('ppn_persen')->nullable();
            $table->double('ppn_rupiah')->nullable();
            $table->float('diskon_persen')->nullable();
            $table->double('diskon_rupiah')->nullable();
            $table->double('total_receice');
            $table->double('total_receive_net');
            $table->integer('cara_bayar')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('receive_head');
    }
};
