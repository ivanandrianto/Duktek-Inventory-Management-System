<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Pengguna;
use App\Booking;
use App\Transaksi;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Session;

class PenggunaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function pengguna($id = null) {
        if ($id == null) {
            return Pengguna::orderBy('id', 'asc')->get();
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
        return Pengguna::find($id);
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
     * @return Response
     */
    public function store(Request $request)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        $output->writeln("store");
        $rules = array(
            'id'        => 'required|integer',
            'nama'      => 'required',
            'alamat'    => 'required',
            'no_telp'   => 'required',
            'jenis'     => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            $output = new \Symfony\Component\Console\Output\ConsoleOutput(2); 
            $error = $validator->messages()->toJson();
            $output->writeln("a");
            $json_output = json_decode($error);
            $output->writeln("b");
            /*$x
            foreach ( $json_output->trends as $trend )
            {
                echo "{$trend->name}\n";
            }*/
            $output->writeln($error);
        } else {

            //cek apakah id yang sama sudah ada
            $pengguna = Pengguna::find(Input::get('id'));
            if($pengguna){

                $output->writeln("s1");
                return "ID harus unik";
            } else {
                //validate phone number
                if (!preg_match('/^[0-9]+$/', Input::get('no_telp'))){
                    return "No. Telp tidak valid. Hanya boleh mengandung angka";
                }

                $output->writeln("s2");
                $jenis = "";
                if(Input::get('jenis') == 1){
                    $jenis = "Mahasiswa";
                } else if(Input::get('jenis') == 2) {
                    $jenis = "Dosen";
                } else {
                    $jenis = "Karyawan";
                }

                // store
                $pengguna = new pengguna;
                $pengguna->id           = Input::get('id');
                $pengguna->nama         = Input::get('nama');
                $pengguna->alamat       = Input::get('alamat');
                $pengguna->no_telp      = Input::get('no_telp');
                $pengguna->jenis        = $jenis;
                $pengguna->save();

                return 1;
            }
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
        $pengguna = Pengguna::find($id);
        if(!$pengguna)
            return view('errors.404');
        return view('pengguna.edit', compact('pengguna'));
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
        $rules = array(
            'id'        => 'required|integer',
            'nama'      => 'required',
            'alamat'    => 'required',
            'no_telp'   => 'required',
            'jenis'     => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the update
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $jenis = "";
            if(Input::get('jenis') == 1){
                $jenis = "Mahasiswa";
            } else if(Input::get('jenis') == 2) {
                $jenis = "Dosen";
            } else {
                $jenis = "Karyawan";
            }
            // update
            $pengguna = Pengguna::find($id);
            if(!$pengguna)
                return "Not Found";
            $pengguna->id       = Input::get('id');
            $pengguna->nama     = Input::get('nama');
            $pengguna->alamat   = Input::get('alamat');
            $pengguna->no_telp  = Input::get('no_telp');
            $pengguna->jenis    = $jenis;
            $pengguna->save();

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
        $pengguna = Pengguna::find($id);
        if(!$pengguna)
                return "Not Found";

        $inBooking = Booking::where('id_pembooking' , '=', $id)->count();
        $inTransaksi = Transaksi::where('id_peminjam' , '=', $id)->count();
        if(($inBooking > 0) || ($inTransaksi > 0)){
            return "Tidak dapat menghapus";
        } else {
            $pengguna->delete();
            return 1;
        }
    }
}

