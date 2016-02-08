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
                $table->increments('id')->unique();
                $table->string('nama',50);
                $table->enum('status', array('Rusak', 'Perbaikan','Baik'));
                $table->enum('ketersediaan', array('Tersedia', 'Sedang Digunakan'));
                $table->string('lokasi',300);
                $table->string('jenis',50);
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
