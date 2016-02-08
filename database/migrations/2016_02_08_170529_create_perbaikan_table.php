<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerbaikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('perbaikan')){
            Schema::create('perbaikan', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->integer('id_barang')->unsigned();
                $table->timestamp('waktu_mulai');
                $table->timestamp('waktu_selesai');
                $table->integer('duarsi');
                $table->timestamps();
                $table->foreign('id_barang')->references('id')->on('peralatan');
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
        Schema::table('perbaikan', function (Blueprint $table) {
            Schema::drop('perbaikan');
        });
    }
}
