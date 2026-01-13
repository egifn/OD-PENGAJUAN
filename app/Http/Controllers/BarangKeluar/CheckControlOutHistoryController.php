<?php

namespace App\Http\Controllers\BarangKeluar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\BarangDagang_Out_History;
use App\BarangDagang_Out_History_Detail;
use Carbon\carbon;
use Auth;
use DB;

class CheckControlOutHistoryController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_depo == '337'){ //BOGOR
        	$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '337')
                    ->get();
        }else if(Auth::user()->kode_depo == '901'){ //PARUNG
        	$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '901')
                    ->get();
        }else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
        	$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '342')
                    ->get();
        }else{
            $out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', Auth::user()->kode_depo)
                    ->get();
        }

        return view ('keluar_barang.checker_control_out_history.index', compact('out_history'));
    }

    public function cari(Request $request)
    {
    	$kategori = $request->kategori;

    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->kategori != '')
        {
            $kategori = request()->kategori;
        }

        if(Auth::user()->kode_depo == '337'){ //BOGOR
        	if($kategori=='')
        	{
        		$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '337')
                    ->get();
        	}else{
        		$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '337')
                    ->Where('barang_dagang_out_history_update.kategori', $kategori)
                    ->get();
        	}
       	}else if(Auth::user()->kode_depo == '901'){ //PARUNG
       		if($kategori=='')
        	{
        		$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '901')
                    ->get();
        	}else{
        		$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '901')
                    ->Where('barang_dagang_out_history_update.kategori', $kategori)
                    ->get();
        	}
       	}else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
       		if($kategori=='')
        	{
        		$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '342')
                    ->get();
        	}else{
        		$out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', '342')
                    ->Where('barang_dagang_out_history_update.kategori', $kategori)
                    ->get();
        	}
       	}else{
            if($kategori=='')
            {
                $out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', Auth::user()->kode_depo)
                    ->get();
            }else{
                $out_history = DB::table('barang_dagang_out_history_update')
                    ->join('perusahaans','barang_dagang_out_history_update.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out_history_update.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out_history_update.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out_history_update.status', '1')
                    ->Where('barang_dagang_out_history_update.status_bs', '1')
                    ->Where('barang_dagang_out_history_update.kode_depo', Auth::user()->kode_depo)
                    ->Where('barang_dagang_out_history_update.kategori', $kategori)
                    ->get();
            }
        }

       	return view ('keluar_barang.checker_control_out_history.index', compact('out_history'));
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

        return view ('keluar_barang.checker_control_out_history.view', compact('head','detail','kategori_out')); 
    }
}
