<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CatatanRekeningFin;
use App\Rekening;
use App\Bank;
use Carbon\Carbon;
use DB;


class MutasiRekeningFinController extends Controller
{
    public function index(Request $request)
    {
    	$rekening = Rekening::orderBy('norek','DESC')->get();
    	$bank = Bank::orderBy('kode_bank','ASC')->get();

    	$start = '';
    	$end = '';
    	
    	$pilihrek = $request->norek;
    	$pilihbank = $request->kode_bank;

    	if(request()->date != ''){
    		$date = explode(' - ' ,request()->date);
    		$start = Carbon::parse($date[0])->format('Y-m-d');
    		$end = Carbon::parse($date[1])->format('Y-m-d');
    	}

    	if ($pilihbank == '' and $pilihrek == '' ){
    		$mutasi = DB::table('catatan_rekening_fin')
    						->join('banks','catatan_rekening_fin.kode_bank','=','banks.kode_bank')
    						->join('users','catatan_rekening_fin.kode_user','=','users.id')
    						->whereBetween('catatan_rekening_fin.tanggal_rek', [$start, $end])
    						->get();

    	}elseif ($pilihbank != '' and $pilihrek == '' ){
    		$mutasi = DB::table('catatan_rekening_fin')
    						->join('banks','catatan_rekening_fin.kode_bank','=','banks.kode_bank')
    						->join('users','catatan_rekening_fin.kode_user','=','users.id')
    						->whereBetween('catatan_rekening_fin.tanggal_rek', [$start, $end])
    						->where('catatan_rekening_fin.kode_bank', $pilihbank)
    						->get();
    	}elseif ($pilihbank == '' and $pilihrek != '' ){
    		$mutasi = DB::table('catatan_rekening_fin')
    						->join('banks','catatan_rekening_fin.kode_bank','=','banks.kode_bank')
    						->join('users','catatan_rekening_fin.kode_user','=','users.id')
    						->whereBetween('catatan_rekening_fin.tanggal_rek', [$start, $end])
    						->where('catatan_rekening_fin.norek', $pilihrek)
    						->get();
    	}elseif ($pilihbank != '' and $pilihrek != '' ){
    		$mutasi = DB::table('catatan_rekening_fin')
    						->join('banks','catatan_rekening_fin.kode_bank','=','banks.kode_bank')
    						->join('users','catatan_rekening_fin.kode_user','=','users.id')
    						->whereBetween('catatan_rekening_fin.tanggal_rek', [$start, $end])
    						->where('catatan_rekening_fin.kode_bank', $pilihbank)
    						->where('catatan_rekening_fin.norek', $pilihrek)
    						->get();
    	}

    	return view('finance.mutasi_fin.index', compact('rekening','bank','mutasi'));
    }
}
