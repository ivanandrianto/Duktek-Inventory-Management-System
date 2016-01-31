<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    public function pengguna(){
    	return $this->hasOne('App\Pengguna', 'id', 'id_pembooking');
    }

    public function peralatan(){
    	return $this->hasOne('App\Peralatan', 'id', 'id_barang');
    }
}