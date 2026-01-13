<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MutasiRekening;
use App\Rekening;
use Carbon\Carbon;

class MutasiRekeningController extends Controller
{
    public function index(Request $request)
    {
    	$rekening = Rekening::orderBy('norek','DESC')->get();

    	$start = Carbon::now()->startOfMonth()->format('Y-m-d');
    	$end = Carbon::now()->endOfMonth()->format('Y-m-d');
    	$pilihrek = $request->norek;

    	if(request()->date != ''){
    		$date = explode(' - ' ,request()->date);
    		$start = Carbon::parse($date[0])->format('Y-m-d');
    		$end = Carbon::parse($date[1])->format('Y-m-d');
    	}

    	if ($pilihrek == '')
    	{
    		$mutasi = MutasiRekening::whereBetween('tanggal_rek', [$start, $end])
    								->get();
    	}else{
    		$mutasi = MutasiRekening::whereBetween('tanggal_rek', [$start, $end])
    								->where('norek',$pilihrek)->get();
    	}

    	
    	return view('rekon.mutasi.index', compact('mutasi','rekening'));
    }
}
