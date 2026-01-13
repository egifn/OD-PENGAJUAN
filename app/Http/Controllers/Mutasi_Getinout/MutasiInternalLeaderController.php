<?php

namespace App\Http\Controllers\Mutasi_Getinout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Auth;
use DB;

class MutasiInternalLeaderController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $mutasi = DB::table('mutasi_gudang')
        	->join('perusahaans','mutasi_gudang.kode_perusahaan','=','perusahaans.kode_perusahaan')
        	->join('depos','mutasi_gudang.kode_depo','=','depos.kode_depo')
        	->join('area as area_asal','mutasi_gudang.kode_area_asal','=','area_asal.kode_area')
        	->join('area_sub as area_sub_asal','mutasi_gudang.kode_sub_area_asal','area_sub_asal.kode_sub_area')
        	->join('area as area_tujuan','mutasi_gudang.kode_area_tujuan','=','area_tujuan.kode_area')
        	->join('area_sub as area_sub_tujuan','mutasi_gudang.kode_sub_area_tujuan','=','area_sub_tujuan.kode_sub_area')
        	->join('users','mutasi_gudang.id_user_input','=','users.id')
        	->select('mutasi_gudang.kode_mutasi','mutasi_gudang.tanggal','mutasi_gudang.waktu','area_asal.nama_area as nama_area_asal','area_sub_asal.nama_sub_area as nama_sub_area_asal','area_tujuan.nama_area as nama_area_tujuan','area_sub_tujuan.nama_sub_area as nama_sub_area_tujuan','mutasi_gudang.status')
        	->WhereBetween('mutasi_gudang.tanggal', [$date_start,$date_end])
        	->Where('mutasi_gudang.kode_depo', Auth::user()->kode_depo)
        	->get();

    	return view('mutasi_getinout.internal_leader.index', compact('mutasi'));
    }

    public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $mutasi = DB::table('mutasi_gudang')
            ->join('perusahaans','mutasi_gudang.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang.kode_depo','=','depos.kode_depo')
            ->join('area as area_asal','mutasi_gudang.kode_area_asal','=','area_asal.kode_area')
            ->join('area_sub as area_sub_asal','mutasi_gudang.kode_sub_area_asal','area_sub_asal.kode_sub_area')
            ->join('area as area_tujuan','mutasi_gudang.kode_area_tujuan','=','area_tujuan.kode_area')
            ->join('area_sub as area_sub_tujuan','mutasi_gudang.kode_sub_area_tujuan','=','area_sub_tujuan.kode_sub_area')
            ->join('users','mutasi_gudang.id_user_input','=','users.id')
            ->select('mutasi_gudang.kode_mutasi','mutasi_gudang.tanggal','mutasi_gudang.waktu','area_asal.nama_area as nama_area_asal','area_sub_asal.nama_sub_area as nama_sub_area_asal','area_tujuan.nama_area as nama_area_tujuan','area_sub_tujuan.nama_sub_area as nama_sub_area_tujuan','mutasi_gudang.status')
            ->WhereBetween('mutasi_gudang.tanggal', [$date_start,$date_end])
            ->Where('mutasi_gudang.kode_depo', Auth::user()->kode_depo)
            ->get();


        return view('mutasi_getinout.internal_leader.index', compact('mutasi'));
    }

    public function view($kode_mutasi)
    {
        $head = DB::table('mutasi_gudang')
        	->join('perusahaans','mutasi_gudang.kode_perusahaan','=','perusahaans.kode_perusahaan')
        	->join('depos','mutasi_gudang.kode_depo','=','depos.kode_depo')
        	->join('area as area_asal','mutasi_gudang.kode_area_asal','=','area_asal.kode_area')
        	->join('area_sub as area_sub_asal','mutasi_gudang.kode_sub_area_asal','area_sub_asal.kode_sub_area')
        	->join('area as area_tujuan','mutasi_gudang.kode_area_tujuan','=','area_tujuan.kode_area')
        	->join('area_sub as area_sub_tujuan','mutasi_gudang.kode_sub_area_tujuan','=','area_sub_tujuan.kode_sub_area')
        	->join('users','mutasi_gudang.id_user_input','=','users.id')
        	->select('mutasi_gudang.kode_mutasi','mutasi_gudang.tanggal','mutasi_gudang.waktu','area_asal.nama_area as nama_area_asal','area_sub_asal.nama_sub_area as nama_sub_area_asal','area_tujuan.nama_area as nama_area_tujuan','area_sub_tujuan.nama_sub_area as nama_sub_area_tujuan','mutasi_gudang.status')
        	->Where('mutasi_gudang.kode_mutasi', $kode_mutasi)
        	->first();

        $detail = DB::table('mutasi_gudang_detail')
                ->join('product_dagang','mutasi_gudang_detail.kode_produk','=','product_dagang.kode_produk')
                ->Where('mutasi_gudang_detail.kode_mutasi', $kode_mutasi)
                ->get();

    	return view ('mutasi_getinout.internal_leader.view', compact('head','detail'));  
    }

    public function approved(Request $request)
    {
        $kode_mutasi = request()->kode_mutasi;

        $approved = DB::table('mutasi_gudang')->where('kode_mutasi', $kode_mutasi)
                    ->update([
                        'id_user_approved' => Auth::user()->id,
                        'status' => 1
                    ]);

        alert()->success('Success.','Request Approved...');
        return redirect()->route('mutasi_internal_leader.index');
    }

    public function denied(Request $request)
    {
        $kode_mutasi = request()->kode_mutasi;

        $approved = DB::table('mutasi_gudang')->where('kode_mutasi', $kode_mutasi)
                    ->update([
                        'id_user_approved' => Auth::user()->id,
                        'status' => 2
                    ]);

        alert()->success('Success.','Request Denied...');
        return redirect()->route('mutasi_internal_leader.index');
    }

}
