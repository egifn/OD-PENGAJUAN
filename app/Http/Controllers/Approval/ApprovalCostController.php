<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pengajuan_Biaya_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalCostController extends Controller
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
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->WhereIn('pengajuan_biaya_detail.status_detail', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya.status_validasi', ['0','1','2','3'])
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Biaya Pusat (Akunting)--
            if(Auth::user()->kode_sub_divisi == '5'){ //Manager Biaya ACC
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm','pengajuan_biaya.status_bod_otorisasi')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                //->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                // ->WhereIn('pengajuan_biaya_detail.status_detail_acc', ['0','1','2','3'])
                // ->WhereIn('pengajuan_biaya.status_validasi_acc', ['0','1','2','3'])
                ->Where('pengajuan_biaya.status_atasan', 1)
                //->Where('pengajuan_biaya.status_fin', 1)
                //->Where('pengajuan_biaya.status_bod_otorisasi', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name','pengajuan_biaya.status_bod_otorisasi')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }elseif(Auth::user()->kode_sub_divisi == '4'){ //Manager Ka Akunting
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm','pengajuan_biaya.status_bod_otorisasi')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->Where('pengajuan_biaya.status_atasan', 1)
                //->Where('pengajuan_biaya.status_fin', 1)
                //->Where('pengajuan_biaya.status_biaya_pusat', 1)
                ->WhereIn('pengajuan_biaya_detail.status_detail_acc', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya.status_validasi_acc', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya_detail.status_detail_ka_akunting', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya.status_validasi_ka_akunting', ['0','1','2','3'])
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name','pengajuan_biaya.status_bod_otorisasi')
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
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->whereNotIn('pengajuan_biaya.kode_divisi', ['10'])
                // ->Where('pengajuan_biaya.status_spp_1', 1)
                // ->Where('pengajuan_biaya.status_spp_2', 1)
                //->WhereIn('pengajuan_biaya_detail.status_detail_fin', ['0','1','2','3'])
                //->WhereIn('pengajuan_biaya.status_validasi_fin', ['0','1','2','3'])
                ->Where('pengajuan_biaya.status_atasan', 1)
                //->Where('pengajuan_biaya.status_ka_akunting', 1)
                //->Where('pengajuan_biaya.status_validasi_fin', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '10'){ //--jika CLAIM--
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['137','139','140']) //Kode Gaji,mitra,BPJS,insentif
                ->Where('pengajuan_biaya.status_validasi_clm', 1)
                //->orWhere('pengajuan_biaya.status_validasi_clm', 3)
                
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }else{
            $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.status_validasi', ['1','2','3','43','130'])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2'])
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }

        return view ('approval.approval_cost.index', compact('approval_cost'));
    }

    public function cari(Request $request)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

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
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->WhereIn('pengajuan_biaya_detail.status_detail', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya.status_validasi', ['0','1','2','3'])
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Biaya Pusat (Akunting)--
            if(Auth::user()->kode_sub_divisi == '5'){ //Manager Biaya ACC
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                //->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                //->WhereIn('pengajuan_biaya_detail.status_detail_acc', ['0','1','2','3'])
                //->WhereIn('pengajuan_biaya.status_validasi_acc', ['0','1','2','3'])
                ->Where('pengajuan_biaya.status_atasan', 1)
                //->Where('pengajuan_biaya.status_fin', 1)
                //->where('pengajuan_biaya.status_bod_otorisasi', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name','pengajuan_biaya.status_bod_otorisasi')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }elseif(Auth::user()->kode_sub_divisi == '4'){ //Manager Ka Akunting
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm','pengajuan_biaya.status_bod_otorisasi')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->Where('pengajuan_biaya.status_atasan', 1)
                //->Where('pengajuan_biaya.status_fin', 1)
                ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                ->WhereIn('pengajuan_biaya_detail.status_detail_acc', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya.status_validasi_acc', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya_detail.status_detail_ka_akunting', ['0','1','2','3'])
                ->WhereIn('pengajuan_biaya.status_validasi_ka_akunting', ['0','1','2','3'])
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name','pengajuan_biaya.status_bod_otorisasi')
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
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','6','43','130']) //Kode Gaji,mitra,BPJS,insentif
                ->whereNotIn('pengajuan_biaya.kode_divisi', ['10'])
                // ->Where('pengajuan_biaya.status_spp_1', 1)
                // ->Where('pengajuan_biaya.status_spp_2', 1)
                //->WhereIn('pengajuan_biaya_detail.status_detail_fin', ['0','1','2','3'])
                //->WhereIn('pengajuan_biaya.status_validasi_fin', ['0','1','2','3'])
                ->Where('pengajuan_biaya.status_atasan', 1)
                //->Where('pengajuan_biaya.status_ka_akunting', 1)
                //->Where('pengajuan_biaya.status_validasi_fin', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '10'){ //--jika CLAIM--
                $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['137','139','140']) //Kode Gaji,mitra,BPJS,insentif
                ->Where('pengajuan_biaya.status_validasi_clm', 1)
                //->orWhere('pengajuan_biaya.status_validasi_clm', 3)
                
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }else{
            $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
                ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
                ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
                ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.status_validasi', ['1','2','3','43','130'])
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3'])
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }

        return view ('approval.approval_cost.index', compact('approval_cost'));
    }

    public function view($no_urut)
    {
        $approval_cost_head = DB::table('pengajuan_biaya')
            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('perusahaans as perusahaan_tujuan','pengajuan_biaya.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan as perusahaan_tujuan','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_bod','pengajuan_biaya.kategori')
            ->Where('pengajuan_biaya.no_urut', $no_urut)
            //->where('pengajuan_biaya_detail.status_detail_acc', '1')
            ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_bod','pengajuan_biaya.kategori')
            ->first();

        $approval_cost_detail = DB::table('pengajuan_biaya_detail') 
            ->Where('pengajuan_biaya_detail.no_urut', $no_urut)
            ->get();

        $approval_cost_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $approval_cost_head->kode_pengajuan_b)
            ->orderBy('pengajuan_upload.no_description_detail', 'ASC')
            ->get();

        // if(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
        //     $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         ->whereIn('status_detail', ['1','3'])
        //                         ->get()->sum('tharga');
        // }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Koordinator ACC--
        //     $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         //->Where('status_detail_acc', 1)
        //                         ->get()->sum('tharga');
        // // }elseif(Auth::user()->kode_divisi == '5'){ //--jika FINANCE--
        // //     $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        // //                         ->Where('status_detail_fin', 1)
        // //                         ->get()->sum('tharga');
        // }elseif(Auth::user()->kode_divisi == '10'){ //--jika CLAIM--
        //     $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         ->Where('status_detail_clm', 1)
        //                         ->Where('status_detail', 1)
        //                         ->Where('status_detail_acc', 1)
        //                         ->get()->sum('tharga');
        // }else{
        //     $approval_cost_total =  Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
        //                         ->get()->sum('tharga');
        // }

        return view('approval.approval_cost.view', compact('approval_cost_head','approval_cost_detail','approval_cost_upload'));
    }

    public function approved(Request $request)
    { 
        if(Auth::user()->kode_divisi == '6'){ //-- jika Biaya Pusat/Acc
            if(Auth::user()->kode_sub_divisi == '5'){ //Manager Biaya ACC
                    //----kode APP ------------------------------------------------//
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

                    $no_urut = $request->no_urut;
                    $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                        ->select('kode_perusahaan_tujuan')  
                                        ->where('no_urut', $no_urut)
                                        ->first();

                    $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();

                    $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                    $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                    $alias_depo = $alias_depo->alias;
                    $alias_divisi = $alias_divisi->alias;

                    $data_app = DB::table('pengajuan_biaya')
                                    ->select('status_atasan','status_biaya_pusat','status_biaya')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                    $status_atasan = $data_app->status_atasan;
                    $status_biaya_pusat = $data_app->status_biaya_pusat;
                    $status_biaya = $data_app->status_biaya;

                    $getRow = DB::table('pengajuan_biaya')
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
                    $no_urut = request()->no_urut;
                    if($status_atasan == 0) {
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'status_atasan' => 1,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'kode_app_atasan' => $no_pengajuan_biaya,
                            'keterangan_approval' => 'Approved',
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
                                        'status_detail_atasan' => $ceklist[$i],
                                        'id_user_detail_atasan' => Auth::user()->id,
                                        'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_detail_atasan' => $keterangan_detail[$i]
                                    ]);
                        }
                    }else{
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'status_biaya_pusat' => 1,
                            'id_user_approval_biaya_pusat' => Auth::user()->id,
                            'tgl_approval_biaya_pusat' => Carbon::now()->format('Y-m-d'),
                            'kode_app_biaya_pusat' => $no_pengajuan_biaya,
                            'keterangan_approval' => 'Approved',
                            'status_validasi' => 1,
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
                
            }elseif(Auth::user()->kode_sub_divisi == '4'){ //Manager Ka Akunting
                //----kode APP ------------------------------------------------//
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

                $no_urut = $request->no_urut;
                $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                    ->select('kode_perusahaan_tujuan')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $data_app = DB::table('pengajuan_biaya')
                                    ->select('status_atasan','status_biaya_pusat','status_biaya')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $status_atasan = $data_app->status_atasan;
                $status_biaya_pusat = $data_app->status_biaya_pusat;
                $status_biaya = $data_app->status_biaya;

                $getRow = DB::table('pengajuan_biaya')
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

                $no_urut = $request->no_urut;
                if($status_atasan == 0) {
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'status_atasan' => 1,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'kode_app_atasan' => $no_pengajuan_biaya,
                            'keterangan_approval' => 'Approved',
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
                                        'status_detail_atasan' => $ceklist[$i],
                                        'id_user_detail_atasan' => Auth::user()->id,
                                        'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_detail_atasan' => $keterangan_detail[$i]
                                    ]);
                        }
                }else{
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'status_ka_akunting' => 1,
                            'id_approval_ka_akunting' => Auth::user()->id,
                            'tgl_approval_ka_akunting' => Carbon::now()->format('Y-m-d'),
                            'kode_app_kakunting' => $no_pengajuan_biaya,
                            'keterangan_approval' => 'Approved',
                            'status_validasi_ka_akunting' => 1,
                            'status_buat_spp' => 0,
                        ]);

                        $deskripsi = $request->deskripsi;
                        $ceklist = $request->ceklist;
                        $keterangan_detail = $request->keterangan_detail;
                        
                        for ($i=0; $i < count((array)$deskripsi); $i++) { 
                            $approved = DB::table('pengajuan_biaya_detail')
                                    ->Where('no_urut', request()->no_urut)
                                    ->Where('description', $deskripsi[$i])
                                    ->update([
                                        'status_detail_ka_akunting' => $ceklist[$i],
                                        'id_user_detail_ka_akunting' => Auth::user()->id,
                                        'tgl_approval_detail_ka_akunting' => Carbon::now()->format('Y-m-d'),
                                        'keterangan_detail_ka_akunting' => $keterangan_detail[$i]
                                    ]);
                        }
                }
                
                $output = [
                    'msg'  => 'Transaksi baru berhasil ditambah',
                    'res'  => true,
                    'type' => 'success'
                ];
                return response()->json($output, 200);
                // alert()->success('Success.','Request Approved...');
                // return redirect()->route('pengajuan_biaya.index');  
            }
            alert()->success('Success.','Request Approved...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '10'){ //-- jika claim
            //----kode APP ------------------------------------------------//
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

            $no_urut = $request->no_urut;
            $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                ->select('kode_perusahaan_tujuan')  
                                ->where('no_urut', $no_urut)
                                ->first();

            $alias_depo = DB::table('depos')
                        ->select('alias')
                        ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                        ->select('alias')
                        ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $data_app = DB::table('pengajuan_biaya')
                            ->select('status_atasan','status_biaya_pusat','status_biaya')  
                            ->where('no_urut', $no_urut)
                            ->first();

            $status_atasan = $data_app->status_atasan;
            $status_biaya_pusat = $data_app->status_biaya_pusat;
            $status_biaya = $data_app->status_biaya;

            $getRow = DB::table('pengajuan_biaya')
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
            $no_urut = request()->no_urut;
            if($status_atasan == 0) {
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 0,
                    'status_atasan' => 1,
                    'id_user_approval_atasan' => Auth::user()->id,
                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                    'kode_app_atasan' => $no_pengajuan_biaya,
                    'keterangan_approval' => 'Approved',
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
                                'status_detail_atasan' => $ceklist[$i],
                                'id_user_detail_atasan' => Auth::user()->id,
                                'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_atasan' => $keterangan_detail[$i]
                            ]);
                }
            }else{
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 0,
                    'status_claim' => 1,
                    'id_approval_claim' => Auth::user()->id,
                    'tgl_approval_claim' => Carbon::now()->format('Y-m-d'),
                    'kode_app_claim' => $no_pengajuan_biaya,
                    'keterangan_approval' => 'Approved',
                ]);
            }
             
            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            alert()->success('Success.','Request Approved...');
	        return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $cari_status = DB::table('pengajuan_biaya')
                            ->select('pengajuan_biaya.status_atasan')
                            ->Where('pengajuan_biaya.no_urut', request()->no_urut)
                            ->first();
            if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                //----kode APP ------------------------------------------------//
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

                $no_urut = $request->no_urut;
                $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                    ->select('kode_perusahaan_tujuan')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan_biaya')
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

                $no_urut = request()->no_urut;

                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_atasan' => 1,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'kode_app_atasan' => $no_pengajuan_biaya,
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);
            }elseif($cari_status->status_atasan == '1'){
                //----kode APP ------------------------------------------------//
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

                $no_urut = $request->no_urut;
                $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                    ->select('kode_perusahaan_tujuan')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan_biaya')
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

                $no_urut = request()->no_urut;

                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'id_user_approval_biaya' => Auth::user()->id,
                            'status_biaya' => 1,
                            'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                            'kode_app_biaya' => $no_pengajuan_biaya,
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);
            }

            alert()->success('Success.','Request Approved...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '106'){ //-- jika Biaya Depo
            $cari_status = DB::table('pengajuan_biaya')
                            ->select('pengajuan_biaya.status_biaya')
                            ->Where('pengajuan_biaya.no_urut', request()->no_urut)
                            ->first();
            if($cari_status->status_biaya == '0' or $cari_status->status_biaya == '3'){
                //----kode APP ------------------------------------------------//
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

                $no_urut = $request->no_urut;
                $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                    ->select('kode_perusahaan_tujuan')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan_biaya')
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

                $no_urut = request()->no_urut;

                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'id_user_approval_biaya' => Auth::user()->id,
                            'status_biaya' => 1,
                            'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                            'kode_app_biaya' => $no_pengajuan_biaya,
                            'keterangan_approval' => $request->get('addKeterangan'),
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
            }elseif($cari_status->status_biaya == '1'){
                //----kode APP ------------------------------------------------//
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

                $no_urut = $request->no_urut;
                $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                    ->select('kode_perusahaan_tujuan')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan_biaya')
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

                $no_urut = request()->no_urut;

                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'id_user_approval_biaya' => Auth::user()->id,
                            'status_biaya' => 1,
                            'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                            'kode_app_biaya' => $no_pengajuan_biaya,
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);
            }

            alert()->success('Success.','Request Approved...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '5'){ //-- jika Finance
            //----kode APP ------------------------------------------------//
            if(Auth::user()->id == '391' || Auth::user()->id == '698'){ //--- jika user finance bu berliana
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

                $no_urut = $request->no_urut;
                $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                    ->select('kode_perusahaan_tujuan')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan_biaya')
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

                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 1,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'kode_app_atasan' => $no_pengajuan_biaya,
                        'keterangan_approval' => 'Approved',
                        'status_validasi_fin' => 0,
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
                                'status_detail_atasan' => $ceklist[$i],
                                'id_user_detail_atasan' => Auth::user()->id,
                                'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_atasan' => $keterangan_detail[$i],
                                

                                'status_detail' => $status,
                                
                                'keterangan_detail' => $ket,
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

                $no_urut = $request->no_urut;
                $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                    ->select('kode_perusahaan_tujuan')  
                                    ->where('no_urut', $no_urut)
                                    ->first();

                $alias_depo = DB::table('depos')
                            ->select('alias')
                            ->where('kode_depo', Auth::user()->kode_depo)->first();

                $alias_divisi = DB::table('divisi')
                            ->select('alias')
                            ->where('kode_divisi', Auth::user()->kode_divisi)->first();

                $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;

                $getRow = DB::table('pengajuan_biaya')
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

                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status_fin' => 1,
                            'id_approval_fin' => Auth::user()->id,
                            'tgl_approval_fin' => Carbon::now()->format('Y-m-d'),
                            'kode_app_finance' => $no_pengajuan_biaya,
                            'keterangan_approval' => 'Approved',
                            'status_validasi_fin' => 1,
                        ]);

                // $deskripsi = $request->deskripsi;
                // $ceklist = $request->ceklist;
                // $keterangan_detail = $request->keterangan_detail;
                    
                // for ($i=0; $i < count((array)$deskripsi); $i++) { 
                //     $approved = DB::table('pengajuan_biaya_detail')
                //                 ->Where('no_urut', request()->no_urut)
                //                 ->Where('description', $deskripsi[$i])
                //                 ->update([
                //                     'status_detail_fin' => $ceklist[$i],
                //                     'id_user_detail_fin' => Auth::user()->id,
                //                     'tgl_approval_detail_fin' => Carbon::now()->format('Y-m-d'),
                //                     'keterangan_detail_fin' => $keterangan_detail[$i]
                //                 ]);
                // }

                $output = [
                        'msg'  => 'Transaksi baru berhasil ditambah',
                        'res'  => true,
                        'type' => 'success'
                ];
                return response()->json($output, 200); 
                //alert()->success('Success.','Request Approved...');
                //return redirect()->route('approval_cost.index');
            }
            
        }elseif(Auth::user()->kode_divisi == '14'){ //-- jika BOD
            //----kode APP ------------------------------------------------//
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

            $no_urut = $request->no_urut;
            $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                ->select('kode_perusahaan_tujuan')  
                                ->where('no_urut', $no_urut)
                                ->first();

            $alias_depo = DB::table('depos')
                        ->select('alias')
                        ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                        ->select('alias')
                        ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $getRow = DB::table('pengajuan_biaya')
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

            $no_urut = request()->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                                //'status' => 0,
                                'status_bod' => 1,
                                'id_approval_bod' => Auth::user()->id,
                                'tgl_approval_bod' => Carbon::now()->format('Y-m-d'),
                                'kode_app_bod' => $no_pengajuan_biaya,
                                'keterangan_approval' => $request->get('addKeterangan'),
                        ]);

            alert()->success('Success.','Request Approved...');
            return redirect()->route('home');
        }else{
            //----kode APP ------------------------------------------------//
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

            $no_urut = $request->no_urut;
            $data_perusahaan_tujuan = DB::table('pengajuan_biaya')
                                ->select('kode_perusahaan_tujuan')  
                                ->where('no_urut', $no_urut)
                                ->first();

            $alias_depo = DB::table('depos')
                        ->select('alias')
                        ->where('kode_depo', Auth::user()->kode_depo)->first();

            $alias_divisi = DB::table('divisi')
                        ->select('alias')
                        ->where('kode_divisi', Auth::user()->kode_divisi)->first();

            $kd_perusahaan = $data_perusahaan_tujuan->kode_perusahaan_tujuan;
            $alias_depo = $alias_depo->alias;
            $alias_divisi = $alias_divisi->alias;

            $getRow = DB::table('pengajuan_biaya')
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

            $jenis = $request->jenis;
            if($jenis == '1'){ //Gaji 
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 1,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'kode_app_atasan' => $no_pengajuan_biaya,
                        'keterangan_approval' => 'Approved',
                        'status_validasi_fin' => 0,
                ]);
            }elseif($jenis == '2'){ //Mitra
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 1,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'kode_app_atasan' => $no_pengajuan_biaya,
                        'keterangan_approval' => 'Approved',
                        'status_validasi_fin' => 0,
                ]);
            }elseif($jenis == '5'){ //Insentif
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 1,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'kode_app_atasan' => $no_pengajuan_biaya,
                        'keterangan_approval' => 'Approved',
                        'status_validasi_fin' => 0,
                ]);
			}elseif($jenis == '130'){ //Insentif
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 1,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'kode_app_atasan' => $no_pengajuan_biaya,
                        'keterangan_approval' => 'Approved',
                        'status_validasi_fin' => 0,
                ]);
            }elseif($jenis == '3'){ //Insentif
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 1,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'kode_app_atasan' => $no_pengajuan_biaya,
                        'keterangan_approval' => 'Approved',
                        'status_validasi_fin' => 0,
                ]);
            }else{ 
                if(Auth::user()->kode_sub_divisi == '12'){
                    $no_urut = $request->no_urut;
                    $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'id_user_approval_biaya' => Auth::user()->id,
                            'status_biaya' => 1,
                            'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                            'kode_app_biaya' => $no_pengajuan_biaya,
                            'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
                }else{
                    $no_urut = $request->no_urut;
                    $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 0,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'status_atasan' => 1,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'kode_app_atasan' => $no_pengajuan_biaya,
                            'keterangan_approval' => 'Approved',
                            'status_validasi_fin' => 0,
                    ]);
                }
                
            }

            

            $deskripsi = $request->deskripsi;
            $ceklist = $request->ceklist;
            $keterangan_detail = $request->keterangan_detail;

            if(Auth::user()->kode_sub_divisi == '12'){
                for ($i=0; $i < count((array)$deskripsi); $i++) { 
                    $status = $ceklist[$i] ?? DB::raw('status_detail'); // biar tidak jadi null
                    $ket    = $keterangan_detail[$i] ?? DB::raw('keterangan_detail');
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
            }else{
                for ($i=0; $i < count((array)$deskripsi); $i++) { 
                    $status = $ceklist[$i] ?? DB::raw('status_detail'); // biar tidak jadi null
                    $ket    = $keterangan_detail[$i] ?? DB::raw('keterangan_detail');
                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $deskripsi[$i])
                            ->update([
                                'status_detail_atasan' => $ceklist[$i],
                                'id_user_detail_atasan' => Auth::user()->id,
                                'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_atasan' => $keterangan_detail[$i],
                                
    
                                'status_detail' => $status,
                                
                                'keterangan_detail' => $ket,
                            ]);
                }
            }
            

            $output = [
                'msg'  => 'Transaksi baru berhasil ditambah',
                'res'  => true,
                'type' => 'success'
            ];
            return response()->json($output, 200);
            // alert()->success('Success.','Request Approved...');
            // return redirect()->route('pengajuan_biaya.index');    
        }
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_divisi == '6'){ //-- jika Biaya Pusat/Acc
            if(Auth::user()->kode_sub_divisi == '5'){ //Manager Biaya ACC
                $no_urut = request()->no_urut;
                $data_app = DB::table('pengajuan_biaya')
                    ->select('status_atasan','status_biaya_pusat','status_biaya')  
                    ->where('no_urut', $no_urut)
                    ->first();

                $status_atasan = $data_app->status_atasan;
                $status_biaya_pusat = $data_app->status_biaya_pusat;
                $status_biaya = $data_app->status_biaya;

                if($status_atasan == 0) {
                    $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 2,
                            'status_atasan' => 2,
                            'id_user_approval_atasan' => Auth::user()->id,
                            'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => 'Denied',
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
                                    'status_detail_atasan' => $chkd,
                                    'id_user_detail_atasan' => Auth::user()->id,
                                    'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_detail_atasan' => $keterangan_detail[$i]
                                ]);
                    }
                }else{
                    $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 2,
                            'status_biaya_pusat' => 2,
                            'id_user_approval_biaya_pusat' => Auth::user()->id,
                            'tgl_approval_biaya_pusat' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
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
                }
        
                $output = [
                    'msg'  => 'Transaksi baru berhasil ditambah',
                    'res'  => true,
                    'type' => 'success'
                ];
                return response()->json($output, 200);
                // alert()->success('Success.','Request Approved...');
                 // return redirect()->route('pengajuan_biaya.index');  
            }elseif(Auth::user()->kode_sub_divisi == '4'){ //Manager Ka Akunting
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_approval_ka_akunting' => Auth::user()->id,
                        'status_ka_akunting' => 2,
                        'tgl_approval_ka_akunting' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_ka_akunting' => 2,
                        'keterangan_approval' => 'Denied',
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
                                'status_detail_ka_akunting' => $chkd,
                                'id_user_detail_ka_akunting' => Auth::user()->id,
                                'tgl_approval_detail_ka_akunting' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_ka_akunting' => $keterangan_detail[$i]
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
            }

            alert()->error('Oops...','Request Denied...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $no_urut = request()->no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_biaya_pusat' => 2,
                        'status_biaya' => 2,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            alert()->error('Oops...','Request Denied...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '106'){ //-- jika Biaya Depo
            $no_urut = request()->no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_biaya' => 2,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            alert()->error('Oops...','Request Denied...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '5'){ //-- jika Finance
            if(Auth::user()->id == '391' || Auth::user()->id == '698'){ //--- jika user finance bu berliana
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 2,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => 'Denied',
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
                                'status_detail_atasan' => $chkd,
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
                // return redirect()->route('pengajuan_biaya.index');
            }else{
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status_fin' => 2,
                            'id_approval_fin' => Auth::user()->id,
                            'tgl_approval_fin' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => 'Denied',
                            'status_validasi_fin' => 2,
                        ]);

                $deskripsi = $request->deskripsi;
                $ceklist = $request->ceklist;
                $keterangan_detail = $request->keterangan_detail;
                    
                for ($i=0; $i < count((array)$deskripsi); $i++) { 
                    $approved = DB::table('pengajuan_biaya_detail')
                                ->Where('no_urut', request()->no_urut)
                                ->Where('description', $deskripsi[$i])
                                ->update([
                                    'status_detail_fin' => 2,
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
                
                alert()->success('Success.','Request Approved...');
                return redirect()->route('approval_cost.index');
            }
            
        }elseif(Auth::user()->kode_divisi == '14'){ //-- jika BOD
            $no_urut = request()->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                                'status' => 2,
                                'status_bod' => 2,
                                'id_approval_bod' => Auth::user()->id,
                                'tgl_approval_bod' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => $request->get('addKeterangan'),
                        ]);

            alert()->success('Success.','Request Approved...');
            return redirect()->route('home');
        }else{
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 2,
                    'id_user_approval_atasan' => Auth::user()->id,
                    'status_atasan' => 2,
                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                    'keterangan_approval' => 'Denied',
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
                            'status_detail_atasan' => $chkd,
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
            // return redirect()->route('pengajuan_biaya.index');  
        }
    }

    public function pending(Request $request)
    {
        if(Auth::user()->kode_divisi == '6'){ //-- jika Biaya Pusat/Acc
             if(Auth::user()->kode_sub_divisi == '5'){ //Manager Biaya ACC
                $no_urut = request()->no_urut;

                $data_app = DB::table('pengajuan_biaya')
                    ->select('status_atasan','status_biaya_pusat','status_biaya')  
                    ->where('no_urut', $no_urut)
                    ->first();

                $status_atasan = $data_app->status_atasan;
                $status_biaya_pusat = $data_app->status_biaya_pusat;
                $status_biaya = $data_app->status_biaya;

                if($status_atasan == 0) {
                    $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'status_atasan' => 3,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => 'Pending',
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
                                    'status_detail_atasan' => $chkd,
                                    'id_user_detail_atasan' => Auth::user()->id,
                                    'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_detail_atasan' => $keterangan_detail[$i]
                                ]);
                    }
                }else{
                    $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 3,
                            'status_biaya_pusat' => 3,
                            'id_user_approval_biaya_pusat' => Auth::user()->id,
                            'tgl_approval_biaya_pusat' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
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
                }
                
                $output = [
                    'msg'  => 'Transaksi baru berhasil ditambah',
                    'res'  => true,
                    'type' => 'success'
                ];
                return response()->json($output, 200);
                // alert()->success('Success.','Request Approved...');
                 // return redirect()->route('pengajuan_biaya.index');  
            }elseif(Auth::user()->kode_sub_divisi == '4'){ //Manager Ka Akunting
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_approval_ka_akunting' => Auth::user()->id,
                        'status_ka_akunting' => 3,
                        'tgl_approval_ka_akunting' => Carbon::now()->format('Y-m-d'),
                        'status_validasi_ka_akunting' => 3,
                        'keterangan_approval' => 'Pending',
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
                                'status_detail_ka_akunting' => $chkd,
                                'id_user_detail_ka_akunting' => Auth::user()->id,
                                'tgl_approval_detail_ka_akunting' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_ka_akunting' => $keterangan_detail[$i]
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
            }

            alert()->warning('Warning.','Request Pending...');
            return redirect()->route('approval_cost.index');

        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $no_urut = request()->no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_biaya' => 3,
                        'status_validasi' => 3,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            alert()->warning('Warning.','Request Pending...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '106'){ //-- jika Biaya Depo
            $no_urut = request()->no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_biaya' => 3,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            alert()->warning('Warning.','Request Pending...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '5'){ //-- jika Finance
            if(Auth::user()->id == '391' || Auth::user()->id == '698'){ //--- jika user finance bu berliana
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 3,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => 'Pending',
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
                                'status_detail_atasan' => $chkd,
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
                // return redirect()->route('pengajuan_biaya.index'); 
            }else{
                $no_urut = $request->no_urut;
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            // 'status' => 3,
                            'id_approval_fin' => Auth::user()->id,
                            'status_fin' => 3,
                            'tgl_approval_fin' => Carbon::now()->format('Y-m-d'),
                            'status_validasi_fin' => 3,
                            'keterangan_approval' => 'Pending',
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
                // alert()->success('Success.','Request Approved...');
                // return redirect()->route('pengajuan_biaya.index');  

                alert()->warning('Warning.','Request Pending...');
                return redirect()->route('approval_cost.index');
            }
            
        }elseif(Auth::user()->kode_divisi == '10'){ //-- jika claim
            $no_urut = request()->no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_claim' => 3,
                        'status_validasi_clm' => 3,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
            alert()->warning('Warning.','Request Pending...');
            return redirect()->route('approval_cost.index');
        }elseif(Auth::user()->kode_divisi == '14'){ //-- jika BOD
            $no_urut = request()->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                                //'status' => 0,
                                'status_bod' => 3,
                                'id_approval_bod' => Auth::user()->id,
                                'tgl_approval_bod' => Carbon::now()->format('Y-m-d'),
                                'keterangan_approval' => $request->get('addKeterangan'),
                        ]);

            alert()->success('Success.','Request Approved...');
            return redirect()->route('home');
        }elseif(Auth::user()->kode_divisi == '106'){ //-- jika claim
            $no_urut = request()->no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_user_approval_biaya'  => Auth::user()->id,
                        'status_biaya' => 3,
                        'status_validasi_clm' => 3,
                        'tgl_approval_biaya'  => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
            alert()->warning('Warning.','Request Pending...');
            return redirect()->route('approval_cost.index');
        }else{
            $no_urut = $request->no_urut;
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status' => 3,
                    'id_user_approval_atasan' => Auth::user()->id,
                    'status_atasan' => 3,
                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                    'keterangan_approval' => 'Pending',
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
                            'status_detail_atasan' => $chkd,
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
            // return redirect()->route('pengajuan_biaya.index');   
        }
    }
}
