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
        Schema::create('common_kontainer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_kontainer', 200);
            $table->string('alamat', 200)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_telepon', 50)->nullable();
            $table->string('kontak_person', 100)->nullable();
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
        Schema::dropIfExists('common_kontainer');
    }
};
