<?php

namespace App\Http\Controllers\Snd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Auth;
use DB;

class SndImportController extends Controller
{
    public function index()
    {
    	/*$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_divisi == '0') {
            $pengajuan_biaya = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', [8])
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }else{
            $pengajuan_biaya = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                ->WhereNotIn('pengajuan_biaya.kategori', [8])
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }*/

    	return view('snd.import_data.index');
    }
}
