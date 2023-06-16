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
        Schema::table('po_head', function (Blueprint $table) {
            $table->integer('approved')->nullable(); //NULL : belum diapprove, 1. Approved
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->text('approved_note')->nullable();
            $table->integer('approved_2')->nullable(); //NULL : belum diapprove, 1. Approved
            $table->integer('approved_by_2')->nullable();
            $table->dateTime('approved_date_2')->nullable();
            $table->text('approved_note_2')->nullable();
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
        Schema::table('po_head', function (Blueprint $table) {
            //
        });
    }
};
