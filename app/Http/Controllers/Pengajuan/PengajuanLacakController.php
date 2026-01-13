<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengajuanLacakController extends Controller
{
    public function index(Request $request)
    {
        $data_lacak = DB::table('pengajuan')
                        ->join('depos AS depos_1','pengajuan.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
        				->leftJoin('pembelian','pengajuan.kode_pengajuan','=','pembelian.kode_pengajuan')
        				->leftJoin('penerimaan','pembelian.kode_pembelian','=','penerimaan.kode_pembelian')
        				->leftJoin('users AS users_penerima','penerimaan.id_user_input','=','users_penerima.id')
        				->leftJoin('kontrabon_detail','penerimaan.no_faktur','=','kontrabon_detail.no_faktur')
        				->leftJoin('kontrabon','kontrabon_detail.no_kontrabon','=','kontrabon.no_kontrabon')
        				->leftJoin('spp','kontrabon.no_kontrabon','=','spp.no_kontrabon')
        				->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_depo','depos_1.nama_depo','pengajuan.kode_divisi','divisi_1.nama_divisi','pengajuan.status_it AS approval_it','pengajuan.tgl_approval_it','pengajuan.status_ga AS approval_ga','pengajuan.tgl_approval_ga','pengajuan.status_ops AS approval_ops','pengajuan.tgl_approval_ops','pengajuan.status_pc AS approval_purchasing','pengajuan.tgl_approval_pc','pembelian.kode_pembelian','pembelian.tgl_pembelian AS tgl_po','pembelian.status AS status_po','penerimaan.no_btb','users_penerima.name AS approved_by','penerimaan.tgl_terima AS tgl_terima_barang','penerimaan.no_faktur','kontrabon_detail.no_kontrabon','kontrabon.tgl_kontrabon','spp.no_spp','spp.tgl_spp','ms_pengeluaran.pembayaran')
        				->where('pengajuan.kode_pengajuan', '')
                        ->first();

        $data_lacak = DB::table('pengajuan_biaya')
        				->join('depos AS depos_1','pengajuan_biaya.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan_biaya.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
        				->leftJoin('spp','pengajuan_biaya.kode_pengajuan_b','=','spp.no_kontrabon')
        				->leftJoin('pengisian_cekgiro_detail','spp.no_spp','=','pengisian_cekgiro_detail.no_spp')
        				->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_depo','depos_1.nama_depo','pengajuan_biaya.kode_divisi','divisi_1.nama_divisi','pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.tgl_approval_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.tgl_approval_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.tgl_approval_claim','spp.no_spp','spp.tgl_spp','ms_pengeluaran.pembayaran','pengisian_cekgiro_detail.id_cek')
        				->where('pengajuan_biaya.kode_pengajuan_b', '')
        				->first();

        return view('pengajuan.pengajuan_lacak.index', compact('data_lacak'));
    }

    public function cari(Request $request)
    {
        
        $data_lacak = DB::table('pengajuan')
                        ->join('depos AS depos_1','pengajuan.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
        				->leftJoin('pembelian','pengajuan.kode_pengajuan','=','pembelian.kode_pengajuan')
        				->leftJoin('penerimaan','pembelian.kode_pembelian','=','penerimaan.kode_pembelian')
        				->leftJoin('users AS users_penerima','penerimaan.id_user_input','=','users_penerima.id')
        				->leftJoin('kontrabon_detail','penerimaan.no_faktur','=','kontrabon_detail.no_faktur')
        				->leftJoin('kontrabon','kontrabon_detail.no_kontrabon','=','kontrabon.no_kontrabon')
        				->leftJoin('spp','kontrabon.no_kontrabon','=','spp.no_kontrabon')
        				->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.jenis','pengajuan.kode_depo','depos_1.nama_depo','pengajuan.kode_divisi','divisi_1.nama_divisi','pengajuan.status_it AS approval_it','pengajuan.tgl_approval_it','pengajuan.status_ga AS approval_ga','pengajuan.tgl_approval_ga','pengajuan.status_ops AS approval_ops','pengajuan.tgl_approval_ops','pengajuan.status_pc AS approval_purchasing','pengajuan.tgl_approval_pc','pembelian.kode_pembelian','pembelian.tgl_pembelian AS tgl_po','pembelian.status AS status_po','penerimaan.no_btb','users_penerima.name AS approved_by','penerimaan.tgl_terima AS tgl_terima_barang','penerimaan.no_faktur','kontrabon_detail.no_kontrabon','kontrabon.tgl_kontrabon','spp.no_spp','spp.tgl_spp','ms_pengeluaran.pembayaran')
        				->where('pengajuan.kode_pengajuan', $request->get('lacak'))
                        ->get();

        return view('pengajuan.pengajuan_lacak.index', compact('data_lacak'));
    }

    
}
