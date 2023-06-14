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
            $table->integer('status_approval')->nullable(); //null : belum approve, 1. Approved, 2. Reject
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
