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
                $table->increments('id');
                $table->integer('id_barang');
                $table->timestamp('waktu_booking_mulai');
                $table->timestamp('waktu_booking_kembali');
                $table->integer('id_pembooking');
                $table->timestamps();
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
