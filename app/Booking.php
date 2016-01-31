<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    public function pengguna(){
    	return $this->hasOne('App\Pengguna', 'id', 'id_pembooking');
    }

    public function peralatan(){
    	return $this->hasOne('App\Peralatan', 'id', 'id_barang');
    }
}