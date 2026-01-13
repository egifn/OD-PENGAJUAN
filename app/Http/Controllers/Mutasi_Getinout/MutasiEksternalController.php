<?php

namespace App\Http\Controllers\Mutasi_Getinout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use DB;

class MutasiEksternalController extends Controller
{
    public function index()
    {
    	return view('mutasi_getinout.eksternal.index');
    }

    public function create(Request $request)
    {
    	$depo = DB::table('depos')
    			->get(); 

    	$data = DB::table('users')
    		->join('perusahaans','users.kode_perusahaan','=','perusahaans.kode_perusahaan')
    		->join('depos','users.kode_depo','=','depos.kode_depo')
    		->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
    		->Where('users.id', Auth::user()->id)
    		->first();

    	$checker_layak=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'Layak')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->get();

        $checker_bs=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'BS')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->get();


        $area = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

        $sub_area = DB::table('warehouse')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->select('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->groupBy('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->get();

        $area_bs = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->Where('area.nama_area', 'like', '%BS%')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();
    	return view('mutasi_getinout.eksternal.create', compact('area','sub_area','area_bs','checker_layak','checker_bs','depo','data'));
    }

    public function view()
    {

    }

    public function store()
    {

    }
}
