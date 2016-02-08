<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('booking')){
            Schema::create('booking', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->integer('id_barang')->unsigned();
                $table->timestamp('waktu_booking_mulai');
                $table->timestamp('waktu_booking_selesai');
                $table->integer('id_pembooking')->unsigned();
                $table->timestamps();
                $table->foreign('id_barang')->references('id')->on('peralatan');
                $table->foreign('id_pembooking')->references('id')->on('pengguna');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            Schema::drop('booking');
        });
    }
}
