<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalBodSppdController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $approval_sppd = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->join('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->join('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
                ->Where('pengajuan_sppd.status_atasan', 1)
                ->Where('pengajuan_sppd.status_hrd', 1)
                ->Where('pengajuan_sppd.status_validasi_adm_biaya', 1)
                ->Where('pengajuan_sppd.status_biaya', 1)
                ->orderBy('pengajuan_sppd.tgl_pengajuan_sppd', 'DESC')
                ->get();

        return view ('approval.approval_bod_sppd.index', compact('approval_sppd'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $approval_sppd = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->join('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->join('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
                ->Where('pengajuan_sppd.status_atasan', 1)
                ->Where('pengajuan_sppd.status_hrd', 1)
                ->Where('pengajuan_sppd.status_validasi_adm_biaya', 1)
                ->Where('pengajuan_sppd.status_biaya', 1)
                ->orderBy('pengajuan_sppd.tgl_pengajuan_sppd', 'DESC')
                ->get();
                
        return view ('approval.approval_bod_sppd.index', compact('approval_sppd'));

    }

    public function view($kode_pengajuan_sppd)
    {
        $view_approval_sppd = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->join('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->join('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.kendaraan',
                    'pengajuan_sppd.sebagai',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                ->first();

                $getRow = DB::table('pengajuan_sppd_rincian')->select(DB::raw('MAX(kode_rincian_sppd) as jml_data'))
                ->where('pengajuan_sppd_rincian.kode_pengajuan_sppd', $kode_pengajuan_sppd);
            $rowCount = $getRow->count();
        
        //rincian SPPD//
        $rincian_sppd = DB::table('pengajuan_sppd')
                        ->join('pengajuan_sppd_rincian','pengajuan_sppd.kode_pengajuan_sppd','=','pengajuan_sppd_rincian.kode_pengajuan_sppd')
                        ->select('pengajuan_sppd.kode_pengajuan_sppd','pengajuan_sppd_rincian.kode_rincian_sppd','pengajuan_sppd_rincian.keterangan','pengajuan_sppd_rincian.total_uang','pengajuan_sppd_rincian.jml','pengajuan_sppd_rincian.subtotal','pengajuan_sppd.status_validasi_adm_biaya')
                        ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                        ->where('pengajuan_sppd_rincian.keterangan', 'Biaya Uang SPPD')
                        ->first();
        //End rincian SPPD//

        //rincian BBM//
        $rincian_bbm = DB::table('pengajuan_sppd')
                        ->join('pengajuan_sppd_rincian','pengajuan_sppd.kode_pengajuan_sppd','=','pengajuan_sppd_rincian.kode_pengajuan_sppd')
                        ->select('pengajuan_sppd.kode_pengajuan_sppd','pengajuan_sppd_rincian.kode_rincian_sppd','pengajuan_sppd_rincian.keterangan','pengajuan_sppd_rincian.total_uang','pengajuan_sppd_rincian.jml','pengajuan_sppd_rincian.subtotal','pengajuan_sppd.status_validasi_adm_biaya')
                        ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                        ->where('pengajuan_sppd_rincian.keterangan', 'Biaya Uang BBM')
                        ->first();
        //End rincian BBM//

        //rincian Tol//
        $rincian_tol = DB::table('pengajuan_sppd')
                        ->join('pengajuan_sppd_rincian','pengajuan_sppd.kode_pengajuan_sppd','=','pengajuan_sppd_rincian.kode_pengajuan_sppd')
                        ->select('pengajuan_sppd.kode_pengajuan_sppd','pengajuan_sppd_rincian.kode_rincian_sppd','pengajuan_sppd_rincian.keterangan','pengajuan_sppd_rincian.total_uang','pengajuan_sppd_rincian.jml','pengajuan_sppd_rincian.subtotal','pengajuan_sppd.status_validasi_adm_biaya')
                        ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                        ->where('pengajuan_sppd_rincian.keterangan', 'Biaya Uang Tol')
                        ->first();
        //End rincian Tol//

        //rincian Parkir//
        $rincian_parkir = DB::table('pengajuan_sppd')
                        ->join('pengajuan_sppd_rincian','pengajuan_sppd.kode_pengajuan_sppd','=','pengajuan_sppd_rincian.kode_pengajuan_sppd')
                        ->select('pengajuan_sppd.kode_pengajuan_sppd','pengajuan_sppd_rincian.kode_rincian_sppd','pengajuan_sppd_rincian.keterangan','pengajuan_sppd_rincian.total_uang','pengajuan_sppd_rincian.jml','pengajuan_sppd_rincian.subtotal','pengajuan_sppd.status_validasi_adm_biaya')
                        ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                        ->where('pengajuan_sppd_rincian.keterangan', 'Biaya Uang Parkir')
                        ->first();
        //End rincian Parkir//

        $data_bbm = DB::table('pengajuan_sppd')
                    ->join('tarif_bbm', function($join)
                        {
                            $join->on('pengajuan_sppd.kode_depo','=','tarif_bbm.kd_dari_depo');
                            $join->on('pengajuan_sppd.tujuan_depo','=','tarif_bbm.kd_ke_depo');
                            $join->on('pengajuan_sppd.kendaraan','=','tarif_bbm.kendaraan');
                        })
                        ->select('pengajuan_sppd.kode_depo','pengajuan_sppd.tujuan_depo','tarif_bbm.uang')
                        ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                        ->first();

        return view ('approval.approval_bod_sppd.view', compact('view_approval_sppd','data_bbm','rowCount','rincian_sppd','rincian_bbm','rincian_tol','rincian_parkir'));
    }

    public function approved(Request $request)
    {
        if(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_biaya' => 1,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

        }elseif(Auth::user()->kode_divisi == '1'){ //-- jika HRD
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_hrd' => 1,
                        'id_user_approval_hrd' => Auth::user()->id,
                        'tgl_approval_hrd' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }else{
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_atasan' => 1,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }

        alert()->success('Success.','Request Approved...');
        return redirect()->route('approval_sppd.index');
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_biaya' => 2,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

        }elseif(Auth::user()->kode_divisi == '1'){ //-- jika HRD
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_hrd' => 2,
                        'id_user_approval_hrd' => Auth::user()->id,
                        'tgl_approval_hrd' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }else{
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_atasan' => 2,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }

        alert()->success('Success.','Request Approved...');
        return redirect()->route('approval_sppd.index');
    }

    public function pending(Request $request)
    {
        if(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_biaya' => 3,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

        }elseif(Auth::user()->kode_divisi == '1'){ //-- jika HRD
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_hrd' => 3,
                        'id_user_approval_hrd' => Auth::user()->id,
                        'tgl_approval_hrd' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }else{
            $kode_pengajuan_sppd = request()->kode_pengajuan_sppd;

            $approved_sppd = DB::table('pengajuan_sppd')->where('kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->update([
                        'status_atasan' => 3,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }

        alert()->success('Success.','Request Approved...');
        return redirect()->route('approval_sppd.index');
    }
}
