<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Perusahaan;
use App\Depo;
use App\Rekening; 
use App\Imports\CatatanSaldoImport;
use App\CatatanSaldo;
use Carbon\carbon;
use Auth;
use DB;
use Excel;

class SaldoController extends Controller
{
	public function ajax_depo(Request $request)
	{
		$kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
		return response()->json($kodedepo);
	}

    public function ajax_norek(Request $request)
    {
        $norek = Rekening::where('kode_depo', $request->deporek_id)->pluck('norek');
        return response()->json($norek);
    }

    public function index()
    {
        // if(request()->periode != ''){
        //     $date = explode(' - ' ,request()->periode);
        //     $start_date = Carbon::parse($date[0])->format('Y-m-d');
        //     $end_date = Carbon::parse($date[1])->format('Y-m-d');
        // }

        $start_date = (date('Y-m-d'));
        $end_date = (date('Y-m-d'));

    	$perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $saldo = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', ['-', '-'])
                    ->get();

        $debet = CatatanSaldo::whereBetween('catatan_saldo.transaction_date', ['-', '-'])
                ->get()->sum('debet');

        $kredit = CatatanSaldo::whereBetween('catatan_saldo.transaction_date', ['-', '-'])
                ->get()->sum('kredit');

        $balance = DB::table('catatan_saldo')
                    ->select('balance')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->first();

    	return view('rekon.saldo.index', compact('perusahaan','saldo','debet','kredit','balance'));
    }

    public function cari(Request $request)
    {
        if(request()->periode != ''){
            $date = explode(' - ' ,request()->periode);
            $start_date = Carbon::parse($date[0])->format('Y-m-d');
            $end_date = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->perusahaan != ''){
            $kode_perusahaan = request()->perusahaan;
        }else{
            $kode_perusahaan = '';
        }

        if(request()->depo != ''){
            $kode_depo = request()->depo;
        }else{
            $kode_depo = '';
        }

        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        if($kode_perusahaan == '' and $kode_depo == ''){
            $saldo = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->get();

            $debet = DB::table('catatan_saldo')->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->get()->sum('debet');

            $kredit = DB::table('catatan_saldo')->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->get()->sum('kredit');

            $balance = DB::table('catatan_saldo')
                    ->select('balance')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->first();

        }elseif($kode_perusahaan != '' and $kode_depo == ''){
            $saldo = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->get();

            $debet = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->get()->sum('debet');

            $kredit = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->get()->sum('kredit');

            $balance = DB::table('catatan_saldo')
                    ->select('balance')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->first();

        }elseif($kode_perusahaan != '' and $kode_depo != ''){
            $saldo = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->get();

            $debet = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->get()->sum('debet');

            $kredit = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->get()->sum('kredit');

            $balance = DB::table('catatan_saldo')
                    ->select('balance')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_perusahaan', $kode_perusahaan)
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->first();

        }elseif($kode_perusahaan == '' and $kode_depo != ''){
            $saldo = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->get();

            $debet = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->get()->sum('debet');

            $kredit = DB::table('catatan_saldo')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->get()->sum('kredit');

            $balance = DB::table('catatan_saldo')
                    ->select('balance')
                    ->whereBetween('catatan_saldo.transaction_date', [$start_date, $end_date])
                    ->Where('catatan_saldo.kode_depo', $kode_depo)
                    ->orderBy('id', 'DESC')
                    ->limit(1)
                    ->first();
        }   
        return view('rekon.saldo.index', compact('perusahaan','saldo','debet','kredit','balance'));
    }

    public function storeData(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

    	if($request->hasFile('file')) 
    	{
    		$file = $request->file('file');
    		Excel::import(new CatatanSaldoImport, $file);
    		return redirect()->back()->with(['success' => 'Import success']);
    	}
    	return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
