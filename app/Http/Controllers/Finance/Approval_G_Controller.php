<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Tanda_Terima_Cek_Vendor_Detail;
use Carbon\carbon;
use Auth;
use DB;
use PDF;

class Approval_G_Controller extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
            $receipt = DB::table('tanda_terima_cek')->join('users','tanda_terima_cek.id_user_input','=','users.id')
                        ->WhereBetween('tanda_terima_cek.date_receipt', [$date_start,$date_end])
                        ->Where('tanda_terima_cek.keterangan_id','like','G%')
                        ->orderBy('tanda_terima_cek.receipt_id', 'ASC')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--
            $receipt = DB::table('tanda_terima_cek')->join('users','tanda_terima_cek.id_user_input','=','users.id')
                        ->WhereBetween('tanda_terima_cek.date_receipt', [$date_start,$date_end])
                        ->Where('tanda_terima_cek.keterangan_id','like','G%')
                        ->WhereIn('tanda_terima_cek.status', [1,2])
                        ->orderBy('tanda_terima_cek.receipt_id', 'ASC')
                        ->get();
        }

    	return view('finance.approval_g.index', compact('receipt'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
            $receipt = DB::table('tanda_terima_cek')->join('users','tanda_terima_cek.id_user_input','=','users.id')
                        ->WhereBetween('tanda_terima_cek.date_receipt', [$date_start,$date_end])
                        ->Where('tanda_terima_cek.keterangan_id','like','G%')
                        ->orderBy('tanda_terima_cek.receipt_id', 'ASC')
                        ->get();
        }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--
            $receipt = DB::table('tanda_terima_cek')->join('users','tanda_terima_cek.id_user_input','=','users.id')
                        ->WhereBetween('tanda_terima_cek.date_receipt', [$date_start,$date_end])
                        ->Where('tanda_terima_cek.keterangan_id','like','G%')
                        ->WhereIn('tanda_terima_cek.status', [1,2])
                        ->orderBy('tanda_terima_cek.receipt_id', 'ASC')
                        ->get();
        }

    	return view('finance.approval_g.index', compact('receipt'));
    }

    public function view($receipt_id)
    {
    	$tanda_terima_head = DB::table('tanda_terima_cek')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->first();

        $tanda_terima_detail = DB::table('tanda_terima_cek')
                ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
                ->join('pengisian_cekgiro_detail','tanda_terima_cek_detail.cek_giro','=','pengisian_cekgiro_detail.id_cek')
                ->join('spp','pengisian_cekgiro_detail.no_spp','=','spp.no_spp')
                ->select('tanda_terima_cek.receipt_id','tanda_terima_cek_detail.jenis_pengeluaran','tanda_terima_cek_detail.total','tanda_terima_cek_detail.cek_giro','tanda_terima_cek_detail.tanggal','tanda_terima_cek_detail.kd_perusahaan','tanda_terima_cek_detail.bank','tanda_terima_cek_detail.norek_perusahaan','tanda_terima_cek_detail.vendor','tanda_terima_cek_detail.atas_nama','tanda_terima_cek_detail.bank_vendor','tanda_terima_cek_detail.norek_vendor','tanda_terima_cek_detail.status','pengisian_cekgiro_detail.no_spp','spp.no_kontrabon')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->get();

        $total_jml = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->sum('total');

        $count = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->count('receipt_id');

        return view('finance.approval_g.view',compact('tanda_terima_head','tanda_terima_detail','total_jml','count'));
    }

    public function approved(Request $request)
    {
        if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
            $approved = DB::table('tanda_terima_cek')
                        ->select('tanda_terima_cek.receipt_id')
                        ->Where('tanda_terima_cek.receipt_id', $request->get("receipt_id"))
                        ->update([
                            'status' => 1,
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);

            // $datas = [];
            // foreach ($request->input('no_spp') as $key => $value) {
               
            // }
            // $validator = Validator::make($request->all(), $datas);
            // if($validator->passes()){
            //     foreach ($request->input("no_spp") as $key => $value) {
            //         $isi_cek = DB::table('kontrabon')
            //                 ->select('kontrabon.id_cek')
            //                 ->Where('kontrabon.no_kontrabon', $request->get("no_kontrabon")[$key])
            //                 ->update([
            //                     'id_cek' => $request->get("cek_giro")[$key]
            //         ]);
            //     }
            // }
            alert()->success('Success.','Request Approved...');
            return redirect()->route('approval_g.index');
        }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--
            $approved = DB::table('tanda_terima_cek')
                        ->select('tanda_terima_cek.receipt_id')
                        ->Where('tanda_terima_cek.receipt_id', $request->get("receipt_id"))
                        ->update([
                            'status' => 2,
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);

            $datas = [];
            foreach ($request->input('no_spp') as $key => $value) {
               
            }
            $validator = Validator::make($request->all(), $datas);
            if($validator->passes()){
                foreach ($request->input("no_spp") as $key => $value) {
                    $isi_cek = DB::table('kontrabon')
                            ->select('kontrabon.id_cek')
                            ->Where('kontrabon.no_kontrabon', $request->get("no_kontrabon")[$key])
                            ->update([
                                'id_cek' => $request->get("cek_giro")[$key]
                    ]);
                }
            }
            alert()->success('Success.','Request Approved...');
            return redirect()->route('home');
        }    
    }

    public function pending(Request $request)
    {
        $receipt_id = request()->receipt_id;
        $approved = DB::table('tanda_terima_cek')->where('receipt_id',$receipt_id)
                    ->update([
                        //'id_user_approval_it' => Auth::user()->id,
                        //'status_pengajuan' => 4,
                        //'status_it' => 3,
                        //'keterangan_approval' => $request->get('addKeterangan'),
                        'status' => 3,
                        'keterangan_approval' => $request->get('addKeterangan'),
        ]);

        
        if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
            alert()->success('Warning.','Request Pending...');
            return redirect()->route('approval_g.index');
        }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--
            alert()->success('Warning.','Request Pending...');
            return redirect()->route('home');
        }
    }
}
