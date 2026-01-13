<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pengajuan_Biaya_Detail;
use Carbon\carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanTivMasukController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_perusahaan == 'ARS'){
            if(Auth::user()->kode_divisi == '2'){
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['137'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->orWhere('pengajuan_biaya.status_claim', 0)
                    ->WhereIn('pengajuan_biaya.kategori', ['137'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_claim = '0' THEN 0 WHEN pengajuan_biaya.status_claim = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }
        }else{
            if(Auth::user()->kode_divisi == '10'){ //-- Jika Claim--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->orWhere('pengajuan_biaya.status_claim', 0)
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_claim = '0' THEN 0 WHEN pengajuan_biaya.status_claim = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }elseif(Auth::user()->kode_divisi == '24'){ //-- Jika Piutang--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Piutang--
                if(Auth::user()->kode_sub_divisi == '2'){
                    $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                                'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
                }else{
                    $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orWhere('pengajuan_biaya.status_validasi', 0)
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_validasi = '0' THEN 0 WHEN pengajuan_biaya.status_validasi = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
                }
            }elseif(Auth::user()->kode_divisi == '30'){ //-- Jika non gudang--
                    $approval_cost = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                                'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                        ->whereNotIn('pengajuan_biaya.status', ['9'])
                        ->where('pengajuan_biaya.status_ssd', 1)
                        ->where('pengajuan_biaya.status_atasan', 1)
                        ->where('pengajuan_biaya.status_som', 1)
                        ->where('pengajuan_biaya.status_claim', 1)
                        ->orWhere('pengajuan_biaya.status_validasi_ng', 0)
                        ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                        ->whereNotIn('pengajuan_biaya.status', ['9'])
                        ->where('pengajuan_biaya.status_ssd', 1)
                        ->where('pengajuan_biaya.status_atasan', 1)
                        ->where('pengajuan_biaya.status_som', 1)
                        ->where('pengajuan_biaya.status_claim', 1)
                        ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_validasi_ng = '0' THEN 0 WHEN pengajuan_biaya.status_validasi_ng = '1' THEN 1 ELSE 2 END"))
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();
            }elseif(Auth::user()->kode_divisi == '16'){ //-- Jika Biaya--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orWhere('pengajuan_biaya.status_validasi', 0)
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_validasi = '0' THEN 0 WHEN pengajuan_biaya.status_validasi = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }
        }
        

    	return view ('pengajuan.pengajuan_tiv_masuk.index', compact('approval_cost'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_perusahaan == 'ARS'){
            if(Auth::user()->kode_divisi == '2'){
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['137'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->orWhere('pengajuan_biaya.status_claim', 0)
                    ->WhereIn('pengajuan_biaya.kategori', ['137'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_claim = '0' THEN 0 WHEN pengajuan_biaya.status_claim = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }
        }else{
            if(Auth::user()->kode_divisi == '10'){ //-- Jika Koordinator Claim--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }elseif(Auth::user()->kode_divisi == '24'){ //-- Jika Koordinator Piutang--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Piutang--
                if(Auth::user()->kode_sub_divisi == '2'){
                    $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                                    'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->where('pengajuan_biaya.status_ssd', 1)
                    ->where('pengajuan_biaya.status_atasan', 1)
                    ->where('pengajuan_biaya.status_som', 1)
                    ->where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
                }else{
                    $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orWhere('pengajuan_biaya.status_validasi', 0)
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_validasi = '0' THEN 0 WHEN pengajuan_biaya.status_validasi = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
                }
                
            }elseif(Auth::user()->kode_divisi == '30'){ //-- Jika Koordinator Piutang--
                    $approval_cost = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                                'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng')
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                        ->whereNotIn('pengajuan_biaya.status', ['9'])
                        ->where('pengajuan_biaya.status_ssd', 1)
                        ->where('pengajuan_biaya.status_atasan', 1)
                        ->where('pengajuan_biaya.status_som', 1)
                        ->where('pengajuan_biaya.status_claim', 1)
                        ->orWhere('pengajuan_biaya.status_validasi_ng', 0)
                        ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
                        ->whereNotIn('pengajuan_biaya.status', ['9'])
                        ->where('pengajuan_biaya.status_ssd', 1)
                        ->where('pengajuan_biaya.status_atasan', 1)
                        ->where('pengajuan_biaya.status_som', 1)
                        ->where('pengajuan_biaya.status_claim', 1)
                        ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_validasi_ng = '0' THEN 0 WHEN pengajuan_biaya.status_validasi_ng = '1' THEN 1 ELSE 2 END"))
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();
            }elseif(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
                $approval_cost = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_ng')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orWhere('pengajuan_biaya.status_validasi', 0)
                    ->WhereIn('pengajuan_biaya.kategori',  ['43','118','119']) //Kode Gaji,mitra,BPJS,insentif
                    ->Where('pengajuan_biaya.status_claim', 1)
                    ->Where('pengajuan_biaya.status_piutang', 1)
                    ->Where('pengajuan_biaya.status_ng', 1)
                    ->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_validasi = '0' THEN 0 WHEN pengajuan_biaya.status_validasi = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }
        }
        
        return view ('pengajuan.pengajuan_tiv_masuk.index', compact('approval_cost'));
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
                        'pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_validasi','import_pencapaian_program_header.no_urut_pengajuan')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
            ->leftjoin('pengajuan_upload','pengajuan_biaya_detail.kode_pengajuan_b','=','pengajuan_upload.kode_pengajuan')
            ->select('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga',
                    'pengajuan_biaya_detail.status_detail_clm','pengajuan_biaya_detail.keterangan_detail_clm','pengajuan_biaya_detail.status_detail_piutang','pengajuan_biaya_detail.keterangan_detail_piutang','pengajuan_biaya_detail.status_detail_ng','pengajuan_biaya_detail.keterangan_detail_ng','pengajuan_biaya_detail.status_detail','pengajuan_biaya_detail.keterangan_detail',
                     DB::raw('COUNT(pengajuan_upload.filename) as jml_file'))
            ->where('pengajuan_biaya_detail.no_urut',$no_urut)
            ->groupBy('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga',
                    'pengajuan_biaya_detail.status_detail_clm','pengajuan_biaya_detail.keterangan_detail_clm','pengajuan_biaya_detail.status_detail_piutang','pengajuan_biaya_detail.keterangan_detail_piutang','pengajuan_biaya_detail.status_detail_ng','pengajuan_biaya_detail.keterangan_detail_ng','pengajuan_biaya_detail.status_detail','pengajuan_biaya_detail.keterangan_detail')
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

    	return view('pengajuan.pengajuan_Tiv_masuk.view', compact('pengajuan_biaya_head','pengajuan_biaya_detail','pengajuan_biaya_detail_total','pengajuan_biaya_upload','approval_upload'));
    }
	
	public function actionRekening(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('rekening_fin_comp')
                        ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                        ->where('rekening_fin_comp.norek','like','%'.$query.'%')
                        ->where('rekening_fin_comp.kode_perusahaan','like','%'.$query.'%')
                        ->where('banks.nama_bank','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('rekening_fin_comp')
                        ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih_rekening" data-norek="'.$row->norek.'" data-perusahaan="'.$row->kode_perusahaan.'" data-bank="'.$row->nama_bank.'" data-keterangan="'.$row->keterangan.'">
                        <td>'.$row->norek.'</td>
                        <td>'.$row->kode_perusahaan.'</td>
                        <td>'.$row->nama_bank.'</td>
                        <td>'.$row->keterangan.'</td>
                    </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="4">No Data Found</td>
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

    public function approved(Request $request)
    {
    	if(Auth::user()->kode_divisi == '6'){ //-- jika Biaya Pusat/Acc
            if(Auth::user()->kode_sub_divisi == '2'){ //--Jika piutang /
                
                $datas = [];
                foreach ($request->input('id_program') as $key => $value) {
                    
                }
        
                $validator = Validator::make($request->all(), $datas);
                    
                $no = 1;
                foreach ($request->input('id_program') as $key => $value) {
                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("id_program")[$key])
                            ->update([
                                'status_detail_piutang' => '1',
                                'id_user_detail_piutang' => Auth::user()->id,
                                'tgl_approval_detail_piutang' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_piutang' => $request->get("ket")[$key]
                            ]);
                    $no++;
                }  
        
                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi_piutang' => 1
                            ]);  
                    
                $output = [
                            'msg'  => 'Transaksi baru berhasil ditambah',
                            'res'  => true,
                            'type' => 'success'
                        ];
                return response()->json($output, 200);

            }else{ //Jika Akunting //

                $datas = [];
                foreach ($request->input('id_program') as $key => $value) {
                
                }

                $validator = Validator::make($request->all(), $datas);
                
                $no = 1;
                foreach ($request->input('id_program') as $key => $value) {
                    $approved = DB::table('pengajuan_biaya_detail')
                                ->Where('no_urut', request()->no_urut)
                                ->Where('description', $request->get("id_program")[$key])
                                ->update([
                                    'status_detail' => '1',
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
                
                $output = [
                                'msg'  => 'Transaksi baru berhasil ditambah',
                                'res'  => true,
                                'type' => 'success'
                ];
                return response()->json($output, 200); 

            }

            
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya
            $datas = [];
            foreach ($request->input('id_program') as $key => $value) {
               
            }

            $validator = Validator::make($request->all(), $datas);
            
            $no = 1;
            foreach ($request->input('id_program') as $key => $value) {
                $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("id_program")[$key])
                            ->update([
                                'status_detail' => '1',
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
            
            $output = [
                            'msg'  => 'Transaksi baru berhasil ditambah',
                            'res'  => true,
                            'type' => 'success'
            ];
            return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '5'){ //-- jika Finance
            $datas = [];
            foreach ($request->input('desc') as $key => $value) {
               
            }

            $validator = Validator::make($request->all(), $datas);
           
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
                                'status_detail_fin' => $chkd,
                                'id_user_detail_fin' => Auth::user()->id,
                                'tgl_approval_detail_fin' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_fin' => $request->get("ket")[$key]
                    ]);
                $no++;
                }  

                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi_fin' => 1
                            ]);  
           
        }elseif(Auth::user()->kode_divisi == '10'){ //-- jika claim
            $datas = [];
            foreach ($request->input('id_program') as $key => $value) {
               
            }

            $validator = Validator::make($request->all(), $datas);
            
                $no = 1;
                foreach ($request->input('id_program') as $key => $value) {
                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("id_program")[$key])
                            ->update([
                                'status_detail_clm' => '1',
                                'id_user_detail_clm' => Auth::user()->id,
                                'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_clm' => $request->get("ket")[$key]
                    ]);
                $no++;
                }  

                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi_clm' => 1
                            ]);  
            
                $output = [
                            'msg'  => 'Transaksi baru berhasil ditambah',
                            'res'  => true,
                            'type' => 'success'
                        ];
                return response()->json($output, 200);
        }elseif(Auth::user()->kode_divisi == '2'){ //-- jika claim ARS
                $datas = [];
                foreach ($request->input('id_program') as $key => $value) {
                   
                }
    
                $validator = Validator::make($request->all(), $datas);
                
                    $no = 1;
                    foreach ($request->input('id_program') as $key => $value) {
                        $approved = DB::table('pengajuan_biaya_detail')
                                ->Where('no_urut', request()->no_urut)
                                ->Where('description', $request->get("id_program")[$key])
                                ->update([
                                    'status_detail_clm' => '1',
                                    'id_user_detail_clm' => Auth::user()->id,
                                    'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                                    'keterangan_detail_clm' => $request->get("ket")[$key]
                        ]);
                    $no++;
                    }  
    
                    $approved_head = DB::table('pengajuan_biaya')
                                ->Where('no_urut', request()->no_urut)
                                ->update([
                                    'status_validasi_clm' => 1
                                ]);  
                
                    $output = [
                                'msg'  => 'Transaksi baru berhasil ditambah',
                                'res'  => true,
                                'type' => 'success'
                            ];
                    return response()->json($output, 200);

        }elseif(Auth::user()->kode_divisi == '24'){ //-- jika piutang
            $datas = [];
            foreach ($request->input('id_program') as $key => $value) {
                   
            }
    
            $validator = Validator::make($request->all(), $datas);
                
                $no = 1;
                foreach ($request->input('id_program') as $key => $value) {
                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("id_program")[$key])
                            ->update([
                                'status_detail_piutang' => '1',
                                'id_user_detail_piutang' => Auth::user()->id,
                                'tgl_approval_detail_piutang' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_piutang' => $request->get("ket")[$key]
                    ]);
                $no++;
                }  
    
                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi_piutang' => 1
                            ]);  
                
                $output = [
                            'msg'  => 'Transaksi baru berhasil ditambah',
                            'res'  => true,
                            'type' => 'success'
                        ];
                return response()->json($output, 200);
            
        }elseif(Auth::user()->kode_divisi == '30'){ //-- jika Non Gudang
            $datas = [];
            foreach ($request->input('id_program') as $key => $value) {
                       
            }
        
            $validator = Validator::make($request->all(), $datas);
                    
                $no = 1;
                foreach ($request->input('id_program') as $key => $value) {
                    $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', $request->get("id_program")[$key])
                            ->update([
                                'status_detail_ng' => '1',
                                'id_user_detail_ng' => Auth::user()->id,
                                'tgl_approval_detail_ng' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_ng' => $request->get("ket")[$key]
                    ]);
                $no++;
                }  
        
                $approved_head = DB::table('pengajuan_biaya')
                            ->Where('no_urut', request()->no_urut)
                            ->update([
                                'status_validasi_ng' => 1
                            ]);  
                    
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
            
        }

        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('pengajuan_tiv_masuk.index');
    }
	
	public function pending(Request $request)
    {
        //dd(Auth::user()->kode_divisi);

        if(Auth::user()->kode_divisi == '10' or Auth::user()->kode_divisi == '2'){ //-- jika CLAIM
            // $no_urut = request()->modal_no_urut;
            // $modal_kode_pengajuan_b = request()->modal_kode_pengajuan_b;
            // $modal_no_surat = request()->modal_no_surat;
            // $modal_id_program = request()->modal_id_program;
            $chk_ssd = $request->get('penerima_ssd');
            $chk_control = $request->get('penerima_control');

            if($chk_ssd == "SSD" && $chk_control == ""){
                //dd("1");
                $pending_ssd = DB::table('pengajuan_biaya')
                    ->Where('no_urut', request()->no_urut)
                    ->update([
                        //'status_ssd' => 4,
                        'status_validasi_clm' => 3,
                    ]);
					
				//================//
                $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', request()->modal_id_program)
                            ->update([
                                'status_detail_clm' => '3',
                                'id_user_detail_clm' => Auth::user()->id,
                                'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_clm' => request()->modal_keterangan_header
                            ]);
                //================//

                $pending_import = DB::table('import_pencapaian_program_header')
                    ->Where('no_surat', request()->modal_no_surat)
                    ->where('kode_perusahaan', request()->modal_kode_perusahaan)
                    ->update([
                        'status' => 3
                    ]);
            }elseif($chk_ssd == "" && $chk_control == "CLAIM CONTROLLER"){
                //dd("2");
                $pending = DB::table('pengajuan_biaya')
                    ->Where('no_urut', request()->no_urut)
                    ->update([
                        'status_validasi_clm' => 3,
                    ]);  
					
				//================//
                $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', request()->modal_id_program)
                            ->update([
                                'status_detail_clm' => '3',
                                'id_user_detail_clm' => Auth::user()->id,
                                'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_clm' => request()->modal_keterangan_header
                            ]);
                //================//
            }elseif($chk_ssd == "SSD" && $chk_control == "CLAIM CONTROLLER"){
                //dd("3");
                $pending_pengajuan = DB::table('pengajuan_biaya')
                    ->Where('no_urut', request()->no_urut)
                    ->update([
                        'status_validasi_clm' => 3,
                    ]);  
                
                $pending_ssd = DB::table('pengajuan_biaya')
                    ->Where('no_urut', request()->no_urut)
                    ->update([
                        //'status_ssd' => 4,
                        'status_validasi_clm' => 3,
                    ]);
					
				//================//
                $approved = DB::table('pengajuan_biaya_detail')
                            ->Where('no_urut', request()->no_urut)
                            ->Where('description', request()->modal_id_program)
                            ->update([
                                'status_detail_clm' => '3',
                                'id_user_detail_clm' => Auth::user()->id,
                                'tgl_approval_detail_clm' => Carbon::now()->format('Y-m-d'),
                                'keterangan_detail_clm' => request()->modal_keterangan_header
                            ]);
                //================//

                $pending_import = DB::table('import_pencapaian_program_header')
                    ->Where('no_surat', request()->modal_no_surat)
                    ->where('kode_perusahaan', request()->modal_kode_perusahaan)
                    ->update([
                        'status' => 3
                    ]);
            }
        }
        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('pengajuan_tiv_masuk.index');
    }

    public function store(Request $request)
    {
        set_time_limit(300);

        ini_set('max_execution_time', 300); // Waktu eksekusi
        ini_set('memory_limit', '512M'); // Memori yang lebih besar

        $kode_pengajuan = $request->kode_pengajuan;
        $no_surat = $request->no_surat;
		$no_urut_pengajuan = $request->no_urut_pengajuan;
        $perusahaan_detail = $request->perusahaan_detail;
        $id_toko = $request->id_toko;
        $piutang_depo = str_replace(",", "", $request->piutang_depo);
        $norek_depo = $request->norek_depo;
        $piutang_ng = str_replace(",", "", $request->piutang_ng);
        $norek_ng = $request->norek_ng;
        
        $cari_data = DB::table('pengajuan_biaya_claim_piutang')
            ->select('pengajuan_biaya_claim_piutang.kode_pengajuan_b')
            ->where('pengajuan_biaya_claim_piutang.kode_pengajuan_b', $kode_pengajuan);
        
        //if($cari_data->kode_pengajuan_b != null || $cari_data->kode_pengajuan_b != '')
        $rowCount = $cari_data->count();
        if($rowCount > 0) {
            for ($i=0; $i < count((array)$id_toko); $i++) {
				if($piutang_depo[$i] === ''){
                    $piutang_depo_1 = 0;
                }else{
                    $piutang_depo_1 = $piutang_depo[$i];
                }

                if($piutang_ng[$i] === ''){
                    $piutang_ng_1 = 0;
                }else{
                    $piutang_ng_1 = $piutang_ng[$i];
                }
                $simpan_update = DB::table('pengajuan_biaya_claim_piutang')
                            ->Where('pengajuan_biaya_claim_piutang.kode_pengajuan_b', $kode_pengajuan)
                            ->Where('pengajuan_biaya_claim_piutang.id_toko', $id_toko[$i])
                            ->update([
                                'piutang_depo' => $piutang_depo_1,
                                'norek_depo' => $norek_depo[$i],
                                'piutang_ng' => $piutang_ng_1,
                                'norek_ng' => $norek_ng[$i],
								'no_urut_pengajuan' => $no_urut_pengajuan
                            ]);
            }
        }else{
            for ($i=0; $i < count((array)$id_toko); $i++) {
				if($piutang_depo[$i] === ''){
                    $piutang_depo_1 = 0;
                }else{
                    $piutang_depo_1 = $piutang_depo[$i];
                }

                if($piutang_ng[$i] === ''){
                    $piutang_ng_1 = 0;
                }else{
                    $piutang_ng_1 = $piutang_ng[$i];
                }
                DB::table('pengajuan_biaya_claim_piutang')->insert([
                    'kode_pengajuan_b' => $kode_pengajuan,
                    'no_surat' => $no_surat,
                    'kode_perusahaan' => $perusahaan_detail[$i],
                    'id_toko' => $id_toko[$i],
                    'piutang_depo' => $piutang_depo_1,
                    'norek_depo' => $norek_depo[$i],
                    'piutang_ng' => $piutang_ng_1,
                    'norek_ng' => $norek_ng[$i],
					'no_urut_pengajuan' => $no_urut_pengajuan,
                    'id_user_input' => Auth::user()->id
                ]);
            }
        }
        
        $output = [
            'msg'  => 'Transaksi baru berhasil ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    }

}
