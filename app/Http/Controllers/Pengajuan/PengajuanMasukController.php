<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pengajuan_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PengajuanMasukController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_divisi == '3') {  //Jika IT
        	$pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->Where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan_detail.id_kategori', 2)
                                ->orWhere('pengajuan.status_validasi_adm_it', 0)
								->Where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan_detail.id_kategori', 2)
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_it = '0' THEN 0 WHEN pengajuan.status_validasi_adm_it = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
        }elseif(Auth::user()->kode_divisi == '2'){ //Jika OPS
        	if(Auth::user()->kode_perusahaan == 'TUA'){ //jika Area TA
                if(Auth::user()->kode_sub_divisi == '20'){ //jika Area TA
                    $pengajuan_masuk = DB::table('pengajuan')
                                    ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                    ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                    ->join('users','pengajuan.id_user_input','=','users.id')
                                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                    ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                    ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
									->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                    ->Where('pengajuan.status_atasan', 1)
                                    ->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'WPS')
                                    ->orWhere('pengajuan.status_validasi_adm_ops', 0)
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                    ->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'WPS')
                                    ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    // ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                    ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                    ->orderByDesc('pengajuan.tgl_pengajuan')
                                    ->get();
                }elseif(Auth::user()->kode_sub_divisi == '19'){ //jika Area TU
                    $pengajuan_masuk = DB::table('pengajuan')
                                    ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                    ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                    ->join('users','pengajuan.id_user_input','=','users.id')
                                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                    ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                    ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
									->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                    ->Where('pengajuan.status_atasan', 1)
									->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'LP')
                                    ->orWhere('pengajuan.status_validasi_adm_ops', 0)
									->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
									->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'LP')
                                    ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    // ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                    ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                    ->orderByDesc('pengajuan.tgl_pengajuan')
                                    ->get();
                }elseif(Auth::user()->kode_sub_divisi == '18'){ //jika Area TUA
                    $pengajuan_masuk = DB::table('pengajuan')
                                    ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                    ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                    ->join('users','pengajuan.id_user_input','=','users.id')
                                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                    ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                    ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
									->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                    ->Where('pengajuan.status_atasan', 1)
									->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->whereIn('pengajuan.kode_perusahaan', ['TUA','DTS','DTS_A','DTS_C','TGSM'])
                                    ->orWhere('pengajuan.status_validasi_adm_ops', 0)
									->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
									->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->whereIn('pengajuan.kode_perusahaan', ['TUA','DTS','DTS_A','DTS_C','TGSM'])
                                    ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    // ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                    ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                    ->orderByDesc('pengajuan.tgl_pengajuan')
                                    ->get();
                }else{
                    $pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
								->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->Where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan.status_it', 1)
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                ->orWhere('pengajuan.status_validasi_adm_ops', 0)
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                ->Where('pengajuan.status_it', 1)
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                // ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
                }
            }else{
                $pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
								->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->Where('pengajuan.status_atasan', 1)
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                ->orWhere('pengajuan.status_validasi_adm_ops', 0)
								->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                // ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
            }
        }elseif(Auth::user()->kode_divisi == '4'){ //jika GA
        	$pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
								->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                // ->where('pengajuan.status_atasan', 1)
                                ->Wherein('pengajuan.status_atasan', ['0','1'])
                                //->Where('pengajuan.status_ops', 1)
                                ->Wherein('pengajuan.status_ops', ['0','1'])
                                //->Where('pengajuan.status_it', 1)
                                ->Wherein('pengajuan.status_it', ['0','1'])
                                ->orWhere('pengajuan.status_validasi_adm_ga', 0)
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                //->Where('pengajuan.status_ops', 1)
                                ->Wherein('pengajuan.status_ops', ['0','1'])
                                //->Where('pengajuan.status_it', 1)
                                ->Wherein('pengajuan.status_it', ['0','1'])
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ga = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ga = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
        }elseif(Auth::user()->kode_divisi == '11'){ //jika Purchasing
        	$pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
								->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan.status_it', 1)
                                ->Where('pengajuan.status_ops', 1)
                                ->Where('pengajuan.status_ga', 1)
                                ->orWhere('pengajuan.status_validasi_adm_pc', 0)
								->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
                                ->Where('pengajuan.status_it', 1)
                                ->Where('pengajuan.status_ops', 1)
                                ->Where('pengajuan.status_ga', 1)
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_pc = '0' THEN 0 WHEN pengajuan.status_validasi_adm_pc = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
        }

        return view ('pengajuan.pengajuan_masuk.index', compact('pengajuan_masuk'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_divisi == '3') {  //Jika IT
        	$pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->Where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan_detail.id_kategori', 2)
                                ->orWhere('pengajuan.status_validasi_adm_it', 0)
								->Where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan_detail.id_kategori', 2)
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_it = '0' THEN 0 WHEN pengajuan.status_validasi_adm_it = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
        }elseif(Auth::user()->kode_divisi == '2'){ //Jika OPS
        	if(Auth::user()->kode_perusahaan == 'TUA'){ //jika Area TA
                if(Auth::user()->kode_sub_divisi == '20'){ //jika Area TA
                    $pengajuan_masuk = DB::table('pengajuan')
                                    ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                    ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                    ->join('users','pengajuan.id_user_input','=','users.id')
                                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                    ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                    ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                    ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                    ->Where('pengajuan.status_atasan', 1)
                                    ->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'WPS')
                                    ->orWhere('pengajuan.status_validasi_adm_ops', 0)
                                    ->Where('pengajuan.status_it', 1)
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'WPS')
                                    ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                    ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                    ->orderByDesc('pengajuan.tgl_pengajuan')
                                    ->get();
                }elseif(Auth::user()->kode_sub_divisi == '19'){ //jika Area TU
                    $pengajuan_masuk = DB::table('pengajuan')
                                    ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                    ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                    ->join('users','pengajuan.id_user_input','=','users.id')
                                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                    ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                    ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                    ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                    ->Where('pengajuan.status_atasan', 1)
                                    ->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'LP')
                                    ->orWhere('pengajuan.status_validasi_adm_ops', 0)
                                    ->Where('pengajuan.status_it', 1)
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->where('pengajuan.kode_perusahaan', 'LP')
                                    ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                    ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                    ->orderByDesc('pengajuan.tgl_pengajuan')
                                    ->get();
                }elseif(Auth::user()->kode_sub_divisi == '18'){ //jika Area TUA
                    $pengajuan_masuk = DB::table('pengajuan')
                                    ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                    ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                    ->join('users','pengajuan.id_user_input','=','users.id')
                                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                    ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                    ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                    ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                    ->Where('pengajuan.status_atasan', 1)
                                    ->Where('pengajuan.status_it', 1)
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->whereIn('pengajuan.kode_perusahaan', ['TUA','DTS','DTS_A','DTS_C','TGSM'])
                                    ->orWhere('pengajuan.status_validasi_adm_ops', 0)
                                    ->Where('pengajuan.status_it', 1)
                                    ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                    ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                    ->whereIn('pengajuan.kode_perusahaan', ['TUA','DTS','DTS_A','DTS_C','TGSM'])
                                    ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                    //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                    ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                    ->orderByDesc('pengajuan.tgl_pengajuan')
                                    ->get();
                }else{
                    $pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->Where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan.status_it', 1)
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                ->orWhere('pengajuan.status_validasi_adm_ops', 0)
                                ->Where('pengajuan.status_it', 1)
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
                }
            }else{
                $pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->Where('pengajuan.status_atasan', 1)
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                //->Where('pengajuan.status_it', 1)
                                ->orWhere('pengajuan.status_validasi_adm_ops', 0)
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                ->Wherein('pengajuan_detail.id_kategori', ['1','2','3','4'])
                                //->Where('pengajuan.status_it', 1)
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                //->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ops = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ops = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
            }
        }elseif(Auth::user()->kode_divisi == '4'){ //jika GA
        	$pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                // ->where('pengajuan.status_atasan', 1)
                                ->Wherein('pengajuan.status_atasan', ['0','1'])
                                //->Where('pengajuan.status_ops', 1)
                                ->Wherein('pengajuan.status_ops', ['0','1'])
                                //->Where('pengajuan.status_it', 1)
                                ->Wherein('pengajuan.status_it', ['0','1'])
                                ->orWhere('pengajuan.status_validasi_adm_ga', 0)
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-01')
                                //->Where('pengajuan.status_ops', 1)
                                ->Wherein('pengajuan.status_ops', ['0','1'])
                                //->Where('pengajuan.status_it', 1)
                                ->Wherein('pengajuan.status_it', ['0','1'])
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_atasan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_ga = '0' THEN 0 WHEN pengajuan.status_validasi_adm_ga = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();

        }elseif(Auth::user()->kode_divisi == '11'){ //jika Purchasing
        	$pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
								->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan.status_it', 1)
                                ->Where('pengajuan.status_ops', 1)
                                ->Where('pengajuan.status_ga', 1)
                                ->orWhere('pengajuan.status_validasi_adm_pc', 0)
								->where('pengajuan.tgl_pengajuan', '>=', '2023-07-14')
                                ->Where('pengajuan.status_it', 1)
                                ->Where('pengajuan.status_ops', 1)
                                ->Where('pengajuan.status_ga', 1)
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->orderBy(DB::raw("CASE WHEN pengajuan.status_validasi_adm_pc = '0' THEN 0 WHEN pengajuan.status_validasi_adm_pc = '1' THEN 1 ELSE 2 END"))
                                ->orderByDesc('pengajuan.tgl_pengajuan')
                                ->get();
        }

        return view ('pengajuan.pengajuan_masuk.index', compact('pengajuan_masuk'));

    }

    public function view($no_urut)
    {
        $pengajuan_v = DB::table('pengajuan')->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                             ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                             ->join('users','pengajuan.id_user_input','=','users.id')
                                             ->join('products','pengajuan_detail.kode_product','=','products.kode')
                                             ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                             ->where('pengajuan.no_urut', $no_urut)->first();

        $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
                                                ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
            									->join('categories','products.category_id','=','categories.id')
            									->where('pengajuan_detail.no_urut', $no_urut)->get();

        $approval_upload = DB::table('pengajuan_upload')
                                    ->select('pengajuan_upload.filename')
                                    ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                                    ->get();

        // $budget = DB::table('pengajuan')
        //             ->select('pengajuan.sisa_budget')
        //             ->where('pengajuan.no_urut', $no_urut)->first();

        $budget = DB::table('budget_atk')
                    ->select('budget_atk.budget')
                    ->where('budget_atk.kode_perusahaan', $pengajuan_v->kode_perusahaan)
                    ->where('budget_atk.kode_depo', $pengajuan_v->kode_depo)
                    ->where('budget_atk.kode_divisi', $pengajuan_v->kode_divisi)
                    ->first();

        return view('pengajuan.pengajuan_masuk.view', compact('pengajuan_v','details','approval_upload','budget'));
    }

    public function approved(Request $request)
    {
    	if(Auth::user()->kode_divisi == '3'){ //-- jika IT
            $no_urut = $request->no_urut;
            $budget_sisa = $request->budget_sisa;
            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_adm_it' => 1,
                    'sisa_budget' => $budget_sisa,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;

            $qty_it = $request->qty_it;
            $qty_ops = $request->qty_ops;
            $qty_ga = $request->qty_ga;
            $qty_prc = $request->qty_prc;
            $harga_satuan = str_replace(",", "", $request->harga_satuan);
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 0; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'qty_it' => $qty_it[$i],
                            'harga_satuan' => $harga_satuan[$i],
                            'harga_total' => $qty_it[$i]*$harga_satuan[$i],
                            'status_cek_it' => $chkd,
                            'id_user_adm_it' => Auth::user()->id,
                            'tgl_approval_adm_it' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_it' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}elseif(Auth::user()->kode_divisi == '2'){ //-- jika OPS
            $no_urut = $request->no_urut;
            $budget_sisa = $request->budget_sisa;

            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_adm_ops' => 1,
                    'sisa_budget' => $budget_sisa,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;

            $qty_it = $request->qty_it;
            $qty_ops = $request->qty_ops;
            $qty_ga = $request->qty_ga;
            $qty_prc = $request->qty_prc;
            $harga_satuan = str_replace(",", "", $request->harga_satuan);
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 0; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'qty_ops' => $qty_ops[$i],
                            'harga_satuan' => $harga_satuan[$i],
                            'harga_total' => $qty_ops[$i]*$harga_satuan[$i],
                            'status_cek_ops' => $chkd,
                            'id_user_adm_ops' => Auth::user()->id,
                            'tgl_approval_adm_ops' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_ops' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}elseif(Auth::user()->kode_divisi == '4'){ //-- jika GA
            $no_urut = $request->no_urut;
            $budget_sisa = $request->budget_sisa;

            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_adm_ga' => 1,
                    'sisa_budget' => $budget_sisa,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;

            $qty_it = $request->qty_it;
            $qty_ops = $request->qty_ops;
            $qty_ga = $request->qty_ga;
            $qty_prc = $request->qty_prc;
            $harga_satuan = str_replace(",", "", $request->harga_satuan);
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 0; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'qty_ga' => $qty_ga[$i],
                            'harga_satuan' => $harga_satuan[$i],
                            'harga_total' => $qty_ga[$i]*$harga_satuan[$i],
                            'status_cek_ga' => $chkd,
                            'id_user_adm_ga' => Auth::user()->id,
                            'tgl_approval_adm_ga' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_ga' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}elseif(Auth::user()->kode_divisi == '11'){ //-- jika purchasing
            $no_urut = $request->no_urut;
            $budget_sisa = $request->budget_sisa;

            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_adm_pc' => 1,
                    'sisa_budget' => $budget_sisa,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;

            $qty_it = $request->qty_it;
            $qty_ops = $request->qty_ops;
            $qty_ga = $request->qty_ga;
            $qty_prc = $request->qty_prc;
            $harga_satuan = str_replace(",", "", $request->harga_satuan);
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 0; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'qty_pc' => $qty_prc[$i],
                            'harga_satuan' => $harga_satuan[$i],
                            'harga_total' => $qty_prc[$i]*$harga_satuan[$i],
                            'status_cek_pc' =>  $chkd,
                            'id_user_adm_pc' => Auth::user()->id,
                            'tgl_approval_adm_pc' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_pc' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}
        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('pengajuan_masuk.index');
    }

    public function pending(Request $request)
    {
        if(Auth::user()->kode_divisi == '3'){ //-- jika IT
            $no_urut = $request->no_urut;
            
            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_pengajuan' => 3,
                    'status_validasi_adm_it' => 3,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'status_cek_it' =>  $chkd,
                            'id_user_adm_it' => Auth::user()->id,
                            'tgl_approval_adm_it' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_it' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}elseif(Auth::user()->kode_divisi == '2'){ //-- jika OPS
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_pengajuan' => 3,
                    'status_validasi_adm_ops' => 3,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'status_cek_ops' => $chkd,
                            'id_user_adm_ops' => Auth::user()->id,
                            'tgl_approval_adm_ops' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_ops' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}elseif(Auth::user()->kode_divisi == '4'){ //-- jika GA
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_pengajuan' => 3,
                    'status_validasi_adm_ga' => 3,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'status_cek_ga' => $chkd,
                            'id_user_adm_ga' => Auth::user()->id,
                            'tgl_approval_adm_ga' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_ga' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}elseif(Auth::user()->kode_divisi == '11'){ //-- jika purchasing
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status_pengajuan' => 3,
                    'status_validasi_adm_pc' => 3,
            ]);

            $kode_produk = $request->kode_produk;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$kode_produk); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_produk[$i])
                        ->update([
                            'status_cek_pc' => $chkd,
                            'id_user_adm_pc' => Auth::user()->id,
                            'tgl_approval_adm_pc' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_adm_pc' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
    	}
        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('pengajuan_masuk.index');
    }
	
	public function pdf($no_urut)
    {
        $pengajuan_head = DB::table('pengajuan')
            ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan.id_user_input','=','users.id')
            ->leftJoin('users as user_atasan','pengajuan.id_user_approval_atasan','=','user_atasan.id')
            ->leftJoin('users as user_app_it','pengajuan.id_user_approval_it','=','user_app_it.id')
            ->leftJoin('users as user_app_ops','pengajuan.id_user_approval_ops','=','user_app_ops.id')
            ->leftJoin('users as user_app_ga','pengajuan.id_user_approval_ga','=','user_app_ga.id')
            ->leftJoin('users as user_app_pc','pengajuan.id_user_approval_pc','=','user_app_pc.id')
            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
            ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.keterangan','ms_pengeluaran.sifat','pengajuan.kode_perusahaan',
            'perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','divisi.nama_divisi','pengajuan.id_user_input','users.name',
            'pengajuan.kode_app_atasan','pengajuan.id_user_approval_atasan','user_atasan.name as nama_atasan','pengajuan.tgl_approval_atasan',
            'pengajuan.kode_app_it','pengajuan.id_user_approval_it','user_app_it.name as nama_atasan_it','pengajuan.tgl_approval_it','pengajuan.status_it',
            'pengajuan.kode_app_ops','pengajuan.id_user_approval_ops','user_app_ops.name as nama_atasan_ops','pengajuan.tgl_approval_ops','pengajuan.status_ops',
            'pengajuan.kode_app_ga','pengajuan.id_user_approval_ga','user_app_ga.name as nama_atasan_ga','pengajuan.tgl_approval_ga','pengajuan.status_ga',
            'pengajuan.kode_app_pc','pengajuan.id_user_approval_pc','user_app_pc.name as nama_atasan_pc','pengajuan.tgl_approval_pc','pengajuan.status_pc',
            'pengajuan.kode_app_tgsm','pengajuan.kode_app_bod')
            ->where('pengajuan.no_urut', $no_urut)->first();

        $pengajuan_detail = DB::table('pengajuan_detail')
            ->join('products','pengajuan_detail.kode_product','=','products.kode')
            ->where('pengajuan_detail.no_urut',$no_urut)
            ->get();

        $total_jml = DB::table('pengajuan_detail')
            ->join('products','pengajuan_detail.kode_product','=','products.kode')
            ->select(DB::raw('SUM(products.price*pengajuan_detail.qty_pc) as total'))
            ->where('pengajuan_detail.no_urut',$no_urut)
            ->first();

        // $total_jml = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
        //                         ->get()->sum('tharga');
                                

        $pdf = PDF::loadview('pengajuan.pengajuan_masuk.pdf', compact('pengajuan_head','pengajuan_detail','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
