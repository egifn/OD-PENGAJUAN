<?php

namespace App\Http\Controllers\Snd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UploadKirimHistoryController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_divisi == '13') { //SND
            if (Auth::user()->kode_sub_divisi == '12') { //SSD
                if(Auth::user()->id_segmen == '11') { //Jika  All Segmen
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        //->where('claim_surat_program.segmen', Auth::user()->id_segmen)
                        ->get();
                }elseif(Auth::user()->id_segmen == '7') { //Jika  SO
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
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
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
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
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        //->where('claim_surat_program.sku', 'like', '%' . Auth::user()->id_kategori_sku . '%')
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
				}elseif(Auth::user()->id_segmen == '4') { //Jika IOD/AFH
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        //->where('claim_surat_program.sku', 'like', '%' . Auth::user()->id_kategori_sku . '%')
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
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
						 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->where('claim_surat_program.segmen', 'like', '%' . Auth::user()->id_segmen . '%')
                         ->where(function($data_claim){
                            $data_claim->where('claim_surat_program.sku', 'like', '%' . Auth::user()->id_kategori_sku . '%');
                        })
                        ->get();
                }

            }elseif(Auth::user()->kode_sub_divisi == '16') { //SOM
                $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->get();
    
            }elseif(Auth::user()->kode_sub_divisi == '13') { //ASM
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
                //         'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                //         ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                //         ->where('claim_surat_program.status_approval_ssd', 1)
                //         ->where('claim_surat_program.status_approval_manager', 1)
                //         ->where('claim_surat_program.status_approval_som', 1)
                //         ->get();

                if(Auth::user()->id_area == '1') { // CIKAMAJAKU
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['260', '261', '262', '263', '267', '033', '341', '920', '036', '919'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name ','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '2') { // PPJS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['264', '265', '266', '344', '335', '908', '910', '344'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '3') { // GATARIPA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['268', '269', '270', '271', '032', '916', '917', '031'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '4') { // BOPACIS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['280', '281', '282', '283', '289', '337', '901', '342', '915', '925','290'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '5') { // SUCI
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['284', '285', '287', '906', '911', '021'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '6') { // Bandung KAB
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '7') { // Bandung KOTA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['902', '900', '029', '030','343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }
            }elseif(Auth::user()->kode_sub_divisi == '14') { //KPJ
               
                    $data_claim = DB::table('claim_surat_program')
                            ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                            ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                            ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                            ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                            ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                            ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                            ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                            'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                            'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                            'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                            'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_kpj',
                            'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                            'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                            'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                            ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
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
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
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
					if (Auth::user()->id_segmen == '5') {
						$data_claim = DB::table('claim_surat_program')
							->join('users','claim_surat_program.id_user_input','=','users.id')
							->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
							->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
							->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
							->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
							->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
							->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
							->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
							->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
							'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
							'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
							'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
							'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
							'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
							'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
							'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som',
							)
							->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
							 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
							->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
							->whereNotIn('claim_surat_program.status_approval_som', ['9'])
							->where('claim_surat_program.segmen', 'LIKE', '%5%')
							->get();
					}else{
						$data_claim = DB::table('claim_surat_program')
							->join('users','claim_surat_program.id_user_input','=','users.id')
							->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
							->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
							->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
							->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
							->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
							->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
							->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
							->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
							'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
							'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
							'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
							'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
							'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
							'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
							'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som',
							)
							->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
							 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
							->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
							->whereNotIn('claim_surat_program.status_approval_som', ['9'])
							->get();
					}
                }elseif (Auth::user()->type == 'Manager'){
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->get();
                }
            }
        }elseif(Auth::user()->kode_divisi == '18' or Auth::user()->kode_divisi == '6' or Auth::user()->kode_divisi == '23' or Auth::user()->kode_divisi == '30' or Auth::user()->kode_divisi == '24' or Auth::user()->kode_divisi == '2' or Auth::user()->kode_divisi == '10') { 
            //Jika Jika Audit, akunting, korsis, koordinator admin distribusi, Non Gudang, piutang (bu fitri), claim, kops 
            $data_claim = DB::table('claim_surat_program')
                ->join('users','claim_surat_program.id_user_input','=','users.id')
                ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                ->where('claim_surat_program.status_approval_ssd', 1)
                ->where('claim_surat_program.status_approval_manager',1)
                ->where('claim_surat_program.status_approval_som', 1)
                ->get();
        }

        return view ('snd.upload_kirim_history.index', compact('data_claim')); 
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
                if(Auth::user()->id_segmen == '11') { //Jika  All Segmen
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        //->where('claim_surat_program.segmen', Auth::user()->id_segmen)
						 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->get();
                }elseif(Auth::user()->id_segmen == '7') { //Jika  SO
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
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
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
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
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        //->where('claim_surat_program.sku', 'like', '%' . Auth::user()->id_kategori_sku . '%')
						 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
                        ->where(function ($query) {
                            $query->where('claim_surat_program.sku', 'like', '%Jugs%')
                                  ->orWhere('claim_surat_program.sku', 'like', '%MIX%');
                        })
						->where(function($data_claim){
                            $data_claim->where('claim_surat_program.segmen', 'like', '%7%')
                                        ->orWhere('claim_surat_program.segmen', 'LIKE', '%9%')
                                        ->orWhere('claim_surat_program.segmen', 'LIKE', '%10%');
                        })
                        ->get();
				}elseif(Auth::user()->id_segmen == '4') { //Jika IOD/AFH
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        //->where('claim_surat_program.sku', 'like', '%' . Auth::user()->id_kategori_sku . '%')
						 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
						->where(function($data_claim){
                            $data_claim->where('claim_surat_program.segmen', 'like', '%4%')
                                        ->orWhere('claim_surat_program.segmen', 'LIKE', '%2%');
                        })
                        ->get();
                }else{
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.segmen', 'like', '%' . Auth::user()->id_segmen . '%')
						 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
                        ->whereNotIn('claim_surat_program.status_approval_som', ['9'])
						->where(function($data_claim){
                            $data_claim->where('claim_surat_program.sku', 'like', '%' . Auth::user()->id_kategori_sku . '%');
                        })
                        ->get();
                }

            }elseif(Auth::user()->kode_sub_divisi == '16') { //SOM
                $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->get();

            }elseif(Auth::user()->kode_sub_divisi == '13') { //ASM
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
                //         'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                //         ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                //         ->where('claim_surat_program.status_approval_ssd', 1)
                //         ->where('claim_surat_program.status_approval_manager',1)
                //         ->where('claim_surat_program.status_approval_som', 1)
                //         ->get();

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
                //         'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta')
                //         ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                //         ->where('claim_surat_program.status_approval_ssd', 1)
                //         ->where('claim_surat_program.status_approval_manager', 1)
                //         ->where('claim_surat_program.status_approval_som', 1)
                //         ->get();

                if(Auth::user()->id_area == '1') { // CIKAMAJAKU
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['260', '261', '262', '263', '267', '033', '341', '920', '036', '919'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '2') { // PPJS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['264', '265', '266', '344', '335', '908', '910', '344'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '3') { // GATARIPA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['268', '269', '270', '271', '032', '916', '917', '031'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '4') { // BOPACIS
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['280', '281', '282', '283', '289', '337', '901', '342', '915', '925','290'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '5') { // SUCI
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['284', '285', '287', '906', '911', '021'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '6') { // Bandung KAB
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }elseif(Auth::user()->id_area == '7') { // Bandung KOTA
                    $data_claim = DB::table('claim_surat_program')
                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->whereIn('claim_surat_program_detail.kode_depo', ['902', '900', '029', '030','343', '904', '930', '912', '914'])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->where('claim_surat_program.status_approval_manager', 1)
                        ->where('claim_surat_program.status_approval_som', 1)
                        ->whereNotIn('claim_surat_program.sku', ['None'])
                        ->groupBy('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_asm',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name','claim_surat_program.tgl_approval_som')
                        ->get();
                }
            }elseif(Auth::user()->kode_sub_divisi == '14') { //KPJ
                
                    $data_claim = DB::table('claim_surat_program')
                            ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                            ->join('users','claim_surat_program.id_user_input','=','users.id')
                            ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                            ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                            ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                            ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                            ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                            ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                            ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                            ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                            'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                            'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                            'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                            'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta','claim_surat_program_detail.status_terima_kpj',
                            'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                            ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
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
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim','claim_surat_program_detail.kode_depo',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
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
					if (Auth::user()->id_segmen == '5') {
						$data_claim = DB::table('claim_surat_program')
							->join('users','claim_surat_program.id_user_input','=','users.id')
							->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
							->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
							->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
							->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
							->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
							->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
							->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
							->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
							'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
							'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
							'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
							'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
							'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
							'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
							'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
							->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
							 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
							->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
							->whereNotIn('claim_surat_program.status_approval_som', ['9'])
							->where('claim_surat_program.segmen', 'LIKE', '%5%')
							->get();
					}else{
						$data_claim = DB::table('claim_surat_program')
							->join('users','claim_surat_program.id_user_input','=','users.id')
							->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
							->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
							->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
							->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
							->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
							->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
							->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
							->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
							'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
							'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
							'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
							'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
							'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
							'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
							'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
							->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
							 ->whereNotIn('claim_surat_program.status_approval_ssd', ['9'])
							->whereNotIn('claim_surat_program.status_approval_manager', ['9'])
							->whereNotIn('claim_surat_program.status_approval_som', ['9'])
							->get();
					}
                    
                }elseif (Auth::user()->type == 'Manager'){
                    $data_claim = DB::table('claim_surat_program')
                        ->join('users','claim_surat_program.id_user_input','=','users.id')
                        ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                        ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                        ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                        ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                        ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                        ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                        ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                        ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                        'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                        'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                        'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                        'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                        'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->where('claim_surat_program.status_approval_ssd', 1)
                        ->get();
                }
            }
        }elseif(Auth::user()->kode_divisi == '18' or Auth::user()->kode_divisi == '6' or Auth::user()->kode_divisi == '23' or Auth::user()->kode_divisi == '30' or Auth::user()->kode_divisi == '24' or Auth::user()->kode_divisi == '2' or Auth::user()->kode_divisi == '10') { 
            //Jika Jika Audit, akunting, korsis, koordinator admin distribusi, Non Gudang, piutang (bu fitri), claim, kops 
            $data_claim = DB::table('claim_surat_program')
                ->join('users','claim_surat_program.id_user_input','=','users.id')
                ->leftJoin ('users AS user_ssd','claim_surat_program.id_user_approval_ssd','=','user_ssd.id')
                ->leftJoin ('users AS user_manager','claim_surat_program.id_user_approval_manager','=','user_manager.id')
                ->leftJoin ('users AS user_som','claim_surat_program.id_user_approval_som','=','user_som.id')
                ->join('perusahaans','claim_surat_program.kode_perusahaan_user','=','perusahaans.kode_perusahaan')
                ->join('depos','claim_surat_program.kode_depo_user','=','depos.kode_depo')
                ->join('divisi','claim_surat_program.kode_divisi_user','=','divisi.kode_divisi')
                ->leftJoin('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
                ->select('claim_surat_program.id','claim_surat_program.no_surat','claim_surat_program.tgl_upload_kirim',
                'claim_surat_program.id_user_input','claim_surat_program.kode_perusahaan_user','claim_surat_program.kode_depo_user','claim_surat_program.kode_divisi_user',
                'users.name','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi',
                'claim_surat_program.jenis_surat','claim_surat_program.id_program','claim_surat_program.nama_program','claim_surat_program.periode_awal','claim_surat_program.periode_akhir',
                'claim_surat_program.penerima','claim_surat_program.kategori','claim_surat_program.sku','claim_surat_program.segmen','dt_segment.name as nama_segmen','claim_surat_program.no_urut','claim_surat_program.jml_peserta',
                'claim_surat_program.status_approval_ssd','claim_surat_program.id_user_approval_ssd','user_ssd.name AS nama_ssd','claim_surat_program.tgl_approval_ssd',
                        'claim_surat_program.status_approval_manager','claim_surat_program.id_user_approval_manager','user_manager.name AS nama_manager','claim_surat_program.tgl_approval_manager',
                        'claim_surat_program.status_approval_som','claim_surat_program.id_user_approval_som','user_som.name AS nama_som','claim_surat_program.tgl_approval_som')
                ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                ->where('claim_surat_program.status_approval_ssd', 1)
                ->where('claim_surat_program.status_approval_manager',1)
                ->where('claim_surat_program.status_approval_som', 1)
                ->get();
        }

        return view ('snd.upload_kirim_history.index', compact('data_claim'));
    }

    public function view($no_urut)
    {
        //====update status Diterima oleh depo===//
        if(Auth::user()->kode_sub_divisi == '13') { // Jika ASM
            if(Auth::user()->id_area == '1') { // CIKAMAJAKU
                $cari_kode_depo = DB::table('claim_surat_program_detail')
                    ->select('claim_surat_program_detail.kode_depo')
                    ->where('claim_surat_program_detail.no_urut', $no_urut)
                    ->whereIn('claim_surat_program_detail.kode_depo', ['033', '341', '920', '036', '919'])
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
                    ->whereIn('claim_surat_program_detail.kode_depo', ['335', '908', '910', '344'])
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
                    ->whereIn('claim_surat_program_detail.kode_depo', ['032', '916', '917', '031'])
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
                    ->whereIn('claim_surat_program_detail.kode_depo', ['337', '901', '342', '915', '925','290'])
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
                    ->whereIn('claim_surat_program_detail.kode_depo', ['906', '911', '021'])
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
        }elseif(Auth::user()->kode_sub_divisi == '14') { // Jika KPJ
            $update_surat_diterima = DB::table('claim_surat_program_detail')
                    ->where('no_urut', $no_urut)
                    ->where('kode_depo', Auth::user()->kode_depo)
                    ->update([
                        'status_terima_kpj' => '1',
                    ]);
        }
        //=======================================//

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
        //dd($segmenAsArray);
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
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['033', '341', '920', '036', '919'])
                                        ->get();
            }elseif(Auth::user()->id_area == '2') { // PPJS
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['335', '908', '910', '344'])
                                        ->get();
            }elseif(Auth::user()->id_area == '3') { // GATARIPA
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['032', '916', '917', '031'])
                                        ->get();
            }elseif(Auth::user()->id_area == '4') { // BOPACIS
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['337', '901', '342', '915', '925','290'])
                                        ->get();
            }elseif(Auth::user()->id_area == '5') { // SUCI
                $data_claim_program_detail_area = DB::table('claim_surat_program')
                                        ->join('claim_surat_program_detail','claim_surat_program.no_surat','=','claim_surat_program_detail.no_surat')
                                        ->join('perusahaans','claim_surat_program_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','claim_surat_program_detail.kode_depo','depos.kode_depo')
                                        ->select('claim_surat_program.no_surat','claim_surat_program_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                                'claim_surat_program_detail.kode_depo','depos.nama_depo','claim_surat_program_detail.no_urut')
                                        ->where('claim_surat_program_detail.no_urut', $no_urut)
                                        ->whereIn('claim_surat_program_detail.kode_depo', ['906', '911', '021'])
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

            return view('snd.upload_kirim.view', compact('data_claim_program','segmenArrayToString','skuArrayToString','data_claim_program_detail_area',
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
}
