<?php

namespace App\Http\Controllers\Expenditure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;
use Auth;

class PcHoController extends Controller
{
    public function index()
    {
    	$depo = DB::table('depos')
    				->where('depos.kode_perusahaan', 'TUA')
    				->get();


        $start_dms = (date('Y-m-d'));
        $end_dms = (date('Y-m-d'));

    	$view = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
    				->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
    				->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$start_dms,$end_dms])
    				->orderBy('pengajuan_biaya.kode_pengajuan_b','ASC')
                    ->groupBy('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan','users.name')
                    ->get();

    	return view ('pengeluaran.rutin.index', compact('depo','view'));
    }

    public function cari(Request $request)
    {   
        $depo = DB::table('depos')
                    ->where('depos.kode_perusahaan', 'TUA')
                    ->get();
        $kategori = $request->type;
        $kode_depo = $request->depo;
        $start_dms = (date('Y-m-d'));
        $end_dms = (date('Y-m-d'));

        if(request()->tanggal != ''){
            $date_dms = explode(' - ' ,request()->tanggal);
            $start_dms = Carbon::parse($date_dms[0])->format('Y-m-d');
            $end_dms = Carbon::parse($date_dms[1])->format('Y-m-d');
        }

        if(request()->depo != '')
        {
            $kode_depo = request()->depo;
        }

        if(request()->type != '')
        {
            $kategori = request()->type;
        }

        if ($kode_depo == '')
        {
            $view = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$start_dms,$end_dms])
                    ->orderBy('pengajuan_biaya.kode_pengajuan_b','ASC')
                    ->groupBy('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan','users.name')
                    ->get();
        }else{
            $view = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name')
                    ->whereBetween('pengajuan_biaya.tgl_pengajuan_b', [$start_dms,$end_dms])
                    ->where('pengajuan_biaya.kode_depo',  $kode_depo)
                    ->orderBy('pengajuan_biaya.kode_pengajuan_b','ASC')
                    ->groupBy('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan','users.name')
                    ->get();
        }

        

        return view('pengeluaran.rutin.index', compact('view','depo'));
    }
}
