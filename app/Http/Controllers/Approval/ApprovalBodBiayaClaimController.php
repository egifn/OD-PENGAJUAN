<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalBodBiayaClaimController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        // $data_claim = DB::table('claim_surat_program')
        //                 ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
        //                 ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
        //                 ->get();

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
                        'claim_surat_program.status_approval_ssd','claim_surat_program.status_approval_manager','claim_surat_program.status_approval_som')
                        ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                        ->get();

    	return view ('approval.approval_bod_biaya_claim.index', compact('data_claim'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        // $data_claim = DB::table('claim_surat_program')
        //                         ->join('dt_segment','claim_surat_program.segmen','=','dt_segment.id')
        //                         ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
        //                         ->get();

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
                                'claim_surat_program.status_approval_ssd','claim_surat_program.status_approval_manager','claim_surat_program.status_approval_som')
                                ->WhereBetween('claim_surat_program.tgl_upload_kirim', [$date_start,$date_end])
                                ->get();

        return view ('approval.approval_bod_biaya_claim.index', compact('data_claim'));
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
        	->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan as perusahaan_tujuan','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_bod','pengajuan_biaya.kategori')
        	->Where('pengajuan_biaya.no_urut', $no_urut)
        	->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_validasi_ka_akunting','pengajuan_biaya.status_ka_akunting','pengajuan_biaya.status_fin','pengajuan_biaya.status_bod','pengajuan_biaya.kategori')
        	->first();

        $approval_cost_detail = DB::table('pengajuan_biaya_detail')	
        	->Where('pengajuan_biaya_detail.no_urut', $no_urut)
        	->get();

        $approval_cost_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $approval_cost_head->kode_pengajuan_b)
            ->orderBy('pengajuan_upload.no_description_detail', 'ASC')
            ->get();

        if(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
            $approval_cost_total =  DB::table('pengajuan_biaya_detail')
                                ->Where('no_urut', $no_urut)
                                ->whereIn('status_detail', ['1','3'])
                                ->get()->sum('tharga');
        // }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Koordinator ACC--
        //     $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         ->Where('status_detail_acc', 1)
        //                         ->get()->sum('tharga');
        // }elseif(Auth::user()->kode_divisi == '5'){ //--jika FINANCE--
        //     $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
        //                         ->Where('status_detail_fin', 1)
        //                         ->get()->sum('tharga');
        }elseif(Auth::user()->kode_divisi == '10'){ //--jika CLAIM--
            $approval_cost_total = DB::table('pengajuan_biaya_detail')
                                ->Where('no_urut', $no_urut)
                                ->Where('status_detail_clm', 1)
                                ->Where('status_detail', 1)
                                ->Where('status_detail_acc', 1)
                                ->get()->sum('tharga');
        }else{
            $approval_cost_total = DB::table('pengajuan_biaya_detail')
                                ->where('no_urut', $no_urut)
                                ->get()->sum('tharga');
        }

            return view('approval.approval_bod_biaya_claim.view', compact('approval_cost_head','approval_cost_detail','approval_cost_upload','approval_cost_total'));
    }

    public function approved($kode_pengajuan)
    {
        
    }

    public function denied($kode_pengajuan)
    {
        
    }

    public function pending($kode_pengajuan)
    {
        
    }
}
