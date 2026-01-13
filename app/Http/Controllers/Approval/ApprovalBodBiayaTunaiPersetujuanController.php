<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalBodBiayaTunaiPersetujuanController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$approval = DB::table('pengajuan_biaya')
                                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                            ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                                            ->Where('pengajuan_biaya.status_biaya', 1)
                                            ->Where('pengajuan_biaya.status_ka_akunting', 1)
                                            ->Where('pengajuan_biaya.status_fin',1)
                                            //->Where('pengajuan_biaya.status_claim',1)
                                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                            ->get();
    	return view ('approval.approval_bod_biaya_persetujuan.index', compact('approval'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $approval = DB::table('pengajuan_biaya')
                                            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                                            ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                                            ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                                            ->Where('pengajuan_biaya.status_biaya', 1)
                                            ->Where('pengajuan_biaya.status_ka_akunting', 1)
                                            ->Where('pengajuan_biaya.status_fin',1)
                                            //->Where('pengajuan_biaya.status_claim',1)
                                            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                                            ->get();
        return view ('approval.approval_bod_biaya_persetujuan.index', compact('approval'));
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

            return view('approval.approval_bod_biaya_persetujuan.view', compact('approval_cost_head','approval_cost_detail','approval_cost_upload','approval_cost_total'));
    }

    public function approved($kode_pengajuan)
    {
        $approved = DB::table('pengajuan')->where('no_urut', $kode_pengajuan)
                    ->update([
                        'status_pengajuan' => 1,
                        'id_user_approval_bod' => Auth::user()->id,
                        'tgl_approval_bod' => Carbon::now()->format('Y-m-d'),
                        'status_bod' => 1
                    ]);

            $approved_detail = DB::table('pengajuan_detail')->Where('no_urut',$kode_pengajuan)
                    ->update([
                        'status_cek_bod' => 1
                    ]);
        
        //return redirect(route('approval.index'))->with(['success' => 'Request Approved...']);
        alert()->success('Success.','Request Approved...');
        return redirect()->route('home');
    }

    public function denied($kode_pengajuan)
    {
        $denied = DB::table('pengajuan')->where('no_urut',$kode_pengajuan)
                    ->update([
                        'status_pengajuan' => 2,
                        'id_user_approval_bod' => Auth::user()->id,
                        'tgl_approval_bod' => Carbon::now()->format('Y-m-d'),
                        'status_bod' => 2
                    ]);
        //return redirect(route('approval.index'))->with(['success' => 'Request Denied...']);
        alert()->error('Oops...','Request Denied...');
        return redirect()->route('home');
    }

    public function pending($kode_pengajuan)
    {
        $denied = DB::table('pengajuan')->where('no_urut',$kode_pengajuan)
                    ->update([
                        'status_pengajuan' => 3,
                        'id_user_approval_bod' => Auth::user()->id,
                        'tgl_approval_bod' => Carbon::now()->format('Y-m-d'),
                        'status_bod' => 3
                    ]);
        //return redirect(route('approval.index'))->with(['success' => 'Request Denied...']);
        alert()->warning('Warning.','Request Pending...');
        return redirect()->route('home');
    }
}
