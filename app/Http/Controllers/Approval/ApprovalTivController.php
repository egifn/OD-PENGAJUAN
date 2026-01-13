<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Pengajuan_Biaya;
use App\Pengajuan_Biaya_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalTivController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_divisi == '10') { //-- Jika CLAIM--
            // $pengajuan_tiv = DB::table('pengajuan_biaya')
            //     ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            //     ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            //     ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            //     ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            //     ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            //     ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
            //     ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
            //     ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
            //     ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
            //     ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            //     ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
            //     ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
            //     ->Where('pengajuan_biaya_detail.status_detail_clm', 1)
            //     ->Where('pengajuan_biaya.status_validasi_clm', 1)
            //     ->orWhere('pengajuan_biaya.status_validasi_clm', 3)
            //     ->Where('pengajuan_biaya.kategori', 43)
            //     ->Where('pengajuan_biaya.status_atasan', 1)
            //     ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
            //     ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
            //     ->get();

            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('users AS users_claim','pengajuan_biaya_detail.id_user_detail_clm','=','users_claim.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->join('claim_surat_program','pengajuan_biaya.no_surat_program','=','claim_surat_program.no_surat')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','users_claim.name AS nama_user_claim','claim_surat_program.periode_awal','claim_surat_program.periode_akhir')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_clm', 1)
				->orWhere('pengajuan_biaya.status_claim', 0)
				->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_clm', 1)
				->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_claim = '0' THEN 0 WHEN pengajuan_biaya.status_claim = '1' THEN 1 ELSE 2 END"))
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '30'){ //-- Jika Non Gudang--
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_ng','pengajuan_biaya.status_validasi_ng')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_ng', 1)
				->orWhere('pengajuan_biaya.status_ng', 0)
				->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_ng', 1)
				->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_ng = '0' THEN 0 WHEN pengajuan_biaya.status_ng = '1' THEN 1 ELSE 2 END"))
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '24'){ //-- Jika Piutang-- 
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_piutang','pengajuan_biaya.status_validasi_piutang')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_piutang', 1)
				->orWhere('pengajuan_biaya.status_piutang', 0)
				->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_piutang', 1)
				->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_piutang = '0' THEN 0 WHEN pengajuan_biaya.status_piutang = '1' THEN 1 ELSE 2 END"))
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '16'){ //-- Jika Biaya/Cost--     
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_piutang','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_biaya')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Accounting--
            if(Auth::user()->kode_sub_divisi == '2'){ //-- Jika Piutang
                $pengajuan_tiv = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                            'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_validasi_piutang')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
					->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_validasi_piutang', 1)
                    ->Where('pengajuan_biaya.status_validasi_ng', 1)
					->Where('pengajuan_biaya.status_validasi', 1)
					->orWhere('pengajuan_biaya.status_biaya_pusat', 0)
					->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
					->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_validasi_piutang', 1)
                    ->Where('pengajuan_biaya.status_validasi_ng', 1)
					->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_biaya_pusat = '0' THEN 0 WHEN pengajuan_biaya.status_biaya_pusat = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }else{
                $pengajuan_tiv = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                            'pengajuan_biaya.status_validasi','pengajuan_biaya.status_biaya_pusat')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
					->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_validasi', 1)
                    ->Where('pengajuan_biaya.status_validasi_piutang', 1)
                    ->Where('pengajuan_biaya.status_validasi_ng', 1)
					->orWhere('pengajuan_biaya.status_biaya_pusat', 0)
					->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
					->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_validasi', 1)
                    ->Where('pengajuan_biaya.status_validasi_piutang', 1)
                    ->Where('pengajuan_biaya.status_validasi_ng', 1)
					->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_biaya_pusat = '0' THEN 0 WHEN pengajuan_biaya.status_biaya_pusat = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }
        }elseif(Auth::user()->kode_divisi == '0'){ //-- Jika Administrator--
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                ->Where('pengajuan_biaya.kategori', 43)
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }else{
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            
        }

        return view('approval.approval_tiv.index', compact('pengajuan_tiv'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_divisi == '10') { //-- Jika CLAIM--
            // $pengajuan_tiv = DB::table('pengajuan_biaya')
            //     ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            //     ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            //     ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            //     ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            //     ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            //     ->leftJoin('users as validator','pengajuan_biaya_detail.id_user_detail','=','validator.id')
            //     ->leftJoin('users as validator_acc','pengajuan_biaya_detail.id_user_detail_acc','=','validator_acc.id')
            //     ->leftJoin('users as validator_fin','pengajuan_biaya_detail.id_user_detail_fin','=','validator_fin.id')
            //     ->leftJoin('users as validator_clm','pengajuan_biaya_detail.id_user_detail_clm','=','validator_clm.id')
            //     ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            //     ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name as name_2','validator_acc.name as name_acc','validator_fin.name as name_fin','validator_clm.name as name_clm')
            //     //->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
            //     ->Where('pengajuan_biaya_detail.status_detail_clm', 1)
            //     ->Where('pengajuan_biaya.status_validasi_clm', 1)
            //     ->orWhere('pengajuan_biaya.status_validasi_clm', 3)                
            //     ->Where('pengajuan_biaya.kategori', 43)
            //     ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_claim','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','validator.name','validator_acc.name','validator_fin.name','validator_clm.name')
            //     ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
            //     ->get();

            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('users AS users_claim','pengajuan_biaya_detail.id_user_detail_clm','=','users_claim.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->join('claim_surat_program','pengajuan_biaya.no_surat_program','=','claim_surat_program.no_surat')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','users_claim.name AS nama_user_claim','claim_surat_program.periode_awal','claim_surat_program.periode_akhir')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_clm', 1)
				->orWhere('pengajuan_biaya.status_claim', 0)
				->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_clm', 1)
				->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_claim = '0' THEN 0 WHEN pengajuan_biaya.status_claim = '1' THEN 1 ELSE 2 END"))
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '30'){ //-- Jika Non Gudang--
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_ng','pengajuan_biaya.status_validasi_ng')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_ng', 1)
				->orWhere('pengajuan_biaya.status_ng', 0)
				->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_ng', 1)
				->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_ng = '0' THEN 0 WHEN pengajuan_biaya.status_ng = '1' THEN 1 ELSE 2 END"))
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '24'){ //-- Jika Piutang-- 
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_piutang','pengajuan_biaya.status_validasi_piutang')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_piutang', 1)
                ->orWhere('pengajuan_biaya.status_piutang', 0)
				->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi_piutang', 1)
				->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_piutang = '0' THEN 0 WHEN pengajuan_biaya.status_piutang = '1' THEN 1 ELSE 2 END"))
				->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '16'){ //-- Jika Biaya/Cost-- 
        	$pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_piutang','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_biaya')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Accounting--
        	if(Auth::user()->kode_sub_divisi == '2'){ //-- Jika Piutang
                $pengajuan_tiv = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                            'pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_validasi_piutang')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
					->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_validasi_piutang', 1)
					->Where('pengajuan_biaya.status_validasi', 1)
					->orWhere('pengajuan_biaya.status_biaya_pusat', 0)
					->WhereIn('pengajuan_biaya.kategori', ['43','118','119'])
					->whereNotIn('pengajuan_biaya.status', ['9'])
                    ->Where('pengajuan_biaya.status_validasi_piutang', 1)
					->Where('pengajuan_biaya.status_validasi', 1)
					->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_biaya_pusat = '0' THEN 0 WHEN pengajuan_biaya.status_biaya_pusat = '1' THEN 1 ELSE 2 END"))
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();
            }else{
                $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.kode_perusahaan_tujuan',
                        'pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.keterangan_app_ssd','pengajuan_biaya.no_urut','users.name',
                        'pengajuan_biaya.status_validasi','pengajuan_biaya.status_biaya_pusat')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi', 1)
				->orWhere('pengajuan_biaya.status_biaya_pusat', 0)
				->WhereIn('pengajuan_biaya.kategori', ['43','118','119','137'])
				->whereNotIn('pengajuan_biaya.status', ['9'])
                ->Where('pengajuan_biaya.status_validasi', 1)
				->orderBy(DB::raw("CASE WHEN pengajuan_biaya.status_biaya_pusat = '0' THEN 0 WHEN pengajuan_biaya.status_biaya_pusat = '1' THEN 1 ELSE 2 END"))
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
            }
        }elseif(Auth::user()->kode_divisi == '0'){ //-- Jika Administrator--
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                ->Where('pengajuan_biaya.kategori', 43)
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }else{
            $pengajuan_tiv = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();
        }

        return view('approval.approval_tiv.index', compact('pengajuan_tiv'));
    }

    public function view($no_urut)
    {
        $approval_pengajuan_tiv_head = DB::table('pengajuan_biaya')
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
                        'pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_ng','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_piutang','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $approval_pengajuan_tiv_detail = DB::table('pengajuan_biaya_detail')	
        	->Where('pengajuan_biaya_detail.no_urut', $no_urut)
        	->get();
			
		$approval_upload = DB::select("SELECT import_pencapaian_program_upload.filename
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_upload ON import_pencapaian_program_header.no_urut = import_pencapaian_program_upload.no_urut
            WHERE import_pencapaian_program_header.id_program = '$approval_pengajuan_tiv_head->id_program' 
            AND import_pencapaian_program_header.kode_perusahaan = '$approval_pengajuan_tiv_head->kode_perusahaan_tujuan'
            ");

        $approval_upload = DB::select("SELECT DISTINCT import_pencapaian_program_upload.filename
            FROM import_pencapaian_program_header
            INNER JOIN import_pencapaian_program_upload ON import_pencapaian_program_header.no_urut = import_pencapaian_program_upload.no_urut
            INNER JOIN import_pencapaian_program_detail ON import_pencapaian_program_header.no_urut = import_pencapaian_program_detail.no_urut
            WHERE import_pencapaian_program_header.id_program = '$approval_pengajuan_tiv_head->id_program' 
            AND import_pencapaian_program_header.kode_perusahaan = '$approval_pengajuan_tiv_head->kode_perusahaan_tujuan'
            AND import_pencapaian_program_detail.no_urut_pengajuan = '$no_urut'
            ");

        $approval_tiv_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $approval_pengajuan_tiv_head->kode_pengajuan_b)
            ->get();

        $total_jml = DB::table('pengajuan_biaya_detail')
                        ->select(DB::raw('SUM(pengajuan_biaya_detail.harga - pengajuan_biaya_detail.potongan) as ditransfer'))
                        ->where('pengajuan_biaya_detail.no_urut', $no_urut)
                        ->first();

        // if(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
        //     $total_jml =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)->Where('status_detail', 1)
        //                         ->get()->sum('tharga');
        // }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Koordinator ACC--
        //     $total_jml =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         ->Where('status_detail_acc', 1)
        //                         ->get()->sum('tharga');
        // }elseif(Auth::user()->kode_divisi == '5'){ //--jika FINANCE--
        //     $total_jml =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         ->Where('status_detail_fin', 1)
        //                         ->get()->sum('tharga');
        // }elseif(Auth::user()->kode_divisi == '10'){ //--jika CLAIM--
        //     $total_jml =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         ->Where('status_detail_clm', 1)
        //                         ->Where('status_detail', 1)
        //                         ->Where('status_detail_acc', 1)
        //                         ->get()->sum('tharga');
        // }else{
        //     $total_jml =  Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
        //                         ->get()->sum('tharga');
        // }

        return view('approval.approval_tiv.view', compact('approval_pengajuan_tiv_head','approval_pengajuan_tiv_detail','approval_tiv_upload','total_jml','approval_upload'));
    }

    public function approved(Request $request)
    {
        if(Auth::user()->kode_divisi == '10'){ //-- jika CLAIM
            $no_urut = request()->modal_no_urut;
            $kategori = request()->kategori_nama;

            if($kategori == 'Program Multi Produk'){
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_approval_claim' => Auth::user()->id,
                        'status_claim' => 1,
                        'tgl_approval_claim' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                        'status_ng' => 1,
                        'status_piutang' => 1,
                    ]);
            }else{
                $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_approval_claim' => Auth::user()->id,
                        'status_claim' => 1,
                        'tgl_approval_claim' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
            }

            
        }elseif(Auth::user()->kode_divisi == '30'){ //-- Non Gudang
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_approval_ng' => Auth::user()->id,
                        'status_ng' => 1,
                        'tgl_approval_ng' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '24'){ //-- Piutang
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_approval_piutang' => Auth::user()->id,
                        'status_piutang' => 1,
                        'tgl_approval_piutang' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '16'){ //-- Biaya COST
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_biaya' => 1,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '6'){ //-- jika ACC/Biaya Pusat
            $no_urut = request()->modal_no_urut;
        
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_biaya_pusat' => Auth::user()->id,
                        'status_biaya_pusat' => 1,
                        'tgl_approval_biaya_pusat' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }else{
            $no_urut = request()->modal_no_urut;
       
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 0,
                        'id_user_approval_atasan' => Auth::user()->id,
                        'status_atasan' => 1,
                        'tgl_approval_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }

        alert()->success('Success.','Request Approved...');
        return redirect()->route('approval_tiv.index');
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_divisi == '10'){ //-- jika CLAIM
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_approval_claim' => Auth::user()->id,
                        'status_claim' => 2,
                        'tgl_approval_claim' => Carbon::now()->format('Y-m-d'),
                        'kode_app_claim' => 'Ditolak',
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '30'){ //-- jika Non Gudang
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_approval_ng' => Auth::user()->id,
                        'status_ng' => 2,
                        'tgl_approval_ng' => Carbon::now()->format('Y-m-d'),
                        'kode_app_ng' => 'Ditolak',
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '24'){ //-- jika Piutang
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_approval_piutang' => Auth::user()->id,
                        'status_piutang' => 2,
                        'tgl_approval_piutang' => Carbon::now()->format('Y-m-d'),
                        'kode_app_piutang' => 'Ditolak',
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya/COST
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_biaya' => 2,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'kode_app_biaya' => 'Ditolak',
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '6'){ //-- jika ACC/Biaya Pusat
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 2,
                        'id_user_approval_biaya_pusat' => Auth::user()->id,
                        'status_biaya_pusat' => 2,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'kode_app_biaya_pusat' => 'Ditolak',
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }

        alert()->error('Oops...','Request Denied...');
        return redirect()->route('approval_tiv.index');
    }

    public function pending(Request $request)
    {
        if(Auth::user()->kode_divisi == '10'){ //-- jika Claim
            $no_urut = request()->modal_no_urut;
            
            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_approval_claim' => Auth::user()->id,
                        'status_claim' => 3,
                        'status_validasi_clm' => 3,
                        'tgl_approval_claim' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '30'){ //-- jika Non Gudang
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_approval_ng' => Auth::user()->id,
                        'status_ng' => 3,
                        'status_validasi_clm' => 3,
                        'tgl_approval_ng' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '24'){ //-- jika Piutang
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_approval_piutang' => Auth::user()->id,
                        'status_piutang' => 3,
                        'status_validasi_clm' => 3,
                        'tgl_approval_piutang' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '16'){ //-- jika Biaya?COST
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_user_approval_biaya' => Auth::user()->id,
                        'status_biaya' => 3,
                        'status_validasi' => 3,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }elseif(Auth::user()->kode_divisi == '6'){ //-- jika ACC/Biaya Pusat
            $no_urut = request()->modal_no_urut;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        'status' => 3,
                        'id_user_approval_biaya_pusat' => Auth::user()->id,
                        'status_biaya_pusat' => 3,
                        'status_validasi_acc' => 3,
                        'tgl_approval_biaya' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);
        }

        alert()->warning('Warning.','Request Pending...');
        return redirect()->route('approval_tiv.index');
    }
}
