<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Booking;
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

        if ($id == null) {
            return Booking::orderBy('id', 'desc')->get();
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
        return Booking::find($id)->with('peralatan')->get();;
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
        $rules = array(
            'jenis_barang'             => 'required',
            'id_pembooking'         => 'required',
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

            $alat_sesuai_jenis = Peralatan::where('jenis' , '=', Input::get('jenis_barang'))->get();
            $selected_id = -1;
            foreach ($alat_sesuai_jenis as $alat)
            {
                // PENCARIAN ALAT YG SESUAI - BELUM DIBUAT
                $available = true;
                // Cek di tabel booking


                // Cek di tabel transaksi

            }

            if($selected_id < 1){
                return "Tidak ada alat tersedia";
            } else {
                //cek tanggal
                if(strtotime(Input::get('waktu_booking_mulai')) <= strtotime(Input::get('waktu_booking_selesai'))){
                    return "Tanggal tidak valid";
                } else {
                    // store
                    $booking = new Booking;
                    $booking->id_barang                 = $selected_id;
                    $booking->id_pembooking             = Input::get('id_peminjam');
                    $booking->waktu_booking_mulai       = Input::get('waktu_pinjam');
                    $booking->waktu_booking_selesai     = Input::get('waktu_rencana_kembali');
                    $booking->save();
                }
                return 1;
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
            'id_pembooking'         => 'required',
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
                    foreach ($alat_sesuai_jenis as $alat)
                    {
                        // PENCARIAN ALAT YG SESUAI - BELUM DIBUAT

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
                    $booking->id_pembooking             = Input::get('id_peminjam');
                    $booking->waktu_booking_mulai       = Input::get('waktu_pinjam');
                    $booking->waktu_booking_selesai     = Input::get('waktu_rencana_kembali');
                    $booking->save();
                }
                return 1;
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
        if(!$booking)
                return "Not Found";
        $booking->delete();

        return 1;
    }
}
