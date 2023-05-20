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
        Schema::create('piutang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_bayar', 50);
            $table->date('tgl_bayar');
            $table->integer('jual_id')->unsigned();
            $table->foreign('jual_id')->references('id')->on('jual_head');
            $table->integer('metode_bayar'); //1. Tunai, 2. Transfer
            $table->double('nominal');
            $table->text('keterangan')->nullable();
            $table->string('file_evidence')->nullable();
            $table->integer('flag')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('piutang');
    }
};
