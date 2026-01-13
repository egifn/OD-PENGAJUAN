<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Category;
use App\Divisi;
use App\Product;
use App\Pengajuan;
use App\Pengajuan_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index()
    {   
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_divisi == '3'){ //-- Jika IT--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])    
                        ->Where('pengajuan.status_atasan', 1)               
                        ->WhereIn('pengajuan.status_validasi_adm_it', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_it', ['0','1','2','3'])
                        ->Where('pengajuan_detail.id_kategori', 2)
                        ->orWhere('pengajuan.status_it', 0)
                        ->WhereIn('pengajuan.status_validasi_adm_it', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_it', ['0','1','2','3'])
                        ->Where('pengajuan_detail.id_kategori', 2)
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        //->orderBy('pengajuan.status_it', 'ASC')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_it = '0' THEN 0 WHEN pengajuan.status_it = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '2'){ //-- Jika Operasional--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->where('pengajuan.tgl_pengajuan', '>=', '2023-08-30')
						->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_atasan', 1)
						->Where('pengajuan.status_it', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ops', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ops', ['0','1','2','3']) 
                        ->orWhere('pengajuan.status_ops', 0)
						->where('pengajuan.tgl_pengajuan', '>=', '2023-08-30')
						->Where('pengajuan.status_atasan',  1)
						->Where('pengajuan.status_it', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ops', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ops', ['0','1','2','3'])
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        //->orderBy('pengajuan.status_ops', 'ASC')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_ops = '0' THEN 0 WHEN pengajuan.status_ops = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '4'){ //-- Jika GA--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
						->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_atasan', 1)
						->Where('pengajuan.status_it', 1)
						->Where('pengajuan.status_ops', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ga', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ga', ['0','1','2','3']) 
                        ->orWhere('pengajuan.status_ga', 0)
						->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
						->Where('pengajuan.status_atasan',  1)
                        ->Where('pengajuan.status_it', 1)
                        ->Where('pengajuan.status_ops', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ga', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ga', ['0','1','2','3']) 
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        //->orderBy('pengajuan.status_ga', 'ASC')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_ga = '0' THEN 0 WHEN pengajuan.status_ga = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '11'){ //-- Jika Purchasing--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
						->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_atasan',  1)
                        ->Where('pengajuan.status_it', 1)
                        ->Where('pengajuan.status_ops', 1)
                        ->Where('pengajuan.status_ga', 1)
                        ->orWhere('pengajuan.status_validasi_adm_pc', 0)
                        ->WhereIn('pengajuan_detail.status_cek_pc', ['0','1','2','3'])
                        ->WhereIn('pengajuan.status_validasi_adm_pc', ['1'])
                        ->orWhere('pengajuan.status_pc', 0)
						->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
						->Where('pengajuan.status_atasan',  1)
                        ->Where('pengajuan.status_it', 1)
                        ->Where('pengajuan.status_ops', 1)
                        ->Where('pengajuan.status_ga', 1)
                        ->WhereIn('pengajuan_detail.status_cek_pc', ['0','1','2','3'])
                        ->WhereIn('pengajuan.status_validasi_adm_pc', ['1'])
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        //->orderBy('pengajuan.status_pc', 'ASC')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_pc = '0' THEN 0 WHEN pengajuan.status_pc = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '17'){ //-- Jika tgsm--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->leftJoin('users as validator_tgsm','pengajuan_detail.id_user_adm_tgsm','=','validator_tgsm.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','pengajuan.status_tgsm','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','validator_tgsm.name as nama_tgsm')
                        ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        // ->Where('pengajuan.status_validasi_adm_it', 1)
                        // ->orWhere('pengajuan.status_validasi_adm_it', 3)                     
                        ->WhereIn('pengajuan.status_validasi_adm_tgsm', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_tgsm', ['0','1','2','3'])
                        ->Where('pengajuan_detail.id_kategori', 5)
                        ->Where('pengajuan.status_atasan', 1)
                        // ->Where('pengajuan_detail.status_cek_atasan', 1)
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','pengajuan.status_tgsm','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','validator_tgsm.name')
                        ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '0'){
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_validasi_adm_it', 1)
                        ->Where('pengajuan.status_validasi_adm_ops', 1)
                        ->Where('pengajuan.status_validasi_adm_ga', 1)
                        ->Where('pengajuan.status_validasi_adm_pc', 1)
                        ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                        ->get();
        }else{
            $approval = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('users','pengajuan.id_user_input','=','users.id')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->Where('pengajuan.status_atasan', '')
                                            ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                            ->get();
        }
    	
    	return view ('approval.approval.index', compact('approval'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_divisi == '3'){ //-- Jika IT--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_atasan', 1)               
                        ->WhereIn('pengajuan.status_validasi_adm_it', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_it', ['0','1','2','3'])
                        ->Where('pengajuan_detail.id_kategori', 2)
                        ->orWhere('pengajuan.status_it', 0)
                        ->WhereIn('pengajuan.status_validasi_adm_it', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_it', ['0','1','2','3'])
                        ->Where('pengajuan_detail.id_kategori', 2)
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                         //->orderBy('pengajuan.status_it', 'ASC')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_it = '0' THEN 0 WHEN pengajuan.status_it = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '2'){ //-- Jika Operasional--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->where('pengajuan.tgl_pengajuan', '>=', '2023-08-30')
						->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_atasan', 1)
						->Where('pengajuan.status_it', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ops', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ops', ['0','1','2','3']) 
                        ->orWhere('pengajuan.status_ops', 0)
						->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
						->where('pengajuan.tgl_pengajuan', '>=', '2023-08-30')
						->Where('pengajuan.status_atasan',  1)
						->Where('pengajuan.status_it', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ops', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ops', ['0','1','2','3'])
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_ops = '0' THEN 0 WHEN pengajuan.status_ops = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '4'){ //-- Jika GA--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
						->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_atasan', 1)
						->Where('pengajuan.status_it', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ga', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ga', ['0','1','2','3'])
                        ->orWhere('pengajuan.status_ga', 0)
						->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
						->Where('pengajuan.status_atasan',  1)
						->Where('pengajuan.status_it', 1)
                        ->WhereIn('pengajuan.status_validasi_adm_ga', ['0','1','2','3'])
                        ->WhereIn('pengajuan_detail.status_cek_ga', ['0','1','2','3'])
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_ga = '0' THEN 0 WHEN pengajuan.status_ga = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '11'){ //-- Jika Purchasing--
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
						->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_atasan',  1)
                        ->Where('pengajuan.status_it', 1)
                        ->Where('pengajuan.status_ops', 1)
                        ->Where('pengajuan.status_ga', 1)
                        ->WhereIn('pengajuan_detail.status_cek_pc', ['0','1','2','3'])
                        ->WhereIn('pengajuan.status_validasi_adm_pc', ['1'])
                        ->orWhere('pengajuan.status_pc', 0)
						->Where('pengajuan.status_atasan',  1)
                        ->Where('pengajuan.status_it', 1)
                        ->Where('pengajuan.status_ops', 1)
                        ->Where('pengajuan.status_ga', 1)
						->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
                        ->WhereIn('pengajuan_detail.status_cek_pc', ['0','1','2','3'])
                        ->WhereIn('pengajuan.status_validasi_adm_pc', ['1'])
                        ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                        ->orderBy(DB::raw("CASE WHEN pengajuan.status_pc = '0' THEN 0 WHEN pengajuan.status_pc = '1' THEN 1 ELSE 2 END"))
                        ->orderByDesc('pengajuan.tgl_pengajuan')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '17'){ //-- Jika tgsm--
            $approval = DB::table('pengajuan')
                                    ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                    ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                    ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                    ->join('users','pengajuan.id_user_input','=','users.id')
                                    ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                                    ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                                    ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                                    ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                                    ->leftJoin('users as validator_tgsm','pengajuan_detail.id_user_adm_tgsm','=','validator_tgsm.id')
                                    ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','pengajuan.status_tgsm','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name as nama_it','validator_ops.name as nama_ops','validator_ga.name as nama_ga','validator_pc.name as nama_pc','validator_tgsm.name as nama_tgsm')
                                    ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                    // ->Where('pengajuan.status_validasi_adm_it', 1)
                                    // ->orWhere('pengajuan.status_validasi_adm_it', 3)                     
                                    ->WhereIn('pengajuan.status_validasi_adm_tgsm', ['0','1','2','3'])
                                    ->WhereIn('pengajuan_detail.status_cek_tgsm', ['0','1','2','3'])
                                    ->Where('pengajuan_detail.id_kategori', 5)
                                    ->Where('pengajuan.status_atasan', 1)
                                    // ->Where('pengajuan_detail.status_cek_atasan', 1)
                                    ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','pengajuan.status_tgsm','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','validator_it.name','validator_ops.name','validator_ga.name','validator_pc.name','validator_tgsm.name')
                                    ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                    ->get();
        }elseif(Auth::user()->kode_divisi == '0'){
            $approval = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->leftJoin('users as validator_it','pengajuan_detail.id_user_adm_it','=','validator_it.id')
                        ->leftJoin('users as validator_ops','pengajuan_detail.id_user_adm_ops','=','validator_ops.id')
                        ->leftJoin('users as validator_ga','pengajuan_detail.id_user_adm_ga','=','validator_ga.id')
                        ->leftJoin('users as validator_pc','pengajuan_detail.id_user_adm_pc','=','validator_pc.id')
                        ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                        ->Where('pengajuan.status_validasi_adm_it', 1)
                        ->Where('pengajuan.status_validasi_adm_ops', 1)
                        ->Where('pengajuan.status_validasi_adm_ga', 1)
                        ->Where('pengajuan.status_validasi_adm_pc', 1)
                        ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                        ->get(); 
        }
        
        return view ('approval.approval.index', compact('approval'));


    }

    public function view($no_urut)
    {
        if(Auth::user()->kode_divisi == '27'){ //-- Jika TGSM --
            $cari_jenis_pengeluaran = DB::table('pengajuan')
                                    ->select('pengajuan.jenis')
                                    ->where('pengajuan.no_urut', $no_urut)
                                    ->first();
            if($cari_jenis_pengeluaran->jenis == '26'){ // jika pengajuan material TGSM
                $pengajuan_v = DB::table('pengajuan')
                            ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                            ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan.id_user_input','=','users.id')
                            ->join('products_tgsm','pengajuan_detail.kode_product','=','products_tgsm.kode_produk')
                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                            ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo',
                            'depos.nama_depo','pengajuan.jenis as kode_jenis','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran',
                            'pengajuan.id_user_input','users.name','pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','status_ops','status_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                            ->where('pengajuan.no_urut', $no_urut)->first();

                $details = DB::table('pengajuan_detail')
                        ->join('products_tgsm','pengajuan_detail.kode_product','=','products_tgsm.kode_produk')
                        ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
                        ->join('categories','products_tgsm.category_id','=','categories.id')
                        ->where('pengajuan_detail.no_urut', $no_urut)->get();

                $approval_upload = DB::table('pengajuan_upload')
                                ->select('pengajuan_upload.filename')
                                ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                                ->get();    
            }else{
                $pengajuan_v = DB::table('pengajuan')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->join('products','pengajuan_detail.kode_product','=','products.kode')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','pengajuan.kode_depo',
                        'pengajuan.kode_divisi','pengajuan.keterangan as keterangan_pengajuan','pengajuan.id_user_input','perusahaans.nama_perusahaan','depos.nama_depo',
                        'pengajuan.jenis as kode_jenis','users.name','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.keterangan','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran',
                        'pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','status_ops','status_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                        ->where('pengajuan.no_urut', $no_urut)->first();

                $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
                                                    ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
                                                    ->join('categories','products.category_id','=','categories.id')
                                                    ->where('pengajuan_detail.no_urut', $no_urut)->get();

                $approval_upload = DB::table('pengajuan_upload')
                ->select('pengajuan_upload.filename')
                ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                ->get();
            }
            
        }else{
            // $pengajuan_v = DB::table('pengajuan')
            //             ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
            //             ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
            //             ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
            //             ->join('users','pengajuan.id_user_input','=','users.id')
            //             ->join('products','pengajuan_detail.kode_product','=','products.kode')
            //             ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
            //             ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','pengajuan.kode_depo',
            //             'pengajuan.kode_divisi','pengajuan.keterangan as keterangan_pengajuan','pengajuan.id_user_input','perusahaans.nama_perusahaan','depos.nama_depo',
            //             'pengajuan.jenis as kode_jenis','users.name','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.keterangan','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran',
            //             'pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','status_ops','status_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
            //             ->where('pengajuan.no_urut', $no_urut)->first();

            // $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
            //                                     ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
            // 									->join('categories','products.category_id','=','categories.id')
            // 									->where('pengajuan_detail.no_urut', $no_urut)->get();

            // $approval_upload = DB::table('pengajuan_upload')
            // ->select('pengajuan_upload.filename')
            // ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
            // ->get();

            $cari_jenis_pengeluaran = DB::table('pengajuan')
                                    ->select('pengajuan.jenis')
                                    ->where('pengajuan.no_urut', $no_urut)
                                    ->first();
            if($cari_jenis_pengeluaran->jenis == '26'){ // jika pengajuan material TGSM
                $pengajuan_v = DB::table('pengajuan')
                            ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                            ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan.id_user_input','=','users.id')
                            ->join('products_tgsm','pengajuan_detail.kode_product','=','products_tgsm.kode_produk')
                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                            ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo',
                            'depos.nama_depo','pengajuan.jenis as kode_jenis','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran',
                            'pengajuan.id_user_input','users.name','pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','status_ops','status_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                            ->where('pengajuan.no_urut', $no_urut)->first();

                $details = DB::table('pengajuan_detail')
                        ->join('products_tgsm','pengajuan_detail.kode_product','=','products_tgsm.kode_produk')
                        ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
                        ->join('categories','products_tgsm.category_id','=','categories.id')
                        ->where('pengajuan_detail.no_urut', $no_urut)->get();

                $approval_upload = DB::table('pengajuan_upload')
                                ->select('pengajuan_upload.filename')
                                ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                                ->get();    
            }else{
                $pengajuan_v = DB::table('pengajuan')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->join('products','pengajuan_detail.kode_product','=','products.kode')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','pengajuan.kode_depo',
                        'pengajuan.kode_divisi','pengajuan.keterangan as keterangan_pengajuan','pengajuan.id_user_input','perusahaans.nama_perusahaan','depos.nama_depo',
                        'pengajuan.jenis as kode_jenis','users.name','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.keterangan','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran',
                        'pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','status_ops','status_pc','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                        ->where('pengajuan.no_urut', $no_urut)->first();

                $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
                                                    ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
                                                    ->join('categories','products.category_id','=','categories.id')
                                                    ->where('pengajuan_detail.no_urut', $no_urut)->get();

                $approval_upload = DB::table('pengajuan_upload')
                ->select('pengajuan_upload.filename')
                ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                ->get();
            }
        }
        

            return view('approval.approval.view', compact('pengajuan_v','details','approval_upload'));
    }

    public function approved(Request $request)
    {   
        $tahun = (date('Y'));
        $bulan = (date('m'));

        if ($bulan == '01'){
            $bulan_romawi = 'I'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
        }

        if(Auth::user()->kode_divisi == '3'){ //-- Jika IT--
			if(Auth::user()->type == 'Manager'){
                if(request()->kode_divisi_temp == '3'){
                    if(request()->status_atasan == '0'){
                        $cari_divisi = DB::table('pengajuan')
                            ->select('kode_divisi')
                            ->where('no_urut', request()->no_urut)->first();
                    }else{
                        $cari_divisi = DB::table('pengajuan')
                            ->select('kode_divisi')
                            ->where('no_urut',request()->modal_no_urut)->first();
                    }
                }else{
                    $cari_divisi = DB::table('pengajuan')
						->select('kode_divisi')
						->where('no_urut', request()->modal_no_urut)->first();
                }
            }else{
                $cari_divisi = DB::table('pengajuan')
						->select('kode_divisi')
						->where('no_urut', request()->no_urut)->first();
            }
						
			if($cari_divisi->kode_divisi != '3'){
				//kode Approval
				$alias_depo = DB::table('depos')
							->select('alias')
							->where('kode_depo', Auth::user()->kode_depo)->first();

				$alias_divisi = DB::table('divisi')
							->select('alias')
							->where('kode_divisi', Auth::user()->kode_divisi)->first();

				$kd_perusahaan = Auth::user()->kode_perusahaan;
				$alias_depo = $alias_depo->alias;
				$alias_divisi = $alias_divisi->alias;

				$getRow = DB::table('pengajuan')
							->select(DB::raw('MAX(kode_app_it) as No_Urut_app_atasan'))
							->where('kode_depo', $alias_depo)
							->where('kode_divisi', $alias_divisi);
				$rowCount = $getRow->count();

				if($rowCount > 0){
					//$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
					if ($rowCount < 9) {
						$no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
					} else if ($rowCount < 99) {
						$no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
					} else if ($rowCount < 999) {
						$no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
					} else {
						$no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
					}
				}else{
					//$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
					$no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
				}
				//end kode approval

				$cari_status = DB::table('pengajuan')
								->select('pengajuan.status_atasan')
								->Where('pengajuan.no_urut', request()->modal_no_urut)
								->first();
								//dd($cari_status->status_atasan);

				if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
					$approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
							->update([
								'status_pengajuan' => 0,
								'id_user_approval_atasan' => Auth::user()->id,
								'status_atasan' => 1,
								'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
								'keterangan_approval' => $request->get('addKeterangan'),
								'kode_app_it' => $no_pengajuan_biaya,
							]);
				}elseif($cari_status->status_atasan == '1'){
					$approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
							->update([
								'status_pengajuan' => 0,
								'id_user_approval_it' => Auth::user()->id,
								'status_it' => 1,
								'tgl_approval_it' => Carbon::now()->format('Y-m-d'),
								'keterangan_approval' => $request->get('addKeterangan'),
								'kode_app_it' => $no_pengajuan_biaya,
							]);
				}
			}else{
                if(request()->status_atasan == '0'){
                    $cari_status = DB::table('pengajuan')
								->select('pengajuan.status_atasan')
								->Where('pengajuan.no_urut', request()->no_urut)
								->first();
                }else{
                    $cari_status = DB::table('pengajuan')
								->select('pengajuan.status_atasan')
								->Where('pengajuan.no_urut', request()->modal_no_urut)
								->first();
                }

                if($cari_status->status_atasan == '1'){
                    //kode Approval
                    $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo', Auth::user()->kode_depo)->first();

                    $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                    $kd_perusahaan = Auth::user()->kode_perusahaan;
                    $alias_depo = $alias_depo->alias;
                    $alias_divisi = $alias_divisi->alias;

                    $getRow = DB::table('pengajuan')
                                ->select(DB::raw('MAX(kode_app_it) as No_Urut_app_atasan'))
                                ->where('kode_depo', $alias_depo)
                                ->where('kode_divisi', $alias_divisi);
                    $rowCount = $getRow->count();

                    if($rowCount > 0){
                        //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                        if ($rowCount < 9) {
                            $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else if ($rowCount < 99) {
                            $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else if ($rowCount < 999) {
                            $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else {
                            $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        }
                    }else{
                        //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                        $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                    //end kode approval

                    $cari_status = DB::table('pengajuan')
                                    ->select('pengajuan.status_atasan')
                                    ->Where('pengajuan.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);

                    if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                        $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => $request->get('addKeterangan'),
                                    'kode_app_it' => $no_pengajuan_biaya,
                                ]);
                    }elseif($cari_status->status_atasan == '1'){
                        $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_it' => Auth::user()->id,
                                    'status_it' => 1,
                                    'tgl_approval_it' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => $request->get('addKeterangan'),
                                    'kode_app_it' => $no_pengajuan_biaya,
                                ]);
                    }
                }elseif($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                    
                    $alias_depo = DB::table('depos')
                        ->select('alias')
                        ->where('kode_depo', Auth::user()->kode_depo)->first();

                    $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                    $kd_perusahaan = Auth::user()->kode_perusahaan;
                    $alias_depo = $alias_depo->alias;
                    $alias_divisi = $alias_divisi->alias;

                    $getRow = DB::table('pengajuan')
                                ->select(DB::raw('MAX(kode_app_atasan) as No_Urut_app_atasan'))
                                ->where('kode_depo', $alias_depo)
                                ->where('kode_divisi', $alias_divisi);
                    $rowCount = $getRow->count();

                    if($rowCount > 0){
                        //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                        if ($rowCount < 9) {
                            $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else if ($rowCount < 99) {
                            $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else if ($rowCount < 999) {
                            $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else {
                            $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        }
                    }else{
                        //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                        $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                    //end kode approval

                    $jenis = $request->jenis;
                    if($jenis == '8'){ //Pembelian ATK
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                                    'kode_app_atasan' => $no_pengajuan_biaya,
                        ]);
                    }elseif($jenis == '9'){ //Pembelian Materai
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                                    'kode_app_atasan' => $no_pengajuan_biaya,
                                ]);
                    }elseif($jenis == '19'){ //Pembelian BBM
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'id_user_approval_atasan' => Auth::user()->id,
                                        'status_atasan' => 1,
                                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => 'Approved',
                                        'status_it' => 1,
                                        'kode_app_atasan' => $no_pengajuan_biaya,
                        ]);
                    }elseif($jenis == '31'){ //Pembelian IT
                        $cari_kategori_barang = DB::table('pengajuan_detail')
                                        ->select(DB::raw('MAX(pengajuan_detail.id_kategori) as id_kategori'))
                                        ->where('pengajuan_detail.no_urut',request()->no_urut)
                                        ->first();
                                        
						if($cari_kategori_barang->id_kategori == '2'){ // Jika id kategori barang nya 2 = IT //
							$approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
								->update([
									'status_pengajuan' => 0,
									'id_user_approval_atasan' => Auth::user()->id,
									'status_atasan' => 1,
									'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
									'keterangan_approval' => 'Approved',
									'status_it' => 0,
									'kode_app_atasan' => $no_pengajuan_biaya,
								]);
						}else{
							$approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
								->update([
									'status_pengajuan' => 0,
									'id_user_approval_atasan' => Auth::user()->id,
									'status_atasan' => 1,
									'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
									'keterangan_approval' => 'Approved',
									'status_it' => 1,
									'kode_app_atasan' => $no_pengajuan_biaya,
								]);
						}
                    }
                    
                    $products = $request->products;
                    $ceklist = $request->ceklist;
                    $keterangan_detail = $request->keterangan_detail;
                    
                    for ($i=0; $i < count((array)$products); $i++) { 
                        $approved = DB::table('pengajuan_detail')
                                ->Where('no_urut', request()->no_urut)
                                ->Where('kode_product', $products[$i])
                                ->update([
                                    'status_cek_atasan' => $ceklist[$i],
                                    'id_user_detail_atasan' => Auth::user()->id,
                                    'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_detail_atasan' => $keterangan_detail[$i]
                                ]);
                    }

                    $output = [
                        'msg'  => 'Transaksi baru berhasil ditambah',
                        'res'  => true,
                        'type' => 'success'
                    ];
                    return response()->json($output, 200);
                    // alert()->success('Success.','Request Approved...');
                    // return redirect()->route('approval.index');
                }

				
			}    
        }elseif(Auth::user()->kode_divisi == '2'){ //-- Jika Operasional--
            if(Auth::user()->kode_perusahaan == 'DTS'){ //-- Jika DTS--

                //kode Approval
                $alias_depo = DB::table('depos')
                ->select('alias')
                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan')
                            ->select(DB::raw('MAX(kode_app_atasan) as No_Urut_app_atasan'))
                            ->where('kode_depo', $alias_depo)
                            ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();

                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                }
                //end kode approval

                $jenis = $request->jenis;
                if($jenis == '8'){ //Pembelian ATK
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '9'){ //Pembelian Materai
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                }elseif($jenis == '19'){ //Pembelian BBM
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                                    'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '31'){ //Pembelian IT
                    $cari_kategori_barang = DB::table('pengajuan_detail')
                                        ->select(DB::raw('MAX(pengajuan_detail.id_kategori) as id_kategori'))
                                        ->where('pengajuan_detail.no_urut',request()->no_urut)
                                        ->first();
                                        
                    if($cari_kategori_barang->id_kategori == '2'){ // Jika id kategori barang nya 2 = IT //
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 0,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                    }else{
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                    }
                }

                $products = $request->products;
                $ceklist = $request->ceklist;
                $keterangan_detail = $request->keterangan_detail;

                for ($i=0; $i < count((array)$products); $i++) { 
                    $approved = DB::table('pengajuan_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('kode_product', $products[$i])
                            ->update([
                                'status_cek_atasan' => $ceklist[$i],
                                'id_user_detail_atasan' => Auth::user()->id,
                                'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_atasan' => $keterangan_detail[$i]
                            ]);
                }

                $output = [
                    'msg'  => 'Transaksi baru berhasil ditambah',
                    'res'  => true,
                    'type' => 'success'
                ];
                return response()->json($output, 200);
                // alert()->success('Success.','Request Approved...');
                // return redirect()->route('approval.index'); 
			}elseif(Auth::user()->kode_perusahaan == 'DTS_A'){ //-- Jika DTS--

                //kode Approval
                $alias_depo = DB::table('depos')
                ->select('alias')
                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan')
                            ->select(DB::raw('MAX(kode_app_atasan) as No_Urut_app_atasan'))
                            ->where('kode_depo', $alias_depo)
                            ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();

                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                }
                //end kode approval

                $jenis = $request->jenis;
                if($jenis == '8'){ //Pembelian ATK
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '9'){ //Pembelian Materai
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                }elseif($jenis == '19'){ //Pembelian BBM
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                                    'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '31'){ //Pembelian IT
                    $cari_kategori_barang = DB::table('pengajuan_detail')
                                        ->select(DB::raw('MAX(pengajuan_detail.id_kategori) as id_kategori'))
                                        ->where('pengajuan_detail.no_urut',request()->no_urut)
                                        ->first();
                                        
                    if($cari_kategori_barang->id_kategori == '2'){ // Jika id kategori barang nya 2 = IT //
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 0,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                    }else{
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                    }
                }

                $products = $request->products;
                $ceklist = $request->ceklist;
                $keterangan_detail = $request->keterangan_detail;

                for ($i=0; $i < count((array)$products); $i++) { 
                    $approved = DB::table('pengajuan_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('kode_product', $products[$i])
                            ->update([
                                'status_cek_atasan' => $ceklist[$i],
                                'id_user_detail_atasan' => Auth::user()->id,
                                'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_atasan' => $keterangan_detail[$i]
                            ]);
                }

                $output = [
                    'msg'  => 'Transaksi baru berhasil ditambah',
                    'res'  => true,
                    'type' => 'success'
                ];
                return response()->json($output, 200);
                // alert()->success('Success.','Request Approved...');
                // return redirect()->route('approval.index'); 
            }elseif(Auth::user()->kode_perusahaan == 'DTS_C'){ //-- Jika DTS--

                //kode Approval
                $alias_depo = DB::table('depos')
                ->select('alias')
                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan')
                            ->select(DB::raw('MAX(kode_app_atasan) as No_Urut_app_atasan'))
                            ->where('kode_depo', $alias_depo)
                            ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();

                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                }
                //end kode approval

                $jenis = $request->jenis;
                if($jenis == '8'){ //Pembelian ATK
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '9'){ //Pembelian Materai
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                }elseif($jenis == '19'){ //Pembelian BBM
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                                    'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '31'){ //Pembelian IT
                    $cari_kategori_barang = DB::table('pengajuan_detail')
                                            ->select(DB::raw('MAX(pengajuan_detail.id_kategori) as id_kategori'))
                                            ->where('pengajuan_detail.no_urut',request()->no_urut)
                                            ->first();
                    
                    if($cari_kategori_barang->id_kategori == '2'){ // Jika id kategori barang nya 2 = IT //
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 0,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                    }else{
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                    }
                }

                $products = $request->products;
                $ceklist = $request->ceklist;
                $keterangan_detail = $request->keterangan_detail;

                for ($i=0; $i < count((array)$products); $i++) { 
                    $approved = DB::table('pengajuan_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('kode_product', $products[$i])
                            ->update([
                                'status_cek_atasan' => $ceklist[$i],
                                'id_user_detail_atasan' => Auth::user()->id,
                                'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_atasan' => $keterangan_detail[$i]
                            ]);
                }

                $output = [
                    'msg'  => 'Transaksi baru berhasil ditambah',
                    'res'  => true,
                    'type' => 'success'
                ];
                return response()->json($output, 200);
                // alert()->success('Success.','Request Approved...');
                // return redirect()->route('approval.index');
            }else{
                if(Auth::user()->type == 'Manager'){
                    if(request()->kode_divisi_temp == '2'){
                        if(request()->status_atasan == '0'){
                            $cari_divisi = DB::table('pengajuan')
                                ->select('kode_divisi')
                                ->where('no_urut', request()->no_urut)->first();
                        }else{
                            $cari_divisi = DB::table('pengajuan')
                                ->select('kode_divisi')
                                ->where('no_urut',request()->modal_no_urut)->first();
                        }
                    }else{
                        $cari_divisi = DB::table('pengajuan')
                            ->select('kode_divisi')
                            ->where('no_urut', request()->modal_no_urut)->first();
                    }
                }else{
                    $cari_divisi = DB::table('pengajuan')
						->select('kode_divisi')
						->where('no_urut', request()->no_urut)->first();
                }
                if($cari_divisi->kode_divisi != '2'){
                    //kode Approval
                    $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo', Auth::user()->kode_depo)->first();

                    $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                    $kd_perusahaan = Auth::user()->kode_perusahaan;
                    $alias_depo = $alias_depo->alias;
                    $alias_divisi = $alias_divisi->alias;

                    $getRow = DB::table('pengajuan')
                                ->select(DB::raw('MAX(kode_app_ops) as No_Urut_app_atasan'))
                                ->where('kode_depo', $alias_depo)
                                ->where('kode_divisi', $alias_divisi);
                    $rowCount = $getRow->count();

                    if($rowCount > 0){
                        //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                        if ($rowCount < 9) {
                            $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else if ($rowCount < 99) {
                            $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else if ($rowCount < 999) {
                            $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        } else {
                            $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        }
                    }else{
                        //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                        $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                    //end kode approval

                    $cari_status = DB::table('pengajuan')
                                    ->select('pengajuan.status_atasan')
                                    ->Where('pengajuan.no_urut', request()->modal_no_urut)
                                    ->first();

                    if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                        $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => $request->get('addKeterangan'),
                                ]);

                    }elseif($cari_status->status_atasan == '1'){
                        $cari_kategori_barang = DB::table('pengajuan_detail')
                                            ->select(DB::raw('MAX(pengajuan_detail.id_kategori) as id_kategori'))
                                            ->where('pengajuan_detail.no_urut',request()->modal_no_urut)
                                            ->first();
                                            
                        if($cari_kategori_barang->id_kategori == '2'){ // Jika id kategori barang nya 2 = IT //
                            $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'status_it' => 1,
                                    'id_user_approval_ops' => Auth::user()->id,
                                    'status_ops' => 1,
                                    'tgl_approval_ops' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => $request->get('addKeterangan'),
                                    'kode_app_ops' => $no_pengajuan_biaya,
                                ]);
                        }else{
                            $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'status_it' => 1,
                                    'id_user_approval_ops' => Auth::user()->id,
                                    'status_ops' => 1,
                                    'tgl_approval_ops' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => $request->get('addKeterangan'),
                                    'kode_app_ops' => $no_pengajuan_biaya,
                                ]);
                        }
                    }
                }else{
                    if(request()->status_atasan == '0'){
                        $cari_status = DB::table('pengajuan')
                                    ->select('pengajuan.status_atasan')
                                    ->Where('pengajuan.no_urut', request()->no_urut)
                                    ->first();
                    }else{
                        $cari_status = DB::table('pengajuan')
                                    ->select('pengajuan.status_atasan')
                                    ->Where('pengajuan.no_urut', request()->modal_no_urut)
                                    ->first();
                    }
    
                    if($cari_status->status_atasan == '1'){
                        //kode Approval
                        $alias_depo = DB::table('depos')
                        ->select('alias')
                        ->where('kode_depo', Auth::user()->kode_depo)->first();
    
                        $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();
    
                        $kd_perusahaan = Auth::user()->kode_perusahaan;
                        $alias_depo = $alias_depo->alias;
                        $alias_divisi = $alias_divisi->alias;
    
                        $getRow = DB::table('pengajuan')
                                    ->select(DB::raw('MAX(kode_app_ops) as No_Urut_app_atasan'))
                                    ->where('kode_depo', $alias_depo)
                                    ->where('kode_divisi', $alias_divisi);
                        $rowCount = $getRow->count();
    
                        if($rowCount > 0){
                            //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                            if ($rowCount < 9) {
                                $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            } else if ($rowCount < 99) {
                                $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            } else if ($rowCount < 999) {
                                $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            } else {
                                $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            }
                        }else{
                            //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                            $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        }
                        //end kode approval
    
                        $cari_status = DB::table('pengajuan')
                                        ->select('pengajuan.status_atasan')
                                        ->Where('pengajuan.no_urut', request()->modal_no_urut)
                                        ->first();
                                        //dd($cari_status->status_atasan);
    
                        if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                            $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'id_user_approval_atasan' => Auth::user()->id,
                                        'status_atasan' => 1,
                                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => $request->get('addKeterangan'),
                                        'kode_app_atasan' => $no_pengajuan_biaya,
                                    ]);
                                    
                        }elseif($cari_status->status_atasan == '1'){
                            $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'status_it' => 1,
                                        'id_user_approval_ops' => Auth::user()->id,
                                        'status_ops' => 1,
                                        'tgl_approval_ops' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => $request->get('addKeterangan'),
                                        'kode_app_ops' => $no_pengajuan_biaya,
                                    ]);
                        }
                    }elseif($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                        
                        $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();
    
                        $alias_divisi = DB::table('divisi')
                                    ->select('alias')
                                    ->where('kode_divisi', Auth::user()->kode_divisi)->first();
    
                        $kd_perusahaan = Auth::user()->kode_perusahaan;
                        $alias_depo = $alias_depo->alias;
                        $alias_divisi = $alias_divisi->alias;
    
                        $getRow = DB::table('pengajuan')
                                    ->select(DB::raw('MAX(kode_app_atasan) as No_Urut_app_atasan'))
                                    ->where('kode_depo', $alias_depo)
                                    ->where('kode_divisi', $alias_divisi);
                        $rowCount = $getRow->count();
    
                        if($rowCount > 0){
                            //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                            if ($rowCount < 9) {
                                $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            } else if ($rowCount < 99) {
                                $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            } else if ($rowCount < 999) {
                                $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            } else {
                                $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                            }
                        }else{
                            //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                            $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                        }
                        //end kode approval
    
                        $jenis = $request->jenis;
                        if($jenis == '8'){ //Pembelian ATK
                            $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'id_user_approval_atasan' => Auth::user()->id,
                                        'status_atasan' => 1,
                                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => 'Approved',
                                        'status_it' => 1,
                                        'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                        }elseif($jenis == '9'){ //Pembelian Materai
                            $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'id_user_approval_atasan' => Auth::user()->id,
                                        'status_atasan' => 1,
                                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => 'Approved',
                                        'status_it' => 1,
                                        'kode_app_atasan' => $no_pengajuan_biaya,
                                    ]);
                        }elseif($jenis == '19'){ //Pembelian BBM
                            $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                        ->update([
                                            'status_pengajuan' => 0,
                                            'id_user_approval_atasan' => Auth::user()->id,
                                            'status_atasan' => 1,
                                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                            'keterangan_approval' => 'Approved',
                                            'status_it' => 1,
                                            'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                        }elseif($jenis == '31'){ //Pembelian IT
                            $cari_kategori_barang = DB::table('pengajuan_detail')
                                            ->select(DB::raw('MAX(pengajuan_detail.id_kategori) as id_kategori'))
                                            ->where('pengajuan_detail.no_urut',request()->no_urut)
                                            ->first();
                                            
                            if($cari_kategori_barang->id_kategori == '2'){ // Jika id kategori barang nya 2 = IT //
                                $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'id_user_approval_atasan' => Auth::user()->id,
                                        'status_atasan' => 1,
                                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => 'Approved',
                                        'status_it' => 0,
                                        'kode_app_atasan' => $no_pengajuan_biaya,
                                    ]);
                            }else{
                                $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'id_user_approval_atasan' => Auth::user()->id,
                                        'status_atasan' => 1,
                                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => 'Approved',
                                        'status_it' => 1,
                                        'kode_app_atasan' => $no_pengajuan_biaya,
                                    ]);
                            }
                        }
                        
                        $products = $request->products;
                        $ceklist = $request->ceklist;
                        $keterangan_detail = $request->keterangan_detail;
                        
                        for ($i=0; $i < count((array)$products); $i++) { 
                            $approved = DB::table('pengajuan_detail')
                                    ->Where('no_urut', request()->no_urut)
                                    ->Where('kode_product', $products[$i])
                                    ->update([
                                        'status_cek_atasan' => $ceklist[$i],
                                        'id_user_detail_atasan' => Auth::user()->id,
                                        'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_detail_atasan' => $keterangan_detail[$i]
                                    ]);
                        }
                        $output = [
                            'msg'  => 'Transaksi baru berhasil ditambah',
                            'res'  => true,
                            'type' => 'success'
                        ];
                        return response()->json($output, 200);
                        // alert()->success('Success.','Request Approved...');
                        // return redirect()->route('approval.index');
                    }
                }
            }      
        }elseif(Auth::user()->kode_divisi == '4'){ //-- Jika GA--
            //kode Approval
            $alias_depo = DB::table('depos')
                        ->select('alias')
                        ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                        ->select('alias')
                        ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $kd_perusahaan = Auth::user()->kode_perusahaan;
            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $getRow = DB::table('pengajuan')
                        ->select(DB::raw('MAX(kode_app_ga) as No_Urut_app_atasan'))
                        ->where('kode_depo', $alias_depo)
                        ->where('kode_divisi', $alias_divisi);
            $rowCount = $getRow->count();

            if($rowCount > 0){
                //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                if ($rowCount < 9) {
                    $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                } else {
                    $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                }
            }else{
                //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
            }
            //end kode approval

            $cari_status = DB::table('pengajuan')
                            ->select('pengajuan.status_atasan')
                            ->Where('pengajuan.no_urut', request()->modal_no_urut)
                            ->first();

            if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                        ->update([
                            'status_pengajuan' => 0,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_atasan' => 1,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);
            }elseif($cari_status->status_atasan == '1'){
                $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                        ->update([
                            'status_pengajuan' => 0,
                            'id_user_approval_ga' => Auth::user()->id,
                            'status_ga' => 1,
                            'tgl_approval_ga' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
                            'kode_app_ga' => $no_pengajuan_biaya,
                        ]);
            } 
        }elseif(Auth::user()->kode_divisi == '11'){ //-- Jika Purchasing--
            if(Auth::user()->type == 'Manager'){
                // //kode Approval
                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan')
                            ->select(DB::raw('MAX(kode_app_pc) as No_Urut_app_atasan'))
                            ->where('kode_depo', $alias_depo)
                            ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();

                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                }
                //end kode approval

                $cari_status = DB::table('pengajuan')
                    ->select('pengajuan.status_atasan')
                    ->Where('pengajuan.no_urut', request()->modal_no_urut)
                    ->first();

                if($cari_status->status_atasan == '0'){
                    $jenis = $request->jenis;
                    if($jenis == '8'){ //Pembelian ATK
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                        ]);
                    }elseif($jenis == '9'){ //Pembelian Materai
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                                ]);
                    }elseif($jenis == '19'){ //Pembelian BBM
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                    ->update([
                                        'status_pengajuan' => 0,
                                        'id_user_approval_atasan' => Auth::user()->id,
                                        'status_atasan' => 1,
                                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_approval' => 'Approved',
                                        'status_it' => 1,
                        ]);
                    }elseif($jenis == '31'){ //Pembelian IT
                        $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                        ]);
                    }
                    
                    $products = $request->products;
                    $ceklist = $request->ceklist;
                    $keterangan_detail = $request->keterangan_detail;
                    
                    for ($i=0; $i < count((array)$products); $i++) { 
                        $approved = DB::table('pengajuan_detail')
                                ->Where('no_urut', request()->no_urut)
                                ->Where('kode_product', $products[$i])
                                ->update([
                                    'status_cek_atasan' => $ceklist[$i],
                                    'id_user_detail_atasan' => Auth::user()->id,
                                    'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_detail_atasan' => $keterangan_detail[$i]
                                ]);
                    }

                    $output = [
                        'msg'  => 'Transaksi baru berhasil ditambah',
                        'res'  => true,
                        'type' => 'success'
                    ];
                    return response()->json($output, 200);
                    // alert()->success('Success.','Request Approved...');
                    // return redirect()->route('approval.index');

                }else{
                    $cari_status = DB::table('pengajuan')
                                ->select('pengajuan.status_atasan')
                                ->Where('pengajuan.no_urut', request()->modal_no_urut)//no_urut', request()->no_urut
                                ->first();

                    if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                        $kode_pengajuan = request()->kode_pengajuan;
            
                        $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => $request->get('addKeterangan'),
                                ]);
                    }elseif($cari_status->status_atasan == '1'){
                        $approved = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_pc' => Auth::user()->id,
                                    'status_pc' => 1,
                                    'tgl_approval_pc' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => $request->get('addKeterangan'),
                                    'kode_app_pc' => $no_pengajuan_biaya,
                                ]);
                    }
                }
            }else{
                //kode Approval
                $alias_depo = DB::table('depos')
                ->select('alias')
                ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan')
                            ->select(DB::raw('MAX(kode_app_atasan) as No_Urut_app_atasan'))
                            ->where('kode_depo', $alias_depo)
                            ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();

                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                }
                //end kode approval

                $jenis = $request->jenis;
                if($jenis == '8'){ //Pembelian ATK
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '9'){ //Pembelian Materai
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                            ]);
                }elseif($jenis == '19'){ //Pembelian BBM
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                                ->update([
                                    'status_pengajuan' => 0,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'status_atasan' => 1,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_approval' => 'Approved',
                                    'status_it' => 1,
                                    'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }elseif($jenis == '31'){ //Pembelian IT
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'kode_app_atasan' => $no_pengajuan_biaya,
                    ]);
                }

                $products = $request->products;
                $ceklist = $request->ceklist;
                $keterangan_detail = $request->keterangan_detail;

                for ($i=0; $i < count((array)$products); $i++) { 
                    $approved = DB::table('pengajuan_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('kode_product', $products[$i])
                            ->update([
                                'status_cek_atasan' => $ceklist[$i],
                                'id_user_detail_atasan' => Auth::user()->id,
                                'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_atasan' => $keterangan_detail[$i]
                            ]);
                }

                $output = [
                    'msg'  => 'Transaksi baru berhasil ditambah',
                    'res'  => true,
                    'type' => 'success'
                ];
                return response()->json($output, 200);
                // alert()->success('Success.','Request Approved...');
                // return redirect()->route('approval.index');
            }

        }else{
            //kode Approval
            $alias_depo = DB::table('depos')
                        ->select('alias')
                        ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                        ->select('alias')
                        ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $kd_perusahaan = Auth::user()->kode_perusahaan;
            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $getRow = DB::table('pengajuan')
                        ->select(DB::raw('MAX(kode_app_atasan) as No_Urut_app_atasan'))
                        ->where('kode_depo', $alias_depo)
                        ->where('kode_divisi', $alias_divisi);
            $rowCount = $getRow->count();

            if($rowCount > 0){
                //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                if ($rowCount < 9) {
                    $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                } else {
                    $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
                }
            }else{
                //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.$alias_divisi.'/'.$bulan_romawi.'/'.$tahun;
            }
            //end kode approval

            $jenis = $request->jenis;
            if($jenis == '8'){ //Pembelian ATK
                $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                        ->update([
                            'status_pengajuan' => 0,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_atasan' => 1,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => 'Approved',
                            'status_it' => 1,
                            'kode_app_atasan' => $no_pengajuan_biaya,
                ]);
            }elseif($jenis == '9'){ //Pembelian Materai
                $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                        ->update([
                            'status_pengajuan' => 0,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_atasan' => 1,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => 'Approved',
                            'status_it' => 1,
                            'kode_app_atasan' => $no_pengajuan_biaya,
                        ]);
            }elseif($jenis == '19'){ //Pembelian BBM
                $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                            ->update([
                                'status_pengajuan' => 0,
                                'id_user_approval_atasan' => Auth::user()->id,
                                'status_atasan' => 1,
                                'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => 'Approved',
                                'status_it' => 1,
                                'kode_app_atasan' => $no_pengajuan_biaya,
                ]);
            }elseif($jenis == '31'){ //Pembelian IT
				$cari_kategori_barang = DB::table('pengajuan_detail')
                                        ->select(DB::raw('MAX(pengajuan_detail.id_kategori) as id_kategori'))
                                        ->where('pengajuan_detail.no_urut',request()->no_urut)
                                        ->first();
										
				if($cari_kategori_barang->id_kategori == '2'){ // Jika id kategori barang nya 2 = IT //
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                        ->update([
                            'status_pengajuan' => 0,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_atasan' => 1,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => 'Approved',
                            'status_it' => 0,
                            'kode_app_atasan' => $no_pengajuan_biaya,
                        ]);
                }else{
                    $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                        ->update([
                            'status_pengajuan' => 0,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_atasan' => 1,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => 'Approved',
                            'status_it' => 1,
                            'kode_app_atasan' => $no_pengajuan_biaya,
                        ]);
                }
            }
            
            $products = $request->products;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$products); $i++) { 
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $products[$i])
                        ->update([
                            'status_cek_atasan' => $ceklist[$i],
                            'id_user_detail_atasan' => Auth::user()->id,
                            'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_atasan' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('approval.index');  
        }
            
        // //return redirect(route('approval.index'))->with(['success' => 'Request Approved...']);
        alert()->success('Success.','Request Approved...');
        return redirect()->route('approval.index');
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_divisi == '3'){ //-- Jika IT--
            $kode_pengajuan = request()->kode_pengajuan;
            $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                    ->update([
                        'id_user_approval_it' => Auth::user()->id,
                        'status_pengajuan' => 2,
                        'status_it' => 2,
                        'tgl_approval_it' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '2'){ //-- Jika Operasioanl--
            $kode_pengajuan = request()->kode_pengajuan;
            $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                    ->update([
                        'id_user_approval_ops' => Auth::user()->id,
                        'status_pengajuan' => 2,
                        'status_ops' => 2,
                        'tgl_approval_ops' =>Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '4'){ //-- Jika GA--
            $kode_pengajuan = request()->kode_pengajuan;   
            $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                    ->update([
                        'id_user_approval_ga' => Auth::user()->id,
                        'status_pengajuan' => 2,
                        'status_ga' => 2,
                        'tgl_approval_ga' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '11'){ //-- Jika Purchasing--
            $kode_pengajuan = request()->kode_pengajuan;
            $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                    ->update([
                        'id_user_approval_pc' => Auth::user()->id,
                        'status_pengajuan' => 2,
                        'status_pc' => 2,
                        'tgl_approval_pc' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }else{
            $kode_pengajuan = $request->kode_pengajuan;
            $denied = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                    ->update([
                        'status_pengajuan' => 2,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 2,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => 'Denied',
                    ]);
        
            $products = $request->products;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
                    
            for ($i=0; $i < count((array)$products); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 2; 
                }
                        
                $approved = DB::table('pengajuan_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('kode_product', $products[$i])
                            ->update([
                                    'status_cek_atasan' => $chkd,
                                    'id_user_detail_atasan' => Auth::user()->id,
                                    'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_detail_atasan' => $keterangan_detail[$i]
                            ]);
            }
        
            $output = [
                'msg'  => 'Transaksi berhasil ditolak',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('approval.index');  
        }
        
        //return redirect(route('approval.index'))->with(['success' => 'Request Denied...']);
        alert()->error('Oops...','Request Denied...');
        return redirect()->route('approval.index');
    }

    public function pending(Request $request)
    {   
        if(Auth::user()->kode_divisi == '3'){ //-- Jika IT--
            $cari_status = DB::table('pengajuan')
                            ->select('pengajuan.status_atasan')
                            ->Where('pengajuan.no_urut', request()->modal_no_urut)
                            ->first();
            
            if($cari_status->status_atasan == '0'){
                $kode_pengajuan = request()->kode_pengajuan;
                $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                        ->update([
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_pengajuan' => 3,
                            'status_atasan' => 3,
                            'status_validasi_adm_it' => 3,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);
            }elseif($cari_status->status_atasan == '1'){
                $kode_pengajuan = request()->kode_pengajuan;
                $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                        ->update([
                            'id_user_approval_it' => Auth::user()->id,
                            'status_pengajuan' => 3,
                            'status_it' => 3,
                            'status_validasi_adm_it' => 3,
                            'tgl_approval_it' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);
            }    
        }elseif(Auth::user()->kode_divisi == '2'){ //-- Jika Operasional--
            $kode_pengajuan = request()->kode_pengajuan;
            $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                    ->update([
                        'id_user_approval_ops' => Auth::user()->id,
                        'status_pengajuan' => 3,
                        'status_ops' => 3,
                        'status_validasi_adm_ops' => 3,
                        'tgl_approval_ops' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '4'){ //-- Jika GA-- 
            $kode_pengajuan = request()->kode_pengajuan;   
            $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                    ->update([
                        'id_user_approval_ga' => Auth::user()->id,
                        'status_pengajuan' => 3,
                        'status_ga' => 3,
                        'status_validasi_adm_ga' => 3,
                        'tgl_approval_ga' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '11'){ //-- Jika Purchasing--
            $kode_pengajuan = request()->kode_pengajuan;
            $denied = DB::table('pengajuan')->where('no_urut', request()->modal_no_urut)
                    ->update([
                        'id_user_approval_pc' => Auth::user()->id,
                        'status_pengajuan' => 3,
                        'status_pc' => 3,
                        'status_validasi_adm_pc' => 3,
                        'tgl_approval_pc' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }else{
            $kode_pengajuan = $request->kode_pengajuan;
            $approved = DB::table('pengajuan')->where('no_urut', request()->no_urut)
                ->update([
                    'status_pengajuan' => 3,
                    'id_user_approval_atasan' => Auth::user()->id,
                    'status_atasan' => 3,
                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                    'keterangan_approval' => 'Pending',
            ]);

            $products = $request->products;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$products); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $products[$i])
                        ->update([
                            'status_cek_atasan' => $chkd,
                            'id_user_detail_atasan' => Auth::user()->id,
                            'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_atasan' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('approval.index');  
        }
        
        //return redirect(route('approval.index'))->with(['success' => 'Request Denied...']);
        alert()->warning('Warning.','Request Pending...');
        return redirect()->route('approval.index');
    }
}
