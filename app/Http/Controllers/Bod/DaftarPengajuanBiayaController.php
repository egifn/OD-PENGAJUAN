<?php

namespace App\Http\Controllers\Bod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Auth;
use DB;

class DaftarPengajuanBiayaController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_pengajuan = DB::table('pengajuan_biaya')
        				->join('depos AS depos_1','pengajuan_biaya.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan_biaya.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
        				->leftJoin('spp','pengajuan_biaya.kode_pengajuan_b','=','spp.no_kontrabon')
        				->leftJoin('pengisian_cekgiro_detail','spp.no_spp','=','pengisian_cekgiro_detail.no_spp')
        				->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_depo','depos_1.nama_depo','pengajuan_biaya.kode_divisi','divisi_1.nama_divisi','pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.tgl_approval_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.tgl_approval_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.tgl_approval_claim','spp.no_spp','spp.tgl_spp','ms_pengeluaran.pembayaran','pengisian_cekgiro_detail.id_cek')
        				->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->WhereNotIn('pengajuan_biaya.kategori',  ['33','9','12','21','17','18','35'])
        				->orderBy('pengajuan_biaya.kode_pengajuan_b', 'DESC')
        				->get();

        return view ('bod.daftar_biaya.index', compact('data_pengajuan'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data_pengajuan = DB::table('pengajuan_biaya')
        				->join('depos AS depos_1','pengajuan_biaya.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan_biaya.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
        				->leftJoin('spp','pengajuan_biaya.kode_pengajuan_b','=','spp.no_kontrabon')
        				->leftJoin('pengisian_cekgiro_detail','spp.no_spp','=','pengisian_cekgiro_detail.no_spp')
        				->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_depo','depos_1.nama_depo','pengajuan_biaya.kode_divisi','divisi_1.nama_divisi','pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.tgl_approval_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.tgl_approval_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.tgl_approval_claim','spp.no_spp','spp.tgl_spp','ms_pengeluaran.pembayaran','pengisian_cekgiro_detail.id_cek')
        				->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->WhereNotIn('pengajuan_biaya.kategori',  ['33','9','12','21','17','18','35'])
        				->orderBy('pengajuan_biaya.kode_pengajuan_b', 'DESC')
        				->get();

        return view ('bod.daftar_biaya.index', compact('data_pengajuan'));
    }
}
