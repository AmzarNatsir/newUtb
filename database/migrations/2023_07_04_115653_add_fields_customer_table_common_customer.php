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
        Schema::table('common_customer', function (Blueprint $table) {
            $table->string('no_identitas', 50)->nullable();
            $table->float('lat', 10, 6)->nullable();
            $table->float('lng', 10, 6)->nullable();
            $table->string('file_identitas', 100)->nullable();
            $table->string('file_lokasi', 100)->nullable();
            $table->integer('status')->nullable();
            $table->integer('approve_by')->nullable();
            $table->date('approve_date')->nullable();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('common_customer', function (Blueprint $table) {
            //
        });
    }
};
