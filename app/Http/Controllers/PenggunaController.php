<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Pengguna;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Session;

class PenggunaController extends Controller
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
        $pengguna = Pengguna::all();       
        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengguna.create');
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
            'nama'      => 'required',
            'alamat'    => 'required',
            'no_telp'   => 'required',
            'jenis'     => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('pengguna/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $pengguna = new pengguna;
            $pengguna->nama         = Input::get('nama');
            $pengguna->alamat       = Input::get('alamat');
            $pengguna->no_telp      = Input::get('no_telp');
            $pengguna->jenis        = Input::get('jenis');
            $pengguna->save();

            // redirect
            Session::flash('message', 'Pengguna berhasil ditambahkan');
            return Redirect::to('pengguna');
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
        $pengguna = Pengguna::where($column , '=', $id)->first();
        return view('pengguna.show', compact('pengguna'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengguna = Pengguna::find($id);
        return view('pengguna.edit', compact('pengguna'));
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
            'nama'      => 'required',
            'alamat'    => 'required',
            'no_telp'   => 'required',
            'jenis'     => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator);
        } else {
            // store
            $pengguna = Pengguna::find($id);
            $pengguna->nama     = Input::get('nama');
            $pengguna->alamat   = Input::get('alamat');
            $pengguna->no_telp  = Input::get('no_telp');
            $pengguna->jenis    = Input::get('jenis');
            $pengguna->save();

            // redirect
            Session::flash('message', 'Pengguna berhasil diupdate');
            return Redirect::to('pengguna');
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
        $pengguna = Pengguna::find($id);
        $pengguna->delete();

        Session::flash('message', 'Pengguna berhasil dihapus');
        return Redirect::to('pengguna');
    }
}
