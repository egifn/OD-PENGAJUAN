<?php

namespace App\Http\Controllers\Korsis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ListDueDate;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use App\Export\ExportJatuhTempoSukanda;
use Maatwebsite\Excel\Facades\Excel;

class ListDueDateSukandaController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$date_start = (date('Y-m-d 00:00:00'));
        $date_end = (date('Y-m-d 23:59:59'));

        $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.time_update','acc_jatuh_tempo_sukanda.created_at')
                        ->whereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
						//->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->get();

        return view ('korsis_sukanda.index', compact('list_jt'));
    }

    public function listcari(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		
		if(request()->tanggal != ''){
			 $date = explode(' - ' ,request()->tanggal);
			 $date_start = Carbon::parse($date[0])->format('Y-m-d 00:00:00');
			 $date_end = Carbon::parse($date[1])->format('Y-m-d 23:59:59');
        }
	 
        if(request()->customer != '' and request()->docId == '' ){ //jika customer tidak kosong dan docId kosong
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.time_update','acc_jatuh_tempo_sukanda.created_at')
                        ->Where('acc_jatuh_tempo_sukanda.customer_id', request()->customer)
						->WhereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
						//->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->get();
        }elseif(request()->customer == '' and request()->docId != '' ){ //jika customer kosong dan docId tidak kosong
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.time_update','acc_jatuh_tempo_sukanda.created_at')
                        ->Where('acc_jatuh_tempo_sukanda.doc_id', request()->docId)
						->WhereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
						//->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->get();
        }elseif(request()->customer != '' and request()->docId != '' ){ //jika customer tidak kosong dan docId tidak kosong
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.time_update','acc_jatuh_tempo_sukanda.created_at')
                        ->Where('acc_jatuh_tempo_sukanda.customer_id', request()->customer)
                        ->Where('acc_jatuh_tempo_sukanda.doc_id', request()->docId)
						->WhereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
						//->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->get();
        }else{
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.time_update','acc_jatuh_tempo_sukanda.created_at')
						->WhereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
                        ->get();
        }

        return view ('korsis_sukanda.index', compact('list_jt'));
    }

    public function export()
    {
        return Excel::download(new ExportJatuhTempoSukanda, 'ListJatuhTempo (Sukanda).xlsx');
    }
	
	public function view(Request $request)
    {
        $id_cuss = $request->input('customer_ex');
        $invoice = $request->input('docId_ex');
        $tgl = $request->input('tanggal_ex');

        if($tgl != ''){
            $date = explode(' - ' ,$tgl);
            $date_start = Carbon::parse($date[0])->format('Y-m-d 00:00:00');
            $date_end = Carbon::parse($date[1])->format('Y-m-d 23:59:59');
        }
       

        date_default_timezone_set('Asia/Jakarta');
       
        if(request()->customer_ex != '' and request()->docId_ex == '' ){ //jika customer tidak kosong dan docId kosong
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.created_at','acc_jatuh_tempo_sukanda.time_update')
                        ->Where('acc_jatuh_tempo_sukanda.customer_id', $id_cuss)
                        //->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->whereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
                        ->get();
        }elseif(request()->customer_ex == '' and request()->docId_ex != '' ){ //jika customer kosong dan docId tidak kosong
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.created_at','acc_jatuh_tempo_sukanda.time_update')
                        ->Where('acc_jatuh_tempo_sukanda.doc_id', $invoice)
                        //->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->whereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
                        ->get();
        }elseif(request()->customer_ex != '' and request()->docId_ex != '' ){ //jika customer tidak kosong dan docId tidak kosong
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.created_at','acc_jatuh_tempo_sukanda.time_update')
                        ->Where('acc_jatuh_tempo_sukanda.customer_id', $id_cuss)
                        ->Where('acc_jatuh_tempo_sukanda.doc_id', $invoice)
                        //->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->whereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
                        ->get();
        }else{
            $list_jt = DB::table('acc_jatuh_tempo_sukanda')
                        ->join('users','acc_jatuh_tempo_sukanda.id_user','=','users.id')
                        ->select('acc_jatuh_tempo_sukanda.id','acc_jatuh_tempo_sukanda.doc_id','acc_jatuh_tempo_sukanda.customer_id','acc_jatuh_tempo_sukanda.customer_name',
                        'acc_jatuh_tempo_sukanda.amount','acc_jatuh_tempo_sukanda.remain','acc_jatuh_tempo_sukanda.doc_date','acc_jatuh_tempo_sukanda.due_date',
                        'acc_jatuh_tempo_sukanda.due_date_updated','acc_jatuh_tempo_sukanda.id_user','users.name','acc_jatuh_tempo_sukanda.created_at','acc_jatuh_tempo_sukanda.time_update')
                        //->Where('acc_jatuh_tempo_sukanda.customer_id', $id_cuss)
                        //->Where('acc_jatuh_tempo_sukanda.doc_id', '')
                        //->Where('acc_jatuh_tempo_sukanda.kode_perusahaan', '')
                        ->whereBetween('acc_jatuh_tempo_sukanda.created_at', [$date_start,$date_end])
                        ->get();
        }

        return view ('korsis_sukanda.view', compact('list_jt'));
    }
}
