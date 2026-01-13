<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Category;
use App\Divisi;
use App\Product;
use App\Pengajuan;
use App\Pengajuan_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalBodController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$approval = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->Where('pengajuan.status_it', 1)
                                            ->Where('pengajuan.status_ga', 1)
                                            ->Where('pengajuan.status_ops', 1)
                                            ->Where('pengajuan.status_pc',1)
                                            ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                            ->get();
    	return view ('approval.approval_bod.index', compact('approval'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $approval = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->Where('pengajuan.status_it', 1)
                                            ->Where('pengajuan.status_ga', 1)
                                            ->Where('pengajuan.status_ops', 1)
                                            ->Where('pengajuan.status_pc',1)
                                            ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                            ->get();
        return view ('approval.approval_bod.index', compact('approval'));
    }

    public function view($kodepengajuan)
    {
    	$pengajuan_v = DB::table('pengajuan')->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                             ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                             ->join('users','pengajuan.id_user_input','=','users.id')
                                             ->join('products','pengajuan_detail.kode_product','=','products.kode')
                                             ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                             ->where('pengajuan.no_urut', $kodepengajuan)->first();

            $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
                                                ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
            									->join('categories','products.category_id','=','categories.id')
            									->where('pengajuan_detail.no_urut', $kodepengajuan)->get();

            return view('approval.approval_bod.view', compact('pengajuan_v','details'));
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
