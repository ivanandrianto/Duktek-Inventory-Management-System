<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Booking;
use App\Pengguna;
use App\Transaksi;
use App\Peralatan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Session;

class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function booking($id = null) {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        if ($id == null) {
            return Booking::orderBy('id', 'desc')->get();
            $output->writeln("booking");
        } else {
            return $this->show($id);
            $output->writeln("booking2");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return Booking::with('peralatan')->get()->find($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking = Booking::all();
        return view('booking.index', compact('booking'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('booking.create');
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
            'id_pembooking'         => 'required|integer',
            'waktu_booking_mulai'   => 'required',
            'waktu_booking_selesai' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        $output->writeln("a");
        // process the login
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {

            
            //cek id pembooking
            $pengguna = Pengguna::find(Input::get('id_pembooking'));
            if(!$pengguna)
                return "ID pengguna tidak ditemukan";
            $alat_sesuai_jenis = Peralatan::where('jenis' , '=', Input::get('jenis_barang'))->get();
            $selected_id = -1;

            $input_booking_mulai_time = strtotime(Input::get('waktu_booking_mulai'));
            $input_booking_selesai_time = strtotime(Input::get('waktu_booking_selesai'));
            $output->writeln("1".$input_booking_mulai_time);
            $output->writeln("2".$input_booking_selesai_time);
            foreach ($alat_sesuai_jenis as $alat)
            {
                // PENCARIAN ALAT YG SESUAI - BELUM DIBUAT
                $available = true;
                // Cek di tabel booking
                $booking_of_alat = Booking::where('id_barang', '=', $alat->id)->get();
                foreach ($booking_of_alat as $booking){
                    $booking_mulai_time = strtotime($booking->waktu_booking_mulai);
                    $booking_selesai_time = strtotime($booking->waktu_booking_selesai);
                    if((($input_booking_mulai_time > $booking_mulai_time) && ($input_booking_mulai_time < $booking_selesai_time)) ||
                        (($input_booking_selesai_time > $booking_mulai_time) && ($input_booking_selesai_time < $booking_selesai_time))||
(($booking_mulai_time > $input_booking_mulai_time) && ($booking_mulai_time < $input_booking_selesai_time)) || (($booking_selesai_time > $input_booking_mulai_time) && ($booking_selesai_time < $input_booking_selesai_time))){
                            $available = false;
                    }
                }
                $output->writeln("c");
                // Cek di tabel transaksi
                if($available){
                    $transaksi_of_alat = Transaksi::where('id_barang', '=', $alat->id)->get();
                    foreach ($transaksi_of_alat as $transaksi){
                        $transaksi_pinjam_time = $transaksi->waktu_pinjam;
                        $transaksi_rencana_kembali_time = $transaksi->waktu_rencana_kembali;
                        if((($input_booking_mulai_time > $transaksi_pinjam_time) && ($input_booking_mulai_time < $transaksi_rencana_kembali_time)) ||
                            (($input_booking_selesai_time > $transaksi_pinjam_time) && ($input_booking_selesai_time < $transaksi_rencana_kembali_time)) || (($transaksi_pinjam_time > $input_booking_mulai_time) && ($transaksi_pinjam_time < $input_booking_selesai_time)) || (($transaksi_rencana_kembali_time > $input_booking_mulai_time) && ($transaksi_rencana_kembali_time < $input_booking_selesai_time))){
                                $available = false;
                        }
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
                if(strtotime(Input::get('waktu_booking_selesai')) <= strtotime(Input::get('waktu_booking_mulai'))){
                    return "Tanggal tidak valid";
                } else {
                    // store
                    $booking = new Booking;
                    $booking->id_barang                 = $selected_id;
                    $booking->id_pembooking             = Input::get('id_pembooking');
                    $booking->waktu_booking_mulai       = Input::get('waktu_booking_mulai');
                    $booking->waktu_booking_selesai     = Input::get('waktu_booking_kembali');
                    $booking->save();
                    return $booking->id;
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
        $booking = Booking::find($id);
        if(!$booking)
            return view('errors.404');
        return view('booking.edit', compact('booking'));
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
            'id_pembooking'         => 'required|integer',
            'waktu_booking_mulai'   => 'required',
            'waktu_booking_selesai' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            //cek id pembooking
            $pengguna = Pengguna::find(Input::get('id_pembooking'));
            if(!$pengguna)
                return "ID pengguna tidak ditemukan";

            $booking = Booking::find($id);
            if(!$booking)
                return "Not Found";
            /* cek apakah jenis peralatan berubah
             * jika berubah, cari alat baru
             */
            $id_barang_old = $booking->id_barang;
            $barang_old = Peralatan::find($id_barang_old);
            $jenis_barang_old = $barang_old->jenis;
            $selected_id = -1;
            if(strcmp(Input::get('jenis_barang'),$jenis_barang_old)==0){
                $selected_id = $id_barang_old;
            } else { //cari peralatan baru jika jenis berubah
                $alat_sesuai_jenis = Peralatan::where('jenis' , '=', Input::get('jenis_barang'))->get();
                $input_booking_mulai_time = strtotime(Input::get('waktu_booking_mulai'));
                $input_booking_selesai_time = strtotime(Input::get('waktu_booking_selesai'));
                foreach ($alat_sesuai_jenis as $alat)
                {
                    // PENCARIAN ALAT YG SESUAI - BELUM DIBUAT
                    $available = true;
                    // Cek di tabel booking
                    $booking_of_alat = Booking::where('id_barang', '=', $alat->id)->get();
                    foreach ($booking_of_alat as $booking){
                    $booking_mulai_time = strtotime($booking->waktu_booking_mulai);
                    $booking_selesai_time = strtotime($booking->waktu_booking_selesai);
                    if((($input_booking_mulai_time > $booking_mulai_time) && ($input_booking_mulai_time < $booking_selesai_time)) ||
                        (($input_booking_selesai_time > $booking_mulai_time) && ($input_booking_selesai_time < $booking_selesai_time))||
(($booking_mulai_time > $input_booking_mulai_time) && ($booking_mulai_time < $input_booking_selesai_time)) || (($booking_selesai_time > $input_booking_mulai_time) && ($booking_selesai_time < $input_booking_selesai_time))){
                            $available = false;
                    }
                }
                    // Cek di tabel transaksi
                    if($available){
                        $transaksi_of_alat = Transaksi::where('id_barang', '=', $alat->id)->get();
                        foreach ($transaksi_of_alat as $transaksi){
                            $transaksi_pinjam_time = $transaksi->waktu_pinjam;
                            $transaksi_rencana_kembali_time = $transaksi->waktu_rencana_kembali;
                            if((($input_booking_mulai_time > $transaksi_pinjam_time) && ($input_booking_mulai_time < $transaksi_rencana_kembali_time)) ||
                                (($input_booking_selesai_time > $transaksi_pinjam_time) && ($input_booking_selesai_time < $transaksi_rencana_kembali_time)) || (($transaksi_pinjam_time > $input_booking_mulai_time) && ($transaksi_pinjam_time < $input_booking_selesai_time)) || (($transaksi_rencana_kembali_time > $input_booking_mulai_time) && ($transaksi_rencana_kembali_time < $input_booking_selesai_time))){
                                    $available = false;
                            }
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
                //cek tanggal
                if(strtotime(Input::get('waktu_booking_mulai')) <= strtotime(Input::get('waktu_booking_selesai'))){
                    return "Tanggal tidak valid";
                } else {
                    // store
                    $booking->id_barang                 = $selected_id;
                    $booking->id_pembooking             = Input::get('id_pembooking');
                    $booking->waktu_booking_mulai       = Input::get('waktu_booking_mulai');
                    $booking->waktu_booking_selesai     = Input::get('waktu_booking_kembali');
                    $booking->save();
                    return $booking->id;
                }
                
            }
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
        $booking = Booking::find($id);
        if(!$booking){
            return "Not Found";
        } else {
            $booking->delete();
            return 1;
        }
    }
}
