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
                $table->increments('id')->unique();
                $table->string('nama',50);
                $table->text('alamat');
                $table->string('no_telp',20);
                $table->enum('jenis', array('Dosen', 'Mahasiswa','Karyawan'));
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
