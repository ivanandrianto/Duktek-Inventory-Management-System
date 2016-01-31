<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if(!Schema::hasTable('pengguna')){
            Schema::create('pengguna', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nama');
                $table->string('alamat');
                $table->string('no_telp');
                $table->string('jenis');
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
        Schema::table('pengguna', function (Blueprint $table) {
            Schema::drop('pengguna');
        });
    }
}
