<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Auth;
use App\Admin;
use App\Transaksi;
use App\Peralatan;
use App\Booking;
use App\Pengguna;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Session;

class TransaksiController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function transaksi($id = null) {
        if ($id == null) {
            return Transaksi::orderBy('id', 'desc')->get();
        } else {
            return $this->show($id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return Transaksi::with('peralatan')->get()->find($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::all();       
        return view('transaksi.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transaksi.create');
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
        $output->writeln("store");

        $rules = array(
            'jenis_barang'          => 'required',
            'id_peminjam'           => 'required',
            'waktu_rencana_kembali' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {

            //cek id pengguna
            $pengguna = Pengguna::find(Input::get('id_peminjam'));
            if(!$pengguna)
                return "ID pengguna tidak ditemukan";
            // cek ketersediaan
            $alat_sesuai_jenis = Peralatan::where('jenis' , '=', Input::get('jenis_barang'))->get();
            $selected_id = -1;
            $now = Carbon::now()->addHours(7)->toDateTimeString();
            $output->writeln($now);
            $curTime = strtotime($now);

            if(!checkDateTime(Input::get('waktu_rencana_kembali'))){
                return "Waktu rencana kembali tidak valid";
            }

            $output->writeln(Input::get('waktu_rencana_kembali'));
            if($curTime >= strtotime(Input::get('waktu_rencana_kembali'))){
                return "Waktu rencana kembali tidak valid";
            }

            $waktu_rencana_kembali_time = strtotime(Input::get('waktu_rencana_kembali'));
            foreach ($alat_sesuai_jenis as $alat)
            {
                $available = true;
                $output->writeln($alat->status);
                $output->writeln($alat->ketersediaan);
                if((strcmp($alat->status,"Baik") != 0) || (strcmp($alat->ketersediaan,"Tersedia") != 0)){
                    $available = false;
                    break;
                }
                //cek di data booking
                $booking_of_alat = Booking::where('id_barang', '=', $alat->id)->get();
                foreach ($booking_of_alat as $booking){
                    $booking_mulai_time = strtotime($booking->waktu_booking_mulai);
                    $booking_selesai_time = strtotime($booking->waktu_booking_selesai);
                    $output->writeln($curTime);
                    $output->writeln($booking_mulai_time);
                    $output->writeln($booking_selesai_time);
                    if((($curTime > $booking_mulai_time) && ($curTime < $booking_selesai_time)) ||
                        (($waktu_rencana_kembali_time > $booking_mulai_time) && ($waktu_rencana_kembali_time < $booking_selesai_time))||(($booking_mulai_time > $curTime) && ($booking_mulai_time < $waktu_rencana_kembali_time))||(($booking_selesai_time > $curTime) && ($booking_selesai_time < $waktu_rencana_kembali_time))){
                            $available = false;
                    }
                }
                if($available){
                    $selected_id = $alat->id;
                }
            }
            if($selected_id < 1){
                return "Tidak ada alat tersedia";
            } else {
                //cek tanggal
                if(strtotime(Input::get('waktu_rencana_kembali')) <= strtotime(Input::get('waktu_pinjam'))){
                    return "Tanggal tidak valid";
                } else {
                    // store
                    $transaksi = new transaksi;
                    $transaksi->id_barang               = $selected_id;
                    //ganti dengan jenis barang
                    $transaksi->id_peminjam             = Input::get('id_peminjam');
                    $transaksi->waktu_pinjam            = $now;
                    $transaksi->waktu_rencana_kembali   = Input::get('waktu_rencana_kembali');
                    $transaksi->save();

                    //ubah ketersediaan peralatan
                    $peralatan = Peralatan::find($selected_id);
                    if(!$peralatan)
                        return "ID peralatan tidak ditemukan";
                    $peralatan->ketersediaan = "Sedang Digunakan";
                    $peralatan->save();

                    return $transaksi->id;
                }
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaksi = Transaksi::find($id);
        if(!$transaksi)
            return view('errors.404');
        return view('transaksi.edit', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'jenis_barang'          => 'required',
            'id_peminjam'           => 'required',
            'waktu_pinjam'          => 'required',
            'waktu_rencana_kembali' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the update
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            //cek id pengguna
            $pengguna = Pengguna::find(Input::get('id_peminjam'));
            if(!$pengguna)
                return "ID pengguna tidak ditemukan";
            
            // update         
            $transaksi = Transaksi::find($id);
            if(!$transaksi)
                return "Not Found";

            if(!checkDateTime(Input::get('waktu_pinjam'))){
                return "Waktu pinjam tidak valid";
            }

            if(!checkDateTime(Input::get('waktu_rencana_kembali'))){
                return "Waktu rencana kembali tidak valid";
            }

            if(strtotime(Input::get('waktu_rencana_kembali')) <= strtotime(Input::get('waktu_pinjam'))){
                return "Waktu tidak valid";
            }

            if(Input::get('waktu_kembali')){
                if(!checkDateTime(Input::get('waktu_kembali'))){
                    return "Waktu kembali tidak valid";
                }

                if(strtotime(Input::get('waktu_kembali')) <= strtotime(Input::get('waktu_pinjam'))){
                return "Waktu tidak valid";
                    }
            }

            

            $id_barang_old = $transaksi->id_barang;
            $barang_old = Peralatan::find($id_barang_old);
            $jenis_barang_old = $barang_old->jenis;
            $selected_id = -1;

            if(strcmp(Input::get('jenis_barang'),$jenis_barang_old)==0){
                $selected_id = $id_barang_old;
            } else { // cari peralatan baru
                $waktu_pinjam_time = strtotime(Input::get('waktu_pinjam'));
                $waktu_rencana_kembali_time = strtotime(Input::get('waktu_rencana_kembali'));
                foreach ($alat_sesuai_jenis as $alat)
                {
                    $available = true;
                    $output->writeln($alat->status);
                    $output->writeln($alat->ketersediaan);
                    if((strcmp($alat->status,"Baik") != 0) || (strcmp($alat->ketersediaan,"Tersedia") != 0)){
                        $available = false;
                        break;
                    }
                    //cek di data booking
                    $booking_of_alat = Booking::where('id_barang', '=', $alat->id)->get();
                    foreach ($booking_of_alat as $booking){
                        $booking_mulai_time = strtotime($booking->waktu_booking_mulai);
                        $booking_selseai_time = strtotime($booking->waktu_booking_selesai);
                        if((($waktu_pinjam_time > $booking_mulai_time) && ($waktu_pinjam_time < $booking_selesai_time)) ||
                            (($waktu_rencana_kembali_time > $booking_mulai_time) && ($waktu_rencana_kembali_time < $booking_selesai_time))||(($booking_mulai_time > $waktu_pinjam_time) && ($booking_mulai_time < $waktu_rencana_kembali_time))||(($booking_selesai_time > $waktu_pinjam_time) && ($booking_selesai_time < $waktu_rencana_kembali_time))){
                                $available = false;
                        }
                    }
                    if($available){
                        $selected_id = $alat->id;
                    }
                }
            }
            if($selected_id < 1){
                return "Tidak ada alat tersedia";
            } else {
                $transaksi->id_barang               = Input::get('id_barang');
                $transaksi->id_peminjam             = Input::get('id_peminjam');
                $transaksi->waktu_pinjam            = Input::get('waktu_pinjam');
                $transaksi->waktu_rencana_kembali   = Input::get('waktu_rencana_kembali');
                $transaksi->waktu_kembali           = Input::get('waktu_kembali');
                $transaksi->save();
                return $transaksi->id;
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function end(Request $request, $id)
    {

        $rules = array(
            'waktu_kembali'   => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the update
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            // store
            $transaksi = Transaksi::find($id);
            if(!$transaksi)
                return "Not Found";


            if(!checkDateTime(Input::get('waktu_kembali'))){
                return "Waktu kembali tidak valid";
            }

            if(strtotime(Input::get('waktu_kembali')) <= strtotime(Input::get('waktu_pinjam'))){
            return "Waktu tidak valid";
            }

            $now = Carbon::now()->addHours(7)->toDateTimeString();  
            $transaksi->waktu_kembali   = $now;
            $id_barang = $transaksi->id_barang;
            $transaksi->save();

            //ubah ketersediaan peralatan
            $peralatan = Peralatan::find($id_barang);
            if(!$peralatan)
                return "ID peralatan tidak ditemukan";
            $peralatan->ketersediaan = "Tersedia";
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
        $transaksi = Transaksi::find($id);
        if(!$transaksi)
                return "Not Found";
        $now = Carbon::now()->addHours(7)->toDateTimeString();  
        $curDateTime = strtotime($now);
        $pinjam = strtotime($transaksi->waktu_pinjam);
        $rencana_kembali = strtotime($transaksi->waktu_rencana_kembali);
        if(($curDateTime > $pinjam) && ($curDateTime < $rencana_kembali)){
            return "Tidak dapat menghapus";
        } else {
            $transaksi->delete();
            return 1;
        }
    }
}

