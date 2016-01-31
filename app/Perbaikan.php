<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    protected $table = 'perbaikan';

    public function peralatan(){
    	return $this->hasOne('App\Peralatan', 'id', 'id_barang');
    }
}