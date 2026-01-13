<?php

namespace App\Http\Controllers\Bod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pengajuan_Biaya_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OtorisasiTransferController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod_otorisasi','pengajuan_biaya.keterangan','pengajuan_biaya.status_validasi_fin_upload')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.status_fin', 1)
                ->Where('pengajuan_biaya.status_validasi_fin_upload', 1)
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43']) //Kode Gaji,mitra,BPJS,insentif
                ->orWhere('pengajuan_biaya.status_bod_otorisasi', 0)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.status_fin', 1)
                ->Where('pengajuan_biaya.status_validasi_fin_upload', 1)
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43']) //Kode Gaji,mitra,BPJS,insentif
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod_otorisasi','pengajuan_biaya.keterangan','pengajuan_biaya.status_validasi_fin_upload')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();

        return view ('bod.otorisasi_transfer.index', compact('approval_cost'));
    }

    public function cari()
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $approval_cost = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod_otorisasi','pengajuan_biaya.keterangan','pengajuan_biaya.status_validasi_fin_upload')
                ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.status_fin', 1)
                ->Where('pengajuan_biaya.status_validasi_fin_upload', 1)
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43']) //Kode Gaji,mitra,BPJS,insentif
                ->orWhere('pengajuan_biaya.status_bod_otorisasi', 0)
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->where('pengajuan_biaya.status_fin', 1)
                ->Where('pengajuan_biaya.status_validasi_fin_upload', 1)
                ->WhereIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43']) //Kode Gaji,mitra,BPJS,insentif
                ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod_otorisasi','pengajuan_biaya.keterangan','pengajuan_biaya.status_validasi_fin_upload')
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();

        return view ('bod.otorisasi_transfer.index', compact('approval_cost'));
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
        	->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod_otorisasi','pengajuan_biaya.keterangan')
        	->Where('pengajuan_biaya.no_urut', $no_urut)
        	->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.status_validasi','pengajuan_biaya.status_validasi_acc','pengajuan_biaya.status_validasi_fin','pengajuan_biaya.status_validasi_fin_upload','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_bod_otorisasi','pengajuan_biaya.keterangan')
        	->first();

        $approval_cost_detail = DB::table('pengajuan_biaya_detail')	
        	->Where('pengajuan_biaya_detail.no_urut', $no_urut)
        	->get();

        $approval_cost_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $approval_cost_head->kode_pengajuan_b)
            ->get();

        $attach_upload_fin = DB::table('pengajuan_upload_otorisasi')
            ->select('pengajuan_upload_otorisasi.filename_upload')
            ->where('pengajuan_upload_otorisasi.kode_pengajuan_upload', $approval_cost_head->kode_pengajuan_b)
            ->get();

        // $approval_cost_total =  Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
        //                         ->get()->sum('tharga');

        if(Auth::user()->kode_divisi == '16'){ //-- Jika Koordinator Biaya--
            $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)
                                ->get()->sum('tharga');
        }elseif(Auth::user()->kode_divisi == '6'){ //-- Jika Koordinator ACC--
            $approval_cost_total =  Pengajuan_Biaya_Detail::Where('no_urut', $no_urut)->Where('status_detail', 1)
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

    	return view('bod.otorisasi_transfer.view', compact('approval_cost_head','approval_cost_detail','approval_cost_upload','approval_cost_total','attach_upload_fin'));
    }

    public function otorisasi(Request $request)
    {
        $no_urut = request()->no_urut;
        
        $otorisasi = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                ->update([
                    'status_bod_otorisasi' => 1,
                    'id_user_bod_otorisasi' => Auth::user()->id,
                    'tgl_bod_otorisasi' => Carbon::now()->format('Y-m-d'),
                ]);

        alert()->success('Berhasil.','Otoritas Data Berhasil...');
        return redirect()->route('bod_otorisasi.index');
    }
	
	public function denied(Request $request)
    {
        $kode_pengajuan = $request->kode_pengajuan_b;
        $no_urut = $request->no_urut;
        
        $otorisasi = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
        ->update([
            'status' => 2,
            'status_bod_otorisasi' => 2,
            'id_user_bod_otorisasi' => Auth::user()->id,
            'tgl_bod_otorisasi' => Carbon::now()->format('Y-m-d'),
        ]);

        alert()->error('Oops...','Request Denied...');
        return redirect()->route('bod_otorisasi.index');
    }
}
