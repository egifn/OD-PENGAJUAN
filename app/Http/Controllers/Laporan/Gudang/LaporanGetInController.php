<?php

namespace App\Http\Controllers\Laporan\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perusahaan;
use App\Depo;
use Carbon\carbon;
use Excel;
use Auth;
use DB;

class LaporanGetInController extends Controller
{
	public function ajax_depo_laporan_getin(Request $request)
	{
		$perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
	}

    public function index(Request $request)
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();

        if(Auth::user()->kode_divisi == '20'){
        	$data = DB::table('barang_dagang_in_history_update')
        		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
        		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
        		->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
        		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
        		->join('users','barang_dagang_in_history_update.id_user_input','=','users.id')
				->join('area_sub','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub.kode_sub_area')
        		->select('barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.from','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_detail_history_update.kode_produk','product_dagang.nama_produk','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_history_update.id_user_input','users.name','barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','area_sub.nama_sub_area')
        		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
        		->Where('barang_dagang_in_history_update.kode_depo', Auth::user()->kode_depo)
        		->get();
        }elseif(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
        	$data = DB::table('barang_dagang_in_history_update')
        		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
        		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
        		->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
        		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
        		->join('users','barang_dagang_in_history_update.id_user_input','=','users.id')
				->join('area_sub','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub.kode_sub_area')
        		->select('barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.from','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_detail_history_update.kode_produk','product_dagang.nama_produk','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_history_update.id_user_input','users.name','barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','area_sub.nama_sub_area')
        		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
				->Where('barang_dagang_in_history_update.kode_perusahaan', $request->kode_perusahaan)
        		->Where('barang_dagang_in_history_update.kode_depo', $request->kode_depo)
        		->get();
        }
        
        return view('laporan.gudang.getin.index',compact('perusahaan','data'));
    }

    public function cari(Request $request)
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(request()->tanggal != ''){
           	$date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $perusahaan_cari = $request->kode_perusahaan;
    	$depo_cari = $request->kode_depo;

        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();

        if(Auth::user()->kode_divisi == '20'){
        	$data = DB::table('barang_dagang_in_history_update')
        		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
        		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
        		->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
        		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
        		->join('users','barang_dagang_in_history_update.id_user_input','=','users.id')
				->join('area_sub','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub.kode_sub_area')
        		->select('barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.from','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_detail_history_update.kode_produk','product_dagang.nama_produk','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_history_update.id_user_input','users.name','barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','area_sub.nama_sub_area')
        		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
        		->Where('barang_dagang_in_history_update.kode_depo', Auth::user()->kode_depo)
        		->get();
        }elseif(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
        	$data = DB::table('barang_dagang_in_history_update')
        		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
        		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
        		->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
        		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
        		->join('users','barang_dagang_in_history_update.id_user_input','=','users.id')
				->join('area_sub','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub.kode_sub_area')
        		->select('barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.from','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_detail_history_update.kode_produk','product_dagang.nama_produk','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_history_update.id_user_input','users.name','barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','area_sub.nama_sub_area')
        		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
        		->Where('barang_dagang_in_history_update.kode_perusahaan', $perusahaan_cari)
	       		->Where('barang_dagang_in_history_update.kode_depo', $depo_cari)
        		->get();
        }

        return view('laporan.gudang.getin.index',compact('perusahaan','data'));

    }
	
	public function view(Request $request)
    {
        $tgl_ex = $request->input('tanggal_ex');
        $kd_perusahaan_ex = $request->input('kode_perusahaan_ex');
        $kd_depo_ex = $request->input('kode_depo_ex');

        if($tgl_ex != ''){
            $date = explode(' - ' ,$tgl_ex);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_divisi == '20'){ //Divisi Checker
            $data = DB::table('barang_dagang_in_history_update')
                ->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
                ->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
                ->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
                ->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
                ->join('users','barang_dagang_in_history_update.id_user_input','=','users.id')
                ->join('area_sub','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub.kode_sub_area')
                ->select('barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.from','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_detail_history_update.kode_produk','product_dagang.nama_produk','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_history_update.id_user_input','users.name','barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','area_sub.nama_sub_area')
                ->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
                ->Where('barang_dagang_in_history_update.kode_depo', Auth::user()->kode_depo)
                ->get();
        }elseif(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
            $data = DB::table('barang_dagang_in_history_update')
                ->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
                ->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
                ->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
                ->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
                ->join('users','barang_dagang_in_history_update.id_user_input','=','users.id')
                ->join('area_sub','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub.kode_sub_area')
                ->select('barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.from','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_detail_history_update.kode_produk','product_dagang.nama_produk','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_history_update.id_user_input','users.name','barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','area_sub.nama_sub_area')
                ->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
                ->Where('barang_dagang_in_history_update.kode_perusahaan', $kd_perusahaan_ex)
                ->Where('barang_dagang_in_history_update.kode_depo', $kd_depo_ex)
                ->get();
        }

        return view ('laporan.gudang.getin.view', compact('data'));
    }
}
