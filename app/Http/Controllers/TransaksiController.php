<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Transaksi;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Session;

class TransaksiController extends Controller
{
    public function __construct ()
    {
        if (Auth::check()) {
        } else {
            return Redirect::to('/')->send();
        }
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'id_barang'        => 'required',
            'id_peminjam'       => 'required',
            'waktu_booking_mulai_date' => 'required|date',
            'waktu_booking_mulai_time' => 'required',
            'waktu_booking_selesai_date' => 'required|date',
            'waktu_booking_selesai_time' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('booking/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $booking = new Booking;

            $mulai_date = Input::get('waktu_booking_mulai_date');
            $mulai_time = Input::get('waktu_booking_mulai_time');
            $selesai_date = Input::get('waktu_booking_selesai_date');
            $selesai_time = Input::get('waktu_booking_selesai_time');

            $booking->id_barang     = Input::get('id_barang');
            $booking->id_pembooking   = Input::get('id_pembooking');
            $booking->waktu_booking_mulai = date('Y-m-d H:i:s', strtotime("$mulai_date $mulai_time"));
            $booking->waktu_booking_kembali = date('Y-m-d H:i:s', strtotime("$selesai_date $selesai_time"));
            $booking->save();
            // redirect
            Session::flash('message', 'Booking berhasil ditambahkan');
            return Redirect::to('booking');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
