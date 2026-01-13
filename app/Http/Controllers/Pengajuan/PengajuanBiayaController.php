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
/*use App\Pengajuan_Biaya_Pc;
use App\Pengajuan_Biaya_Pc_Detail;*/
use App\JurnalUmum;
use App\Imports\ImportGajiKaryawan;
use App\Imports\ImportPendapatanMitra;
use App\Imports\ImportBpjsKes;
use App\Imports\ImportBpjsTk;
use App\Imports\ImportInsentif;
use App\Imports\ImportThr;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Excel;


class PengajuanBiayaController extends Controller
{
    public function index()
    {   
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_divisi == '0') {
            $pengajuan_biaya = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();

                $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                    ->select('no_urut','description',
                            'status_detail','keterangan_detail',
                            'status_detail_atasan','keterangan_detail_atasan',
                            'status_detail_acc','keterangan_detail_acc')
                    ->get()
                    ->groupBy('no_urut');
        }else{
            if (Auth::user()->type == 'Manager') {
                if (Auth::user()->kode_depo == '002') { //jika Head Office
                    if (Auth::user()->kode_divisi == '5') { //jika kode_divisi Finance
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                        'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                        'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                        'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                        ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                        ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                        ->whereNotIn('users.kode_sub_divisi', ['7'])
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();

                        $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                        ->select('no_urut','description',
                                'status_detail','keterangan_detail',
                                'status_detail_atasan','keterangan_detail_atasan',
                                'status_detail_acc','keterangan_detail_acc')
                        ->get()
                        ->groupBy('no_urut');
                    // }elseif(Auth::user()->kode_divisi == '13') {

                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                        'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                        'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                        'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                        ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','140'])
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                        ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();

                        $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                        ->select('no_urut','description',
                                'status_detail','keterangan_detail',
                                'status_detail_atasan','keterangan_detail_atasan',
                                'status_detail_acc','keterangan_detail_acc')
                        ->get()
                        ->groupBy('no_urut');
                    }
                    
                }elseif (Auth::user()->kode_depo == '005') { // TGSM
                    $pengajuan_biaya = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                    'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                    'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                    'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                    ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                    ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                    ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();

                    $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                    ->select('no_urut','description',
                            'status_detail','keterangan_detail',
                            'status_detail_atasan','keterangan_detail_atasan',
                            'status_detail_acc','keterangan_detail_acc')
                    ->get()
                    ->groupBy('no_urut');
                }elseif (Auth::user()->kode_depo == '006') { // TGSM
                    $pengajuan_biaya = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                    'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                    'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                    'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                    ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                    ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                    ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();

                    $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                    ->select('no_urut','description',
                            'status_detail','keterangan_detail',
                            'status_detail_atasan','keterangan_detail_atasan',
                            'status_detail_acc','keterangan_detail_acc')
                    ->get()
                    ->groupBy('no_urut');
                }elseif (Auth::user()->kode_depo == '008') { // ARS
                    if (Auth::user()->kode_divisi == '13') {
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['137','140'])
                            ->WhereIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->where('pengajuan_biaya.status_biaya', 1)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }
                    
                }else{
                    if (Auth::user()->kode_divisi == '106') { //Jika Biaya Depo
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            //->Where('pengajuan_biaya.status_biaya', '1')
                            //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }elseif (Auth::user()->kode_divisi == '10') { //Jika claim
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            //->Where('pengajuan_biaya.status_biaya', '1')
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');    
                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.status_biaya', '1')
                            //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }
                    
                }
            }elseif (Auth::user()->type == 'Admin') {
                if (Auth::user()->kode_divisi == '13'){
                    if (Auth::user()->kode_sub_divisi == '12'){
                        if(Auth::user()->id_segmen == '3'){
                            $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['139'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                        }else{
                            $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['137','139','140'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                        }
                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['139'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }
                }else{
                    if(Auth::user()->id == '391' || Auth::user()->id == '698'){ //Jika Finance Bu Berliana 391
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->whereIn('users.kode_sub_divisi', ['7'])
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }else{
                        
                        
                            $pengajuan_biaya = DB::table('pengajuan_biaya')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                                'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                                'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                                'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                                ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                                ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.id_user_input', Auth::user()->id)
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
    
                                $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                                ->select('no_urut','description',
                                        'status_detail','keterangan_detail',
                                        'status_detail_atasan','keterangan_detail_atasan',
                                        'status_detail_acc','keterangan_detail_acc')
                                ->get()
                                ->groupBy('no_urut');
                        
                        
                    }
                }
            }
        }

        return view('pengajuan.pengajuan_biaya.index', compact('pengajuan_biaya','pengajuan_detail'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_divisi == '0') {
            $pengajuan_biaya = DB::table('pengajuan_biaya')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();

                $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                    ->select('no_urut','description',
                            'status_detail','keterangan_detail',
                            'status_detail_atasan','keterangan_detail_atasan',
                            'status_detail_acc','keterangan_detail_acc')
                    ->get()
                    ->groupBy('no_urut');
        }else{
            if (Auth::user()->type == 'Manager') {
                if (Auth::user()->kode_depo == '002') { //jika Head Office
                    if (Auth::user()->kode_divisi == '5') { //jika kode_divisi Finance
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                        'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                        'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                        'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                        ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                        ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                        ->WhereNotIn('users.kode_sub_divisi', ['7'])
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();

                        $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                        ->select('no_urut','description',
                                'status_detail','keterangan_detail',
                                'status_detail_atasan','keterangan_detail_atasan',
                                'status_detail_acc','keterangan_detail_acc')
                        ->get()
                        ->groupBy('no_urut');
                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                        'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                        'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                        'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                        ->WhereNotIn('pengajuan_biaya.kategori', ['43','137','140'])
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                        ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();

                        $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                        ->select('no_urut','description',
                                'status_detail','keterangan_detail',
                                'status_detail_atasan','keterangan_detail_atasan',
                                'status_detail_acc','keterangan_detail_acc')
                        ->get()
                        ->groupBy('no_urut');
                    }
                }elseif (Auth::user()->kode_depo == '005') { // TGSM
                    $pengajuan_biaya = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                    'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                    'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                    'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                    ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                    ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                    ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();

                    $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                    ->select('no_urut','description',
                            'status_detail','keterangan_detail',
                            'status_detail_atasan','keterangan_detail_atasan',
                            'status_detail_acc','keterangan_detail_acc')
                    ->get()
                    ->groupBy('no_urut');
                }elseif (Auth::user()->kode_depo == '006') { // TGSM
                    $pengajuan_biaya = DB::table('pengajuan_biaya')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                    'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                    'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                    'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                    ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                    ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                    ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                    ->get();

                    $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                    ->select('no_urut','description',
                            'status_detail','keterangan_detail',
                            'status_detail_atasan','keterangan_detail_atasan',
                            'status_detail_acc','keterangan_detail_acc')
                    ->get()
                    ->groupBy('no_urut');
                }elseif (Auth::user()->kode_depo == '008') { // ARS
                    if (Auth::user()->kode_divisi == '13') {
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['137','140'])
                            ->WhereIn('pengajuan_biaya.kode_perusahaan_tujuan', ['ARS'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->where('pengajuan_biaya.status_biaya', 1)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }
                }else{
                    if (Auth::user()->kode_divisi == '106') { //Jika Biaya Depo
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            //->Where('pengajuan_biaya.status_biaya', '1')
                            //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }elseif (Auth::user()->kode_divisi == '10') { //Jika Biaya Depo
                            $pengajuan_biaya = DB::table('pengajuan_biaya')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                                'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                                'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                                'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                                ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                                ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                                //->Where('pengajuan_biaya.status_biaya', '1')
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
    
                                $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                                ->select('no_urut','description',
                                        'status_detail','keterangan_detail',
                                        'status_detail_atasan','keterangan_detail_atasan',
                                        'status_detail_acc','keterangan_detail_acc')
                                ->get()
                                ->groupBy('no_urut');
                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.status_biaya', '1')
                            //->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();

                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }
                    
                }
            }elseif (Auth::user()->type == 'Admin') {
                if (Auth::user()->kode_divisi == '13'){
                    if (Auth::user()->kode_sub_divisi == '12'){
                        if(Auth::user()->id_segmen == '3'){
                            $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['139'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                        }else{
                            $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['137','139','140'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                        }
                    }else{
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereIn('pengajuan_biaya.kategori', ['137','140'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }
                    
                }else{
                    if(Auth::user()->id == '391' || Auth::user()->id == '698'){ //Jika Finance Bu Berliana
                        $pengajuan_biaya = DB::table('pengajuan_biaya')
                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                            'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                            'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                            'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                            ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                            ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                            ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                            ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                            ->WhereIn('users.kode_sub_divisi', ['7'])
                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                            ->get();
    
                            $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                            ->select('no_urut','description',
                                    'status_detail','keterangan_detail',
                                    'status_detail_atasan','keterangan_detail_atasan',
                                    'status_detail_acc','keterangan_detail_acc')
                            ->get()
                            ->groupBy('no_urut');
                    }else{
                            $pengajuan_biaya = DB::table('pengajuan_biaya')
                                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                                'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan as permintaan_pengajuan',
                                'ms_pengeluaran.sifat','pengajuan_biaya.status','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod',
                                'pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.no_urut','pengajuan_biaya.keterangan_approval')
                                ->WhereNotIn('pengajuan_biaya.kategori', ['43'])
                                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                ->Where('pengajuan_biaya.kode_perusahaan', Auth::user()->kode_perusahaan)
                                ->Where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                                ->Where('pengajuan_biaya.kode_divisi', Auth::user()->kode_divisi)
                                ->where('pengajuan_biaya.id_user_input', Auth::user()->id)
                                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                ->get();
    
                                $pengajuan_detail = DB::table('pengajuan_biaya_detail')
                                ->select('no_urut','description',
                                        'status_detail','keterangan_detail',
                                        'status_detail_atasan','keterangan_detail_atasan',
                                        'status_detail_acc','keterangan_detail_acc')
                                ->get()
                                ->groupBy('no_urut');
                        
                    }
                }
            }
        }

        return view('pengajuan.pengajuan_biaya.index', compact('pengajuan_biaya'));

    }

    public function view($no_urut)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','users.name','perusahaans.nama_perusahaan','depos.nama_depo',
                    'divisi.nama_divisi','pengajuan_biaya.keterangan as keterangan_pengajuan','ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.keterangan as keterangan_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','pengajuan_biaya.kategori')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
            ->leftjoin('pengajuan_upload','pengajuan_biaya_detail.kode_pengajuan_b','=','pengajuan_upload.kode_pengajuan')
            ->select('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.tharga',
                DB::raw('COUNT(pengajuan_upload.filename) as jml_file'),
                'pengajuan_biaya_detail.status_detail_atasan','pengajuan_biaya_detail.keterangan_detail_atasan',
                'pengajuan_biaya_detail.status_detail','pengajuan_biaya_detail.keterangan_detail',
                'pengajuan_biaya_detail.status_detail_acc','pengajuan_biaya_detail.keterangan_detail_acc',
                'pengajuan_biaya_detail.status_detail_ka_akunting','pengajuan_biaya_detail.keterangan_detail_ka_akunting'
                )
            ->where('pengajuan_biaya_detail.no_urut',$no_urut)
            ->groupBy('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.tharga',
                'pengajuan_biaya_detail.status_detail_atasan','pengajuan_biaya_detail.keterangan_detail_atasan',
                'pengajuan_biaya_detail.status_detail','pengajuan_biaya_detail.keterangan_detail',
                'pengajuan_biaya_detail.status_detail_acc','pengajuan_biaya_detail.keterangan_detail_acc',
                'pengajuan_biaya_detail.status_detail_ka_akunting','pengajuan_biaya_detail.keterangan_detail_ka_akunting')
            ->orderBy('pengajuan_biaya_detail.no_description_detail', 'ASC')
            ->get();

        $pengajuan_biaya_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $pengajuan_biaya_head->kode_pengajuan_b)
            ->orderBy('pengajuan_upload.no_description_detail', 'ASC')
            ->get();

        $pengajuan_biaya_detail_total = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');

        return view('pengajuan.pengajuan_biaya.view', compact('pengajuan_biaya_head','pengajuan_biaya_detail','pengajuan_biaya_detail_total','pengajuan_biaya_upload'));
    }

    public function view_approval($no_urut)
    {
        $data = DB::table('pengajuan_biaya')
                    ->leftjoin('users','pengajuan_biaya.id_user_approval_biaya_pusat','=','users.id')
                    ->leftjoin('users as user_1','pengajuan_biaya.id_user_approval_biaya','=','user_1.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b')
                    ->where('pengajuan_biaya.no_urut', $no_urut)
                    ->first();

        // $data_approval = DB::table('pengajuan_biaya')
        //             ->leftjoin('users','pengajuan_biaya.id_user_approval_biaya_pusat','=','users.id')
        //             ->leftjoin('users as user_1','pengajuan_biaya.id_user_approval_biaya','=','user_1.id')
        //             ->select('pengajuan_biaya.kode_pengajuan_b','users.name as biaya_pusat','user_1.name as biaya')
        //             ->where('pengajuan_biaya.no_urut', $no_urut)
        //             ->get();

        $data_approval = DB::table('pengajuan_biaya')
                        ->leftJoin('users as user_1','pengajuan_biaya.id_user_approval_biaya','=','user_1.id')
                        ->leftJoin('users','pengajuan_biaya.id_user_approval_atasan','=','users.id')
                        ->leftJoin('users as akunting','pengajuan_biaya.id_user_approval_biaya_pusat','=','akunting.id')
                        ->leftJoin('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                        ->leftJoin('users AS pic_akunting','pengajuan_biaya_detail.id_user_detail_acc','=','pic_akunting.id')
                        ->select('pengajuan_biaya.kode_pengajuan_b',
                                'user_1.name AS biaya',
                                'pengajuan_biaya.status_biaya',
                                'pengajuan_biaya.tgl_approval_biaya',
                                'pengajuan_biaya.kode_app_biaya',
                                DB::raw('(CASE WHEN pengajuan_biaya.status_biaya = "1" THEN "Approved" WHEN pengajuan_biaya.status_biaya = "2" THEN "Denied" WHEN pengajuan_biaya.status_biaya = "3" THEN "Pending" END) AS status_ket_biaya'),
                                'users.name AS ops',
                                'pengajuan_biaya.status_atasan',
                                'pengajuan_biaya.tgl_approval_atasan',
                                'pengajuan_biaya.kode_app_atasan',
                                DB::raw('(CASE WHEN pengajuan_biaya.status_atasan = "1" THEN "Approved" WHEN pengajuan_biaya.status_atasan = "2" THEN "Denied" WHEN pengajuan_biaya.status_atasan = "3" THEN "Pending" END) AS status_ket_atasan'),
                                'pic_akunting.name AS pic_akunting',
                                'pengajuan_biaya_detail.status_detail_acc',
                                'pengajuan_biaya_detail.tgl_approval_detail_acc',
                                DB::raw('(CASE WHEN pengajuan_biaya_detail.status_detail_acc = "1" THEN "Approved" WHEN pengajuan_biaya_detail.status_detail_acc = "2" THEN "Denied" WHEN pengajuan_biaya_detail.status_detail_acc = "3" THEN "Pending" END) AS status_ket_pic'),
                                'akunting.name AS akunting',
                                'pengajuan_biaya.status_biaya_pusat',
                                'pengajuan_biaya.tgl_approval_biaya_pusat',
                                'pengajuan_biaya.kode_app_biaya_pusat',
                                DB::raw('(CASE WHEN pengajuan_biaya.status_biaya_pusat = "1" THEN "Approved" WHEN pengajuan_biaya.status_biaya_pusat = "2" THEN "Denied" WHEN pengajuan_biaya.status_biaya_pusat = "3" THEN "Pending" END) AS status_ket_biaya_pusat'),
                                'pengajuan_biaya.kategori',
                                'pengajuan_biaya.status_buat_spp',
                                'pengajuan_biaya.no_spp',
                                'pengajuan_biaya.tgl_spp',
                                'pengajuan_biaya.no_urut'
                            )
                        ->where('pengajuan_biaya.no_urut', $no_urut)
                        ->groupBy(
                            'pengajuan_biaya.kode_pengajuan_b',
                                'user_1.name',
                                'pengajuan_biaya.status_biaya',
                                'pengajuan_biaya.tgl_approval_biaya',
                                'pengajuan_biaya.kode_app_biaya',
                            'users.name',
                                'pengajuan_biaya.status_atasan',
                                'pengajuan_biaya.tgl_approval_atasan',
                                'pengajuan_biaya.kode_app_atasan',
                            'pic_akunting.name',
                                'pengajuan_biaya_detail.status_detail_acc',
                                'pengajuan_biaya_detail.tgl_approval_detail_acc',
                            'akunting.name',
                                'pengajuan_biaya.status_biaya_pusat',
                                'pengajuan_biaya.tgl_approval_biaya_pusat',
                                'pengajuan_biaya.kode_app_biaya_pusat',
                            'pengajuan_biaya.kategori',
                            'pengajuan_biaya.status_buat_spp',
                            'pengajuan_biaya.no_spp',
                            'pengajuan_biaya.tgl_spp',
                            'pengajuan_biaya.no_urut'
                            )
                        ->get();

        return view('pengajuan.pengajuan_biaya.view_approval', compact('data','data_approval'));
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
                        ->Where('ms_pengeluaran.id','like','%'.$query.'%')
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
                        <tr class="pilih_category" data-id="'.$row->id.'" data-nama_pengeluaran="'.$row->nama_pengeluaran.'" data-sifat="'.$row->sifat.'" data-jenis="'.$row->jenis.'" data-pembayaran="'.$row->pembayaran.'" data-kategori="'.$row->kategori.'" >
                            <td>'.$row->id.'</td>
                            <td>'.$row->nama_pengeluaran.'</td>
                            <td>'.$row->sifat.'</td>
                            <td hidden>'.$row->jenis.'</td>
                            <td hidden>'.$row->pembayaran.'</td>
                            <td hidden>'.$row->kategori.'</td>
                            
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

    public function actionCoa(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                //$data = DB::table('coa_lv4')
                  //      ->WhereIn('coa_lv4.kode_lv3', ['200102600'])
                    //    ->Where('coa_lv4.kode_lv4','like','%'.$query.'%')
                      //  ->orWhere('coa_lv4.account_name','like','%'.$query.'%')
                        //->get();

                $data = DB::table('coa_transaksi')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                        ->select('coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->Where('coa_transaksi.no','like','%'.$query.'%')
                        ->orWhere('coa_transaksi.nama_transaksi','like','%'.$query.'%')
                        ->groupBy('coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
            }else{
                //$data = DB::table('coa_lv4')
                  //      ->WhereIn('coa_lv4.kode_lv3', ['200102600'])
                    //    ->get();

                $data = DB::table('coa_transaksi')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                         ->select('coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->groupBy('coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_coa" data-kode_coa="'.$row->no.'" data-coa="'.$row->nama_transaksi.'" data-debit="'.$row->debit_1.'" data-kredit="'.$row->kredit_1.'">
                            <td>'.$row->no.'</td>
                            <td>'.$row->nama_transaksi.'</td>
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

    public function ajax(Request $request) // dropdown perusahaan dan depo
    {
        $perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
    }

    public function create(Request $request)
    {
        //===================================================================
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        //$depo = Depo::orderBy('nama_depo','ASC')->get();
        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
        
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        return view('pengajuan.pengajuan_biaya.create', compact('perusahaan','depo','divisi'));
    }

    public function store(Request $request)
    {   
        set_time_limit(5000);
        ini_set('max_execution_time', 5000);

        // untuk import data excel //
        if($request->get('id_pengeluaran') == '1'){
            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new ImportGajiKaryawan, $file);
                // return redirect()->back()->with(['success' => 'Import success']);
            }
        }elseif($request->get('id_pengeluaran') == '2'){
            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new ImportPendapatanMitra, $file);
                // return redirect()->back()->with(['success' => 'Import success']);
            }
        }elseif($request->get('id_pengeluaran') == '3'){
            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new ImportBpjsKes, $file);
                // return redirect()->back()->with(['success' => 'Import success']);
            }
        }elseif($request->get('id_pengeluaran') == '4'){
            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new ImportBpjsTk, $file);
                // return redirect()->back()->with(['success' => 'Import success']);
            }
        }elseif($request->get('id_pengeluaran') == '5'){
            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new ImportInsentif, $file);
                // return redirect()->back()->with(['success' => 'Import success']);
            }
        }elseif($request->get('id_pengeluaran') == '25'){
            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new ImportThr, $file);
                // return redirect()->back()->with(['success' => 'Import success']);
            }
        }
        // end Import data excell //

        $this->validate($request, [

        ]);
        //----baru ------------------------------------------------//
        $tahun = date('Y', strtotime($request->get('tgl')));
        $bulan = date('m', strtotime($request->get('tgl')));
        // $tanggal = date('d', strtotime($request->get('tgl')));

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
         //----End baru ------------------------------------------------//

        //$kd_perusahaan = $request->get('kode_perusahaan');
        $kd_perusahaan_tujuan = $request->get('kode_perusahaan_tujuan');
        $kode_depo = $request->get('kode_depo');
        $kode_divisi = $request->get('kode_divisi');
        //$id_kat = $request->get('id_pengeluaran');

        

        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',$kode_depo)->first();

        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getRow = DB::table('pengajuan_biaya')
                    ->select(DB::raw('MAX(kode_pengajuan_b) as NoUrut'))
                    ->where('kode_perusahaan_tujuan', $kd_perusahaan_tujuan)
                    ->where('kode_depo', $kode_depo)
                    ->where('kode_divisi', $kode_divisi);
        $rowCount = $getRow->count();

        // dd($rowCount + 1);

            if($rowCount > 0){
                //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                if ($rowCount < 9) {
                    $no_pengajuan_biaya = 'REQ '.'B'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_pengajuan_biaya = 'REQ '.'B'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_pengajuan_biaya = 'REQ '.'B'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else {
                    $no_pengajuan_biaya = 'REQ '.'B'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                }
            }else{
                //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_pengajuan_biaya = 'REQ '.'B'.'0001'.'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            }

        $getRow = DB::table('pengajuan_biaya')->select(DB::raw('COUNT(kode_pengajuan_b) as NoUrut'))->first();
        if ($getRow->NoUrut > 0) {
            $no_urut = $getRow->NoUrut + 1;
        }else{
            $no_urut = 1;
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
            'status' => '0',
            'keterangan' => $request->get('ket'),
            'id_user_input' => Auth::user()->id,
            'no_urut' => $no_urut
        ]);

        $datas=[];
        foreach ($request->input("description") as $key => $value) {
            $datas["description.{$key}"] = 'required';
            //$datas["spek.{$key}"] = 'required'; 
            //$datas["qty.{$key}"] = 'required';
            //$datas["price.{$key}"] = 'required';
            $datas["total_price.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);

        //if($validator->passes()){
        foreach ($request->input("description") as $key => $value) {
            $data = new Pengajuan_Biaya_Detail;

            $data->kode_pengajuan_b = $no_pengajuan_biaya;
            $data->no_description_detail = $request->get("no_description_detail")[$key];
            $data->description = $request->get("description")[$key];
            $data->spesifikasi = $request->get("spek")[$key];
            $data->qty = $request->get("qty")[$key];
            $data->harga = str_replace(",", "", $request->get("price")[$key]); //$request->get("price")[$key];
            $data->jml_harga = str_replace(",", "", $request->get("total_price")[$key]); //$request->get("total_price")[$key];
            $data->tharga = str_replace(",", "", $request->get("total_price")[$key]); //$request->get("total_price")[$key];
            $data->no_urut = $no_urut;
            if($request->get("id_pengeluaran") == '1'){
                $data->status_detail = '1';
            }elseif($request->get("id_pengeluaran") == '2' ){
                $data->status_detail = '1';
            }elseif($request->get("id_pengeluaran") == '3' ){
                $data->status_detail = '1';
            }elseif($request->get("id_pengeluaran") == '4' ){
                $data->status_detail = '1';
            }elseif($request->get("id_pengeluaran") == '5' ){
                $data->status_detail = '1';
            }elseif($request->get("id_pengeluaran") == '6' ){
                $data->status_detail = '1';
            }elseif($request->get("id_pengeluaran") == '43' ){
                $data->status_detail = '1';
			}elseif($request->get("id_pengeluaran") == '130' ){
                $data->status_detail = '1';
            }
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
        }
        //} 
        //upload file
        // $no=1;
        // if($request->hasfile('filename')) { 
        //     foreach ($request->file('filename') as $file) {
        //         //select terlebih dahulu untuk mencari detail pengajuan//
        //         $data_description = DB::table('pengajuan_biaya_detail')
        //             ->select('pengajuan_biaya_detail.description')
        //             ->where('pengajuan_biaya_detail.kode_pengajuan_b', $no_pengajuan_biaya)
        //             ->where('pengajuan_biaya_detail.no_description_detail', $no)
        //             ->first();
        //         //End select terlebih dahulu untuk mencari detail pengajuan//

        //         if ($file->isValid()) {
        //             $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
        //             $file->move(public_path('images'), $filename);
                       
        //             Pengajuan_Upload::create([
        //                 'kode_pengajuan' => $no_pengajuan_biaya,
        //                 'no_description_detail' => $no,
        //                 'description' => $data_description->description,
        //                 'filename' => $filename
        //             ]);
        //         }
        //         $no++;
        //     }
        //     echo 'Success';
        // }else{
        //     echo 'Gagal';
        // }

        // JurnalUmum::create([
        //     'tgl' => Carbon::now()->format('Y-m-d'),
        //     'no_coa_transaksi' => $request->get('kode_coa'), 
        //     'kode_transaksi' => $no_pengajuan_biaya,
        //     'kode_account' => $request->get('debit'),
        //     'debit' => str_replace(",", "", $request->get('total')),
        //     'kredit' => '0' 
        // ]);

        // JurnalUmum::create([
        //     'tgl' => Carbon::now()->format('Y-m-d'),
        //     'no_coa_transaksi' => $request->get('kode_coa'), 
        //     'kode_transaksi' => $no_pengajuan_biaya,
        //     'kode_account' => $request->get('kredit'),
        //     'debit' => '0',
        //     'kredit' => str_replace(",", "", $request->get('total')) 
        // ]);

        alert()->success('Success.','New request has been created');
        return redirect()->route('pengajuan_biaya.index');
    }

    public function update(Request $request, $no_urut)
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        //$depo = Depo::orderBy('nama_depo','ASC')->get();
        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
        
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        $data_pengajuan = DB::table('pengajuan_biaya')
                        ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                        // ->leftJoin('jurnal_umum','pengajuan_biaya.kode_pengajuan_b','=','jurnal_umum.kode_transaksi')
                        // ->join('coa_transaksi','jurnal_umum.no_coa_transaksi','=','coa_transaksi.no')
                        ->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.coa','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.keterangan')
                        ->where('pengajuan_biaya.no_urut', $no_urut)
                        ->groupBy('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.coa','pengajuan_biaya.kode_perusahaan','pengajuan_biaya.kode_depo','pengajuan_biaya.kode_divisi','pengajuan_biaya.keterangan')
                        ->first();

        $data_detail = DB::table('pengajuan_biaya_detail')
            ->leftjoin('pengajuan_upload','pengajuan_biaya_detail.kode_pengajuan_b','=','pengajuan_upload.kode_pengajuan')
            ->select('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.tharga',
                DB::raw('COUNT(pengajuan_upload.filename) as jml_file'))
            ->where('pengajuan_biaya_detail.no_urut',$no_urut)
            ->groupBy('pengajuan_biaya_detail.kode_pengajuan_b','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.tharga')
            ->orderBy('pengajuan_biaya_detail.no_description_detail','ASC')
            ->get();

        $data_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $data_pengajuan->kode_pengajuan_b)
            ->orderBy('pengajuan_upload.no_description_detail','ASC')
            ->get();

        $data_total = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');

        return view ('pengajuan.pengajuan_biaya.edit', compact('perusahaan','depo','divisi','no_urut','data_pengajuan','data_detail','data_upload','data_total'));
    }

    public function edit(Request $request)
    {
        set_time_limit(5000);
        ini_set('max_execution_time', 5000);
        //cari status validasi//
        $cari_status_validasi = DB::table('pengajuan_biaya')
                                ->select('status_validasi','status_validasi_acc','status_validasi_ka_akunting','status_validasi_fin','status_validasi_clm')
                                ->where('kode_pengajuan_b', $request->get("kode_pengajuan_b"))
                                ->first();
        
        
        $approved = DB::table('pengajuan_biaya')->where('kode_pengajuan_b', $request->get("kode_pengajuan_b"))
                ->update([
                    'status' => 0,
                    'keterangan' => $request->get("ket"),
                    'status_atasan' => 0,
                    'status_biaya' => 0,
                    'status_biaya_pusat' => 0,
                    'status_validasi' => 0,
                    'status_validasi_acc' => 0,
                    'keterangan_approval' => '',
            ]);
        //End cari status validasi//

        // $hapus_detail = DB::table('pengajuan_biaya_detail')->Where('pengajuan_biaya_detail.kode_pengajuan_b', $request->get("kode_pengajuan_b"))->delete();
        // $hapus_data_upload = DB::table('pengajuan_upload')->Where('pengajuan_upload.kode_pengajuan', $request->get("kode_pengajuan_b"))->delete();

        $datas=[];
        foreach ($request->input('description') as $key => $value) {
                    
        }
        $validator = Validator::make($request->all(), $datas);
        //if($validator->passes()){
            foreach ($request->input("description") as $key => $value) {
                $approved = DB::table('pengajuan_biaya_detail')
                    ->where('kode_pengajuan_b', $request->get("kode_pengajuan_b"))
                    ->where('no_description_detail', $request->get("no_description_detail")[$key])
                    ->update([
                        'description' => $request->get("description")[$key],
                        'spesifikasi' => $request->get("spek")[$key],
                        'qty' => $request->get("qty")[$key],
                        'harga' => str_replace(",", "", $request->get("price")[$key]), //$request->get("price")[$key];
                        'jml_harga' => str_replace(",", "", $request->get("total_price")[$key]), //$request->get("total_price")[$key];
                        'tharga' => str_replace(",", "", $request->get("total_price")[$key]), //$request->get("total_price")[$key];
                        'keterangan_detail_atasan' => '',

                        'status_detail_atasan' => 0,
                        'tgl_approval_detail_atasan' => Carbon::now()->format('Y-m-d'),
                        'keterangan_detail_atasan' => '',

                        'status_detail' => 0,
                        'tgl_approval_detail' => Carbon::now()->format('Y-m-d'),
                        'keterangan_detail' => '',

                        'status_detail_acc' => 0,
                        'tgl_approval_detail_acc' => Carbon::now()->format('Y-m-d'),
                        'keterangan_detail_acc' => ''
                ]);
                //======================
            }
        //}

        //upload file
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

        alert()->success('Success.','Edit Pengajuan berhasil.');
        return redirect()->route('pengajuan_biaya.index');
    }

    public function pdf($no_urut)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->leftjoin('users','pengajuan_biaya.id_user_input','=','users.id')
            ->leftjoin('users as kabiayadepo','pengajuan_biaya.id_user_approval_biaya','kabiayadepo.id')
            ->leftjoin('users as kabiayaho','pengajuan_biaya.id_user_approval_biaya_pusat','kabiayaho.id')
            ->leftjoin('users as kaopsdepo','pengajuan_biaya.id_user_approval_atasan','kaopsdepo.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            ->leftjoin('users as picho','pengajuan_biaya_detail.id_user_detail_acc','=','picho.id')
            ->select('ms_pengeluaran.sifat','pengajuan_biaya.kode_pengajuan_b','users.name','divisi.nama_divisi',
                    'kabiayadepo.name as atasan','depos.nama_depo','pengajuan_biaya.tgl_pengajuan_b','ms_pengeluaran.keterangan',
                    'pengajuan_biaya.kode_app_biaya',
                    'kabiayaho.name as kabiayaho','pengajuan_biaya.tgl_approval_biaya_pusat','pengajuan_biaya.kode_app_biaya_pusat',
                    'kaopsdepo.name as kaopsdepo','pengajuan_biaya.tgl_approval_atasan','pengajuan_biaya.kode_app_atasan',
                    'picho.name as picho','pengajuan_biaya_detail.tgl_approval_detail_acc'
                    )
            ->where('pengajuan_biaya.no_urut', $no_urut)
            ->groupby('ms_pengeluaran.sifat','pengajuan_biaya.kode_pengajuan_b','users.name','divisi.nama_divisi',
                    'kabiayadepo.name','depos.nama_depo','pengajuan_biaya.tgl_pengajuan_b','ms_pengeluaran.keterangan',
                    'pengajuan_biaya.kode_app_biaya',
                    'kabiayaho.name','pengajuan_biaya.tgl_approval_biaya_pusat','pengajuan_biaya.kode_app_biaya_pusat',
                    'kaopsdepo.name','pengajuan_biaya.tgl_approval_atasan','pengajuan_biaya.kode_app_atasan',
                    'picho.name','pengajuan_biaya_detail.tgl_approval_detail_acc')
            ->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
            ->where('pengajuan_biaya_detail.no_urut',$no_urut)
            ->orderBy('pengajuan_biaya_detail.no_description_detail', 'ASC')
            ->get();

        $total_jml = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
            //->where('status_detail', 1)
            ->get()->sum('tharga');
                                

        $pdf = PDF::loadview('pengajuan.pengajuan_biaya.pdf', compact('pengajuan_biaya_head','pengajuan_biaya_detail','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function pdf_new($no_urut)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan_tujuan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->leftJoin('users AS user_atasan','pengajuan_biaya.id_user_approval_atasan','=','user_atasan.id')
            ->leftJoin('users AS user_pic ',' pengajuan_biaya_detail.id_user_detail_acc','=','user_pic.id')
            ->leftJoin('users AS user_biaya_pusat ',' pengajuan_biaya.id_user_approval_biaya_pusat','=','user_biaya_pusat.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.keterangan','pengajuan_biaya.tgl_pengajuan_b','ms_pengeluaran.sifat','perusahaans.nama_perusahaan',
                     'pengajuan_biaya.id_user_input','users.name',
                     'pengajuan_biaya.kode_app_atasan',
                     'pengajuan_biaya.id_user_approval_atasan',
                        'user_atasan.name AS nama_atasan',
                        'pengajuan_biaya_detail.id_user_detail_acc',
                        'user_pic.name AS nama_pic',
                        'pengajuan_biaya.kode_app_biaya_pusat',
                        'pengajuan_biaya.id_user_approval_biaya_pusat',
                        'user_biaya_pusat.name AS nama_biaya_pusat')
            ->groupBy(
                'pengajuan_biaya.kode_pengajuan_b',
                'pengajuan_biaya.keterangan',
                'pengajuan_biaya.tgl_pengajuan_b',
                'ms_pengeluaran.sifat',
                'perusahaans.nama_perusahaan',
                'pengajuan_biaya.id_user_input',
                'users.name',
                'pengajuan_biaya.kode_app_atasan',
                'pengajuan_biaya.id_user_approval_atasan',
                'user_atasan.name',
                'pengajuan_biaya_detail.id_user_detail_acc',
                'user_pic.name',
                'pengajuan_biaya.kode_app_biaya_pusat',
                'pengajuan_biaya.id_user_approval_biaya_pusat',
                'user_biaya_pusat.name'
            )
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')
            ->where('pengajuan_biaya_detail.no_urut',$no_urut)
            ->orderBy('pengajuan_biaya_detail.no_description_detail', 'ASC')
            ->get();

        $total_jml = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');
                                

        $pdf = PDF::loadview('pengajuan.pengajuan_biaya.pdf_new', compact('pengajuan_biaya_head','pengajuan_biaya_detail','total_jml'))->setPaper('a4', 'portrait');
        return $pdf->stream();
    }
}
