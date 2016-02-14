<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Statistik;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class StatistikController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistik = Statistik::all();       
        return view('statistik.index', compact('statistk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('statistik.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $jenis
     * @param  int  $tahun
     * @return \Illuminate\Http\Response
     */
    public function frekuensiPenggunaan($jenis, $tahun){
        // $results = DB::select( DB::raw("SELECT count(*) as Jumlah_Pakai,MONTH(transaksi.waktu_pinjam) AS bulan FROM transaksi INNER JOIN peralatan ON transaksi.id_barang = peralatan.id WHERE (peralatan.jenis = :jenis) and (YEAR(transaksi.waktu_pinjam) = :tahun) GROUP BY MONTH(transaksi.waktu_pinjam)"), array(
        //    'jenis' => $jenis,'tahun' => $tahun,
        //  ));
        $results = DB::table('transaksi')       
            ->select(array(DB::raw('COUNT(*) as Jumlah_Pakai'),(DB::raw('MONTH(transaksi.waktu_pinjam) AS Bulan'))))
            ->where('peralatan.jenis', '=', $jenis )//, ['jenis' => $jenis]) 
            ->where(DB::raw('YEAR(transaksi.waktu_pinjam)'), '=', $tahun )// ,['tahun' => $tahun])
            ->join('peralatan', 'transaksi.id_barang', '=', 'peralatan.id')
            ->groupBy(DB::raw('MONTH(transaksi.waktu_pinjam)'))
            ->get();

        
        return $results;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $jenis
     * @param  int  $tahun
     * @return \Illuminate\Http\Response
     */
    public function frekuensiKerusakan($jenis, $tahun){
        // $results = DB::select( DB::raw("SELECT count(*) as Jumlah_Pakai,MONTH(transaksi.waktu_pinjam) AS bulan FROM transaksi INNER JOIN peralatan ON transaksi.id_barang = peralatan.id WHERE (peralatan.jenis = :jenis) and (YEAR(transaksi.waktu_pinjam) = :tahun) GROUP BY MONTH(transaksi.waktu_pinjam)"), array(
        //    'jenis' => $jenis,'tahun' => $tahun,
        //  ));
        $results = DB::table('perbaikan')       
            ->select(array(DB::raw('COUNT(*) as Jumlah_Rusak'),(DB::raw('MONTH(perbaikan.waktu_mulai) AS Bulan'))))
            ->where('peralatan.jenis', '=', $jenis )//, ['jenis' => $jenis]) 
            ->where(DB::raw('YEAR(perbaikan.waktu_mulai)'), '=', $tahun )// ,['tahun' => $tahun])
            ->join('peralatan', 'perbaikan.id_barang', '=', 'peralatan.id')
            ->groupBy(DB::raw('MONTH(perbaikan.waktu_mulai)'))
            ->get();
        
        return $results;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $jenisBarang
     * @param  string  $jenisPengguna
     * @param  int  $tahun
     * @return \Illuminate\Http\Response
     */
    public function frekuensiKelompok($jenisBarang, $jenisPengguna, $tahun){
        // $results = DB::select( DB::raw("SELECT count(*) as Jumlah_Pakai,MONTH(transaksi.waktu_pinjam) AS bulan FROM transaksi INNER JOIN peralatan ON transaksi.id_barang = peralatan.id WHERE (peralatan.jenis = :jenis) and (YEAR(transaksi.waktu_pinjam) = :tahun) GROUP BY MONTH(transaksi.waktu_pinjam)"), array(
        //    'jenis' => $jenis,'tahun' => $tahun,
        //  ));
        $results = DB::table('transaksi')       
            ->select(array(DB::raw('COUNT(*) as Jumlah_Pakai'),(DB::raw('MONTH(transaksi.waktu_pinjam) AS Bulan')), (DB::raw('pengguna.jenis AS Kelompok_Pengguna'))))
            ->where('peralatan.jenis', '=', $jenisBarang )
            ->where('pengguna.jenis', '=', $jenisPengguna )
            ->where(DB::raw('YEAR(transaksi.waktu_pinjam)'), '=', $tahun )
            ->join('peralatan', 'transaksi.id_barang', '=', 'peralatan.id')
            ->join('pengguna', 'transaksi.id_peminjam', '=', 'pengguna.id')
            ->groupBy(DB::raw('MONTH(transaksi.waktu_pinjam)'))
            ->get();

        return $results;
    }

}