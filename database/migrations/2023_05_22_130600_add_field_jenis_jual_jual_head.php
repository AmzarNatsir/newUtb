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
        Schema::table('jual_head', function (Blueprint $table) {
            $table->integer('jenis_jual')->nullable(); //NULL : Penjualan, 1. Pemberian Sample
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jual_head', function (Blueprint $table) {
            //
        });
    }
};
