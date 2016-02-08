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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function peralatan($id = null) {
        if ($id == null) {
            $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
            $output->writeln("p0");
            return Peralatan::orderBy('id', 'asc')->get();
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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        $output->writeln("p1");
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
        $output->writeln("store");

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
            $output->writeln("store2");
            //return Redirect::to('peralatan/create')
                //->withErrors($validator)
                //->withInput();
        } else {
            $output->writeln("store3");
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
            $output->writeln("store4");
            // store
            $peralatan = new peralatan;
            $peralatan->nama            = Input::get('nama');
            $peralatan->status          = $status;
            $peralatan->ketersediaan    = $ketersediaan;
            $peralatan->lokasi          = Input::get('lokasi');
            $peralatan->jenis           = Input::get('jenis');
            $peralatan->save();
            $output->writeln("store5");
            return 'Peralatan record successfully created with id ' . $peralatan->id;
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
            'nama'          => 'required',
            'status'        => 'required',
            'ketersediaan'  => 'required',
            'lokasi'        => 'required',
            'jenis'         => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the update
        if ($validator->fails()) {
            //return Redirect::back()
                //->withErrors($validator);
        } else {
            // update
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

            $peralatan = Peralatan::find($id);
            if(!$peralatan)
                return Redirect::to('peralatan');
            $peralatan->nama            = Input::get('nama');
            $peralatan->status          = $status;
            $peralatan->ketersediaan    = $ketersediaan;
            $peralatan->lokasi          = Input::get('lokasi');
            $peralatan->jenis           = Input::get('jenis');
            $peralatan->save();

            // redirect
            //Session::flash('message', 'Peralatan berhasil diupdate');
            return "Sucess updating user #" . $peralatan->id;
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
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        $output->writeln("destroy");

        $peralatan = Peralatan::find($id);
        $peralatan->delete();

        return "Peralatan record successfully deleted #" . $id;
    }
}