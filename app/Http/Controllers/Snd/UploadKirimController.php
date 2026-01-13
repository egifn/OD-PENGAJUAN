<?php

namespace App\Http\Controllers\Snd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Depo;
use App\Claim_Surat_Program_Detail;
use App\Claim_Upload_Surat_Program;
use App\Claim_Upload_Surat_Program_Depo;
use App\Imports\ImportDataProgramTiv;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;
use Excel;
use Barryvdh\DomPDF\Facade as PDF;

class UploadKirimController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $tanggalSekarang = Carbon::now();

        if(Auth::user()->kode_divisi == '13') { //SND
            if (Auth::user()->kode_sub_divisi == '12') { //SSD
                if(Auth::user()->id_segmen == '11') { //Jika  All Segmen
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        //->where('claim_surat_program.segmen', Auth::user()->id_segmen)
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->get();
                }elseif(Auth::user()->id_segmen == '7') { //Jika  SO
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->where(function ($query) {
                            $query->where('claim_surat_program.segmen', 'like', '%7%')
                                  ->orWhere('claim_surat_program.segmen', 'like', '%10%');
                        })
                        ->where(function($data_claim){
                            $data_claim->where('claim_surat_program.sku', 'like', '%Beverage%')
                                        ->orWhere('claim_surat_program.sku', 'like', '%SPS%')
										->orWhere('claim_surat_program.sku', 'like', '%MIX%');
                        })
                        ->get();
                }elseif(Auth::user()->id_segmen == '9') { //Jika WS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->where(function ($query) {
                            $query->where('claim_surat_program.segmen', 'like', '%9%')
                                  ->orWhere('claim_surat_program.segmen', 'like', '%10%');
                        })
                        ->where(function($data_claim){
                            $data_claim->where('claim_surat_program.sku', 'like', '%Beverage%')
                                        ->orWhere('claim_surat_program.sku', 'like', '%SPS%')
										->orWhere('claim_surat_program.sku', 'like', '%MIX%');
                        })
                        ->get();
                }elseif(Auth::user()->id_segmen == '10') { //Jika SO/WS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->where('claim_surat_program.sku', 'like', '%Jugs%')
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->where(function ($query) {
                            $query->where('claim_surat_program.sku', 'like', '%Jugs%')
                                  ->orWhere('claim_surat_program.sku', 'like', '%MIX%');
                        })
						->where(function($data_claim){
                            $data_claim->where('claim_surat_program.segmen', 'LIKE', '%7%')
                                        ->orWhere('claim_surat_program.segmen', 'LIKE', '%9%')
                                        ->orWhere('claim_surat_program.segmen', 'LIKE', '%10%');
                        })
                        ->get();
				}elseif(Auth::user()->id_segmen == '4') { //IOD/AFH
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->where('claim_surat_program.sku', 'like', '%Jugs%')
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
						->where(function($data_claim){
                            $data_claim->where('claim_surat_program.segmen', 'LIKE', '%4%')
                                        ->orWhere('claim_surat_program.segmen', 'LIKE', '%2%');
                        })
                        ->get();
                }else{
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->where('claim_surat_program.sku', 'like', '%' . Auth::user()->id_kategori_sku . '%')
                        ->where(function($data_claim){
                            $data_claim->where('claim_surat_program.segmen', 'like', '%' . Auth::user()->id_segmen . '%');
                        })
                        ->get();
                }
            }elseif(Auth::user()->kode_sub_divisi == '16') { //SOM
                $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_som')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->get();
    
            }elseif(Auth::user()->kode_sub_divisi == '13') { //ASM
                if(Auth::user()->id_area == '1') { // CIKAMAJAKU
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['260', '261', '262', '263', '267', '033', '341', '920', '036', '919'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        ->get();
                }elseif(Auth::user()->id_area == '2') { // PPJS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['264', '265', '266', '344', '335', '908', '910', '344'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        ->get();
                }elseif(Auth::user()->id_area == '3') { // GATARIPA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['268', '269', '270', '271', '032', '916', '917', '031'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        ->get();
                }elseif(Auth::user()->id_area == '4') { // BOPACIS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['280', '281', '282', '283', '289', '337', '901', '342', '915', '925','290'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        ->get();
                }elseif(Auth::user()->id_area == '5') { // SUCI
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['284', '285', '287', '906', '911', '021'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        ->get();
                }elseif(Auth::user()->id_area == '6') { // Bandung KAB
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        ->get();
                }elseif(Auth::user()->id_area == '7') { // Bandung KOTA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['902', '900', '029', '030','343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm')
                        ->get();
                }
            }elseif(Auth::user()->kode_sub_divisi == '14') { //KPJ
                
                    $data_claim = DB::table('claim_surat_program')
                            ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                            ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                            ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                            ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                            'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                            'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                            'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                            'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_kpj')
                            //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                            ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                            ->where('claim_surat_program.status_approval_ssd', 1)
                            ->where('claim_surat_program.status_approval_manager', 1)
                            ->where('claim_surat_program.status_approval_som', 1)
                            ->where('claim_surat_program.jenis_surat', 'Eksternal')
                            ->whereNotIn('claim_surat_program.sku', ['None'])
                            ->get();
                
            }elseif(Auth::user()->kode_sub_divisi == '15') { //SPV
                $data_claim = DB::table('claim_surat_program')
                         ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                        ->where('claim_surat_program.segmen', Auth::user()->id_segmen)
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->get();

            }else{ //Andmin SSD dan Manager SSD
                if (Auth::user()->type == 'Admin') { //SSD
                    if (Auth::user()->id_segmen == '5') {
                        $data_claim = DB::table('claim_surat_program')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                            ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                            ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                            'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                            'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                            'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                            'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                            // ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                            ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                            ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                            ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                            ->where('claim_surat_program.segmen', 'LIKE', '%5%')
                            ->get();
                    }else{
                        $data_claim = DB::table('claim_surat_program')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                            ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                            ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                            'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                            'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                            'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                            'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                            // ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                            ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                            ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                            ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                            ->get();
                    }
                }elseif (Auth::user()->type == 'Manager'){
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_manager')
                        // ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->get();
                }
            }
        }elseif(Auth::user()->kode_divisi == '18' or Auth::user()->kode_divisi == '6' or Auth::user()->kode_divisi == '23' or Auth::user()->kode_divisi == '30' or Auth::user()->kode_divisi == '24' or Auth::user()->kode_divisi == '2' or Auth::user()->kode_divisi == '10') { 
            //Jika Jika Audit, akunting, korsis, koordinator admin distribusi, Non Gudang, piutang (bu fitri), claim, kops 
            $data_claim = DB::table('claim_surat_program')
                ->join('users','claim_surat_program.id_user_input','=','users.id')
                ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                ->where('claim_surat_program.status_approval_ssd', 1)
                ->where('claim_surat_program.status_approval_manager',1)
                ->where('claim_surat_program.status_approval_som', 1)
                ->get();
        }
        return view ('snd.upload_kirim.index', compact('data_claim','tanggalSekarang')); 
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_divisi == '13') { //SND
            if (Auth::user()->kode_sub_divisi == '12') { //SSD
                if(Auth::user()->id_segmen == '7') { //Jika  SO
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->whereIn('claim_surat_program.segmen', ['7','10'])
                        ->get();
                }elseif(Auth::user()->id_segmen == '9') { //Jika  WS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->whereIn('claim_surat_program.segmen', ['9','10'])
                        ->get();
                }else{
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->where('claim_surat_program.segmen', Auth::user()->id_segmen)
                        ->get();
                }
                // $data_claim = DB::table('claim_surat_program')
                //         ->join('users','claim_surat_program.id_user_input','=','users.id')
                //         ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                //         ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                //         ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                //         ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                //         ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                //         'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                //         'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                //         'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                //         'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                //         'claim_surat_program.status_approval_ssd')
                //         ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                //         ->where('claim_surat_program.segmen', Auth::user()->id_segmen)
                //         ->get();

            }elseif(Auth::user()->kode_sub_divisi == '16') { //SOM
                $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->get();

            }elseif(Auth::user()->kode_sub_divisi == '13') { //ASM
                if(Auth::user()->id_area == '1') { // CIKAMAJAKU
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['260', '261', '262', '263', '267', '033', '341', '920', '036', '919'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->get();
                }elseif(Auth::user()->id_area == '2') { // PPJS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['264', '265', '266', '344', '335', '908', '910', '344'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->get();
                }elseif(Auth::user()->id_area == '3') { // GATARIPA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['268', '269', '270', '271', '032', '916', '917', '031'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->get();
                }elseif(Auth::user()->id_area == '4') { // BOPACIS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['280', '281', '282', '283', '289', '337', '901', '342', '915', '925','290'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->get();
                }elseif(Auth::user()->id_area == '5') { // SUCI
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['284', '285', '287', '906', '911', '021'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->get();
                }elseif(Auth::user()->id_area == '6') { // Bandung KAB
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->get();
                }elseif(Auth::user()->id_area == '7') { // Bandung KOTA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        //->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['902', '900', '029', '030','343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->get();
                }

            }elseif(Auth::user()->kode_sub_divisi == '14') { //KPJ
                $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->get();

            }elseif(Auth::user()->kode_sub_divisi == '15') { //SPV
                $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                        ->where('claim_surat_program.segmen', Auth::user()->id_segmen)
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->get();

            }else{ //Andmin SSD dan Manager SSD
                if (Auth::user()->type == 'Admin') { //SSD
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->get();
                }elseif (Auth::user()->type == 'Manager'){
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_manager')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->get();
                }
            }
        }elseif(Auth::user()->kode_divisi == '18' or Auth::user()->kode_divisi == '6' or Auth::user()->kode_divisi == '23' or Auth::user()->kode_divisi == '30' or Auth::user()->kode_divisi == '24' or Auth::user()->kode_divisi == '2' or Auth::user()->kode_divisi == '10') { 
            //Jika Jika Audit, akunting, korsis, koordinator admin distribusi, Non Gudang, piutang (bu fitri), claim, kops 
            $data_claim = DB::table('claim_surat_program')
                ->join('users','claim_surat_program.id_user_input','=','users.id')
                ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                ->where('claim_surat_program.status_approval_ssd', 1)
                ->where('claim_surat_program.status_approval_manager',1)
                ->where('claim_surat_program.status_approval_som', 1)
                ->get();
        }

        return view ('snd.upload_kirim.index', compact('data_claim'));
    }

    public function create(Request $request)
    {
        //Kode Surat//
        $tahun = (date('Y'));
        $bulan = (date('m'));

        if ($bulan == '01'){
            $bulan_romawi = 'I';
            $nama_bulan = 'Januari'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
            $nama_bulan = 'Februari';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
            $nama_bulan = 'Maret';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
            $nama_bulan = 'April';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
            $nama_bulan = 'Mei';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
            $nama_bulan = 'Juni';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
            $nama_bulan = 'Juli';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
            $nama_bulan = 'Agustus';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
            $nama_bulan = 'September';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
            $nama_bulan = 'Oktober';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
            $nama_bulan = 'November';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
            $nama_bulan = 'Desember';
        }

        $kode_divisi = Auth::user()->kode_divisi;
        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getRow = DB::table('claim_surat_program')
                    ->select(DB::raw('MAX(no_surat) as NoUrut'));
        $rowCount = $getRow->count();

        $getRowMin = DB::table('claim_surat_program')
                    ->select('claim_surat_program.no_surat as min')
                    ->where('claim_surat_program.no_surat', '-');
        $rowCountMin = $getRowMin->count();

        $jenis_surat = $request->jenis_surat;
        
        if($jenis_surat == 'Eksternal'){
            if($rowCount > 0){
                if ($rowCount < 9) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                } else {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                }
            }else{
                //$no_surat = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_surat = '730'.'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'EP'.'/'.$tahun;
            }
        }else{
            if($rowCount > 0){
                if ($rowCount < 9) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                } else {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
                }
            }else{
                //$no_surat = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_surat = '730'.'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'...'.'/'.$tahun;
            }
        }
      
        //=========//

        $bulan = date('m', strtotime($request->get('tgl')));
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $sku = DB::table('dt_sku')->get();
        $segmen = DB::table('dt_segment')->get();

        $kode_depo_ta = DB::table('depos')->where('kode_perusahaan', 'WPS')->whereNotNull('area')->orderBy('area', 'ASC')->get();
        $kode_depo_tu = DB::table('depos')->where('kode_perusahaan', 'LP')->whereNotNull('area')->orderBy('area', 'ASC')->get();
        $kode_depo_tua = DB::table('depos')->where('kode_perusahaan', 'TUA')->whereNotNull('area')->orderBy('area', 'ASC')->get();

        return view('snd.upload_kirim.create', compact('sku','segmen','kode_depo_ta','kode_depo_tu','kode_depo_tua','no_surat'));
    }

    public function store(Request $request)
    {
        $tahun = (date('Y'));
        $bulan = (date('m'));

        if ($bulan == '01'){
            $bulan_romawi = 'I';
            $nama_bulan = 'Januari'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
            $nama_bulan = 'Februari';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
            $nama_bulan = 'Maret';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
            $nama_bulan = 'April';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
            $nama_bulan = 'Mei';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
            $nama_bulan = 'Juni';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
            $nama_bulan = 'Juli';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
            $nama_bulan = 'Agustus';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
            $nama_bulan = 'September';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
            $nama_bulan = 'Oktober';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
            $nama_bulan = 'November';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
            $nama_bulan = 'Desember';
        }

        $kode_divisi = Auth::user()->kode_divisi;
        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getRow = DB::table('claim_surat_program')
                    ->select(DB::raw('MAX(no_surat) as NoUrut'));
        $rowCount = $getRow->count();

        $getRowMin = DB::table('claim_surat_program')
                    ->select('claim_surat_program.no_surat as min')
                    ->where('claim_surat_program.no_surat', '-');
        $rowCountMin = $getRowMin->count();

        $jenis_surat = $request->get('jenis_surat');
        
        if($jenis_surat == 'Eksternal'){
            if($rowCount > 0){
                if ($rowCount < 9) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'EP'.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'EP'.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'EP'.'/'.$tahun;
                } else {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'EP'.'/'.$tahun;
                }
            }else{
                //$no_surat = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_surat = '730'.'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'EP'.'/'.$tahun;
            }
        }else{
            if($rowCount > 0){
                if ($rowCount < 9) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'IP'.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'IP'.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'IP'.'/'.$tahun;
                } else {
                    $no_surat = ($rowCount + 730 - $rowCountMin).'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'IP'.'/'.$tahun;
                }
            }else{
                //$no_surat = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_surat = '730'.'/'.$bulan_romawi.'/'.$alias_divisi->alias.'-'.'HO'.'/'.'IP'.'/'.$tahun;
            }
        }

        $cari_no_urut = DB::table('claim_surat_program')->select(DB::raw('COUNT(no_surat) as NoUrut'))->first();
        if ($cari_no_urut->NoUrut > 0) {
            $no_urut = $cari_no_urut->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        if($request->get('surat_dist') == 0){ //jika Surat Distributor Tidak
            $no_surat = '-';
        }

        //ubah data array ke string
        $skuAsString = json_encode($request->get('sku'));
        $segmenAsString = json_encode($request->get('segmen'));

        DB::table('claim_surat_program')->insert([
            'no_surat' => $request->get('no_surat'), //$no_surat,
        	'tgl_upload_kirim' => Carbon::now()->format('Y-m-d'),
        	'id_user_input' => $request->get('id_user_input'),
        	'kode_perusahaan_user' => $request->get('kode_perusahaan_user'),
        	'kode_depo_user' => $request->get('kode_depo_user'),
        	'kode_divisi_user' => $request->get('kode_divisi_user'),
        	'jenis_surat' => $request->get('jenis_surat'),
        	'id_program' => $request->get('id_program_tiv'),
        	'nama_program' => $request->get('nama_program_distributor'),
            'jml_peserta' => $request->get('jml_peserta'),
        	'periode_awal' => $request->get('periode_awal'),
            'periode_akhir' => $request->get('periode_akhir'),
        	'penerima' => $request->get('penerima'),
        	'kategori' => $request->get('kategori'),
            'sku' => $skuAsString,
            'segmen' => $segmenAsString,
            'no_urut' =>  $no_urut
        ]);

        //upload file Surat Program dari TIV===============================================================================
        if($request->hasfile('filename_tiv')) { 
            foreach ($request->file('filename_tiv') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);
                       
                    Claim_Upload_Surat_Program::create([
                        'no_surat' => $request->get('no_surat'), //$no_surat,
                        'filename_upload' => $filename,
                        'no_urut_kode' => $no_urut,
                        'keterangan' => 'Surat Program'
                    ]);
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }
        //=================================================================================================================

        //upload file Lain lain============================================================================================
        if($request->hasfile('filename_tiv_lain')) { 
            foreach ($request->file('filename_tiv_lain') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);
                       
                    Claim_Upload_Surat_Program::create([
                        'no_surat' => $request->get('no_surat'), //$no_surat,
                        'filename_upload' => $filename,
                        'no_urut_kode' => $no_urut,
                        'keterangan' => 'Pendukung'
                    ]);
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }
        //==================================================================================================================

        if($request->get('surat_dist') == 1) { //Jika surat distributor iya
            // =========== Depo TA =========================================//
            $datas=[];
            foreach ($request->input('id_depo_ta') as $key => $value) {
                    
            }
            $validator = Validator::make($request->all(), $datas);
            foreach ($request->input("id_depo_ta") as $key => $value) {
                if($request->get("id_depo_ta")[$key] == '222'){
                    $cari_depo_ta = DB::table('depos')
                                ->select('depos.kode_depo')
                                ->where('depos.kode_perusahaan', 'WPS')
                                ->whereIn('depos.area', ['GATARIPA','CIKAMAJAKU','PPJS'])
                                ->get();
                    foreach ($cari_depo_ta as $item_ta) {
                        $data = new Claim_Surat_Program_Detail;

                        $data->no_surat = $request->get('no_surat'); //$no_surat;
                        $data->kode_perusahaan = $request->get("id_perusahaan_ta");
                        $data->kode_depo = $item_ta->kode_depo;
                        $data->no_urut = $no_urut;
                        
                        $data->save();
                    }            
                }else{
                    $data = new Claim_Surat_Program_Detail;

                    $data->no_surat = $request->get('no_surat'); //$no_surat;
                    $data->kode_perusahaan = $request->get("id_perusahaan_ta");
                    $data->kode_depo = $request->get("id_depo_ta")[$key];
                    $data->no_urut = $no_urut;
                    
                    $data->save();
                }
            }

            foreach ($request->input("id_depo_ta") as $key => $value) {
                //upload file Surat Distributor TA==============================================================================
                if($request->hasfile('filenameta')) { 
                    foreach ($request->file('filenameta') as $file) {
                        if ($file->isValid()) {
                            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('images'), $filename);
                            
                            Claim_Upload_Surat_Program_Depo::create([
                                'no_surat' => $request->get('no_surat'), //$no_surat,
                                'kode_perusahaan' => $request->get("id_perusahaan_ta"),
                                'kode_depo' => $request->get("id_depo_ta")[$key],
                                'filename_upload_depo' => $filename,
                                'no_urut_kode_depo' => $no_urut
                            ]);
                        }
                    }
                    echo 'Success';
                }else{
                    echo 'Gagal';
                }
                //=============================================================================================================
            }

            // =========== Depo TU =========================================//
            $datas=[];
            foreach ($request->input('id_depo_tu') as $key => $value) {
                    
            }
            $validator = Validator::make($request->all(), $datas);
            foreach ($request->input("id_depo_tu") as $key => $value) {
                if($request->get("id_depo_tu")[$key] == '111'){
                    $cari_depo_tu = DB::table('depos')
                                ->select('depos.kode_depo')
                                ->where('depos.kode_perusahaan', 'LP')
                                ->whereIn('depos.area', ['BOPACIS','SUCIPLARA'])
                                ->get();
                    foreach ($cari_depo_tu as $item_tu) {
                        $data = new Claim_Surat_Program_Detail;

                        $data->no_surat = $request->get('no_surat'); //$no_surat;
                        $data->kode_perusahaan = $request->get("id_perusahaan_tu");
                        $data->kode_depo = $item_tu->kode_depo;
                        $data->no_urut = $no_urut;
                        
                        $data->save();
                    }            
                }else{
                    $data = new Claim_Surat_Program_Detail;

                    $data->no_surat = $request->get('no_surat'); //$no_surat;
                    $data->kode_perusahaan = $request->get("id_perusahaan_tu");
                    $data->kode_depo = $request->get("id_depo_tu")[$key];
                    $data->no_urut = $no_urut;
                    
                    $data->save();
                }
            }

            foreach ($request->input("id_depo_tu") as $key => $value) {
                //upload file Surat Distributor TU==============================================================================
                if($request->hasfile('filenametu')) { 
                    foreach ($request->file('filenametu') as $file) {
                        if ($file->isValid()) {
                            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('images'), $filename);
                            
                            Claim_Upload_Surat_Program_Depo::create([
                                'no_surat' => $request->get('no_surat'), //$no_surat,
                                'kode_perusahaan' => $request->get("id_perusahaan_tu"),
                                'kode_depo' => $request->get("id_depo_tu")[$key],
                                'filename_upload_depo' => $filename,
                                'no_urut_kode_depo' => $no_urut
                            ]);
                        }
                    }
                    echo 'Success';
                }else{
                    echo 'Gagal';
                }
                //===============================================================================================================
            }

            // =========== Depo TUA =========================================//
            $datas=[];
            foreach ($request->input('id_depo_tua') as $key => $value) {
                    
            }
            $validator = Validator::make($request->all(), $datas);
            foreach ($request->input("id_depo_tua") as $key => $value) {
                if($request->get("id_depo_tua")[$key] == '000'){
                    $cari_depo_tua = DB::table('depos')
                                ->select('depos.kode_depo')
                                ->where('depos.kode_perusahaan', 'TUA')
                                ->whereIn('depos.area', ['TBANDUNG KOTA'])
                                ->get();
                    foreach ($cari_depo_tua as $item_tua) {
                        $data = new Claim_Surat_Program_Detail;

                        $data->no_surat =  $request->get('no_surat'); //$no_surat;
                        $data->kode_perusahaan = $request->get("id_perusahaan_tua");
                        $data->kode_depo = $item_tua->kode_depo;
                        $data->no_urut = $no_urut;
                        
                        $data->save();
                    }            
                }else{
                    $data = new Claim_Surat_Program_Detail;

                    $data->no_surat = $request->get('no_surat'); //$no_surat;
                    $data->kode_perusahaan = $request->get("id_perusahaan_tua");
                    $data->kode_depo = $request->get("id_depo_tua")[$key];
                    $data->no_urut = $no_urut;
                    
                    $data->save();
                }

                //===================
            }

            foreach ($request->input("id_depo_tua") as $key => $value) {
                //upload file Surat Distributor TUA=============================================================================
                if($request->hasfile('filenametua')) { 
                    foreach ($request->file('filenametua') as $file) {
                        if ($file->isValid()) {
                            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('images'), $filename);
                            
                            Claim_Upload_Surat_Program_Depo::create([
                                'no_surat' => $request->get('no_surat'), //$no_surat,
                                'kode_perusahaan' => $request->get("id_perusahaan_tua"),
                                'filename_upload_depo' => $filename,
                                'no_urut_kode_depo' => $no_urut
                            ]);
                        }
                    }
                    echo 'Success';
                }else{
                    echo 'Gagal';
                }
                //==============================================================================================================
            }
        }


        if($request->hasFile('file'))
        {
            $startRow = $request->input('start_row', 16);
            $file = $request->file('file');
            $import = Excel::import(new ImportDataProgramTiv($startRow), $file);
            if ($import) {
                return redirect()->back()->with('success', 'File Excel berhasil diimpor.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengimpor file Excel.');
            }
        }

        alert()->success('Success.','Surat Program Sukses dikirim');
        return redirect()->route('upload_kirim_surat.index');
    }

    public function view($no_urut)
    {
        //====update status Diterima oleh depo===//
        if(Auth::user()->kode_sub_divisi == '13') { // Jika ASM 
            if(Auth::user()->id_area == '1') { // CIKAMAJAKU
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['260', '261', '262', '263', '267'])
                    ->get();

                foreach ($cari_kode_depo as $item_kode) {
                    $update_surat_diterima = DB::table('claim_surat_program_detail')
                            ->where('no_urut', $no_urut)
                            ->where('kode_depo', $item_kode->kode_depo)
                            ->update([
                                    'status_terima_asm' => '1',
                            ]);
                }
            }elseif(Auth::user()->id_area == '2') { // PPJS
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['264', '265', '266', '344'])
                    ->get();

                foreach ($cari_kode_depo as $item_kode) {
                    $update_surat_diterima = DB::table('claim_surat_program_detail')
                            ->where('no_urut', $no_urut)
                            ->where('kode_depo', $item_kode->kode_depo)
                            ->update([
                                    'status_terima_asm' => '1',
                            ]);
                }
            }elseif(Auth::user()->id_area == '3') { // GATARIPA
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['268', '269', '270', '271'])
                    ->get();

                foreach ($cari_kode_depo as $item_kode) {
                    $update_surat_diterima = DB::table('claim_surat_program_detail')
                            ->where('no_urut', $no_urut)
                            ->where('kode_depo', $item_kode->kode_depo)
                            ->update([
                                    'status_terima_asm' => '1',
                            ]);
                }
            }elseif(Auth::user()->id_area == '4') { // BOPACIS
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['280', '281', '282', '283', '289','290'])
                    ->get();

                foreach ($cari_kode_depo as $item_kode) {
                    $update_surat_diterima = DB::table('claim_surat_program_detail')
                            ->where('no_urut', $no_urut)
                            ->where('kode_depo', $item_kode->kode_depo)
                            ->update([
                                    'status_terima_asm' => '1',
                            ]);
                }
            }elseif(Auth::user()->id_area == '5') { // SUCI
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['284', '285', '287'])
                    ->get();

                foreach ($cari_kode_depo as $item_kode) {
                    $update_surat_diterima = DB::table('claim_surat_program_detail')
                            ->where('no_urut', $no_urut)
                            ->where('kode_depo', $item_kode->kode_depo)
                            ->update([
                                    'status_terima_asm' => '1',
                            ]);
                }
            }elseif(Auth::user()->id_area == '6') { // Bandung KAB
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['343', '904', '930', '912', '914'])
                    ->get();

                foreach ($cari_kode_depo as $item_kode) {
                    $update_surat_diterima = DB::table('claim_surat_program_detail')
                            ->where('no_urut', $no_urut)
                            ->where('kode_depo', $item_kode->kode_depo)
                            ->update([
                                    'status_terima_asm' => '1',
                            ]);
                }
            }elseif(Auth::user()->id_area == '7') { // Bandung KOTA
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['902', '900', '029', '030'])
                    ->get();

                foreach ($cari_kode_depo as $item_kode) {
                    $update_surat_diterima = DB::table('claim_surat_program_detail')
                            ->where('no_urut', $no_urut)
                            ->where('kode_depo', $item_kode->kode_depo)
                            ->update([
                                    'status_terima_asm' => '1',
                            ]);
                }
            }
        }elseif(Auth::user()->kode_sub_divisi == '14'){ // Jika KPJ
            $update_surat_diterima = DB::table('claim_surat_program_detail')
                ->where('no_urut', $no_urut)
                ->where('kode_depo', Auth::user()->kode_depo)
                ->update([
                    'status_terima_kpj' => '1',
                ]);
        }
        //=======================================//

        //ubah data array ke string
        //$segmenAsString = json_encode($request->get('segmen'));

        $data_claim_program = DB::table('claim_surat_program')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program.id_user_input',
                                    'users.name','claim_surat_program.kode_perusahaan_user','kode_depo_user','kode_divisi_user','claim_surat_program.jenis_surat',
                                    'claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.jml_peserta','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                                    'claim_surat_program.penerima','claim_surat_program.kategori as kategori_program','claim_surat_program.sku','claim_surat_program.segmen',
                                    'dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.status',
                                    'claim_surat_program.status_approval_ssd','claim_surat_program.status_approval_manager','claim_surat_program.status_approval_som')
                            ->where('claim_surat_program.no_urut', $no_urut)
                            ->first();
        //====== Segmen array ========================================//
        $segmenAsArray = json_decode($data_claim_program->segmen);
        
        if (Is_array($segmenAsArray)) {
            $segmenAsArray_result = $segmenAsArray; 
        } else {
            $segmenAsArray_result = array(0 => $segmenAsArray);
        }
              
        $cari_segmen = DB::table('dt_segment')
                    ->select('dt_segment.name')
                    ->whereIn('dt_segment.id', $segmenAsArray_result)
                    ->get();
        
        $segmenArrayToString = $cari_segmen->pluck('name')->implode(', ');
        //====== End Segmen array ========================================//

        //====== SKU array ========================================//
        $data_cari_sku = DB::table('claim_surat_program')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program.id_user_input',
                                    'users.name','claim_surat_program.kode_perusahaan_user','kode_depo_user','kode_divisi_user','claim_surat_program.jenis_surat',
                                    'claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.jml_peserta','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                                    'claim_surat_program.penerima','claim_surat_program.kategori as kategori_program','claim_surat_program.sku','claim_surat_program.segmen',
                                    'dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.status',
                                    'claim_surat_program.status_approval_ssd','claim_surat_program.status_approval_manager','claim_surat_program.status_approval_som')
                            ->where('claim_surat_program.no_urut', $no_urut)
                            ->first();

        $skuAsArray = json_decode($data_cari_sku->sku);

        if (Is_array($skuAsArray)) {
            $skuAsArray_result = $skuAsArray; 
        } else {
            $skuAsArray_result = array(0 => $skuAsArray);
        }
        
        $cari_sku = DB::table('dt_sku')
                    ->select('dt_sku.sku')
                    ->whereIn('dt_sku.sku', $skuAsArray_result)
                    ->get();
        
        $skuArrayToString = $cari_sku->pluck('sku')->implode(', ');
        //====== End SKU array ========================================//

        //view untuk ASM:
        if(Auth::user()->kode_sub_divisi == '13') { //ASM
            // $data_area = DB::table('dt_area')
            //             ->select('dt_area.area_group_depo')
            //             ->where('dt_area.id', Auth::user()->id_area)
            //             ->get();

            // $area_spv = str_replace("'","",$data_area->area_group_depo);
            // //dd($data_area->area_group_depo);

            if(Auth::user()->id_area == '1') { // CIKAMAJAKU
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['260', '261', '262', '263', '267'])
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();
            }elseif(Auth::user()->id_area == '2') { // PPJS
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['264', '265', '266', '344'])
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();
            }elseif(Auth::user()->id_area == '3') { // GATARIPA
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['268', '269', '270', '271'])
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();
            }elseif(Auth::user()->id_area == '4') { // BOPACIS
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['280', '281', '282', '283', '289','290'])
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();
            }elseif(Auth::user()->id_area == '5') { // SUCI
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['284', '285', '287'])
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();
            }elseif(Auth::user()->id_area == '6') { // Bandung KAB
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['343', '904', '930', '912', '914'])
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();
            }elseif(Auth::user()->id_area == '7') { // Bandung KOTA
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['902', '900', '029', '030'])
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();
            }

            $data_upload_program_tiv = DB::table('claim_upload_surat_program')
                                        ->where('claim_upload_surat_program.no_urut_kode', $no_urut)
                                        ->where('claim_upload_surat_program.keterangan', 'Surat Program')
                                        ->get();

            $data_upload_pendukung = DB::table('claim_upload_surat_program')
                                        ->where('claim_upload_surat_program.no_urut_kode', $no_urut)
                                        ->where('claim_upload_surat_program.keterangan', 'Pendukung')
                                        ->get();

            $data_upload_program_tua = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'TUA')
                                        ->get();

            $data_upload_program_tu = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'LP')
                                        ->get();

            $data_upload_program_ta = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'WPS')
                                        ->get();

            return view('snd.upload_kirim.view', compact('data_claim_program','data_cari_sku','segmenArrayToString','skuArrayToString','data_claim_program_detail_area',
                                        'data_upload_program_tiv','data_upload_pendukung','data_upload_program_tua','data_upload_program_tu','data_upload_program_ta'));
        }elseif(Auth::user()->kode_sub_divisi == '14') { //KPJ
            $data_claim_program_detail_ta = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->where('claim_surat_program_detail.kode_perusahaan', 'WPS')
                                        ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();

            $data_claim_program_detail_tu = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->where('claim_surat_program_detail.kode_perusahaan', 'LP')
                                        ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();

            $data_claim_program_detail_tua = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->where('claim_surat_program_detail.kode_perusahaan', 'TUA')
                                        ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();

            $data_upload_program_tiv = DB::table('claim_upload_surat_program')
                                        ->where('claim_upload_surat_program.no_urut_kode', $no_urut)
                                        ->where('claim_upload_surat_program.keterangan', 'Surat Program')
                                        ->get();

            $data_upload_pendukung = DB::table('claim_upload_surat_program')
                                        ->where('claim_upload_surat_program.no_urut_kode', $no_urut)
                                        ->where('claim_upload_surat_program.keterangan', 'Pendukung')
                                        ->get();

            $data_upload_program_tua = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'TUA')
                                        ->get();

            $data_upload_program_tu = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'LP')
                                        ->get();

            $data_upload_program_ta = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'WPS')
                                        ->get();

            return view('snd.upload_kirim.view', compact('data_claim_program','segmenArrayToString','skuArrayToString','data_claim_program_detail_ta','data_claim_program_detail_tu','data_claim_program_detail_tua',
                                        'data_upload_program_tiv','data_upload_pendukung','data_upload_program_tua','data_upload_program_tu','data_upload_program_ta'));
        }else{
            $data_claim_program_detail_ta = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->where('claim_surat_program_detail.kode_perusahaan', 'WPS')
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        // ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                                        ->get();

            $data_claim_program_detail_tu = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->where('claim_surat_program_detail.kode_perusahaan', 'LP')
                                        // ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();

            $data_claim_program_detail_tua = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->where('claim_surat_program_detail.kode_perusahaan', 'TUA')
                                        // ->where('claim_surat_program_detail.kode_depo', Auth::user()->kode_depo)
                                        ->groupBy('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->get();

            $data_upload_program_tiv = DB::table('claim_upload_surat_program')
                                        ->where('claim_upload_surat_program.no_urut_kode', $no_urut)
                                        ->where('claim_upload_surat_program.keterangan', 'Surat Program')
                                        ->get();

            $data_upload_pendukung = DB::table('claim_upload_surat_program')
                                        ->where('claim_upload_surat_program.no_urut_kode', $no_urut)
                                        ->where('claim_upload_surat_program.keterangan', 'Pendukung')
                                        ->get();

            $data_upload_program_tua = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'TUA')
                                        ->get();

            $data_upload_program_tu = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'LP')
                                        ->get();

            $data_upload_program_ta = DB::table('claim_upload_surat_program_depo')
                                        ->where('claim_upload_surat_program_depo.no_urut_kode_depo', $no_urut)
                                        ->where('claim_upload_surat_program_depo.kode_perusahaan', 'WPS')
                                        ->get();

            return view('snd.upload_kirim.view', compact('data_claim_program','segmenArrayToString','skuArrayToString','data_claim_program_detail_ta','data_claim_program_detail_tu','data_claim_program_detail_tua',
                                        'data_upload_program_tiv','data_upload_pendukung','data_upload_program_tua','data_upload_program_tu','data_upload_program_ta'));
        }
    }

    public function edit($no_urut)
    {
        $sku = DB::table('dt_sku')->get();
        $segmen = DB::table('dt_segment')->get();

        $kode_depo_ta = DB::table('depos')->where('kode_perusahaan', 'WPS')->whereNotNull('area')->orderBy('area', 'ASC')->get();
        $kode_depo_tu = DB::table('depos')->where('kode_perusahaan', 'LP')->whereNotNull('area')->orderBy('area', 'ASC')->get();
        $kode_depo_tua = DB::table('depos')->where('kode_perusahaan', 'TUA')->whereNotNull('area')->orderBy('area', 'ASC')->get();


        $data_surat = DB::table('claim_surat_program')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program.id_user_input',
                                    'users.name','claim_surat_program.kode_perusahaan_user','kode_depo_user','kode_divisi_user','claim_surat_program.jenis_surat',
                                    'claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.jml_peserta','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                                    'claim_surat_program.penerima','claim_surat_program.kategori as kategori_program','claim_surat_program.sku','claim_surat_program.segmen',
                                    'claim_surat_program.no_urut','claim_surat_program.status',
                                    'claim_surat_program.status_approval_ssd','claim_surat_program.status_approval_manager','claim_surat_program.status_approval_som')
                            ->where('claim_surat_program.no_urut', $no_urut)
                            ->first();
        //====== Segmen dan SKU array ========================================//
        $segmenAsArray = json_decode($data_surat->segmen);
        if (Is_array($segmenAsArray)) {
            $segmenAsArray_result = $segmenAsArray; 
        } else {
            $segmenAsArray_result = array(0 => $segmenAsArray);
        }
        $cari_segmen = DB::table('dt_segment')
                    ->select('dt_segment.name')
                    ->whereIn('dt_segment.id', $segmenAsArray_result)
                    ->get();
        $segmenArrayToString = $cari_segmen->pluck('name')->implode(', ');

        $skuAsArray = json_decode($data_surat->sku);
        if (Is_array($skuAsArray)) {
            $skuAsArray_result = $skuAsArray; 
        } else {
            $skuAsArray_result = array(0 => $skuAsArray);
        }
        $cari_sku = DB::table('dt_sku')
                    ->select('dt_sku.sku')
                    ->whereIn('dt_sku.sku', $skuAsArray_result)
                    ->get();
        $skuArrayToString = $cari_sku->pluck('sku')->implode(', ');
        //====== End Segmen dan SKU array ========================================//

        

        return view('snd.upload_kirim.edit', compact('sku','segmen','kode_depo_ta','kode_depo_tu','kode_depo_tua','data_surat','segmenArrayToString',
                                                    'skuArrayToString'));
    }

    public function view_approve($no_urut)
    {
        $rekap_app_surat_header = DB::table('claim_surat_program')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->first();

        $data_view_status = DB::table('claim_surat_program')
                            ->leftJoin('users AS users_ssd','claim_surat_program.id_user_approval_ssd','=','users_ssd.id')
                            ->leftJoin('users AS users_manager','claim_surat_program.id_user_approval_manager','users_manager.id')
                            ->leftJoin('users AS users_som','claim_surat_program.id_user_approval_som','=','users_som.id')
                            ->select('claim_surat_program.no_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.no_urut',
                                    'claim_surat_program.app_1','users_ssd.name AS nama_ssd','claim_surat_program.status_approval_ssd','claim_surat_program.keterangan_ssd','claim_surat_program.tgl_approval_ssd',
                                    'claim_surat_program.app_2','users_manager.name AS nama_manager','claim_surat_program.status_approval_manager','claim_surat_program.keterangan_manager','claim_surat_program.tgl_approval_manager',
                                    'claim_surat_program.app_3','users_som.name AS nama_som','claim_surat_program.status_approval_som','claim_surat_program.keterangan_som','claim_surat_program.tgl_approval_som')
                            ->where('claim_surat_program.no_urut', $no_urut)
                            ->get();

        return view('snd.upload_kirim.status_app', compact('data_view_status','rekap_app_surat_header'));
    }

    public function view_terima_surat($no_urut)
    {
        $rekap_app_surat_header = DB::table('claim_surat_program')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->first();


        if(Auth::user()->id_area == '1') { // CIKAMAJAKU
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->whereIn('claim_surat_program_detail.kode_depo', ['260', '261', '262', '263', '267'])
                                ->get();
        }elseif(Auth::user()->id_area == '2') { // PPJS
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->whereIn('claim_surat_program_detail.kode_depo', ['264', '265', '266', '344'])
                                ->get();
        }elseif(Auth::user()->id_area == '3') { // GATARIPA
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->whereIn('claim_surat_program_detail.kode_depo', ['268', '269', '270', '271'])
                                ->get();
        }elseif(Auth::user()->id_area == '4') { // BOPACIS
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->whereIn('claim_surat_program_detail.kode_depo', ['280', '281', '282', '283', '289','290'])
                                ->get();
        }elseif(Auth::user()->id_area == '5') { // SUCI
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->whereIn('claim_surat_program_detail.kode_depo', ['284', '285', '287'])
                                ->get();
        }elseif(Auth::user()->id_area == '6') { // Bandung KAB
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->whereIn('claim_surat_program_detail.kode_depo', ['343', '904', '930', '912', '914'])
                                ->get();
        }elseif(Auth::user()->id_area == '7') { // Bandung KOTA
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->whereIn('claim_surat_program_detail.kode_depo', ['902', '900', '029', '030'])
                                ->get();
        }else{
            $data_view_terima = DB::table('claim_surat_program')
                                ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->leftJoin('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.status_terima_asm','claim_surat_program_detail.status_terima_kpj','claim_surat_program_detail.no_urut')
                                ->where('claim_surat_program.no_urut', $no_urut)
                                ->get();
        }

        return view('snd.upload_kirim.status_kirim', compact('data_view_terima','rekap_app_surat_header'));
    }
    
    public function pdf_app($no_urut)
    {   
        $rekap_app_surat = DB::table('claim_surat_program')
                        ->join('users AS nama_pembuat','claim_surat_program.id_user_input','=','nama_pembuat.id')
                        ->join('users AS nama_app_ssd','claim_surat_program.id_user_approval_ssd','=','nama_app_ssd.id')
                        ->join('users AS nama_app_mssd','claim_surat_program.id_user_approval_manager','=','nama_app_mssd.id')
                        ->join('users AS nama_app_som','claim_surat_program.id_user_approval_som','=','nama_app_som.id')
                        ->select('claim_surat_program.no_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                                'claim_surat_program.id_user_input','nama_pembuat.name AS yang_membuat',
                                'claim_surat_program.id_user_approval_ssd','nama_app_ssd.name AS nama_ssd','claim_surat_program.kode_app_ssd',
                                'claim_surat_program.id_user_approval_manager','nama_app_mssd.name AS nama_mssd','claim_surat_program.kode_app_manager',
                                'claim_surat_program.id_user_approval_som','nama_app_som.name AS nama_som','claim_surat_program.kode_app_som',
                                'claim_surat_program.no_urut')
                        ->where('claim_surat_program.no_urut', $no_urut)
                        ->get();
                      
        $pdf = PDF::loadview('snd.upload_kirim.view_pdf', compact('rekap_app_surat'))->setPaper('a4', 'landscape');
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
            
            $getRow = DB::table('claim_surat_program')
                    ->select(DB::raw('MAX(kode_app_ssd) as No_Urut_app_ssd'))
                    ->where('app_1', Auth::user()->kode_sub_divisi);
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

            $cari_status = DB::table('claim_surat_program')
								->select('claim_surat_program.status_approval_ssd')
								->Where('claim_surat_program.no_urut', request()->modal_no_urut)
								->first();
								//dd($cari_status->status_atasan);

			if($cari_status->status_approval_ssd == '0' or $cari_status->status_approval_ssd == '3'){
					$approved = DB::table('claim_surat_program')->where('no_urut', request()->modal_no_urut)
							->update([
								'status' => 0,
                                'app_1' => Auth::user()->kode_sub_divisi,
                                'status_approval_ssd' => 1,
                                'keterangan_ssd' => $request->get('addKeterangan'),
                                'tgl_approval_ssd' => Carbon::now()->format('Y-m-d'),
								'id_user_approval_ssd' => Auth::user()->id,
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
            
            $getRow = DB::table('claim_surat_program')
                    ->select(DB::raw('MAX(kode_app_som) as No_Urut_app_som'))
                    ->where('app_3', Auth::user()->kode_sub_divisi);
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

            $cari_status = DB::table('claim_surat_program')
								->select('claim_surat_program.status_approval_som')
								->Where('claim_surat_program.no_urut', request()->modal_no_urut)
								->first();
								//dd($cari_status->status_atasan);

			if($cari_status->status_approval_som == '0' or $cari_status->status_approval_som == '3'){
					$approved = DB::table('claim_surat_program')->where('no_urut', request()->modal_no_urut)
							->update([
								'status' => 0,
                                'app_3' => Auth::user()->kode_sub_divisi,
                                'status_approval_som' => 1,
                                'keterangan_som' => $request->get('addKeterangan'),
                                'tgl_approval_som' => Carbon::now()->format('Y-m-d'),
								'id_user_approval_som' => Auth::user()->id,
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
            
            $getRow = DB::table('claim_surat_program')
                    ->select(DB::raw('MAX(kode_app_manager) as No_Urut_app_manager'))
                    ->where('app_2', Auth::user()->kode_sub_divisi);
            $rowCount = $getRow->count();

            if($rowCount > 0){
                //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                if ($rowCount < 9) {
                    $no_pengajuan_biaya = 'APP '.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SND'.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_pengajuan_biaya = 'APP '.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SND'.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_pengajuan_biaya = 'APP '.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SND'.'/'.$bulan_romawi.'/'.$tahun;
                } else {
                    $no_pengajuan_biaya = 'APP '.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SND'.'/'.$bulan_romawi.'/'.$tahun;
                }
            }else{
                //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_pengajuan_biaya = 'APP '.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo.'/'.'SND'.'/'.$bulan_romawi.'/'.$tahun;
            }

            $cari_status = DB::table('claim_surat_program')
								->select('claim_surat_program.status_approval_manager')
								->Where('claim_surat_program.no_urut', request()->modal_no_urut)
								->first();
								//dd($cari_status->status_atasan);

			if($cari_status->status_approval_manager == '0' or $cari_status->status_approval_manager == '3'){
					$approved = DB::table('claim_surat_program')->where('no_urut', request()->modal_no_urut)
							->update([
								'status' => 0,
                                'app_2' => Auth::user()->kode_sub_divisi,
                                'status_approval_manager' => 1,
                                'keterangan_manager' => $request->get('addKeterangan'),
                                'tgl_approval_manager' => Carbon::now()->format('Y-m-d'),
								'id_user_approval_manager' => Auth::user()->id,
                                'kode_app_manager' => $no_pengajuan_biaya,
							]);
			}
        }

        alert()->success('Success.','Surat Program berhasil di Approved...');
        return redirect()->route('upload_kirim_surat.index');
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_sub_divisi == '12'){ //-- Jika SSD--
            $cari_status = DB::table('claim_surat_program')
								->select('claim_surat_program.status_approval_ssd')
								->Where('claim_surat_program.no_urut', request()->modal_no_urut)
								->first();
								//dd($cari_status->status_atasan);

			if($cari_status->status_approval_ssd == '0' or $cari_status->status_approval_ssd == '3'){
					$approved = DB::table('claim_surat_program')->where('no_urut', request()->modal_no_urut)
							->update([
								'status' => 0,
                                'status_approval_ssd' => 2,
                                'keterangan_ssd' => $request->get('addKeterangan'),
                                'tgl_approval_ssd' => Carbon::now()->format('Y-m-d'),
								'id_user_approval_ssd' => Auth::user()->id,
							]);
			}
        }elseif(Auth::user()->kode_sub_divisi == '16'){ //-- Jika SOM--
            $cari_status = DB::table('claim_surat_program')
								->select('claim_surat_program.status_approval_som')
								->Where('claim_surat_program.no_urut', request()->modal_no_urut)
								->first();
								//dd($cari_status->status_atasan);

			if($cari_status->status_approval_som == '0' or $cari_status->status_approval_som == '3'){
					$approved = DB::table('claim_surat_program')->where('no_urut', request()->modal_no_urut)
							->update([
								'status' => 0,
                                'status_approval_som' => 2,
                                'keterangan_som' => $request->get('addKeterangan'),
                                'tgl_approval_som' => Carbon::now()->format('Y-m-d'),
								'id_user_approval_som' => Auth::user()->id,
							]);
			}
        }else{ //-- Jika Manager SSD
            $cari_status = DB::table('claim_surat_program')
								->select('claim_surat_program.status_approval_manager')
								->Where('claim_surat_program.no_urut', request()->modal_no_urut)
								->first();
								//dd($cari_status->status_atasan);

			if($cari_status->status_approval_manager == '0' or $cari_status->status_approval_manager == '3'){
					$approved = DB::table('claim_surat_program')->where('no_urut', request()->modal_no_urut)
							->update([
								'status' => 0,
                                'status_approval_manager' => 2,
                                'keterangan_manager' => $request->get('addKeterangan'),
                                'tgl_approval_manager' => Carbon::now()->format('Y-m-d'),
								'id_user_approval_manager' => Auth::user()->id,
							]);
			}
        }

        alert()->success('Success.','Surat Program berhasil di Approved...');
        return redirect()->route('upload_kirim_surat.index');
    }

    // public function import(Request $request)
    // {
    //     // if($request->hasFile('file'))
    //     // {
    //     // 	$file = $request->file('file');
    //     //     Excel::import(new ImportDataProgramTiv, $file);
    //     //     return redirect()->back()->with(['success' => 'Import success']);
    //     // }
    //     // return redirect()->back()->with(['error' => 'Please choose file before']);
        
    //     // if($request->hasFile('file'))
    //     // {
    //     //     $file = $request->file('file');
    //     //     $import = Excel::import(new ImportDataProgramTiv, $file);
    //     //     if ($import) {
    //     //         return redirect()->back()->with('success', 'File Excel berhasil diimpor.');
    //     //     } else {
    //     //         return redirect()->back()->with('error', 'Gagal mengimpor file Excel.');
    //     //     }
    //     // }
        
    // }

    public function viewExcel(Request $request)
    {
        // Validasi dan simpan file
        $request->validate([
            'excel_file' => 'required|mimes:xlsx'
        ]);

        $file = $request->file('excel_file');
        $path = $file->getPathname();

        // Load file Excel
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($path);

        // Ubah spreadsheet menjadi format PDF
        $writer = new Mpdf($spreadsheet);
        //$writer = new Tcpdf($spreadsheet); // Jika Anda ingin menggunakan TCPDF

        // Menampilkan file PDF di browser
        $response = response($writer->save('php://output'))->header('Content-Type', 'application/pdf');
        return $response;

    }

    public function viewWord(Request $request)
    {
        // Validasi dan simpan file
        $request->validate([
            'word_file' => 'required|mimes:docx'
        ]);

        $file = $request->file('word_file');
        $path = $file->getPathname();

        // Load file Word
        $reader = IOFactory::createReader('Word2007');
        $spreadsheet = $reader->load($path);

        // Ubah spreadsheet menjadi format PDF
        $writer = IOFactory::createWriter($spreadsheet, 'PDF');

        // Menampilkan file PDF di browser
        $response = response($writer->save('php://output'))->header('Content-Type', 'application/pdf');
        return $response;
    }
}
