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
            'waktu_pinjam_date' => 'required|date',
            'waktu_pinjam_time' => 'required',
            'waktu_rencana_kembali_date' => 'required|date',
            'waktu_rencana_kembali_time' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('booking/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $transaksi = new Transaksi;

            $pinjam_date = Input::get('waktu_pinjam_date');
            $pinjam_time = Input::get('waktu_pinjam_time');
            $rencana_kembali_date = Input::get('waktu_rencana_kembali_date');
            $rencana_kembali_time = Input::get('waktu_rencana_kembali_time');
            $kembali_date = Input::get('waktu_kembali_date');
            $kembali_time = Input::get('waktu_kembali_time');

            $transaksi->id_barang     = Input::get('id_barang');
            $transaksi->id_peminjam   = Input::get('id_pembooking');
            $transaksi->waktu_pinjam = date('Y-m-d H:i:s', strtotime("$pinjam_date $pinjam_time"));
            $transaksi->waktu_rencana_kembali = date('Y-m-d H:i:s', strtotime("$rencana_kembali_date $rencana_kembali_time"));
            $transaksi->waktu_kembali = date('Y-m-d H:i:s', strtotime("$kembali_date $kembali_time"));
            $transaksi->save();
            // redirect
            Session::flash('message', 'Transaksi berhasil ditambahkan');
            return Redirect::to('transaksi');
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
        $column = 'id';
        $transaksi = Transaksi::where($column , '=', $id)->first();
        if(!$transaksi)
            return view('errors.404');
        return view('transaksi.show', compact('transaksi'));
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
            'id_barang'        => 'required',
            'id_peminjam'       => 'required',
            'waktu_pinjam_date' => 'required|date',
            'waktu_pinjam_time' => 'required',
            'waktu_rencana_kembali_date' => 'required|date',
            'waktu_rencana_kembali_time' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the update
        if ($validator->fails()) {
            return Redirect::to('booking/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // update         
            $pinjam_date = Input::get('waktu_pinjam_date');
            $pinjam_time = Input::get('waktu_pinjam_time');
            $rencana_kembali_date = Input::get('waktu_rencana_kembali_date');
            $rencana_kembali_time = Input::get('waktu_rencana_kembali_time');
            $kembali_date = Input::get('waktu_kembali_date');
            $kembali_time = Input::get('waktu_kembali_time');

            $transaksi = Transaksi::find($id);
            if(!$transaksi)
                return Redirect::to('transaksi');
            $transaksi->id_barang     = Input::get('id_barang');
            $transaksi->id_peminjam   = Input::get('id_pembooking');
            $transaksi->waktu_pinjam = date('Y-m-d H:i:s', strtotime("$pinjam_date $pinjam_time"));
            $transaksi->waktu_rencana_kembali = date('Y-m-d H:i:s', strtotime("$rencana_kembali_date $rencana_kembali_time"));
            $transaksi->waktu_kembali = date('Y-m-d H:i:s', strtotime("$kembali_date $kembali_time"));
            $transaksi->save();

            // redirect
            Session::flash('message', 'Transaksi berhasil diupdate');
            return Redirect::to('transaksi');
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
        $transaksi->delete();

        Session::flash('message', 'Transaksi berhasil dihapus');
        return Redirect::to('transaksi');
    }
}

