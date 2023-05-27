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
        Schema::create('return_jual_head', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_return', 50);
            $table->date('tgl_return');
            $table->integer('jual_id')->unsigned();
            $table->foreign('jual_id')->references('id')->on('jual_head');
            $table->double('total_return');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('return_jual_head');
    }
};
