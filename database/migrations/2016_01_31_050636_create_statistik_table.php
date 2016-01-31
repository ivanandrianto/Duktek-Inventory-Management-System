<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatistikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('statistik')){
            Schema::create('statistik', function (Blueprint $table) {
                $table->integer('id_barang')->unique();
                $table->integer('jumlah_pengguna');
                $table->integer('jumlah_kerusakan');
                $table->string('jenis_pengguna');
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
        Schema::table('statistik', function (Blueprint $table) {
            Schema::drop('statistik');
        });
    }
}
