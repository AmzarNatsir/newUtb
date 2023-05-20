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
        Schema::create('common_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 30);
            $table->string('nama_customer', 100);
            $table->string('alamat', 100)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('no_telepon', 50)->nullable();
            $table->integer('level');
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
        Schema::dropIfExists('common_customer');
    }
};
