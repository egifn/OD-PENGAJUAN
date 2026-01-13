<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;

class ReportCekGiroController extends Controller
{
	public function index()
	{
		$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $cekgiro = DB::table('pendaftaran_cekgiro')
        			->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
        			->WhereBetween('pendaftaran_cekgiro.created_at', [$date_start,$date_end])
        			->get();
       	$cekgiro_sum = DB::table('pendaftaran_cekgiro')
        				->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
        				->WhereBetween('pendaftaran_cekgiro.created_at', [$date_start,$date_end])
                        ->get()->count('pendaftaran_cekgiro_detail.status_detail');

		return view('finance.report_cek_giro.index',compact('cekgiro','cekgiro_sum'));	
	}

	public function cari(Request $request)
	{
		$status = $request->status;

		if(request()->date != ''){
            $date = explode(' - ' ,request()->date);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->status != '')
        {
            $status = request()->status;
        }

        if ($status == '')
        {
        	$cekgiro = DB::table('pendaftaran_cekgiro')
        			->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
        			->WhereBetween('pendaftaran_cekgiro.created_at', [$date_start,$date_end])
        			->get();

        	 $cekgiro_sum = DB::table('pendaftaran_cekgiro')
        				->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
        				->WhereBetween('pendaftaran_cekgiro.created_at', [$date_start,$date_end])
                        ->get()->count('pendaftaran_cekgiro_detail.status_detail');
        }else if ($status != ''){
        	$cekgiro = DB::table('pendaftaran_cekgiro')
        			->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
        			->WhereBetween('pendaftaran_cekgiro.created_at', [$date_start,$date_end])
        			->Where('pendaftaran_cekgiro_detail.status_detail', $status)
        			->get();

        	$cekgiro_sum = DB::table('pendaftaran_cekgiro')
        			->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
        			->WhereBetween('pendaftaran_cekgiro.created_at', [$date_start,$date_end])
        			->Where('pendaftaran_cekgiro_detail.status_detail', $status)
                        ->get()->count('pendaftaran_cekgiro_detail.status_detail');
        }
        return view('finance.report_cek_giro.index',compact('cekgiro','cekgiro_sum'));	
	}
    
}
