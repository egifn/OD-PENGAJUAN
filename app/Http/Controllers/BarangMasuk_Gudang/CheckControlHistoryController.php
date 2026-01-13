<?php

namespace App\Http\Controllers\BarangMasuk_Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\BarangDagang_In_History;
use App\BarangDagang_In_History_Detail;
use App\Perusahaan;
use Carbon\carbon;
use Auth;
use DB;

class CheckControlHistoryController extends Controller
{	
	public function ajax_depo_gudang(Request $request) // dropdown perusahaan dan depo
    {
        $perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
    }

    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        $in_history = DB::table('barang_dagang_in_history_update')
                    ->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in_history_update.status', '1')
                    ->Where('barang_dagang_in_history_update.status_bs', '1')
                    ->Where('barang_dagang_in_history_update.kode_depo', '')
                    ->get();

        return view ('masuk_barang_gudang.checker_control_history.index', compact('in_history','perusahaan','depo'));
    }

    public function cari(Request $request)
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        $perusahaan_cari = $request->kode_perusahaan;
    	$depo_cari = $request->kode_depo;
    	$kategori_cari = $request->kategori;

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }


        if($perusahaan_cari == '' && $depo_cari == '' && $kategori_cari == '')
        {
        	$in_history = DB::table('barang_dagang_in_history_update')
                    ->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in_history_update.status', '1')
                    ->Where('barang_dagang_in_history_update.status_bs', '1')
                    ->Where('barang_dagang_in_history_update.kode_depo', '')
                    ->get();
        }elseif($perusahaan_cari != '' && $depo_cari != '' && $kategori_cari == ''){
        	$in_history = DB::table('barang_dagang_in_history_update')
                    ->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in_history_update.status', '1')
                    ->Where('barang_dagang_in_history_update.status_bs', '1')
                    ->Where('barang_dagang_in_history_update.kode_depo', $depo_cari)
                    ->Where('barang_dagang_in_history_update.kode_perusahaan', $perusahaan_cari)
                    ->get();
        }elseif($perusahaan_cari != '' && $depo_cari != '' && $kategori_cari != ''){
        	$in_history = DB::table('barang_dagang_in_history_update')
                    ->join('perusahaans','barang_dagang_in_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in_history_update.status', '1')
                    ->Where('barang_dagang_in_history_update.status_bs', '1')
                    ->Where('barang_dagang_in_history_update.kode_depo', $depo_cari)
                    ->Where('barang_dagang_in_history_update.kode_perusahaan', $perusahaan_cari)
                    ->Where('barang_dagang_in_history_update.kategori', $kategori_cari)
                    ->get();
        }

        return view ('masuk_barang_gudang.checker_control_history.index', compact('in_history','perusahaan','depo'));
    }

    public function view($doc_id)
    {
        
        $head = DB::table('barang_dagang_in_history_update')
                ->join('area','barang_dagang_in_history_update.kode_zona','=','area.kode_area')
                ->join('area_sub','barang_dagang_in_history_update.kode_zona_sub','=','area_sub.kode_sub_area')
                ->join('area as area_bs','barang_dagang_in_history_update.kode_zona_bs','=','area_bs.kode_area')
                ->join('area_sub as area_sub_bs','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub_bs.kode_sub_area')
                ->join('checker','barang_dagang_in_history_update.id_checker','=','checker.id_checker')
                ->join('checker as checker_bs','barang_dagang_in_history_update.id_checker_bs','=','checker_bs.id_checker')
                ->select('barang_dagang_in_history_update.doc_id','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.kode_driver','barang_dagang_in_history_update.nama_driver','area.nama_area','area_sub.nama_sub_area','checker.nama_checker','area_bs.nama_area as nama_area_bs','area_sub_bs.nama_sub_area as nama_sub_area_bs','checker_bs.nama_checker as nama_checker_bs','barang_dagang_in_history_update.from','barang_dagang_in_history_update.kategori')
                ->Where('barang_dagang_in_history_update.doc_id', $doc_id)
                ->first();

        $detail = DB::table('barang_dagang_in_detail_history_update')
                ->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
                ->Where('barang_dagang_in_detail_history_update.doc_id', $doc_id)
                ->get();

        return view ('masuk_barang_gudang.checker_control_history.view', compact('head','detail'));  
    }
}
