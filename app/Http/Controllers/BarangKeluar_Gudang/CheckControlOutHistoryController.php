<?php

namespace App\Http\Controllers\BarangKeluar_Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BarangDagang_Out_History;
use App\BarangDagang_Out_History_Detail;
use App\Perusahaan;
use App\Depo;
use Carbon\carbon;
use Auth;
use DB;

class CheckControlOutHistoryController extends Controller
{
    public function ajax_depo_history_out(Request $request) // dropdown perusahaan dan depo
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

        $out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '')
                    ->get();

        return view ('keluar_barang_gudang.checker_control_history_out.index', compact('out_history','perusahaan','depo'));
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
        	$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '')
                    ->get();
        }elseif($perusahaan_cari != '' && $depo_cari != '' && $kategori_cari == ''){
        	$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', $depo_cari)
                    ->Where('barang_dagang_out_history_update.kode_perusahaan', $perusahaan_cari)
                    ->get();
        }elseif($perusahaan_cari != '' && $depo_cari != '' && $kategori_cari != ''){
        	$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', $depo_cari)
                    ->Where('barang_dagang_out_history_update.kode_perusahaan', $perusahaan_cari)
                    ->Where('barang_dagang_out_history_update.kategori', $kategori_cari)
                    ->get();
        }

        return view ('keluar_barang_gudang.checker_control_history_out.index', compact('out_history','perusahaan','depo'));
    }

    public function view($doc_id)
    {
        $kategori_out =  DB::table('barang_dagang_out_history_update')
                    ->select('barang_dagang_out_history_update.kategori')
                    ->where('barang_dagang_out_history_update.doc_id', $doc_id)  
                    ->first();  

        if($kategori_out->kategori == 'Primary'){
            $head = DB::table('barang_dagang_out_history_update')
                ->join('area','barang_dagang_out_history_update.kode_zona','=','area.kode_area')
                ->join('area_sub','barang_dagang_out_history_update.kode_zona_sub','=','area_sub.kode_sub_area')
                ->join('area as area_bs','barang_dagang_out_history_update.kode_zona_bs','=','area_bs.kode_area')
                ->join('area_sub as area_sub_bs','barang_dagang_out_history_update.kode_zona_sub_bs','=','area_sub_bs.kode_sub_area')
                ->join('checker','barang_dagang_out_history_update.id_checker','=','checker.id_checker')
                ->join('checker as checker_bs','barang_dagang_out_history_update.id_checker_bs','=','checker_bs.id_checker')
                ->select('barang_dagang_out_history_update.doc_id','barang_dagang_out_history_update.no_mobil','barang_dagang_out_history_update.kode_driver','barang_dagang_out_history_update.nama_driver','area.nama_area','area_sub.nama_sub_area','checker.nama_checker','area_bs.nama_area as nama_area_bs','area_sub_bs.nama_sub_area as nama_sub_area_bs','checker_bs.nama_checker as nama_checker_bs','barang_dagang_out_history_update.from','barang_dagang_out_history_update.kategori')
                ->Where('barang_dagang_out_history_update.doc_id', $doc_id)
                ->first();
        }else if($kategori_out->kategori == 'Secondary'){
            $head = DB::table('barang_dagang_out_history_update')
                ->join('area','barang_dagang_out_history_update.kode_zona','=','area.kode_area')
                ->join('area_sub','barang_dagang_out_history_update.kode_zona_sub','=','area_sub.kode_sub_area')
                ->join('checker','barang_dagang_out_history_update.id_checker','=','checker.id_checker')
                ->select('barang_dagang_out_history_update.doc_id','barang_dagang_out_history_update.no_mobil','barang_dagang_out_history_update.kode_driver','barang_dagang_out_history_update.nama_driver','area.nama_area','area_sub.nama_sub_area','checker.nama_checker','barang_dagang_out_history_update.from','barang_dagang_out_history_update.kategori')
                ->Where('barang_dagang_out_history_update.doc_id', $doc_id)
                ->first();
        }

    	

        $detail = DB::table('barang_dagang_out_detail_history_update')
                ->join('product_dagang','barang_dagang_out_detail_history_update.kode_produk','=','product_dagang.kode_produk')
                ->Where('barang_dagang_out_detail_history_update.doc_id', $doc_id)
                ->get();

        return view ('keluar_barang_gudang.checker_control_history_out.view', compact('head','detail','kategori_out')); 

    }
}
