<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeralatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('peralatan')){
            Schema::create('peralatan', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nama');
                $table->enum('status', array('Rusak', 'Tidak Rusak'));
                $table->enum('ketersediaan', array('Tersedia', 'Tidak Tersedia'));
                $table->string('lokasi');
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
        Schema::table('peralatan', function (Blueprint $table) {
            Schema::drop('peralatan');
        });
    }
}
