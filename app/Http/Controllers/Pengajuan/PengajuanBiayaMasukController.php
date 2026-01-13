<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pengajuan_Biaya_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanBiayaMasukController extends Controller
{
    public function index()
    {
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
            $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                //->Where('pengajuan_biaya_detail.status_detail', 1)
                ->Where('pengajuan_biaya.status_atasan', 10) //ditutup
                ->WhereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Biaya Pusat (Akunting)--
            if(Auth::user()->kode_sub_divisi == '20'){ //jika Area TA
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','118','119','140']) 
                // ->Where('pengajuan_biaya_detail.status_detail', 1)
                // ->Where('pengajuan_biaya.status_validasi', 1)
                // ->orWhere('pengajuan_biaya.status_validasi_fin', 1)
                // ->Where('pengajuan_biaya.status_atasan', 1)
                // ->Where('pengajuan_biaya.status_biaya', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.kode_perusahaan', 'WPS')
                //->Where('pengajuan_biaya_detail.status_detail_atasan', 1)
                //->Where('pengajuan_biaya_detail.status_detail', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }elseif(Auth::user()->kode_sub_divisi == '19'){ //jika Area TU
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','118','119','140']) //Kode Gaji,mitra,BPJS,insentif
                // ->Where('pengajuan_biaya_detail.status_detail', 1)
                // ->Where('pengajuan_biaya.status_validasi', 1)
                // ->orWhere('pengajuan_biaya.status_validasi_fin', 1)
                // ->Where('pengajuan_biaya.status_atasan', 1)
                // ->Where('pengajuan_biaya.status_biaya', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.kode_perusahaan', 'LP')
                //->Where('pengajuan_biaya_detail.status_detail_atasan', 1)
                //->Where('pengajuan_biaya_detail.status_detail', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }elseif(Auth::user()->kode_sub_divisi == '18'){ //jika Area TUA
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','118','119','140']) //Kode Gaji,mitra,BPJS,insentif
                // ->Where('pengajuan_biaya_detail.status_detail', 1)
                // ->Where('pengajuan_biaya.status_validasi', 1)
                // ->orWhere('pengajuan_biaya.status_validasi_fin', 1)
                // ->Where('pengajuan_biaya.status_atasan', 1)
                // ->Where('pengajuan_biaya.status_biaya', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.kode_perusahaan', 'TUA')
                //->Where('pengajuan_biaya_detail.status_detail_atasan', 1)
                //->Where('pengajuan_biaya_detail.status_detail', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }else{
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->whereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start, $date_end])
                ->whereIn('pengajuan_biaya.kode_depo', ['002','005','006','008'])
                ->where(function ($q) {
                    $q->where(function ($q2) {
                        $q2->where('pengajuan_biaya.status_atasan', 1)
                        ->whereNotIn('pengajuan_biaya.kategori', ['43','118','119']);
                    })
                    ->orWhere(function ($q2) {
                        $q2->whereIn('pengajuan_biaya.kategori', ['137','140'])
                        ->where('pengajuan_biaya.status_claim', 1);
                    });
                })
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }
            
        }elseif(Auth::user()->kode_divisi == '5'){ //--jika FINANCE--
            if(Auth::user()->kode_sub_divisi == '7'){
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','5','130']) //Kode Gaji,mitra,insentif
                // ->Where('pengajuan_biaya.status_spp_1', 1)
                // ->Where('pengajuan_biaya.status_spp_2', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }else{
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                //->WhereIn('pengajuan_biaya.kategori', ['1','2','5','130']) //Kode Gaji,mitra,insentif
                // ->Where('pengajuan_biaya.status_spp_1', 1)
                // ->Where('pengajuan_biaya.status_spp_2', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }
        }elseif(Auth::user()->kode_divisi == '10'){ //-- Jika Koordinator Claim--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])

                    // ->where(function ($q) {
                    //     $q->where(function ($q2) {
                    //         $q2->where('pengajuan_biaya.status_atasan', 1)
                    //         ->whereIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                    //     })
                    //     ->orWhere(function ($q2) {
                    //         $q2->where('pengajuan_biaya.status_biaya', 1)
                    //         ->whereNotIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                    //     });
                    // })

                    //->Where('pengajuan_biaya_detail.status_detail', 1)
                    //->Where('pengajuan_biaya.status_atasan', 1) //ditutup
                    ->WhereIn('pengajuan_biaya.kategori', ['137','139','140']) //Kode Gaji,mitra,BPJS,insentif
                    ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }elseif(Auth::user()->kode_divisi == '11'){ // --
                $approval_cost = DB::table('pengajuan_biaya')
                        ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                        ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
    
                        // ->where(function ($q) {
                        //     $q->where(function ($q2) {
                        //         $q2->where('pengajuan_biaya.status_atasan', 1)
                        //         ->whereIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                        //     })
                        //     ->orWhere(function ($q2) {
                        //         $q2->where('pengajuan_biaya.status_biaya', 1)
                        //         ->whereNotIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                        //     });
                        // })
    
                        ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                        //->Where('pengajuan_biaya.status_atasan', 1) //ditutup
                        ->WhereIn('pengajuan_biaya.kategori', ['139']) //Kode Gaji,mitra,BPJS,insentif
                        ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();
        }else{
            // $approval_cost = DB::table('pengajuan_biaya')
            //     ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            //     ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            //     ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            //     ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            //     ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            //     ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            //     ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
            //     ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
            //     ->Where('pengajuan_biaya_detail.status_detail', 1)
            //     ->WhereIn('pengajuan_biaya.kategori', ['1','2'])
            //     ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
            //     ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
            //     ->get();
        }

    	return view ('pengajuan.pengajuan_biaya_masuk.index', compact('approval_cost'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
            $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
               
                ->WhereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Biaya Pusat (Akunting)--
            if(Auth::user()->kode_sub_divisi == '20'){ //jika Area TA
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','118','119','140']) //Kode Gaji,mitra,BPJS,insentif
                // ->Where('pengajuan_biaya_detail.status_detail', 1)
                // ->Where('pengajuan_biaya.status_validasi', 1)
                // ->orWhere('pengajuan_biaya.status_validasi_fin', 1)
                // ->Where('pengajuan_biaya.status_atasan', 1)
                // ->Where('pengajuan_biaya.status_biaya', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.kode_perusahaan', 'WPS')
                //->Where('pengajuan_biaya_detail.status_detail_atasan', 1)
                //->Where('pengajuan_biaya_detail.status_detail', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }elseif(Auth::user()->kode_sub_divisi == '19'){ //jika Area TU
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','118','119','140']) //Kode Gaji,mitra,BPJS,insentif
                // ->Where('pengajuan_biaya_detail.status_detail', 1)
                // ->Where('pengajuan_biaya.status_validasi', 1)
                // ->orWhere('pengajuan_biaya.status_validasi_fin', 1)
                // ->Where('pengajuan_biaya.status_atasan', 1)
                // ->Where('pengajuan_biaya.status_biaya', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.kode_perusahaan', 'LP')
                //->Where('pengajuan_biaya_detail.status_detail_atasan', 1)
                //->Where('pengajuan_biaya_detail.status_detail', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }elseif(Auth::user()->kode_sub_divisi == '18'){ //jika Area TUA
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','118','119','140']) //Kode Gaji,mitra,BPJS,insentif
                // ->Where('pengajuan_biaya_detail.status_detail', 1)
                // ->Where('pengajuan_biaya.status_validasi', 1)
                // ->orWhere('pengajuan_biaya.status_validasi_fin', 1)
                // ->Where('pengajuan_biaya.status_atasan', 1)
                // ->Where('pengajuan_biaya.status_biaya', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.kode_perusahaan', 'TUA')
                //->Where('pengajuan_biaya_detail.status_detail_atasan', 1)
                //->Where('pengajuan_biaya_detail.status_detail', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }else{
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->whereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start, $date_end])
                ->whereIn('pengajuan_biaya.kode_depo', ['002','005','006','008'])
                ->where(function ($q) {
                    $q->where(function ($q2) {
                        $q2->where('pengajuan_biaya.status_atasan', 1)
                        ->whereNotIn('pengajuan_biaya.kategori', ['43','118','119']);
                    })
                    ->orWhere(function ($q2) {
                        $q2->whereIn('pengajuan_biaya.kategori', ['137','140'])
                        ->where('pengajuan_biaya.status_claim', 1);
                    });
                })
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }
            
        }elseif(Auth::user()->kode_divisi == '5'){ //--jika FINANCE--
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                //->WhereIn('pengajuan_biaya.kategori', ['1','2','5','130']) //Kode Gaji,mitra,BPJS,insentif
                // ->Where('pengajuan_biaya.status_spp_1', 1)
                // ->Where('pengajuan_biaya.status_spp_2', 1)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '10'){ //-- Jika Koordinator Claim--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])

                    // ->where(function ($q) {
                    //     $q->where(function ($q2) {
                    //         $q2->where('pengajuan_biaya.status_atasan', 1)
                    //         ->whereIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                    //     })
                    //     ->orWhere(function ($q2) {
                    //         $q2->where('pengajuan_biaya.status_biaya', 1)
                    //         ->whereNotIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                    //     });
                    // })

                    //->Where('pengajuan_biaya_detail.status_detail', 1)
                    //->Where('pengajuan_biaya.status_atasan', 1) //ditutup
                    ->WhereIn('pengajuan_biaya.kategori', ['137','139','140']) //Kode Gaji,mitra,BPJS,insentif
                    ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
        }elseif(Auth::user()->kode_divisi == '11'){ // --
            $approval_cost = DB::table('pengajuan_biaya')
                            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
        
                            // ->where(function ($q) {
                            //     $q->where(function ($q2) {
                            //         $q2->where('pengajuan_biaya.status_atasan', 1)
                            //         ->whereIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                            //     })
                            //     ->orWhere(function ($q2) {
                            //         $q2->where('pengajuan_biaya.status_biaya', 1)
                            //         ->whereNotIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS']);
                            //     });
                            // })
        
                            ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                            //->Where('pengajuan_biaya.status_atasan', 1) //ditutup
                            ->WhereIn('pengajuan_biaya.kategori', ['139']) //Kode Gaji,mitra,BPJS,insentif
                            ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
        }else{
            $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2'])
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_fin','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }
        return view ('pengajuan.pengajuan_biaya_masuk.index', compact('approval_cost'));
    }

    public function view($no_urut)
    {
    	$approval_cost_head = DB::table('pengajuan_biaya')
        	->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
        	->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
        	->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
        	->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
        	->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
        	->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.kategori')
        	->Where('pengajuan_biaya.no_urut', $no_urut)
        	->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.kategori')
        	->first();

        $approval_cost_detail = DB::table('pengajuan_biaya_detail')	
        	->Where('pengajuan_biaya_detail.no_urut', $no_urut)
        	->get();

        $approval_cost_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $approval_cost_head->kode_pengajuan_b)
            ->get();

        // $approval_cost_total =  Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
        //                         ->get()->sum('tharga');

        if(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
            $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
                                ->get()->sum('tharga');
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Koordinator ACC--
            $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
                                ->get()->sum('tharga');
        }elseif(Auth::user()->kode_divisi == '5'){ //--jika FINANCE--
            $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
                                // ->Where('status_detail_fin', 1)
                                ->Where('status_detail', 1)
                                ->get()->sum('tharga');
        }elseif(Auth::user()->kode_divisi == '10'){ //--jika CLAIM--
            $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
                                ->Where('status_detail_clm', 1)
                                ->Where('status_detail', 1)
                                ->Where('status_detail_acc', 1)
                                ->get()->sum('tharga');
        }else{
            $approval_cost_total =  Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');
        }

    	return view('pengajuan.pengajuan_biaya_masuk.view', compact('approval_cost_head','approval_cost_detail','approval_cost_upload','approval_cost_total'));
    }

    public function approved(Request $request)
    {
        if(Auth::user()->kode_divisi == '6'){ //-- jika Biaya Pusat/Acc
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_acc' => 1,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                $status = $ceklist[$i] ?? DB::raw('status_detail'); // biar tidak jadi null
                $ket    = $keterangan_detail[$i] ?? DB::raw('keterangan_detail');
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_acc' => $ceklist[$i],
                            'id_user_detail_acc' => Auth::user()->id,
                            'tgl_approval_detail_acc' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_acc' => $keterangan_detail[$i],

                            #ops
                            'status_detail_atasan' => $status,
                            
                            'keterangan_detail_atasan' => $ket,
                            
                            #ka keuangan
                            'status_detail' => $status,
                            
                            'keterangan_detail' => $ket
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('pengajuan_biaya.index');
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi' => 1,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail' => $ceklist[$i],
                            'id_user_detail' => Auth::user()->id,
                            'tgl_approval_detail' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('pengajuan_biaya.index');
        }elseif(Auth::user()->kode_divisi == '5'){ //-- jika Finance
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_fin' => 1,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_fin' => $ceklist[$i],
                            'id_user_detail_fin' => Auth::user()->id,
                            'tgl_approval_detail_fin' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_fin' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('pengajuan_biaya.index');  

        }elseif(Auth::user()->kode_divisi == '10'){ //-- jika claim
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_clm' => 1,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_clm' => $ceklist[$i],
                            'id_user_detail_clm' => Auth::user()->id,
                            'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_clm' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('pengajuan_biaya.index');  
        }else{
            $datas = [];
            foreach ($request->input('desc') as $key => $value) {
               
            }

            $validator = Validator::make($request->all(), $datas);
            // if($validator->passes()){
                $no = 1;
                foreach ($request->input('desc') as $key => $value) {
                
                    if($request->get("chk".$no) == 1){
                        $chkd = 1; 
                    }else{
                        $chkd = 0; 
                    }

                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("desc")[$key])
                            ->update([
                                'status_detail' => $chkd,
                                'id_user_detail' => Auth::user()->id,
                                'tgl_approval_detail' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail' => $request->get("ket")[$key]
                            ]);
                $no++;
                } 

                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi' => 1
                            ]);
            // }
        }

        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('pengajuan_biaya_masuk.index');
    }

    public function denied(Request $request)
    {
		if(Auth::user()->kode_divisi == '6'){ //-- jika Biaya Pusat/Acc
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 2,
                    'status_validasi_acc' => 2,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 2; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_acc' => $chkd,
                            'id_user_detail_acc' => Auth::user()->id,
                            'tgl_approval_detail_acc' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_acc' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 2,
                    'status_validasi' => 2,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 2; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail' => $chkd,
                            'id_user_detail' => Auth::user()->id,
                            'tgl_approval_detail' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '5'){ //-- jika Finance
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 2,
                    'status_validasi_fin' => 2,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 2; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_fin' => $chkd,
                            'id_user_detail_fin' => Auth::user()->id,
                            'tgl_approval_detail_fin' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_fin' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '10'){ //-- jika claim
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 2,
                    'status_validasi_clm' => 2,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 2; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_clm' => $chkd,
                            'id_user_detail_clm' => Auth::user()->id,
                            'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_clm' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }else{
            $datas = [];
            foreach ($request->input('desc') as $key => $value) {
               
            }

            $validator = Validator::make($request->all(), $datas);
            // if($validator->passes()){
                $no = 1;
                foreach ($request->input('desc') as $key => $value) {
                
                    if($request->get("chk".$no) == 1){
                        $chkd = 2; 
                    }else{
                        $chkd = 0; 
                    }

                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("desc")[$key])
                            ->update([
                                'status_detail' => $chkd,
                                'id_user_detail' => Auth::user()->id,
                                'tgl_approval_detail' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail' => $request->get("ket")[$key]
                            ]);
                $no++;
                } 

                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi' => 2
                            ]);
            // }
        }

        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('pengajuan_biaya_masuk.index');
    }

    public function pending(Request $request)
    {
        if(Auth::user()->kode_divisi == '6'){ //-- jika Biaya Pusat/Acc
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
					'status' => 3,
                    'status_validasi_acc' => 3,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_acc' => $chkd,
                            'id_user_detail_acc' => Auth::user()->id,
                            'tgl_approval_detail_acc' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_acc' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
					'status' => 3,
                    'status_validasi' => 3,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail' => $chkd,
                            'id_user_detail' => Auth::user()->id,
                            'tgl_approval_detail' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '5'){ //-- jika Finance
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
					'status' => 3,
                    'status_validasi_fin' => 3,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_fin' => $chkd,
                            'id_user_detail_fin' => Auth::user()->id,
                            'tgl_approval_detail_fin' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_fin' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '10'){ //-- jika claim
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status_validasi_clm' => 3,
            ]);

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;
            
            for ($i=0; $i < count((array)$deskripsi); $i++) { 
                if($ceklist[$i] == 1){
                    $chkd = 1; 
                }else{
                    $chkd = 3; 
                }
                $approved = DB::table('pengajuan_biaya_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('description', $deskripsi[$i])
                        ->update([
                            'status_detail_clm' => $chkd,
                            'id_user_detail_clm' => Auth::user()->id,
                            'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                            'keterangan_detail_clm' => $keterangan_detail[$i]
                        ]);
            }

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
        }else{
            $datas = [];
            foreach ($request->input('desc') as $key => $value) {
               
            }

            $validator = Validator::make($request->all(), $datas);
            // if($validator->passes()){
                $no = 1;
                foreach ($request->input('desc') as $key => $value) {
                
                    if($request->get("chk".$no) == 1){
                        $chkd = 3; 
                    }else{
                        $chkd = 0; 
                    }

                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("desc")[$key])
                            ->update([
                                'status_detail' => $chkd,
                                'id_user_detail' => Auth::user()->id,
                                'tgl_approval_detail' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail' => $request->get("ket")[$key]
                            ]);
                $no++;
                } 

                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi' => 3
                            ]);
            // }
        }

        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('pengajuan_biaya_masuk.index');
    }
}
