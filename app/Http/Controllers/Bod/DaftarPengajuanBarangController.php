<?php

namespace App\Http\Controllers\Bod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Auth;
use DB;

class DaftarPengajuanBarangController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_pengajuan = DB::table('pengajuan')
        				->join('depos AS depos_1','pengajuan.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
						->join('users AS users_pengaju','pengajuan.id_user_input','users_pengaju.id')
						->leftJoin('users AS users_app_it','pengajuan.id_user_approval_it','users_app_it.id')
						->leftJoin('users AS users_app_ops','pengajuan.id_user_approval_ops','users_app_ops.id')
						->leftJoin('users AS users_app_ga','pengajuan.id_user_approval_ga','users_app_ga.id')
						->leftJoin('users AS users_app_pc','pengajuan.id_user_approval_pc','users_app_pc.id')
        				->leftJoin('pembelian','pengajuan.kode_pengajuan','=','pembelian.kode_pengajuan')
						->leftJoin('pembelian_detail','pembelian.kode_pembelian','pembelian_detail.kode_pembelian') 
						->leftJoin('users AS users_po','pembelian.id_user_input','users_po.id')
						->leftJoin('vendors','pembelian.kode_vendor','vendors.kode_vendor')
        				->leftJoin('penerimaan','pembelian.kode_pembelian','=','penerimaan.kode_pembelian')
        				->leftJoin('users AS users_penerima','penerimaan.id_user_input','=','users_penerima.id')
        				->leftJoin('kontrabon_detail','penerimaan.no_faktur','=','kontrabon_detail.no_faktur')
        				->leftJoin('kontrabon','kontrabon_detail.no_kontrabon','=','kontrabon.no_kontrabon')
						->leftJoin('users AS users_kontra','kontrabon.id_user_input','users_kontra.id')
        				->leftJoin('spp','kontrabon.no_kontrabon','=','spp.no_kontrabon')
						->leftJoin('users AS users_spp','spp.id_user_input','users_spp.id')
        				->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_depo','depos_1.nama_depo','pengajuan.kode_divisi','divisi_1.nama_divisi','pengajuan.id_user_input','users_pengaju.name',
								'pengajuan.status_it AS approval_it','pengajuan.id_user_approval_it','users_app_it.name AS nama_it','pengajuan.tgl_approval_it',
								'pengajuan.status_ops AS approval_ops','pengajuan.id_user_approval_ops','users_app_ops.name AS nama_ops','pengajuan.tgl_approval_ops',
								'pengajuan.status_ga AS approval_ga','pengajuan.id_user_approval_ga','users_app_ga.name AS nama_ga','pengajuan.tgl_approval_ga',
								'pengajuan.status_pc AS approval_purchasing','pengajuan.id_user_approval_pc','users_app_pc.name AS nama_pc','pengajuan.tgl_approval_pc',
								'pembelian.id_user_input','users_po.name AS pembuat_po','pembelian.kode_vendor','vendors.nama_vendor','pembelian.kode_pembelian','pembelian.tgl_pembelian AS tgl_po',DB::raw('SUM(pembelian_detail.harga_total) as total'),'pembelian.status AS status_po',
								'penerimaan.no_btb','users_penerima.name AS approved_by','penerimaan.tgl_terima AS tgl_terima_barang','penerimaan.no_faktur',
								'kontrabon_detail.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.id_user_input','users_kontra.name as pembuat_kontra','kontrabon.total as total_kontra',
								'spp.no_spp','spp.tgl_spp','spp.id_user_input','users_spp.name as pembuat_spp','ms_pengeluaran.pembayaran','ms_pengeluaran.cara_pembayaran')
        				->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
						->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_depo','depos_1.nama_depo','pengajuan.kode_divisi','divisi_1.nama_divisi','pengajuan.id_user_input','users_pengaju.name',
								'pengajuan.status_it','pengajuan.id_user_approval_it','users_app_it.name','pengajuan.tgl_approval_it',
								'pengajuan.status_ops','pengajuan.id_user_approval_ops','users_app_ops.name','pengajuan.tgl_approval_ops',
								'pengajuan.status_ga','pengajuan.id_user_approval_ga','users_app_ga.name','pengajuan.tgl_approval_ga',
								'pengajuan.status_pc','pengajuan.id_user_approval_pc','users_app_pc.name','pengajuan.tgl_approval_pc',
								'pembelian.id_user_input','users_po.name','pembelian.kode_vendor','vendors.nama_vendor','pembelian.kode_pembelian','pembelian.tgl_pembelian','pembelian.status',
								'penerimaan.no_btb','users_penerima.name','penerimaan.tgl_terima','penerimaan.no_faktur',
								'kontrabon_detail.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.id_user_input','users_kontra.name','kontrabon.total',
								'spp.no_spp','spp.tgl_spp','spp.id_user_input','users_spp.name','ms_pengeluaran.pembayaran','ms_pengeluaran.cara_pembayaran')
        				->orderBy('pengajuan.kode_pengajuan', 'DESC')
        				->get();

        return view ('bod.daftar_barang.index', compact('data_pengajuan'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data_pengajuan = DB::table('pengajuan')
        				->join('depos AS depos_1','pengajuan.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
						->join('users AS users_pengaju','pengajuan.id_user_input','users_pengaju.id')
						->leftJoin('users AS users_app_it','pengajuan.id_user_approval_it','users_app_it.id')
						->leftJoin('users AS users_app_ops','pengajuan.id_user_approval_ops','users_app_ops.id')
						->leftJoin('users AS users_app_ga','pengajuan.id_user_approval_ga','users_app_ga.id')
						->leftJoin('users AS users_app_pc','pengajuan.id_user_approval_pc','users_app_pc.id')
        				->leftJoin('pembelian','pengajuan.kode_pengajuan','=','pembelian.kode_pengajuan')
						->leftJoin('pembelian_detail','pembelian.kode_pembelian','pembelian_detail.kode_pembelian')
						->leftJoin('users AS users_po','pembelian.id_user_input','users_po.id')
						->leftJoin('vendors','pembelian.kode_vendor','vendors.kode_vendor')
        				->leftJoin('penerimaan','pembelian.kode_pembelian','=','penerimaan.kode_pembelian')
        				->leftJoin('users AS users_penerima','penerimaan.id_user_input','=','users_penerima.id')
        				->leftJoin('kontrabon_detail','penerimaan.no_faktur','=','kontrabon_detail.no_faktur')
        				->leftJoin('kontrabon','kontrabon_detail.no_kontrabon','=','kontrabon.no_kontrabon')
						->leftJoin('users AS users_kontra','kontrabon.id_user_input','users_kontra.id')
        				->leftJoin('spp','kontrabon.no_kontrabon','=','spp.no_kontrabon')
						->leftJoin('users AS users_spp','spp.id_user_input','users_spp.id')
        				->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_depo','depos_1.nama_depo','pengajuan.kode_divisi','divisi_1.nama_divisi','pengajuan.id_user_input','users_pengaju.name',
								'pengajuan.status_it AS approval_it','pengajuan.id_user_approval_it','users_app_it.name AS nama_it','pengajuan.tgl_approval_it',
								'pengajuan.status_ops AS approval_ops','pengajuan.id_user_approval_ops','users_app_ops.name AS nama_ops','pengajuan.tgl_approval_ops',
								'pengajuan.status_ga AS approval_ga','pengajuan.id_user_approval_ga','users_app_ga.name AS nama_ga','pengajuan.tgl_approval_ga',
								'pengajuan.status_pc AS approval_purchasing','pengajuan.id_user_approval_pc','users_app_pc.name AS nama_pc','pengajuan.tgl_approval_pc',
								'pembelian.id_user_input','users_po.name AS pembuat_po','pembelian.kode_vendor','vendors.nama_vendor','pembelian.kode_pembelian','pembelian.tgl_pembelian AS tgl_po',DB::raw('SUM(pembelian_detail.harga_total) as total'),'pembelian.status AS status_po',
								'penerimaan.no_btb','users_penerima.name AS approved_by','penerimaan.tgl_terima AS tgl_terima_barang','penerimaan.no_faktur',
								'kontrabon_detail.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.id_user_input','users_kontra.name as pembuat_kontra','kontrabon.total as total_kontra',
								'spp.no_spp','spp.tgl_spp','spp.id_user_input','users_spp.name as pembuat_spp','ms_pengeluaran.pembayaran','ms_pengeluaran.cara_pembayaran')
        				->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
						->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_depo','depos_1.nama_depo','pengajuan.kode_divisi','divisi_1.nama_divisi','pengajuan.id_user_input','users_pengaju.name',
								'pengajuan.status_it','pengajuan.id_user_approval_it','users_app_it.name','pengajuan.tgl_approval_it',
								'pengajuan.status_ops','pengajuan.id_user_approval_ops','users_app_ops.name','pengajuan.tgl_approval_ops',
								'pengajuan.status_ga','pengajuan.id_user_approval_ga','users_app_ga.name','pengajuan.tgl_approval_ga',
								'pengajuan.status_pc','pengajuan.id_user_approval_pc','users_app_pc.name','pengajuan.tgl_approval_pc',
								'pembelian.id_user_input','users_po.name','pembelian.kode_vendor','vendors.nama_vendor','pembelian.kode_pembelian','pembelian.tgl_pembelian','pembelian.status',
								'penerimaan.no_btb','users_penerima.name','penerimaan.tgl_terima','penerimaan.no_faktur',
								'kontrabon_detail.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.id_user_input','users_kontra.name','kontrabon.total',
								'spp.no_spp','spp.tgl_spp','spp.id_user_input','users_spp.name','ms_pengeluaran.pembayaran','ms_pengeluaran.cara_pembayaran')
        				->orderBy('pengajuan.kode_pengajuan', 'DESC')
        				->get();

        return view ('bod.daftar_barang.index', compact('data_pengajuan'));
    }
}
