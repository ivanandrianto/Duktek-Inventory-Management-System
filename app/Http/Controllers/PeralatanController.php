<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use App\Admin;
use App\Peralatan;
use App\Booking;
use App\Transaksi;
use App\Perbaikan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Session;

class JadwalDetail {
    var $id_pembooking;
    var $col;
    var $margin;
    var $height;

    function getIDPembooking(){
        return $this->id_pembooking;
    }
    function JadwalDetail($id_pembooking, $col, $margin, $height) {
        $this->id_pembooking    = $id_pembooking;
        $this->col              = $col;
        $this->margin           = $margin;
        $this->height           = $height;
    }
}

class PeralatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function peralatan($id = null) {
        if ($id == null) {
            return Peralatan::orderBy('id', 'asc')->get();
        } else {
            return $this->show($id);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getJenis() {
        return Peralatan::distinct()->select('jenis')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function search($jenis) {
        return Peralatan::where('jenis', 'LIKE' , '%'.$jenis.'%')->get();
    }

    public function jadwal2($id,$start_date,$end_date)
    {
        $jam_min = "00:00:00";
        $jam_maks = "23:59:59";

        $booking = Booking::where('id_barang', '=', $id)
                    ->where('waktu_booking_selesai' , '<=', $end_date.' '.$jam_maks)
                    ->where('waktu_booking_mulai' , '>=', $start_date.' '.$jam_min)
                    ->get();
        $tgl_start = substr($start_date,0,10);
        foreach($booking as $item){
            $col = -1;
            $height = $margin = 0;
            $mulai = $item["waktu_booking_mulai"];
            $selesai = $item["waktu_booking_selesai"];
            $jam_mulai = substr($mulai, 11);
            $jam_selesai_ori = substr($selesai, 11);
            $jam_selesai = $jam_selesai_ori;
            $tgl_mulai = substr($mulai, 0, 11);
            $col = (int)((strtotime($tgl_mulai) - strtotime($start_date)) / 86400);
            $selisih_menit = (int)((strtotime($selesai) - strtotime($mulai)) / 60);
            $isFirst = true;
            $listOfBooking;
            while($selisih_menit > 0){
                if($isFirst){
                    $margin = (int)((strtotime($jam_mulai) - strtotime($jam_min)) / 60);
                    $time_batas = (int)((strtotime($jam_maks) - strtotime($jam_mulai)) / 60);
                    if($selisih_menit <= $time_batas){
                        $height = $selisih_menit;
                        $selisih_menit = -1; //keluar dari loop
                        $jam_selesai = $jam_selesai_ori;
                    } else {
                        $height = $time_batas;
                        $selisih_menit -= $time_batas;
                        $jam_selesai = $jam_maks;
                    }
                    $isFirst = false;
                } else {
                    $margin = 0;
                    $jam_mulai = $jam_min;
                    $time_batas = (int)((strtotime($jam_maks) - strtotime($jam_min)) / 60);
                    if($selisih_menit <= $time_batas){
                        $height = $selisih_menit;
                        $selisih_menit = -1; //keluar dari loop
                        $jam_selesai = $jam_selesai_ori;
                    } else {
                        $height = $time_batas;
                        $selisih_menit -= $time_batas;
                        $jam_selesai = $jam_maks;
                    }
                }
                $jdwl = array("id"=>$item->id_pembooking, "col"=>$col, "margin"=>$margin, "height"=>$height, "jam_mulai"=>$jam_mulai, "jam_selesai"=>$jam_selesai);
                $listOfBooking[] = $jdwl;
                $col++;
            }
        }
        $period = (int)((strtotime($end_date) - strtotime($start_date)) / 86400);
        return view('peralatan.z', compact('booking','start_date','end_date','period','listOfBooking'));
    }

    public function jadwal($id,$bulan,$tahun)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        $output->writeln("jadwal");

        $listOfBooking[]="";
        $running_day = date('w',mktime(0,0,0,$bulan,1,$tahun));    
        $period = date('t',mktime(0,0,0,$bulan,1,$tahun));
        $start_date = $tahun + "-" + $bulan + "-" + "01" + " 00:00:00";
        $end_date = $tahun + "-" + $bulan + "-" + $period + " 23:59:59";
        $start_date_time = strtotime($start_date);
        $end_date_time = strtotime($end_date);
        $booking = Booking::where('id_barang', '=', $id);
                    /*->where(function($query) use ($start_date_time,$end_date_time){
                        $query->where('strtotime(waktu_booking_mulai)', '>=', $start_date_time)
                              ->where('strtotime(waktu_booking_mulai)', '<=', $end_date_time);
                    })
                    ->orWhere(function($query) use ($start_date_time,$end_date_time){
                        $query->where('strtotime(waktu_booking_selesai)', '>=', $start_date_time)
                              ->where('strtotime(waktu_booking_selesai)', '<=', $end_date_time);
                    })
                    ->orWhere(function($query) use ($start_date_time,$end_date_time){
                        $query->where('strtotime(waktu_booking_selesai)', '>=', $end_date_time)
                              ->where('strtotime(waktu_booking_mulai)', '<=', $start_date_time);
                    });*/
$output->writeln($booking->count());
        foreach($booking as $item){
            $output->writeln("aaaa");
            $col = -1;
            $height = $margin = 0;
            $mulai = $item["waktu_booking_mulai"];
            $selesai = $item["waktu_booking_selesai"];
            $jam_mulai = substr($mulai, 11);
            $jam_selesai_ori = substr($selesai, 11);
            $jam_selesai = $jam_selesai_ori;
            $tgl_mulai = substr($mulai, 0, 11);
            $col = (int)((strtotime($tgl_mulai) - strtotime($start_date)) / 86400);
            $selisih_menit = (int)((strtotime($selesai) - strtotime($mulai)) / 60);
            $isFirst = true;
            while($selisih_menit > 0){
                if($isFirst){
                    $margin = (int)((strtotime($jam_mulai) - strtotime($jam_min)) / 60);
                    $time_batas = (int)((strtotime($jam_maks) - strtotime($jam_mulai)) / 60);
                    if($selisih_menit <= $time_batas){
                        $height = $selisih_menit;
                        $selisih_menit = -1; //keluar dari loop
                        $jam_selesai = $jam_selesai_ori;
                    } else {
                        $height = $time_batas;
                        $selisih_menit -= $time_batas;
                        $jam_selesai = $jam_maks;
                    }
                    $isFirst = false;
                } else {
                    $margin = 0;
                    $jam_mulai = $jam_min;
                    $time_batas = (int)((strtotime($jam_maks) - strtotime($jam_min)) / 60);
                    if($selisih_menit <= $time_batas){
                        $height = $selisih_menit;
                        $selisih_menit = -1; //keluar dari loop
                        $jam_selesai = $jam_selesai_ori;
                    } else {
                        $height = $time_batas;
                        $selisih_menit -= $time_batas;
                        $jam_selesai = $jam_maks;
                    }
                }
                $jdwl = array("id"=>$item->id_pembooking, "col"=>$col, "margin"=>$margin, "height"=>$height, "jam_mulai"=>$jam_mulai, "jam_selesai"=>$jam_selesai);
                $listOfBooking[] = $jdwl;
                $col++;
            }
        }

            var_dump($listOfBooking);
        return view('peralatan.z', compact('booking','running_day','period','listOfBooking'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return Peralatan::find($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peralatan = Peralatan::all();     
        return view('peralatan.index', compact('peralatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('peralatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);

        $rules = array(
            'nama'          => 'required|min:5',
            'status'        => 'required',
            'ketersediaan'  => 'required',
            'lokasi'        => 'required',
            'jenis'         => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the store
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $ketersediaan = $status = "";
            if(Input::get('ketersediaan') == 1){
                $ketersediaan = "Tersedia";
            } else if (Input::get('ketersediaan') == 0){
                $ketersediaan = "Sedang Digunakan";
            } else {
                return "Ketersediaan tidak valid";
            }

            if(Input::get('status') == 0){
                $status = "Rusak";
            } else if(Input::get('status') == 1) {
                $status = "Baik";
            } else if(Input::get('status') == 2) {
                $status = "Perbaikan";
            } else {
                return "Status tidak valid";
            }
            // store
            $peralatan = new peralatan;
            $peralatan->nama            = Input::get('nama');
            $peralatan->status          = $status;
            $peralatan->ketersediaan    = $ketersediaan;
            $peralatan->lokasi          = Input::get('lokasi');
            $peralatan->jenis           = Input::get('jenis');
            $peralatan->save();

            return 1;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $peralatan = Peralatan::find($id);
        if(!$peralatan)
            return view('errors.404');
        return view('peralatan.edit', compact('peralatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        $output->writeln("update");
        $rules = array(
            'nama'          => 'required|min:5',
            'status'        => 'required',
            'ketersediaan'  => 'required',
            'lokasi'        => 'required',
            'jenis'         => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the update
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            // update
            if(Input::get('ketersediaan') == 1){
                $ketersediaan = "Tersedia";
            } else if (Input::get('ketersediaan') == 0){
                $ketersediaan = "Sedang Digunakan";
            } else {
                return "Ketersediaan tidak valid";
            }

            if(Input::get('status') == 0){
                $status = "Rusak";
            } else if(Input::get('status') == 1) {
                $status = "Baik";
            } else if(Input::get('status') == 2) {
                $status = "Perbaikan";
            } else {
                return "Status tidak valid";
            }

            $peralatan = Peralatan::find($id);
            if(!$peralatan)
                return "Not Found";
            $peralatan->nama            = Input::get('nama');
            $peralatan->status          = $status;
            $peralatan->ketersediaan    = $ketersediaan;
            $peralatan->lokasi          = Input::get('lokasi');
            $peralatan->jenis           = Input::get('jenis');
            $peralatan->save();

            return 1;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peralatan = Peralatan::find($id);
        if(!$peralatan)
                return "Not Found";

        $inBooking = Booking::where('id_barang' , '=', $id)->count();
        $inTransaksi = Transaksi::where('id_barang' , '=', $id)->count();
        $inPerbaakan = Perbaikan::where('id_barang' , '=', $id)->count();
        if(($inBooking > 0) || ($inTransaksi > 0) || ($inPerbaakan > 0)){
            return "Tidak dapat menghapus";
        } else {
            $peralatan->delete();
            return 1;
        }
    }
}