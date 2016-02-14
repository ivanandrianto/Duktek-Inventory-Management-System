<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Perbaikan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Session;

class PerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function perbaikan($id = null) {
        if ($id == null) {

            return Perbaikan::orderBy('id', 'desc')->with('peralatan')->get();
            //return Response::json($perbaikans);
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
        return Perbaikan::find($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perbaikan = Perbaikan::all();
        $peralatan = Peralatan::all();    
        return view('perbaikan.index2', compact('perbaikan','peralatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perbaikan.create');
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
            'id_barang'     => 'required',
            'waktu_mulai'   => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the store
        if ($validator->fails()) {
            return $validator->messages()->toJson();

        } else {
            // store
            $perbaikan = new perbaikan;
            $perbaikan->id_barang       = Input::get('id_barang');
            $perbaikan->waktu_mulai     = Input::get('waktu_mulai');
            //$perbaikan->waktu_selesai   = Input::get('waktu_selesai');
            $perbaikan->save();
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
        $perbaikan = Perbaikan::find($id);
        if(!$perbaikan)
            return view('errors.404');
        return view('perbaikan.edit', compact('perbaikan'));
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
            'id_barang'     => 'required',
            'waktu_mulai'   => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        
        // process the store
        if ($validator->fails()) {
            return $validator->messages()->toJson();

        } else {
            // store
            $perbaikan = Perbaikan::find($id);
            if(!$perbaikan)
                return "Not Found";
            $perbaikan->id_barang       = Input::get('id_barang');
            $perbaikan->waktu_mulai     = Input::get('waktu_mulai');
            $perbaikan->waktu_selesai   = Input::get('waktu_selesai');
            $perbaikan->save();
            return 1;
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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        $output->writeln("end");

        $rules = array(
            'id_barang'     => 'required',
            'waktu_selesai'   => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        $output->writeln(Input::get('waktu_mulai'));
        
        // process the store
        if ($validator->fails()) {
            return $validator->messages()->toJson();

        } else {
            // store
            $perbaikan = Perbaikan::find($id);
            if(!$perbaikan)
                return "Not Found";
            $perbaikan->waktu_selesai   = Input::get('waktu_selesai');
            $perbaikan->save();
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
        $perbaikan = Perbaikan::find($id);
        if(!$perbaikan)
                return "Not Found";
        $curDateTime =  strtotime(new DateTime());
        $mulai = strtotime($perbaikan->waktu_booking_mulai);
        $selesai = strtotime($perbaikan->waktu_booking_selesai);
        if(($curDateTime > $mulai) && ($curDateTime < $selesai)){
            return "Tidak dapat menghapus";
        } else {
            $perbaikan->delete();
            return 1;
        }
    }
}
