<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;

class ReportPermissionController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$permission = DB::select("SELECT tanda_terima_cek.receipt_id,tanda_terima_cek.keterangan_id,tanda_terima_cek.keterangan,tanda_terima_cek.date_receipt,tanda_terima_cek.status,SUM(tanda_terima_cek_detail.total) AS total 
    		FROM tanda_terima_cek
			INNER JOIN tanda_terima_cek_detail ON tanda_terima_cek.receipt_id = tanda_terima_cek_detail.receipt_id
			WHERE tanda_terima_cek.date_receipt BETWEEN '$date_start' AND '$date_end'
			GROUP BY tanda_terima_cek.receipt_id,tanda_terima_cek.keterangan_id,tanda_terima_cek.keterangan,tanda_terima_cek.date_receipt,tanda_terima_cek.status");

    	$permission_sum = DB::table('tanda_terima_cek')
    					->whereBetween('tanda_terima_cek.date_receipt', [$date_start,$date_end])
    					->get()->count('tanda_terima_cek.keterangan_id');

    	return view('finance.report_permission.index', compact('permission','permission_sum'));	
    }

    public function cari(Request $request)
    {
    	if(request()->date != ''){
            $date = explode(' - ' ,request()->date);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

    	$permission = DB::select("SELECT tanda_terima_cek.receipt_id,tanda_terima_cek.keterangan_id,tanda_terima_cek.keterangan,tanda_terima_cek.date_receipt,tanda_terima_cek.status,SUM(tanda_terima_cek_detail.total) AS total 
    		FROM tanda_terima_cek
			INNER JOIN tanda_terima_cek_detail ON tanda_terima_cek.receipt_id = tanda_terima_cek_detail.receipt_id
			WHERE tanda_terima_cek.date_receipt BETWEEN '$date_start' AND '$date_end'
			GROUP BY tanda_terima_cek.receipt_id,tanda_terima_cek.keterangan_id,tanda_terima_cek.keterangan,tanda_terima_cek.date_receipt,tanda_terima_cek.status");

    	$permission_sum = DB::table('tanda_terima_cek')
    					->whereBetween('tanda_terima_cek.date_receipt', [$date_start,$date_end])
    					->get()->count('tanda_terima_cek.keterangan_id');

    	return view('finance.report_permission.index', compact('permission','permission_sum'));
    }
}
