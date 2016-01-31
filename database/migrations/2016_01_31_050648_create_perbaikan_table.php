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
                $table->increments('id_perbaikan');
                $table->integer('id_barang');
                $table->timestamp('waktu_mulai');
                $table->timestamp('waktu_selesai');
                $table->integer('duarsi');
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
        Schema::table('perbaikan', function (Blueprint $table) {
            Schema::drop('perbaikan');
        });
    }
}
