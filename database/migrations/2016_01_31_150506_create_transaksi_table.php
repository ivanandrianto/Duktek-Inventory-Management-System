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
                $table->increments('id');
                $table->integer('id_barang');
                $table->timestamp('waktu_pinjam');
                $table->timestamp('waktu_rencana_kembali');
                $table->timestamp('waktu_kembali');
                $table->integer('duarsi');
                $table->integer('id_peminjam');
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
        Schema::table('transaksi', function (Blueprint $table) {
            Schema::drop('transaksi');
        });
    }
}
