<?php

namespace App\Http\Controllers\Laporan\Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perusahaan;
use App\Depo;
use App\Checker;
use Carbon\carbon;
use Excel;
use Auth;
use DB;

class CheckerGudangControllerBs extends Controller
{
    public function ajax_depo_laporan_bs(Request $request) // dropdown perusahaan dan depo
    {
        $perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
    }

    public function ajax_checker_laporan_bs(Request $request)
    {
    	if(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
    		$depochecker = DB::table('barang_dagang_in_history_update')
    					->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
    					->where('barang_dagang_in_history_update.kode_depo', $request->depo_id)
    					->pluck('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker');
    		return response()->json($depochecker);
    	}
    	
    }

    

    public function index(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        
        if(Auth::user()->kode_divisi == '20'){
        	$checker = DB::table('barang_dagang_in_history_update')
    					->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
    					->select('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.kode_depo')
    					->where('barang_dagang_in_history_update.kode_depo', Auth::user()->kode_depo)
    					->distinct()
    					->get();
        }

       if(Auth::user()->kode_divisi == '20'){ 
       		$data = DB::table('barang_dagang_in_history_update')
	       		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
	       		->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
	       		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
	       		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
	       		->join ('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
	       		->select('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk',DB::raw("SUM(barang_dagang_in_detail_history_update.qty_layak) AS qty_layak"),
	       			DB::raw("SUM(barang_dagang_in_detail_history_update.qty_bs) AS qty_bs"),DB::raw("SUM(barang_dagang_in_detail_history_update.qty_ekspedisi) AS qty_ekspedisi"))
	       		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
	       		->Where('barang_dagang_in_history_update.kode_depo', Auth::user()->kode_depo)
	       		->groupBy('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk','perusahaans.nama_perusahaan','depos.nama_depo')
	       		->get();

       }elseif(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
       		$data = DB::table('barang_dagang_in_history_update')
	       		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
	       		->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
	       		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
	       		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
	       		->join ('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
	       		->select('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk',DB::raw("SUM(barang_dagang_in_detail_history_update.qty_layak) AS qty_layak"),
	       			DB::raw("SUM(barang_dagang_in_detail_history_update.qty_bs) AS qty_bs"),DB::raw("SUM(barang_dagang_in_detail_history_update.qty_ekspedisi) AS qty_ekspedisi"))
	       		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
	       		->groupBy('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk','perusahaans.nama_perusahaan','depos.nama_depo')
	       		->get();

	       	
       }
       
       if(Auth::user()->kode_divisi == '20'){
        	return view('laporan.gudang.checker_gudang_bs.index', compact('perusahaan','data','checker'));
        }elseif(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
        	return view('laporan.gudang.checker_gudang_bs.index', compact('perusahaan','data'));
        }
    	
    }

    public function cari(Request $request){
    	date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        
        if(Auth::user()->kode_divisi == '20'){
        	$checker = DB::table('barang_dagang_in_history_update')
    					->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
    					->select('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.kode_depo')
    					->where('barang_dagang_in_history_update.kode_depo', Auth::user()->kode_depo)
    					->distinct()
    					->get();
    	}

        if(Auth::user()->kode_divisi == '20'){ 
        	$checker_cari = $request->id_checker;
    		$kategori_cari = $request->kategori;

        	if(request()->tanggal != ''){
            	$date = explode(' - ' ,request()->tanggal);
            	$date_start = Carbon::parse($date[0])->format('Y-m-d');
            	$date_end = Carbon::parse($date[1])->format('Y-m-d');
            }

            $data = DB::table('barang_dagang_in_history_update')
	       		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
	       		->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
	       		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
	       		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
	       		->join ('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
	       		->select('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','barang_dagang_in_history_update.kode_perusahaan','perusahaans.nama_perusahaan','barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk',DB::raw("SUM(barang_dagang_in_detail_history_update.qty_layak) AS qty_layak"),
	       			DB::raw("SUM(barang_dagang_in_detail_history_update.qty_bs) AS qty_bs"),DB::raw("SUM(barang_dagang_in_detail_history_update.qty_ekspedisi) AS qty_ekspedisi"))
	       		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
	       		->Where('barang_dagang_in_history_update.kode_depo', Auth::user()->kode_depo)
	       		->Where('barang_dagang_in_history_update.id_checker_bs', $checker_cari)
	       		->Where('barang_dagang_in_history_update.kategori', $kategori_cari)
	       		->groupBy('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in_history_update.kode_perusahaan','barang_dagang_in_history_update.kode_depo')
	       		->get();
        }elseif(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
        	$perusahaan_cari = $request->kode_perusahaan;
    		$depo_cari = $request->kode_depo;
    		$checker_cari = $request->id_checker;
    		$kategori_cari = $request->kategori;

        	if(request()->tanggal != ''){
            	$date = explode(' - ' ,request()->tanggal);
            	$date_start = Carbon::parse($date[0])->format('Y-m-d');
            	$date_end = Carbon::parse($date[1])->format('Y-m-d');
        	}

        	$data = DB::table('barang_dagang_in_history_update')
	       		->join('barang_dagang_in_detail_history_update','barang_dagang_in_history_update.doc_id','=','barang_dagang_in_detail_history_update.doc_id')
	       		->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
	       		->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
	       		->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
	       		->join ('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
	       		->select('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','barang_dagang_in_history_update.kode_perusahaan','perusahaans.nama_perusahaan','barang_dagang_in_history_update.kode_depo','depos.nama_depo','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk',DB::raw("SUM(barang_dagang_in_detail_history_update.qty_layak) AS qty_layak"),
	       			DB::raw("SUM(barang_dagang_in_detail_history_update.qty_bs) AS qty_bs"),DB::raw("SUM(barang_dagang_in_detail_history_update.qty_ekspedisi) AS qty_ekspedisi"))
	       		->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
	       		->Where('barang_dagang_in_history_update.kode_perusahaan', $perusahaan_cari)
	       		->Where('barang_dagang_in_history_update.kode_depo', $depo_cari)
	       		->Where('barang_dagang_in_history_update.id_checker_bs', $checker_cari)
	       		->Where('barang_dagang_in_history_update.kategori', $kategori_cari)
	       		->groupBy('barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.tanggal','barang_dagang_in_history_update.kategori','product_dagang.kode_produk','product_dagang.nama_produk','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in_history_update.kode_perusahaan','barang_dagang_in_history_update.kode_depo')
	       		->get();
        }

        if(Auth::user()->kode_divisi == '20'){
        	return view('laporan.gudang.checker_gudang_bs.index', compact('perusahaan','data','checker'));
        }elseif(Auth::user()->kode_divisi == '22'){ //Divisi Gudang Pusat
        	return view('laporan.gudang.checker_gudang_bs.index', compact('perusahaan','data'));
        }

    }
}
