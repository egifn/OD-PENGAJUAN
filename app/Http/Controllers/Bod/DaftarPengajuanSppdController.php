<?php

namespace App\Http\Controllers\Bod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaftarPengajuanSppdController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_pengajuan = DB::table('pengajuan_sppd')
        				->join('depos AS depos_1','pengajuan_sppd.kode_depo','=','depos_1.kode_depo')
        				->join('divisi AS divisi_1','pengajuan_sppd.kode_divisi','=','divisi_1.kode_divisi')
        				->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
						->join('users AS users_pengaju','pengajuan_sppd.id_user_input','users_pengaju.id')
						->leftJoin('users AS users_atasan','pengajuan_sppd.id_user_approval_atasan','users_atasan.id')
						->leftJoin('users AS users_admin_biaya','pengajuan_sppd.id_user_validasi_adm_biaya','users_admin_biaya.id')
						->leftJoin('users AS users_app_biaya','pengajuan_sppd.id_user_approval_biaya','users_app_biaya.id')
						->leftJoin('users AS users_app_hrd','pengajuan_sppd.id_user_approval_hrd','users_app_hrd.id')
        				->select('pengajuan_sppd.kode_pengajuan_sppd','pengajuan_sppd.tgl_pengajuan_sppd','pengajuan_sppd.pelaksana',
                                'pengajuan_sppd.kode_depo','depos_1.nama_depo','pengajuan_sppd.kode_divisi','divisi_1.nama_divisi',
                                'pengajuan_sppd.id_user_input','users_pengaju.name',
								'pengajuan_sppd.status_hrd AS approval_hrd','pengajuan_sppd.id_user_approval_hrd','users_app_hrd.name AS nama_hrd','pengajuan_sppd.tgl_approval_hrd',
                                'pengajuan_sppd.status_validasi_adm_biaya AS approval_admin_biaya','pengajuan_sppd.id_user_validasi_adm_biaya','users_admin_biaya.name AS nama_admin_biaya','pengajuan_sppd.tgl_validasi_adm_biaya',
								'pengajuan_sppd.status_biaya AS approval_biaya','pengajuan_sppd.id_user_approval_biaya','users_app_biaya.name AS nama_biaya','pengajuan_sppd.tgl_approval_biaya'
								)
        				->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
        				->get();

        return view ('bod.daftar_sppd.index', compact('data_pengajuan'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data_pengajuan = DB::table('pengajuan_sppd')
            ->join('depos AS depos_1','pengajuan_sppd.kode_depo','=','depos_1.kode_depo')
            ->join('divisi AS divisi_1','pengajuan_sppd.kode_divisi','=','divisi_1.kode_divisi')
            ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
            ->join('users AS users_pengaju','pengajuan_sppd.id_user_input','users_pengaju.id')
            ->leftJoin('users AS users_atasan','pengajuan_sppd.id_user_approval_atasan','users_atasan.id')
            ->leftJoin('users AS users_admin_biaya','pengajuan_sppd.id_user_validasi_adm_biaya','users_admin_biaya.id')
            ->leftJoin('users AS users_app_biaya','pengajuan_sppd.id_user_approval_biaya','users_app_biaya.id')
            ->leftJoin('users AS users_app_hrd','pengajuan_sppd.id_user_approval_hrd','users_app_hrd.id')
            ->select('pengajuan_sppd.kode_pengajuan_sppd','pengajuan_sppd.tgl_pengajuan_sppd','pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_depo','depos_1.nama_depo','pengajuan_sppd.kode_divisi','divisi_1.nama_divisi',
                    'pengajuan_sppd.id_user_input','users_pengaju.name',
                    'pengajuan_sppd.status_hrd AS approval_hrd','pengajuan_sppd.id_user_approval_hrd','users_app_hrd.name AS nama_hrd','pengajuan_sppd.tgl_approval_hrd',
                    'pengajuan_sppd.status_validasi_adm_biaya AS approval_admin_biaya','pengajuan_sppd.id_user_validasi_adm_biaya','users_admin_biaya.name AS nama_admin_biaya','pengajuan_sppd.tgl_validasi_adm_biaya',
                    'pengajuan_sppd.status_biaya AS approval_biaya','pengajuan_sppd.id_user_approval_biaya','users_app_biaya.name AS nama_biaya','pengajuan_sppd.tgl_approval_biaya'
                    )
            ->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
            ->orderBy('pengajuan_sppd.kode_pengajuan_sppd', 'DESC')
            ->get();
        return view ('bod.daftar_sppd.index', compact('data_pengajuan'));
    }
}
