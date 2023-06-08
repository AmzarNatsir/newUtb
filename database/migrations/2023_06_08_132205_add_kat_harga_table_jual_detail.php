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
        Schema::table('jual_detail', function (Blueprint $table) {
            $table->integer('kat_harga')->nullable(); //1. Eceranan, 2.Toko
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jual_detail', function (Blueprint $table) {
            //
        });
    }
};
