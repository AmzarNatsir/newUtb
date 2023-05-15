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
        Schema::create('jual_head', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('common_customer');
            $table->string('no_invoice', 50);
            $table->date('tgl_invoice');
            $table->integer('bayar_via')->nullable();
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->text('keterangan')->nullable();
            $table->double('total_invoice');
            $table->float('ppn_persen')->nullable();
            $table->double('ppn_rupiah')->nullable();
            $table->float('diskon_persen')->nullable();
            $table->double('diskon_rupiah')->nullable();
            $table->double('ongkir')->nullable();
            $table->double('total_invoice_net')->nullable();
            $table->integer('status_invoice')->nullable();
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
        Schema::dropIfExists('jual_head');
    }
};
