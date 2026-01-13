<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestSppdController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        // $request_detail = DB::table('pengajuan_biaya')
        //             ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
    	// 			->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
    	// 			->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
    	// 			->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
    	// 			->join('users','pengajuan_biaya.id_user_input','=','users.id')
        //             ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
    	// 			->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','pengajuan_biaya.tipe',DB::raw('SUM(pengajuan_biaya_detail.tharga) as total'),'pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
        //             ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
        //             ->WhereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','10']) //Kode Gaji,mitra,BPJS,insentif
        //             ->groupBy('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
    	// 			->orderBy('pengajuan_biaya.tgl_pengajuan_b','Desc')
    	// 			->get();

        // $sum = DB::table('pengajuan_biaya')
        //             ->select(DB::raw('count(pengajuan_biaya.kode_pengajuan_b) as sum'))
        //             ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
        //             ->WhereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','10']) //Kode Gaji,mitra,BPJS,insentif
        //             ->first();

        // $jumlah = DB::table('pengajuan_biaya')
        //             ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
        //             ->select(DB::raw('sum(pengajuan_biaya_detail.tharga) as total'))
        //             ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
        //             ->WhereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','10']) //Kode Gaji,mitra,BPJS,insentif
        //             ->first();

        return view ('purchasing.request_sppd.index');
    }
}
