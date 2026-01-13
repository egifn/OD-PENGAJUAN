<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Divisi;
use App\Pengajuan_Biaya;
use App\Pengajuan_Biaya_Detail;
use App\Pengajuan_Upload;
use App\Import_Claim_Tiv;
use App\JurnalUmum;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PengajuanTivController extends Controller
{
    public function index()
    {   
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_perusahaan == 'ARS') {
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                                ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.status',
                                            'pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program',
                                            'pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som',
                                            'pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['137'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orWhere('pengajuan_biaya.status_atasan', 1)
                                //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['137'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_som = '0' THEN 0 WHEN pengajuan_biaya.status_som = '1' THEN 1 ELSE 2 END"))
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
        }else{
            if (Auth::user()->kode_divisi == '0') {
                $pengajuan_tiv = DB::table('pengajuan_biaya')
                    ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }else{
                if(Auth::user()->kode_divisi == '13') { //SND
                    if (Auth::user()->kode_sub_divisi == '12') { //SSD
                        $pengajuan_tiv = DB::table('pengajuan_biaya')
                            ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orWhere('pengajuan_biaya.status_ssd', 0)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_ssd = '0' THEN 0 WHEN pengajuan_biaya.status_ssd = '1' THEN 1 ELSE 2 END"))
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
                    }elseif(Auth::user()->kode_sub_divisi == '16') { //SOM
                        $pengajuan_tiv = DB::table('pengajuan_biaya')
                            ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->where('pengajuan_biaya.status_ssd', 1)
                            ->where('pengajuan_biaya.status_atasan', 1)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orWhere('pengajuan_biaya.status_som', 0)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->where('pengajuan_biaya.status_ssd', 1)
                            ->where('pengajuan_biaya.status_atasan', 1)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_som = '0' THEN 0 WHEN pengajuan_biaya.status_som = '1' THEN 1 ELSE 2 END"))
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
                    }else{
                        if (Auth::user()->type == 'Admin') { //SSD
                            $pengajuan_tiv = DB::table('pengajuan_biaya')
                                ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.status',
                                            'pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program',
                                            'pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som',
                                            'pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
                        }elseif (Auth::user()->type == 'Manager'){
                            $pengajuan_tiv = DB::table('pengajuan_biaya')
                                ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.status',
                                            'pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program',
                                            'pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som',
                                            'pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orWhere('pengajuan_biaya.status_atasan', 0)
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_som = '0' THEN 0 WHEN pengajuan_biaya.status_som = '1' THEN 1 ELSE 2 END"))
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
                        }
                    }
                }
            }
        }

        
    	return view('pengajuan.pengajuan_tiv.index', compact('pengajuan_tiv'));
    }

    public function cari(Request $request)
    {   
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_perusahaan == 'ARS') {
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                                ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.status',
                                            'pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program',
                                            'pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som',
                                            'pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['137'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orWhere('pengajuan_biaya.status_atasan', 1)
                                //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['137'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_som = '0' THEN 0 WHEN pengajuan_biaya.status_som = '1' THEN 1 ELSE 2 END"))
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
        }else{
            if (Auth::user()->kode_divisi == '0') {
                $pengajuan_tiv = DB::table('pengajuan_biaya')
                    ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }else{
                if(Auth::user()->kode_divisi == '13') { //SND
                    if (Auth::user()->kode_sub_divisi == '12') { //SSD
                        $pengajuan_tiv = DB::table('pengajuan_biaya')
                            ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orWhere('pengajuan_biaya.status_ssd', 0)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_ssd = '0' THEN 0 WHEN pengajuan_biaya.status_ssd = '1' THEN 1 ELSE 2 END"))
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
                    }elseif(Auth::user()->kode_sub_divisi == '16') { //SOM
                        $pengajuan_tiv = DB::table('pengajuan_biaya')
                            ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->where('pengajuan_biaya.status_ssd', 1)
                            ->where('pengajuan_biaya.status_atasan', 1)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orWhere('pengajuan_biaya.status_som', 0)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->where('pengajuan_biaya.status_ssd', 1)
                            ->where('pengajuan_biaya.status_atasan', 1)
                            ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                            ->whereNotIn('pengajuan_biaya.status', ['9'])
                            ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_som = '0' THEN 0 WHEN pengajuan_biaya.status_som = '1' THEN 1 ELSE 2 END"))
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
                    }else{
                        if (Auth::user()->type == 'Admin') { //SSD
                            $pengajuan_tiv = DB::table('pengajuan_biaya')
                                ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                                'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
                        }elseif (Auth::user()->type == 'Manager'){
                            $pengajuan_tiv = DB::table('pengajuan_biaya')
                                ->Join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.status',
                                'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya_detail.keterangan_detail_clm')
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orWhere('pengajuan_biaya.status_atasan', 0)
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.status_ssd', 1)
                                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','138'])
                                ->whereNotIn('pengajuan_biaya.status', ['9'])
                                ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_som = '0' THEN 0 WHEN pengajuan_biaya.status_som = '1' THEN 1 ELSE 2 END"))
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
                        }
                    }
                }
            }
        }

        

    	return view('pengajuan.pengajuan_tiv.index', compact('pengajuan_tiv'));
    }

    public function create(Request $request)
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        
        // $getRow = DB::table('pengajuan_biaya')->select(DB::raw('MAX(kode_pengajuan_b) as NoUrut'));
        // $rowCount = $getRow->count();
        // if ($rowCount > 0) {
        //     $no_urut = $rowCount + 1;
        // }else{
        //     $no_urut = 1;
        // }

    	return view('pengajuan.pengajuan_tiv.create', compact('perusahaan'));
    }

    public function actionCategory(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                // $data = DB::table('ms_pengeluaran')
                //         ->Where('ms_pengeluaran.id','like','%'.$query.'%')
                //         ->orWhere('ms_pengeluaran.nama_pengeluaran','like','%'.$query.'%')
                //         ->get();

                $data = DB::table('ms_pengeluaran')
                        ->leftJoin('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
                        ->leftJoin('coa_transaksi_detail','coa_transaksi.no','=','coa_transaksi_detail.no')
                        ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->where('ms_pengeluaran.id','like','%'.$query.'%')
                        ->orWhere('ms_pengeluaran.nama_pengeluaran','like','%'.$query.'%')
                        ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi','coa_transaksi.no')
                        ->get();
            }else{
                // $data = DB::table('ms_pengeluaran')
                //         ->get();

                $data = DB::table('ms_pengeluaran')
                        ->leftJoin('coa_transaksi','ms_pengeluaran.coa','coa_transaksi.no')
                        ->leftJoin('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                         ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi','coa_transaksi.no')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_category" data-id="'.$row->id.'" data-nama_pengeluaran="'.$row->nama_pengeluaran.'" data-sifat="'.$row->sifat.'" data-jenis="'.$row->jenis.'" data-pembayaran="'.$row->pembayaran.'" data-kategori="'.$row->kategori.'" data-coa="'.$row->coa.'" data-nama_coa="'.$row->nama_transaksi.'" data-debit="'.$row->debit_1.'" data-kredit="'.$row->kredit_1.'">
                            <td>'.$row->id.'</td>
                            <td>'.$row->nama_pengeluaran.'</td>
                            <td>'.$row->sifat.'</td>
                            <td hidden>'.$row->jenis.'</td>
                            <td hidden>'.$row->pembayaran.'</td>
                            <td hidden>'.$row->kategori.'</td>
                            <td hidden>'.$row->coa.'</td>
                            
                            <td hidden>'.$row->nama_transaksi.'</td>
                            <td hidden>'.$row->debit_1.'</td>
                            <td hidden>'.$row->kredit_1.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function cari_data(Request $request)
    {             
        //dd($request->id_perusahaan);
        // $data_pengajuan_program = DB::select("SELECT 
        // import_data_program_tiv.id_program,
        // SUBSTRING_INDEX(import_data_program_tiv.dist_perusahaan, 'Group', 1) AS perusahaan,
        // COUNT(import_data_program_tiv.customer_id) AS jml_toko,
        // SUM(import_data_program_tiv.reward) AS total_reward,
        // SUM(CASE WHEN import_data_program_tiv.bank = 'BCA' THEN '0' WHEN import_data_program_tiv.bank = '#N/A' THEN '0' ELSE '2900' END) AS total_potongan
        // FROM import_data_program_tiv
        // WHERE import_data_program_tiv.id_program = '$request->id_program'
        // AND SUBSTRING_INDEX(import_data_program_tiv.dist_perusahaan, 'Group', 1) = '$request->id_perusahaan'
        // AND import_data_program_tiv.ach_persen >= '100'
        // GROUP BY import_data_program_tiv.id_program,
        // SUBSTRING_INDEX(import_data_program_tiv.dist_perusahaan, 'Group', 1)");
		// $bulan = date('m', strtotime($request->tgl_import));
		$bulan = $request->tgl_import;
		
        // $data_pengajuan_program = DB::select("SELECT DISTINCT
		// import_pencapaian_program_header.tgl_import,
        // import_pencapaian_program_header.no_surat,
        // claim_surat_program.id_program,
        // import_pencapaian_program_detail.kode_perusahaan as perusahaan,
        // COUNT(import_pencapaian_program_detail.kode_outlet) AS jml_toko,
        // SUM(import_pencapaian_program_detail.reward) AS total_reward,
        // SUM(import_pencapaian_program_detail.reward_tiv) AS total_reward_tiv,
        // SUM(CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END) AS total_potongan
        // FROM import_pencapaian_program_header
        // INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_urut = import_pencapaian_program_detail.no_urut
        // INNER JOIN claim_surat_program ON import_pencapaian_program_header.no_surat = claim_surat_program.no_surat
        // AND import_pencapaian_program_header.id_program = claim_surat_program.id_program
		// LEFT JOIN rekening_outlet ON import_pencapaian_program_detail.kode_outlet = rekening_outlet.kode_toko
        // WHERE import_pencapaian_program_detail.kode_perusahaan = '$request->id_perusahaan' 
        // AND import_pencapaian_program_header.id_program = '$request->id_program'
		// and (import_pencapaian_program_header.tgl_import) = '$bulan'
        // GROUP BY import_pencapaian_program_header.tgl_import,import_pencapaian_program_header.id_import,import_pencapaian_program_header.no_surat,claim_surat_program.id_program,
        // import_pencapaian_program_detail.kode_perusahaan");

        //=====================
        $data_pengajuan_program = DB::select("SELECT DISTINCT  
        import_pencapaian_program_header.tgl_import,
        import_pencapaian_program_header.no_surat, 
        import_pencapaian_program_header.id_program,
        import_pencapaian_program_header.kode_perusahaan AS perusahaan,
        COUNT(import_pencapaian_program_detail.kode_outlet) AS jml_toko,
        SUM(import_pencapaian_program_detail.reward) AS total_reward,
        SUM(import_pencapaian_program_detail.reward_tiv) AS total_reward_tiv,
        SUM(CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END) AS total_potongan
        FROM import_pencapaian_program_header      
        INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_urut = import_pencapaian_program_detail.no_urut
        LEFT JOIN rekening_outlet ON import_pencapaian_program_detail.kode_outlet = rekening_outlet.kode_toko 
        WHERE import_pencapaian_program_detail.kode_perusahaan = '$request->id_perusahaan' 
        AND import_pencapaian_program_header.id_program = '$request->id_program'
        AND (import_pencapaian_program_header.tgl_import) = '$bulan'
        GROUP BY import_pencapaian_program_header.tgl_import,
        import_pencapaian_program_header.no_surat, 
        import_pencapaian_program_header.id_program,
        import_pencapaian_program_header.kode_perusahaan");

        $output = [
            'status'  => true,
                'message' => 'success',
                'data'    => $data_pengajuan_program
            ];
                            
        return response()->json($output, 200);
    }

    public function cari_data_upload(Request $request)
    {
        $approval_upload = DB::select("SELECT import_pencapaian_program_upload.filename
                        FROM import_pencapaian_program_header
                        INNER JOIN import_pencapaian_program_upload ON import_pencapaian_program_header.no_urut = import_pencapaian_program_upload.no_urut
                        WHERE import_pencapaian_program_header.id_program = '$request->id_program' 
                        AND import_pencapaian_program_header.kode_perusahaan = '$request->id_perusahaan'
                        AND import_pencapaian_program_upload.no_urut = '$request->no_urut_upload'");
                        
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $approval_upload
        ];
                                            
        return response()->json($output, 200);
    }

    public function cari_data_all(Request $request)
    {
        $data_pengajuan_program_all = DB::select("SELECT 
        import_data_program_tiv.id_program,
        SUBSTRING_INDEX(import_data_program_tiv.dist_perusahaan, 'Group', 1) AS perusahaan,
        import_data_program_tiv.dist_depo,
        import_data_program_tiv.cluster,
        import_data_program_tiv.customer_id,
        import_data_program_tiv.cuastomer_name,
        import_data_program_tiv.no_rek,
        import_data_program_tiv.bank,
        import_data_program_tiv.nama_rekening,
        import_data_program_tiv.ach,
        import_data_program_tiv.reward,
        import_data_program_tiv.reward_tiv,
        CASE WHEN import_data_program_tiv.bank = 'BCA' THEN '0' WHEN import_data_program_tiv.bank = '#N/A' THEN '0' ELSE '2900' END AS potongan,
        import_data_program_tiv.reward - (CASE WHEN import_data_program_tiv.bank = 'BCA' THEN '0' WHEN import_data_program_tiv.bank = '#N/A' THEN '0' ELSE '2900' END) AS ditransfer
        FROM import_data_program_tiv
        WHERE import_data_program_tiv.id_program = '$request->id_program'
        AND SUBSTRING_INDEX(import_data_program_tiv.dist_perusahaan, 'Group', 1) = '$request->id_perusahaan'
        AND import_data_program_tiv.ach_persen >= '100'");

        $output = [
            'status'  => true,
                'message' => 'success',
                'data'    => $data_pengajuan_program_all
            ];
                            
        return response()->json($output, 200);
    }

    public function view_data_all(Request $request)
    {
        $bulan = $request->tgl_import;

        $data = DB::table('pengajuan_biaya_claim_piutang')
                ->where('pengajuan_biaya_claim_piutang.kode_pengajuan_b', $request->kode_pengajuan)
                ->get();
        $total_row = $data->count();

        if($total_row > 0)
        {
            $data_view_program_all = DB::select("SELECT DISTINCT
            import_pencapaian_program_header.no_surat,
            claim_surat_program.id_program,
            import_pencapaian_program_detail.kode_perusahaan AS perusahaan,
            import_pencapaian_program_detail.kode_depo,
            import_pencapaian_program_detail.nama_depo AS dist_depo,
            import_pencapaian_program_detail.cluster,
            import_pencapaian_program_detail.kode_outlet AS customer_id,
            import_pencapaian_program_detail.nama_outlet AS customer_name,
            rekening_outlet.no_rekening AS no_rek,
            rekening_outlet.bank_rekening AS bank,
            rekening_outlet.nama_rekening AS nama_rekening,
            import_pencapaian_program_detail.reward,
            import_pencapaian_program_detail.reward_tiv,
            CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END AS potongan,
            import_pencapaian_program_detail.reward + import_pencapaian_program_detail.reward_tiv - (CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END) AS ditransfer,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_depo,0) as piutang_depo,
            pengajuan_biaya_claim_piutang.norek_depo,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_ng,0) as piutang_ng,
            pengajuan_biaya_claim_piutang.norek_ng
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_surat = import_pencapaian_program_detail.no_surat
            AND import_pencapaian_program_header.tgl_import = import_pencapaian_program_detail.tgl_import
            INNER JOIN claim_surat_program ON import_pencapaian_program_header.no_surat = claim_surat_program.no_surat
            AND import_pencapaian_program_header.id_program = claim_surat_program.id_program
            LEFT JOIN rekening_outlet ON import_pencapaian_program_detail.kode_outlet = rekening_outlet.kode_toko
            LEFT JOIN pengajuan_biaya_claim_piutang ON import_pencapaian_program_detail.no_surat = pengajuan_biaya_claim_piutang.no_surat
            AND import_pencapaian_program_detail.kode_outlet = pengajuan_biaya_claim_piutang.id_toko
            AND import_pencapaian_program_detail.no_urut_pengajuan = pengajuan_biaya_claim_piutang.no_urut_pengajuan
            WHERE import_pencapaian_program_header.id_program = '$request->id'
            AND import_pencapaian_program_detail.kode_perusahaan = '$request->perusahaan'
            and import_pencapaian_program_detail.tgl_import = '$bulan'
            ");
        }else{
            $data_view_program_all = DB::select("SELECT DISTINCT
            import_pencapaian_program_header.no_surat,
            claim_surat_program.id_program,
            import_pencapaian_program_detail.kode_perusahaan AS perusahaan,
            import_pencapaian_program_detail.kode_depo,
            import_pencapaian_program_detail.nama_depo AS dist_depo,
            import_pencapaian_program_detail.cluster,
            import_pencapaian_program_detail.kode_outlet AS customer_id,
            import_pencapaian_program_detail.nama_outlet AS customer_name,
            rekening_outlet.no_rekening AS no_rek,
            rekening_outlet.bank_rekening AS bank,
            rekening_outlet.nama_rekening AS nama_rekening,
            import_pencapaian_program_detail.reward,
            import_pencapaian_program_detail.reward_tiv,
            CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END AS potongan,
            import_pencapaian_program_detail.reward + import_pencapaian_program_detail.reward_tiv - (CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END) AS ditransfer,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_depo,0) as piutang_depo,
            pengajuan_biaya_claim_piutang.norek_depo,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_ng,0) as piutang_ng,
            pengajuan_biaya_claim_piutang.norek_ng
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_surat = import_pencapaian_program_detail.no_surat
            AND import_pencapaian_program_header.tgl_import = import_pencapaian_program_detail.tgl_import
            INNER JOIN claim_surat_program ON import_pencapaian_program_header.no_surat = claim_surat_program.no_surat
            AND import_pencapaian_program_header.id_program = claim_surat_program.id_program
            LEFT JOIN rekening_outlet ON import_pencapaian_program_detail.kode_outlet = rekening_outlet.kode_toko
            LEFT JOIN pengajuan_biaya_claim_piutang ON import_pencapaian_program_detail.no_surat = pengajuan_biaya_claim_piutang.no_surat
            AND import_pencapaian_program_detail.kode_outlet = pengajuan_biaya_claim_piutang.id_toko
            AND import_pencapaian_program_detail.no_urut_pengajuan = pengajuan_biaya_claim_piutang.no_urut_pengajuan
            WHERE import_pencapaian_program_header.id_program = '$request->id'
            AND import_pencapaian_program_detail.kode_perusahaan = '$request->perusahaan'
            and import_pencapaian_program_detail.tgl_import = '$bulan'
            ");
        }
        // $data_view_program_all = DB::select("SELECT 
        // import_data_program_tiv.id_program,
        // SUBSTRING_INDEX(import_data_program_tiv.dist_perusahaan, 'Group', 1) AS perusahaan,
        // import_data_program_tiv.dist_depo,
        // import_data_program_tiv.cluster,
        // import_data_program_tiv.customer_id,
        // import_data_program_tiv.cuastomer_name,
        // import_data_program_tiv.no_rek,
        // import_data_program_tiv.bank,
        // import_data_program_tiv.nama_rekening,
        // import_data_program_tiv.ach,
        // import_data_program_tiv.reward,
        // CASE WHEN import_data_program_tiv.bank = 'BCA' THEN '0' WHEN import_data_program_tiv.bank = '#N/A' THEN '0' ELSE '2900' END AS potongan,
        // import_data_program_tiv.reward - (CASE WHEN import_data_program_tiv.bank = 'BCA' THEN '0' WHEN import_data_program_tiv.bank = '#N/A' THEN '0' ELSE '2900' END) AS ditransfer
        // FROM import_data_program_tiv
        // WHERE import_data_program_tiv.id_program = '$request->id'
        // AND SUBSTRING_INDEX(import_data_program_tiv.dist_perusahaan, 'Group', 1) = '$request->perusahaan'
        // AND import_data_program_tiv.ach_persen >= '100'");
		
		//$bulan = date('m', strtotime($request->tgl_import));
		

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data_view_program_all
        ];
                            
        return response()->json($output, 200);
    }

    public function actionProgram(Request $request)
    {
        
        
        if($request->ajax())
        {   
            $output = '';
            $perusahaan_tujuan = $request->perusahaan_tujuan;
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('import_pencapaian_program_header')
                        ->Join('claim_surat_program', function($join) {
                            $join->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat')
                                ->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program');
                        })
                        ->select('claim_surat_program.id',
								'import_pencapaian_program_header.tgl_import',
                                'import_pencapaian_program_header.no_surat AS no_surat_at_import',
                                 'import_pencapaian_program_header.keterangan',
                                 'import_pencapaian_program_header.no_urut AS no_urut_at_import',
                                 'claim_surat_program.no_surat AS no_surat_at_pengajuan',
                                 'claim_surat_program.jenis_surat',
                                 'claim_surat_program.id_program',
                                 'claim_surat_program.nama_program',
								 'import_pencapaian_program_header.kode_perusahaan',
                                 'claim_surat_program.no_urut AS no_urut_at_pengajuan')
						->where('import_pencapaian_program_header.status', 0)
                        ->where('import_pencapaian_program_header.kode_perusahaan', $perusahaan_tujuan)
                        ->get();
            }else{
                $data = DB::table('import_pencapaian_program_header')
                        ->Join('claim_surat_program', function($join) {
                            $join->on('import_pencapaian_program_header.no_surat', '=', 'claim_surat_program.no_surat')
                                ->on('import_pencapaian_program_header.id_program', '=', 'claim_surat_program.id_program');
                        })
                        ->select('claim_surat_program.id',
								'import_pencapaian_program_header.tgl_import',
                                'import_pencapaian_program_header.no_surat AS no_surat_at_import',
                                'import_pencapaian_program_header.keterangan',
                                'import_pencapaian_program_header.no_urut AS no_urut_at_import',
                                'import_pencapaian_program_header.kategori',
                                'claim_surat_program.no_surat AS no_surat_at_pengajuan',
                                'claim_surat_program.jenis_surat',
                                'claim_surat_program.id_program',
                                'claim_surat_program.nama_program',
								'import_pencapaian_program_header.kode_perusahaan',
                                'claim_surat_program.no_urut AS no_urut_at_pengajuan')
						->where('import_pencapaian_program_header.status', 0)
                        ->where('import_pencapaian_program_header.kode_perusahaan', $perusahaan_tujuan)
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_program" data-id="'.$row->id.'" data-tgl_import="'.$row->tgl_import.'" data-no_surat="'.$row->no_surat_at_import.'" data-jenis_surat="'.$row->jenis_surat.'" data-id_program="'.$row->id_program.'" data-nama_program="'.$row->nama_program.'"  data-kategori-program="'.$row->kategori.'" data-perusahaan="'.$row->kode_perusahaan.'" data-no_urut="'.$row->no_urut_at_pengajuan.'" data-no_urut_upload="'.$row->no_urut_at_import.'">
                            <td hidden>'.$row->id.'</td>
							<td>'.$row->tgl_import.'</td>
                            <td>'.$row->no_surat_at_import.'</td>
                            <td>'.$row->jenis_surat.'</td>
							<td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->id_program.'</td>
                            <td>'.$row->nama_program.'</td>
                            <td hidden>'.$row->kategori.'</td>
                            <td hidden>'.$row->no_urut_at_pengajuan.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }
	
	public function actionRekening(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('vendors')
                        ->leftJoin('rekening_fin','vendors.kode_vendor','=','rekening_fin.kode_vendor')
                        ->leftJoin('banks','rekening_fin.kode_bank','=','banks.kode_bank') 
                        ->whereIn('rekening_fin.kode_vendor', ['M-TA','M-TUA','PCBDG','TA 7527','TAB','TAP','TGSM','TGSMP','TTA','TTABCA','TTAP','TU5776','TUAB','TUAP','TUB','TUBCA1','TUBCA2','M-TU','TUP','APJP','LPP','TUABO','TAP1','TAB1','TUP1','TUB1','TUA-B','TU-B','TA-B','LP-B','WPS-B'])
                        ->Where('vendors.nama_vendor','like','%'.$query.'%')
                        ->orWhere('banks.nama_nama_bank','like','%'.$query.'%')
                        ->orWhere('rekening_fin_comp.norek','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('vendors')
                        ->leftJoin('rekening_fin','vendors.kode_vendor','=','rekening_fin.kode_vendor')
                        ->leftJoin('banks','rekening_fin.kode_bank','=','banks.kode_bank') 
                        ->whereIn('rekening_fin.kode_vendor', ['M-TA','M-TUA','PCBDG','TA 7527','TAB','TAP','TGSM','TGSMP','TTA','TTABCA','TTAP','TU5776','TUAB','TUAP','TUB','TUBCA1','TUBCA2','M-TU','TUP','APJP','LPP','TUABO','TAP1','TAB1','TUP1','TUB1','TUA-B','TU-B','TA-B','LP-B','WPS-B'])
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_rekening" data-nama_perusahaan="'.$row->nama_vendor.'"  data-kode_bank="'.$row->kode_bank.'" data-nama_bank="'.$row->nama_bank.'" data-norek="'.$row->norek.'" data-atas_nama="'.$row->atas_nama.'">
                            
                            <td>'.$row->nama_vendor.'</td>
                            <td hidden>'.$row->kode_bank.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->norek.'</td>
                            <td hidden>'.$row->atas_nama.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function actionTanggungan(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('import_claim_tiv')
                        ->Where('import_claim_tiv.status', '0')
                        ->Where('import_claim_tiv.area','like','%'.$query.'%')
                        ->orWhere('import_claim_tiv.nama_toko','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('import_claim_tiv')
                        ->Where('import_claim_tiv.status', '0')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_tanggungan" 
                            data-id="'.$row->id.'" 
                            data-area="'.$row->area.'" 
                            data-nama_toko="'.$row->nama_toko.'" 
                            data-no_rekening="'.$row->no_rekening.'" 
                            data-bank="'.$row->bank.'" 
                            data-pemilik_rekening="'.$row->pemilik_rekening.'" 
                            data-qty="'.$row->qty.'" 
                            data-reward_tiv="'.$row->reward_tiv.'" 
                            data-total_reward="'.$row->total_reward.'" 
                            data-potongan="'.$row->potongan.'" 
                            
                            <td>'.$row->id.'</td>
                            <td>'.$row->id.'</td>
                            <td>'.$row->area.'</td>
                            <td>'.$row->nama_toko.'</td>
                            <td>'.$row->no_rekening.'</td>
                            <td>'.$row->bank.'</td>
                            <td>'.$row->pemilik_rekening.'</td>
                            <td>'.$row->qty.'</td>
                            <td>'.$row->reward_tiv.'</td>
                            <td>'.$row->total_reward.'</td>
                            <td>'.$row->potongan.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="10">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }   
    }

    public function view($no_urut)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('perusahaans as perusahaan_tujuan','pengajuan_biaya.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
			->join('import_pencapaian_program_header', function ($join) {
				$join->on('pengajuan_biaya.no_surat_program', '=', 'import_pencapaian_program_header.no_surat')
					->on('pengajuan_biaya.no_urut', '=', 'import_pencapaian_program_header.no_urut_pengajuan');
			})
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','import_pencapaian_program_header.tgl_import','pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan as perusahaan_tujuan',
                        'pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','ms_pengeluaran.nama_pengeluaran','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.no_urut',
                        'pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.status_validasi_clm')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
			->join('pengajuan_biaya','pengajuan_biaya_detail.kode_pengajuan_b','=','pengajuan_biaya.kode_pengajuan_b')
            ->leftjoin('pengajuan_upload','pengajuan_biaya_detail.kode_pengajuan_b','=','pengajuan_upload.kode_pengajuan')
            ->select('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga',
                DB::raw('COUNT(pengajuan_upload.filename) as jml_file'))
            ->where('pengajuan_biaya_detail.no_urut',$no_urut)
            ->groupBy('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga')
            ->get();

        $approval_upload = DB::select("SELECT DISTINCT import_pencapaian_program_upload.filename
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_upload ON import_pencapaian_program_header.no_urut = import_pencapaian_program_upload.no_urut
            INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_urut = import_pencapaian_program_detail.no_urut
            WHERE import_pencapaian_program_header.id_program = '$pengajuan_biaya_head->id_program' 
            AND import_pencapaian_program_header.kode_perusahaan = '$pengajuan_biaya_head->kode_perusahaan_tujuan'
            AND import_pencapaian_program_detail.no_urut_pengajuan = '$no_urut'
            ");

        $pengajuan_biaya_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $pengajuan_biaya_head->kode_pengajuan_b)
            ->get();

        $pengajuan_biaya_detail_total = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');

        return view('pengajuan.pengajuan_tiv.view', compact('pengajuan_biaya_head','pengajuan_biaya_detail','pengajuan_biaya_detail_total','pengajuan_biaya_upload','approval_upload'));
    }

    public function view_approval($no_urut)
    {
        $data = DB::table('pengajuan_biaya')
                    ->leftjoin('users','pengajuan_biaya.id_user_approval_biaya_pusat','=','users.id')
                    ->leftjoin('users as user_1','pengajuan_biaya.id_user_approval_biaya','=','user_1.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b')
                    ->where('pengajuan_biaya.no_urut', $no_urut)
                    ->first();

        $data_approval = DB::table('pengajuan_biaya')
                    ->leftjoin('users as user_ssd','pengajuan_biaya.id_approval_ssd','=','user_ssd.id')
                    ->leftjoin('users as user_snd','pengajuan_biaya.id_user_approval_atasan','=','user_snd.id')
                    ->leftjoin('users as user_som','pengajuan_biaya.id_approval_som','=','user_som.id')
                    ->leftjoin('users as user_claim','pengajuan_biaya.id_approval_claim','=','user_claim.id')
                    ->leftjoin('users as user_piutang_ng','pengajuan_biaya.id_approval_ng','=','user_piutang_ng.id')
                    ->leftjoin('users as user_piutang','pengajuan_biaya.id_approval_piutang','=','user_piutang.id')
                    ->leftjoin('users as user_biaya','pengajuan_biaya.id_user_approval_biaya_pusat','=','user_biaya.id')
                    ->select(
                        'user_ssd.name as nama_ssd',
                        'pengajuan_biaya.status_ssd as st_ssd',
                        'pengajuan_biaya.tgl_approval_ssd',
                        DB::raw('(CASE WHEN pengajuan_biaya.status_ssd = "1" THEN "Approved" WHEN pengajuan_biaya.status_ssd = "2" THEN "Denied" WHEN pengajuan_biaya.status_ssd = "3" THEN "Pending" END) AS status_ssd'),
                        'user_snd.name as nama_snd',
                        'pengajuan_biaya.status_atasan as st_snd',
                        'pengajuan_biaya.tgl_approval_atasan',
                        DB::raw('(CASE WHEN pengajuan_biaya.status_atasan = "1" THEN "Approved" WHEN pengajuan_biaya.status_atasan = "2" THEN "Denied" WHEN pengajuan_biaya.status_atasan = "3" THEN "Pending" END) AS status_snd'),
                        'user_som.name as nama_som',
                        'pengajuan_biaya.status_som as st_som',
                        'pengajuan_biaya.tgl_approval_som',
                        DB::raw('(CASE WHEN pengajuan_biaya.status_som = "1" THEN "Approved" WHEN pengajuan_biaya.status_som = "2" THEN "Denied" WHEN pengajuan_biaya.status_som = "3" THEN "Pending" END) AS status_som'),
                        'user_claim.name as nama_claim',
                        'pengajuan_biaya.status_claim as st_claim',
                        'pengajuan_biaya.tgl_approval_claim',
                        DB::raw('(CASE WHEN pengajuan_biaya.status_claim = "1" THEN "Approved" WHEN pengajuan_biaya.status_claim = "2" THEN "Denied" WHEN pengajuan_biaya.status_claim = "3" THEN "Pending" END) AS status_claim'),
                        'user_piutang_ng.name as nama_ng',
                        'pengajuan_biaya.status_ng as st_ng',
                        'pengajuan_biaya.tgl_approval_ng',
                        DB::raw('(CASE WHEN pengajuan_biaya.status_ng = "1" THEN "Approved" WHEN pengajuan_biaya.status_ng = "2" THEN "Denied" WHEN pengajuan_biaya.status_ng = "3" THEN "Pending" END) AS status_ng'),
                        'user_piutang.name as nama_piutang',
                        'pengajuan_biaya.status_piutang as st_piutang',
                        'pengajuan_biaya.tgl_approval_piutang',
                        DB::raw('(CASE WHEN pengajuan_biaya.status_piutang = "1" THEN "Approved" WHEN pengajuan_biaya.status_piutang = "2" THEN "Denied" WHEN pengajuan_biaya.status_piutang = "3" THEN "Pending" END) AS status_piutang'),
                        'user_biaya.name as nama_biaya',
                        'pengajuan_biaya.status_biaya_pusat as st_biaya',
                        'pengajuan_biaya.tgl_approval_biaya_pusat',
                        DB::raw('(CASE WHEN pengajuan_biaya.status_biaya_pusat = "1" THEN "Approved" WHEN pengajuan_biaya.status_biaya_pusat = "2" THEN "Denied" WHEN pengajuan_biaya.status_biaya_pusat = "3" THEN "Pending" END) AS status_biaya'),
                        'pengajuan_biaya.kode_pengajuan_b',
                        'pengajuan_biaya.kategori',
                        'pengajuan_biaya.status_buat_spp',
                        'pengajuan_biaya.no_spp',
                        'pengajuan_biaya.tgl_spp',
                        'pengajuan_biaya.no_urut'
                        )
                    ->where('pengajuan_biaya.no_urut', $no_urut)
                    ->get();

        return view('pengajuan.pengajuan_tiv.view_approval', compact('data','data_approval'));
    }

    public function store(Request $request)
    {
        set_time_limit(5000);
        ini_set('max_execution_time', 5000);
        $this->validate($request, [
            
        ]);

        $tahun = date('Y', strtotime($request->get('tgl')));
        $bulan = date('m', strtotime($request->get('tgl')));

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

        //$kd_perusahaan = $request->get('kode_perusahaan');
        $kd_perusahaan = $request->get('kode_perusahaan');
        $kode_depo = $request->get('kode_depo');
        $kode_divisi = $request->get('kode_divisi');
        //$id_kat = $request->get('id_pengeluaran');

        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',$kode_depo)->first();

        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getNoUrut = DB::table('pengajuan_biaya')->select(DB::raw('COUNT(kode_pengajuan_b) as NoUrut'))->first();
                    if ($getNoUrut->NoUrut > 0) {
                        $no_urut = $getNoUrut->NoUrut + 1;
                    }else{
                        $no_urut = 1;
                    }

        $getRow = DB::table('pengajuan_biaya')
                    ->select(DB::raw('MAX(kode_pengajuan_b) as NoUrut'))
                    ->where('kode_perusahaan', $kd_perusahaan)
                    ->where('kode_depo', $kode_depo)
                    ->where('kode_divisi', $kode_divisi);
        $rowCount = $getRow->count();

        if($rowCount > 0){
            //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
            if ($rowCount < 9) {
                $no_pengajuan_biaya = 'REQ '.'B'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_pengajuan_biaya = 'REQ '.'B'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_pengajuan_biaya = 'REQ '.'B'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_pengajuan_biaya = 'REQ '.'B'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
            $no_pengajuan_biaya = 'REQ '.'B'.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        }
       
        Pengajuan_Biaya::create([
            'kode_pengajuan_b' => $no_pengajuan_biaya,
            'tgl_pengajuan_b' => Carbon::now()->format('Y-m-d'),
            'kategori' => $request->get('id_pengeluaran'),
            'tipe' => $request->get('tipe'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kode_depo' => $request->get('kode_depo'),
            'kode_divisi' => $request->get('kode_divisi'),
            'kode_perusahaan_tujuan' => $request->get('kode_perusahaan_tujuan'),
            'no_surat_program' => $request->get('no_surat_program'),
            'id_program' => $request->get('id_program_simpan'),
            'status' => '0', 
            'keterangan' => $request->get('ket'),
            'id_user_input' => Auth::user()->id,
            'no_urut' => $no_urut
        ]);

        $datas=[];
        foreach ($request->input("id_program") as $key => $value) {
            //$datas["nama_toko.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);

        //if($validator->passes()){
            foreach ($request->input("id_program") as $key => $value) {
                $data = new Pengajuan_Biaya_Detail;

                $data->kode_pengajuan_b = $no_pengajuan_biaya;
                $data->no_description_detail = '1';
                $data->description = $request->get("id_program")[$key];
                $data->spesifikasi = $request->get("perusahaan")[$key];
                $data->qty = $request->get("jml_toko")[$key];
                $data->harga = $request->get("total_reward")[$key] + $request->get("total_reward_tiv")[$key];
                $data->jml_harga = '0';
                $data->potongan = $request->get("total_potongan")[$key];
                $data->tharga = $request->get("hasil_total")[$key];
                $data->no_urut = $no_urut;
                $data->save();

                //upload file
                if($request->hasfile('filename')) { 
                    foreach ($request->file('filename') as $file) {
                        if ($file->isValid()) {
                            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('images'), $filename);
                               
                            Pengajuan_Upload::create([
                                'kode_pengajuan' => $no_pengajuan_biaya,
                                'description' => $request->get('ket'),
                                'filename' => $filename
                            ]);
                        }
                    }
                    echo 'Success';
                    
                }else{
                    echo 'Gagal';
                }

                // $claim_update = Import_Claim_Tiv::find($request->get("id")[$key]);
                //     $claim_update->update([
                //        'status' => '1'
                // ]);
            }
        //}        
		
		$update_data_import = DB::table('import_pencapaian_program_header')
        ->where('no_surat', $request->get('no_surat_program'))
        ->where('kode_perusahaan', $request->get('kode_perusahaan_tujuan'))
        ->where('tgl_import', $request->get('tgl_import'))
        ->update([
            'no_urut_pengajuan' => $no_urut,
            'status' => 1,
        ]);

        $update_data_import_detail = DB::table('import_pencapaian_program_detail')
        ->where('no_surat', $request->get('no_surat_program'))
        ->where('kode_perusahaan', $request->get('kode_perusahaan_tujuan'))
        ->where('tgl_import', $request->get('tgl_import'))
        ->update([
            'no_urut_pengajuan' => $no_urut,
        ]);

        // JurnalUmum::create([
        //     'tgl' => Carbon::now()->format('Y-m-d'),
        //     'no_coa_transaksi' => $request->get('kode_coa'), 
        //     'kode_transaksi' => $kode_pengajuan_bkw,
        //     'kode_account' => $request->get('debit'),
        //     'debit' => str_replace(",", "", $request->get('total_biaya')),
        //     'kredit' => '0' 
        // ]);

        // JurnalUmum::create([
        //     'tgl' => Carbon::now()->format('Y-m-d'),
        //     'no_coa_transaksi' => $request->get('kode_coa'), 
        //     'kode_transaksi' => $kode_pengajuan_bkw,
        //     'kode_account' => $request->get('kredit'),
        //     'debit' => '0',
        //     'kredit' => str_replace(",", "", $request->get('total_biaya')) 
        // ]);

        alert()->success('Success.','Pengajuan Baru berhasil dibuat');
        return redirect()->route('pengajuan_tiv.index');
    }

    public function pdf($no_urut)
    {
        $pengajuan_tiv_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        //$pengajuan_tiv_detail = DB::table('pengajuan_biaya_detail')->where('pengajuan_biaya_detail.no_urut',$no_urut)->get();

        $data_view_program_all = DB::select("SELECT DISTINCT
            import_pencapaian_program_header.no_surat,
            claim_surat_program.id_program,
            import_pencapaian_program_detail.kode_perusahaan AS perusahaan,
            import_pencapaian_program_detail.nama_depo AS dist_depo,
            import_pencapaian_program_detail.cluster,
            import_pencapaian_program_detail.kode_outlet AS customer_id,
            import_pencapaian_program_detail.nama_outlet AS customer_name,
            rekening_outlet.no_rekening AS no_rek,
            rekening_outlet.bank_rekening AS bank,
            rekening_outlet.nama_rekening AS nama_rekening,
            import_pencapaian_program_detail.reward,
            import_pencapaian_program_detail.reward_tiv,
            CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END AS potongan,
            import_pencapaian_program_detail.reward + import_pencapaian_program_detail.reward_tiv - (CASE WHEN rekening_outlet.bank_rekening = 'BCA' THEN '0' ELSE '2900' END) AS ditransfer,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_depo,0) as piutang_depo,
            pengajuan_biaya_claim_piutang.norek_depo,
            COALESCE(pengajuan_biaya_claim_piutang.piutang_ng,0) as piutang_ng,
            pengajuan_biaya_claim_piutang.norek_ng
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_surat = import_pencapaian_program_detail.no_surat
            AND import_pencapaian_program_header.tgl_import = import_pencapaian_program_detail.tgl_import
            INNER JOIN claim_surat_program ON import_pencapaian_program_header.no_surat = claim_surat_program.no_surat
            AND import_pencapaian_program_header.id_program = claim_surat_program.id_program
            LEFT JOIN rekening_outlet ON import_pencapaian_program_detail.kode_outlet = rekening_outlet.kode_toko
            LEFT JOIN pengajuan_biaya_claim_piutang ON import_pencapaian_program_detail.no_surat = pengajuan_biaya_claim_piutang.no_surat
            AND import_pencapaian_program_detail.kode_outlet = pengajuan_biaya_claim_piutang.id_toko
            AND import_pencapaian_program_detail.no_urut_pengajuan = pengajuan_biaya_claim_piutang.no_urut_pengajuan
            WHERE import_pencapaian_program_detail.no_urut_pengajuan = '$no_urut'
            ");
        

        /*$total_jml = Pengajuan_Biaya_Kwb_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');*/

        $total_jml = DB::table('pengajuan_biaya_detail')
                        ->select(DB::raw('SUM(pengajuan_biaya_detail.qty) as qty'),
                                 DB::raw('SUM(pengajuan_biaya_detail.harga) as harga'),
                                 DB::raw('SUM(pengajuan_biaya_detail.jml_harga) as jml_harga'),
                                 DB::raw('SUM(pengajuan_biaya_detail.potongan) as potongan'),
                                 DB::raw('SUM(pengajuan_biaya_detail.harga - pengajuan_biaya_detail.potongan) as ditransfer'))
                        ->where('pengajuan_biaya_detail.no_urut', $no_urut)
                        ->first();

        $pdf = PDF::loadview('pengajuan.pengajuan_tiv.pdf', compact('pengajuan_tiv_head','data_view_program_all','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function pdf_spp($no_urut)
    {   
        $tgl_cetak = Carbon::now()->format('d/m/y'); //h:i a

        $spp_pdf = DB::table('spp')->join('users','spp.id_user_input','=','users.id')
                        ->leftjoin('users AS ka_biaya','spp.id_user_approval_spp_1','=','ka_biaya.id')
                        ->leftjoin('users AS ka_acc','spp.id_user_approval_spp_2','=','ka_acc.id')
                        ->leftjoin('pengajuan_biaya','spp.no_spp','=','pengajuan_biaya.no_spp')
                        ->leftjoin('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                        ->leftjoin('banks','rekening_fin.kode_bank','=','banks.kode_bank')
						->select('pengajuan_biaya.no_urut','spp.no_spp','spp.tgl_spp','spp.no_kontrabon','spp.kode_pembelian',
						'spp.ditujukan','spp.for','spp.jumlah','spp.jatuh_tempo','spp.keterangan','spp.jenis',
						'spp.id_user_input','spp.kode_user_input_spp','spp.kode_depo','spp.sumber_dana','spp.pajak_masukan','spp.kode_vendor',
						'banks.nama_bank','spp.pembayaran','rekening_fin.atas_nama','spp.yang_mengajukan',
						'spp.kode_approved_spp_1','spp.kode_approved_spp_2','users.name','ka_biaya.name AS ka_biaya','ka_acc.name AS ka_acc')
                        ->where('pengajuan_biaya.no_urut', $no_urut)
                        ->orderBy('spp.no_urut', 'ASC')
                        ->first();
        $sd_1 = DB::table('spp_sumber_dana')->where('kode',1)->first();
        $sd_2 = DB::table('spp_sumber_dana')->where('kode',2)->first();
        $sd_3 = DB::table('spp_sumber_dana')->where('kode',3)->first();
        $sd_4 = DB::table('spp_sumber_dana')->where('kode',4)->first();
        $sd_5 = DB::table('spp_sumber_dana')->where('kode',5)->first();

        // $pdf = PDF::loadview('finance.spp.pdf', compact('spp_pdf','tgl_cetak','sd_1','sd_2','sd_3','sd_4','sd_5'));
        $pdf = PDF::loadview('pengajuan.pengajuan_tiv.pdf_spp', compact('spp_pdf','tgl_cetak','sd_1','sd_2','sd_3','sd_4','sd_5'));
        return $pdf->stream();
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

        if(Auth::user()->kode_perusahaan == 'ARS'){
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();
    
                $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();
    
                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;
    
                $getRow = DB::table('pengajuan_biaya')
                                ->select(DB::raw('MAX(kode_app_som) as No_Urut_app_som'))
                                ->where('kode_depo', $alias_depo)
                                ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();
    
                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                }
    
                $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_som')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_som == '0' or $cari_status->status_som == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status' => 0,
                                    'status_som' => 1,
                                    'id_approval_som' => Auth::user()->id,
                                    'tgl_approval_som' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_app_som' => $request->get('addKeterangan'),
                                    'kode_app_som' => $no_pengajuan_biaya,
                                ]);
                }
        }else{
            if(Auth::user()->kode_sub_divisi == '12'){ //-- Jika SSD--
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();
    
                $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();
    
                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;
    
                $getRow = DB::table('pengajuan_biaya')
                                ->select(DB::raw('MAX(kode_app_ssd) as No_Urut_app_ssd'))
                                ->where('kode_depo', $alias_depo)
                                ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();
    
                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SSD'.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SSD'.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SSD'.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SSD'.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SSD'.'/'.$bulan_romawi.'/'.$tahun;
                }
    
                $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_ssd')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_ssd == '0' or $cari_status->status_ssd == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                        ->update([
                                'status' => 0,
                                'status_ssd' => 1,
                                'status_atasan' => 1,
                                'id_approval_ssd' => Auth::user()->id,
                                'tgl_approval_ssd' => Carbon::now()->format('Y-m-d'),
                                'keterangan_app_ssd' => $request->get('addKeterangan'),
                                'kode_app_ssd' => $no_pengajuan_biaya,
                        ]);
                }
            }elseif(Auth::user()->kode_sub_divisi == '16'){ //-- Jika SOM--
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();
    
                $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();
    
                $kd_perusahaan = Auth::user()->kode_perusahaan;
                $alias_depo = $alias_depo->alias;
                $alias_divisi = $alias_divisi->alias;
    
                $getRow = DB::table('pengajuan_biaya')
                                ->select(DB::raw('MAX(kode_app_som) as No_Urut_app_som'))
                                ->where('kode_depo', $alias_depo)
                                ->where('kode_divisi', $alias_divisi);
                $rowCount = $getRow->count();
    
                if($rowCount > 0){
                    //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                    if ($rowCount < 9) {
                        $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 99) {
                        $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    } else if ($rowCount < 999) {
                        $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    } else {
                        $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                    }
                }else{
                    //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                    $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SOM'.'/'.$bulan_romawi.'/'.$tahun;
                }
    
                $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_som')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_som == '0' or $cari_status->status_som == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status' => 0,
                                    'status_som' => 1,
                                    'id_approval_som' => Auth::user()->id,
                                    'tgl_approval_som' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_app_som' => $request->get('addKeterangan'),
                                    'kode_app_som' => $no_pengajuan_biaya,
                                ]);
                }
            }else{ //-- Jika Manager SSD
                $alias_depo = DB::table('depos')
                                ->select('alias')
                                ->where('kode_depo', Auth::user()->kode_depo)->first();
    
                $alias_divisi = DB::table('divisi')
                                ->select('alias')
                                ->where('kode_divisi', Auth::user()->kode_divisi)->first();
    
                $kd_perusahaan = Auth::user()->kode_perusahaan;
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
    
                $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_atasan')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status' => 0,
                                    'status_atasan' => 1,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_app_atasan' => $request->get('addKeterangan'),
                                    'kode_app_atasan' => $no_pengajuan_biaya,
                                ]);
                }
            }
        }
        

        alert()->success('Success.','Pengajuan berhasil di Approved...');
        return redirect()->route('pengajuan_tiv.index');
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_perusahaan == 'ARS'){
            $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_som')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_som == '0' or $cari_status->status_som == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status' => 2,
                                    'status_som' => 2,
                                    'id_approval_som' => Auth::user()->id,
                                    'tgl_approval_som' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_app_som' => $request->get('addKeterangan'),
                                    'kode_app_som' => 'Ditolak',
                                ]);
                }
        }else{
            if(Auth::user()->kode_sub_divisi == '12'){ //-- Jika SSD--
                $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_ssd')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_ssd == '0' or $cari_status->status_ssd == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                        ->update([
                                'status' => 2,
                                'status_ssd' => 2,
                                'id_approval_ssd' => Auth::user()->id,
                                'tgl_approval_ssd' => Carbon::now()->format('Y-m-d'),
                                'keterangan_app_ssd' => $request->get('addKeterangan'),
                                'kode_app_ssd' => 'Ditolak',
                        ]);
                }
            }elseif(Auth::user()->kode_sub_divisi == '16'){ //-- Jika SOM--
                $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_som')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_som == '0' or $cari_status->status_som == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status' => 2,
                                    'status_som' => 2,
                                    'id_approval_som' => Auth::user()->id,
                                    'tgl_approval_som' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_app_som' => $request->get('addKeterangan'),
                                    'kode_app_som' => 'Ditolak',
                                ]);
                }
            }else{ //-- Jika Manager SSD
                $cari_status = DB::table('pengajuan_biaya')
                                    ->select('pengajuan_biaya.status_atasan')
                                    ->Where('pengajuan_biaya.no_urut', request()->modal_no_urut)
                                    ->first();
                                    //dd($cari_status->status_atasan);
    
                if($cari_status->status_atasan == '0' or $cari_status->status_atasan == '3'){
                        $approved = DB::table('pengajuan_biaya')->where('no_urut', request()->modal_no_urut)
                                ->update([
                                    'status' => 2,
                                    'status_atasan' => 2,
                                    'id_user_approval_atasan' => Auth::user()->id,
                                    'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_app_atasan' => $request->get('addKeterangan'),
                                    'kode_app_atasan' => 'Ditolak',
                                ]);
                }
            }
        }
        

        alert()->error('Ditolak.','Pengajuan di Tolak...');
        return redirect()->route('pengajuan_tiv.index');
    }

    public function update_data(Request $request, $no_urut)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('perusahaans as perusahaan_tujuan','pengajuan_biaya.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->join('claim_surat_program', function ($join) {
                $join->on('pengajuan_biaya.no_surat_program','=','claim_surat_program.no_surat')
                    ->on('pengajuan_biaya.id_program', '=', 'claim_surat_program.id_program');
            })
            ->join('import_pencapaian_program_header', function ($join) {
				$join->on('pengajuan_biaya.no_surat_program', '=', 'import_pencapaian_program_header.no_surat')
					->on('pengajuan_biaya.no_urut', '=', 'import_pencapaian_program_header.no_urut_pengajuan');
			})
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','import_pencapaian_program_header.tgl_import','pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan as perusahaan_tujuan',
                        'pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','ms_pengeluaran.nama_pengeluaran','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.no_urut',
                        'claim_surat_program.nama_program','claim_surat_program.kategori',
                        'pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.status_validasi_clm')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
            ->leftjoin('pengajuan_upload','pengajuan_biaya_detail.kode_pengajuan_b','=','pengajuan_upload.kode_pengajuan')
            ->select('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga',
                DB::raw('COUNT(pengajuan_upload.filename) as jml_file'))
            ->where('pengajuan_biaya_detail.no_urut',$no_urut)
            ->groupBy('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga')
            ->get();

        $approval_upload = DB::select("SELECT DISTINCT import_pencapaian_program_upload.filename
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_upload ON import_pencapaian_program_header.no_urut = import_pencapaian_program_upload.no_urut
            INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_urut = import_pencapaian_program_detail.no_urut
            WHERE import_pencapaian_program_header.id_program = '$pengajuan_biaya_head->id_program' 
            AND import_pencapaian_program_header.kode_perusahaan = '$pengajuan_biaya_head->kode_perusahaan_tujuan'
            AND import_pencapaian_program_detail.no_urut_pengajuan = '$no_urut'
            ");

        $pengajuan_biaya_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $pengajuan_biaya_head->kode_pengajuan_b)
            ->get();

        $pengajuan_biaya_detail_total = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');

        return view ('pengajuan.pengajuan_tiv.edit', compact('pengajuan_biaya_head','pengajuan_biaya_detail','pengajuan_biaya_detail_total','pengajuan_biaya_upload','approval_upload'));
    }

    public function edit(Request $request)
    {
        set_time_limit(5000);
        ini_set('max_execution_time', 5000);
        $edit_head = Pengajuan_Biaya::find($request->get("kode_pengajuan_b"));
        $edit_head->update([
            'kode_perusahaan_tujuan' => $request->get("kode_perusahaan_tujuan"),
            'no_surat_program' => $request->get("no_surat_program"),
            'id_program' => $request->get("id_program_simpan"),
            'keterangan' => $request->get("ket")
        ]);

        $edit_detail = DB::table('pengajuan_biaya_detail')
                ->where('pengajuan_biaya_detail.kode_pengajuan_b', $request->get("kode_perusahaan_tujuan"))
                ->update([
                    'description' => $request->get("kode_perusahaan_tujuan"),
                    'spesifikasi' => $request->get("id_program_simpan"),
                    'qty' => '1',
                    'harga' => $request->get("total_reward_tiv"),
                    'potongan' => $request->get("total_potongan"),
                    'tharga' => $request->get("hasil_total")
                ]);

        if($request->input("filename_text") != null){
            //dd($request->input("filename_text"));
            $no = 1;
            foreach ($request->input("filename_text") as $key => $value) {
                if($request->hasfile('filename')) {
                    foreach ($request->file('filename') as $file) {
                        if ($file->isValid()) {
                                $hapus_data_upload = DB::table('pengajuan_upload')
                                            ->Where('pengajuan_upload.kode_pengajuan', $request->get("kode_pengajuan_b"))
                                            ->where('pengajuan_upload.filename', $request->get("filename_text")[$key])
                                            ->delete();

                                $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                                $file->move(public_path('images'), $filename);
                                                
                                Pengajuan_Upload::create([
                                            'kode_pengajuan' => $request->get('kode_pengajuan_b'),
                                            'no_description_detail' => $no,
                                            'description' => $request->get('ket'),
                                            'filename' => $filename
                                ]);
                            // }
                        }else{
                                
                        }
                        $no++;
                    }
                }
                echo 'Success';
            }
        }
        
		//upload file tambahan 
        if($request->hasfile('filename_tambah')) { 
            foreach ($request->file('filename_tambah') as $file) {
                if ($file->isValid()) {
                    $filename_tambah = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename_tambah);
                       
                    Pengajuan_Upload::create([
                        'kode_pengajuan' => $request->get('kode_pengajuan_b'),
                        'description' =>  $request->get('ket'),
                        'filename' => $filename_tambah
                    ]);
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }
        //======================

        $data_revisi = DB::table('pengajuan_biaya')->where('kode_pengajuan_b', $request->get('kode_pengajuan_b'))
        ->update([
            'status_validasi_clm' => 0,
        ]);
    
        alert()->success('Success.','Edit Pengajuan berhasil.');
        return redirect()->route('pengajuan_tiv.index');
    }
}
