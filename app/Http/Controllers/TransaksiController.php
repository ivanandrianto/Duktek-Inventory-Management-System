<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Transaksi;
use App\Peralatan;
use App\Pengguna;
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
     * @return Response
     */
    public function transaksi($id = null) {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
        $output->writeln("transaksi");
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
            'waktu_pinjam'          => 'required',
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
            foreach ($alat_sesuai_jenis as $alat)
            {
                $output->writeln($alat->status);
                $output->writeln($alat->ketersediaan);
                if((strcmp($alat->status,"Baik") == 0) && (strcmp($alat->ketersediaan,"Tersedia") == 0)){
                    $selected_id = $alat->id;
                    $output->writeln($selected_id);
                    break;
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
                    $transaksi->waktu_pinjam            = Input::get('waktu_pinjam');
                    $transaksi->waktu_rencana_kembali   = Input::get('waktu_rencana_kembali');
                    $transaksi->save();
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
            'id_barang'             => 'required',
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
            $transaksi->id_barang               = Input::get('id_barang');
            $transaksi->id_peminjam             = Input::get('id_peminjam');
            $transaksi->waktu_pinjam            = Input::get('waktu_pinjam');
            $transaksi->waktu_rencana_kembali   = Input::get('waktu_rencana_kembali');
            $transaksi->waktu_kembali           = Input::get('waktu_kembali');
            $transaksi->save();

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
        $rules = array(
            'waktu_kembali' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        
        // process the store
        if ($validator->fails()) {
            return $validator->messages()->toJson();

        } else {
            // store
            $transaksi = Transaksi::find($id);
            if(!$transaksi)
                return "Not Found";
            $transaksi->waktu_kembali   = Input::get('waktu_kembali');
            $transaksi->save();

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
        $transaksi->delete();

        return 1;
    }
}

