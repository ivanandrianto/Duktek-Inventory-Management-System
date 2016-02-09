<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('transaksi')){
            Schema::create('transaksi', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->integer('id_barang')->unsigned();
                $table->timestamp('waktu_pinjam');
                $table->timestamp('waktu_rencana_kembali');
                $table->timestamp('waktu_kembali');
                $table->integer('duarsi');
                $table->integer('id_peminjam')->unsigned();
                $table->timestamps();
                $table->foreign('id_peminjam')->references('id')->on('pengguna');
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
        Schema::table('transaksi', function (Blueprint $table) {
            Schema::drop('transaksi');
        });
    }
}
