<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Peralatan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Session;

class PeralatanController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'nama'          => 'required',
            'status'        => 'required',
            'ketersediaan'  => 'required',
            'lokasi'        => 'required',
            'jenis'         => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the store
        if ($validator->fails()) {
            return Redirect::to('peralatan/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $ketersediaan = $status = "";
            if(Input::get('ketersediaan') == 0){
                $ketersediaan = "Tidak Tersedia";
            } else {
                $ketersediaan = "Tersedia";
            }

            if(Input::get('status') == 0){
                $status = "Rusak";
            } else {
                $status = "Tidak Rusak";
            }

            // store
            $peralatan = new peralatan;
            $peralatan->nama            = Input::get('nama');
            $peralatan->status          = $status;
            $peralatan->ketersediaan    = $ketersediaan;
            $peralatan->lokasi          = Input::get('lokasi');
            $peralatan->jenis           = Input::get('jenis');
            $peralatan->save();

            // redirect
            Session::flash('message', 'Peralatan berhasil ditambahkan');
            return Redirect::to('peralatan');
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
        $peralatan = Peralatan::where($column , '=', $id)->first();
        return view('peralatan.show', compact('peralatan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $peralatan = Peralatan::find($id);
        return view('peralatan.edit', compact('peralatan'));
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
            'nama'          => 'required',
            'status'        => 'required',
            'ketersediaan'  => 'required',
            'lokasi'        => 'required',
            'jenis'         => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the update
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator);
        } else {
            $ketersediaan = $status = "";
            if(Input::get('ketersediaan') == 0){
                $ketersediaan = "Tidak Tersedia";
            } else {
                $ketersediaan = "Tersedia";
            }
            $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);

            $output->writeln(Input::get('status'));
            if(Input::get('status') == 0){
                $status = "Rusak";
            } else {
                $status = "Tidak Rusak";
            }

            //update
            $peralatan = Peralatan::find($id);
            $peralatan->nama            = Input::get('nama');
            $peralatan->status          = $status;
            $peralatan->ketersediaan    = $ketersediaan;
            $peralatan->lokasi          = Input::get('lokasi');
            $peralatan->jenis           = Input::get('jenis');
            $peralatan->save();

            // redirect
            Session::flash('message', 'Peralatan berhasil diupdate');
            return Redirect::to('peralatan');
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
        $peralatan->delete();

        Session::flash('message', 'Peralatan berhasil dihapus');
        return Redirect::to('peralatan');
    }
}
