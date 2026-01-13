<?php

namespace App\Http\Controllers\BarangMasuk_Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Area;
use App\Area_sub;
use App\BarangDagang_In;
use App\BarangDagang_In_Detail;
use App\BarangDagang_In_History;
use App\BarangDagang_In_History_Detail;
use App\Perusahaan;
use App\Depo;
use Carbon\carbon;
use Auth;
use DB;

class GetInController extends Controller
{	
	public function ajax_depo(Request $request) // dropdown perusahaan dan depo
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

        $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->join('users','barang_dagang_in.id_user_input','=','users.id')
                    ->select('barang_dagang_in.doc_id','barang_dagang_in.tanggal','barang_dagang_in.waktu','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in.kategori','barang_dagang_in.from','users.name','barang_dagang_in.status','barang_dagang_in.status_bs')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '')
                    ->get();

        return view ('masuk_barang_gudang.checker.index', compact('in','perusahaan','depo'));
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
        	$in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->join('users','barang_dagang_in.id_user_input','=','users.id')
                    ->select('barang_dagang_in.doc_id','barang_dagang_in.tanggal','barang_dagang_in.waktu','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in.kategori','barang_dagang_in.from','users.name','barang_dagang_in.status','barang_dagang_in.status_bs')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '')
                    ->get();
        }elseif($perusahaan_cari != '' && $depo_cari != '' && $kategori_cari == ''){
        	$in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->join('users','barang_dagang_in.id_user_input','=','users.id')
                    ->select('barang_dagang_in.doc_id','barang_dagang_in.tanggal','barang_dagang_in.waktu','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in.kategori','barang_dagang_in.from','users.name','barang_dagang_in.status','barang_dagang_in.status_bs')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', $depo_cari)
                    ->Where('barang_dagang_in.kode_perusahaan', $perusahaan_cari)
                    ->get();
        }elseif($perusahaan_cari != '' && $depo_cari != '' && $kategori_cari != ''){
        	$in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->join('users','barang_dagang_in.id_user_input','=','users.id')
                    ->select('barang_dagang_in.doc_id','barang_dagang_in.tanggal','barang_dagang_in.waktu','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in.kategori','barang_dagang_in.from','users.name','barang_dagang_in.status','barang_dagang_in.status_bs')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', $depo_cari)
                    ->Where('barang_dagang_in.kode_perusahaan', $perusahaan_cari)
                    ->Where('barang_dagang_in.kategori', $kategori_cari)
                    ->get();
        }

        return view ('masuk_barang_gudang.checker.index', compact('in','perusahaan','depo'));
    }

    public function view($doc_id)
    {
        $head = DB::table('barang_dagang_in')
                ->join('area','barang_dagang_in.kode_zona','=','area.kode_area')
                ->join('area_sub','barang_dagang_in.kode_zona_sub','=','area_sub.kode_sub_area')
                ->join('area as area_bs','barang_dagang_in.kode_zona_bs','=','area_bs.kode_area')
                ->join('area_sub as area_sub_bs','barang_dagang_in.kode_zona_sub_bs','=','area_sub_bs.kode_sub_area')
                ->join('checker','barang_dagang_in.id_checker','=','checker.id_checker')
                ->join('checker as checker_bs','barang_dagang_in.id_checker_bs','=','checker_bs.id_checker')
                ->select('barang_dagang_in.doc_id','barang_dagang_in.no_mobil','barang_dagang_in.kode_driver','barang_dagang_in.nama_driver','area.nama_area','area_sub.nama_sub_area','checker.nama_checker','area_bs.nama_area as nama_area_bs','area_sub_bs.nama_sub_area as nama_sub_area_bs','checker_bs.nama_checker as nama_checker_bs','barang_dagang_in.from')
                ->Where('barang_dagang_in.doc_id', $doc_id)
                ->first();

        $detail = DB::table('barang_dagang_in_detail')
                ->join('product_dagang','barang_dagang_in_detail.kode_produk','=','product_dagang.kode_produk')
                ->Where('barang_dagang_in_detail.doc_id', $doc_id)
                ->get();

        return view ('masuk_barang_gudang.checker.view', compact('head','detail'));  
    }
}
