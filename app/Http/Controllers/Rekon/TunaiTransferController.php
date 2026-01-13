<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MutasiRekening;
use App\Rekening;	
use App\Perusahaan;
use App\Depo;
use Carbon\carbon;
use DB;

class TunaiTransferController extends Controller
{
    public function ajax_depo_dms(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaandms_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
    }

    public function ajax_depo_bank(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaanbank_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
    }

    public function ajax_rekening_bank(Request $request)
    {
        $norek = Rekening::where('kode_perusahaan', $request->perusahaanrek_id)->pluck('norek');
        return response()->json($norek);
    }

    public function ajax_rekening_bank_depo(Request $request)
    {
        $norek = Rekening::where('kode_depo', $request->deporek_id)->pluck('norek');
        return response()->json($norek);
    }

    public function index(Request $request)
    {
    	//$rekening = Rekening::orderBy('norek','DESC')->get();
        
        $perusahaan_dms = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $perusahaan_bank = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
    	$end = Carbon::now()->endOfMonth()->format('Y-m-d');
    	$pilihrek = $request->norek;

        $kredit = DB::table('catatan_rekenings')
                    ->where('tanggal_rek','')->get();

    	if(request()->date_bank != ''){
    		$date_bank = explode(' - ' ,request()->date_bank);
    		$start = Carbon::parse($date_bank[0])->format('Y-m-d');
    		$end = Carbon::parse($date_bank[1])->format('Y-m-d');
    	}

        // $kredit_dms = DB::connection('mysql_tua')
        //                     ->table('dms_cas_doccashtempin')
        //                     ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
        //                     ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
        //                     ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
        //                     ->whereBetween('dms_cas_doccashtempin.dtmDoc', ['',''])

        //                     ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
        //                     ->get();

        $kredit_dms = DB::connection('mysql_tua')
                      ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN '' AND '' GROUP BY dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");

    	return view('rekon.tagihan_tunai.index', compact('kredit','kredit_dms','perusahaan_dms','perusahaan_bank'));
    }

    public function dmscari(Request $request)
    {
        $perusahaan_dms = DB::table('perusahaans')->get();
        $perusahaan_bank = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $depo_dms = DB::table('depos')->get();
        $rekening = DB::table('rekenings')->get();

        //DMS
        if(request()->created_at != ''){
            $date_dms = explode(' - ' ,request()->created_at);
            $start_dms = Carbon::parse($date_dms[0])->format('Y-m-d');
            $end_dms = Carbon::parse($date_dms[1])->format('Y-m-d');
        }

        if(request()->perusahaan_dms == '')
        {
            // $kredit_dms = DB::connection('mysql_tua')
            //                 ->table('dms_cas_doccashtempin')
            //                 ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
            //                 ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
            //                 ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
            //                 ->whereBetween('dms_cas_doccashtempin.dtmDoc', [$start_dms, $end_dms])
            //                 ->Where('dms_fin_account.szName','like', '%HTT%')
            //                 ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
            //                 ->get();

            $kredit_dms = DB::connection('mysql_tua')
                            ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount, dms_cas_doccashtempinitem.szDescription FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN $start_dms AND $end_dms AND (dms_fin_account.szName LIKE 'HPT%' OR dms_fin_account.szName LIKE 'HJPT%') GROUP BY dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");

        }elseif(request()->perusahaan_dms == 'TUA'){
            if(request()->depo_dms != '')
            {
                $pilihdepo = request()->depo_dms;
                $kode_depo_dms = request()->nama_depo;
            }

            

            if ($pilihdepo == '')
            {
                // $kredit_dms = DB::connection('mysql_tua')
                //             ->table('dms_cas_doccashtempin')
                //             ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
                //             ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
                //             ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
                //             ->whereBetween('dms_cas_doccashtempin.dtmDoc', [$start_dms, $end_dms])
                //             ->Where('dms_fin_account.szName','like', '%HTT%')
                //             ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
                //             ->get();

                $kredit_dms = DB::connection('mysql_tua')
                            ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount, dms_cas_doccashtempinitem.szDescription FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN '$start_dms' AND '$end_dms' AND (dms_fin_account.szName LIKE 'HPT%' OR dms_fin_account.szName LIKE 'HJPT%') GROUP BY dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");
            }else{
                // $kredit_dms = DB::connection('mysql_tua')
                //             ->table('dms_cas_doccashtempin')
                //             ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
                //             ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
                //             ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
                //             ->whereBetween('dms_cas_doccashtempin.dtmDoc', [$start_dms, $end_dms])
                //             ->Where('dms_fin_account.szName','like', '%HTT%')
                //             ->where('dms_cas_doccashtempin.szBranchId', $pilihdepo)
                //             ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
                //             ->get();

                $kredit_dms = DB::connection('mysql_tua')
                            ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount, dms_cas_doccashtempinitem.szDescription FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN '$start_dms' AND '$end_dms' AND (dms_fin_account.szName LIKE 'HPT%' OR dms_fin_account.szName LIKE 'HJPT%') AND dms_cas_doccashtempin.szBranchId = '$pilihdepo' GROUP BY dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");

            }
        }elseif(request()->perusahaan_dms == 'LP'){
            if(request()->depo_dms != '')
            {
                $pilihdepo = request()->depo_dms;
                $kode_depo_dms = request()->nama_depo;
            }

            

            if ($pilihdepo == '')
            {
                // $kredit_dms = DB::connection('mysql_tu')
                //             ->table('dms_cas_doccashtempin')
                //             ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
                //             ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
                //             ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
                //             ->whereBetween('dms_cas_doccashtempin.dtmDoc', [$start_dms, $end_dms])
                //             ->Where('dms_fin_account.szName','like', '%HTT%')
                //             ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
                //             ->get();

                $kredit_dms = DB::connection('mysql_tu')
                            ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount, dms_cas_doccashtempinitem.szDescription FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN '$start_dms' AND '$end_dms' AND (dms_fin_account.szName LIKE 'HPT%' OR dms_fin_account.szName LIKE 'HJPT%') GROUP BY dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");
            }else{
                // $kredit_dms = DB::connection('mysql_tu')
                //             ->table('dms_cas_doccashtempin')
                //             ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
                //             ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
                //             ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
                //             ->whereBetween('dms_cas_doccashtempin.dtmDoc', [$start_dms, $end_dms])
                //             ->Where('dms_fin_account.szName','like', '%HTT%')
                //             ->where('dms_cas_doccashtempin.szBranchId', $pilihdepo)
                //             ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
                //             ->get();

                $kredit_dms = DB::connection('mysql_tu')
                            ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount, dms_cas_doccashtempinitem.szDescription FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN '$start_dms' AND '$end_dms' AND (dms_fin_account.szName LIKE 'HPT%' OR dms_fin_account.szName LIKE 'HJPT%') AND dms_cas_doccashtempin.szBranchId = '$pilihdepo' GROUP BY dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");

            }
        }elseif(request()->perusahaan_dms == 'WPS'){
            if(request()->depo_dms != '')
            {
                $pilihdepo = request()->depo_dms;
                $kode_depo_dms = request()->nama_depo;
            }

            

            if ($pilihdepo == '')
            {
                // $kredit_dms = DB::connection('mysql_ta')
                //             ->table('dms_cas_doccashtempin')
                //             ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
                //             ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
                //             ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
                //             ->whereBetween('dms_cas_doccashtempin.dtmDoc', [$start_dms, $end_dms])
                //             ->Where('dms_fin_account.szName','like', '%HTT%')
                //             ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
                //             ->get();

                $kredit_dms = DB::connection('mysql_ta')
                            ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount, dms_cas_doccashtempinitem.szDescription FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN '$start_dms' AND '$end_dms' AND (dms_fin_account.szName LIKE 'HPT%' OR dms_fin_account.szName LIKE 'HJPT%') GROUP BY dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");

            }else{
                // $kredit_dms = DB::connection('mysql_ta')
                //             ->table('dms_cas_doccashtempin')
                //             ->join('dms_cas_doccashtempinitem','dms_cas_doccashtempin.szDocId','=','dms_cas_doccashtempinitem.szdocid')
                //             ->join('dms_fin_account','dms_cas_doccashtempinitem.szAccountId','=','dms_fin_account.szId')
                //             ->select('dms_cas_doccashtempin.szDocId','dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName', DB::raw('SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount'))
                //             ->whereBetween('dms_cas_doccashtempin.dtmDoc', [$start_dms, $end_dms])
                //             ->where('dms_cas_doccashtempin.szBranchId', $pilihdepo)
                //             ->Where('dms_fin_account.szName','like', '%HTT%')
                //             ->groupBy('dms_cas_doccashtempin.dtmDoc','dms_cas_doccashtempinitem.szAccountId','dms_fin_account.szName')
                //             ->get();

                 $kredit_dms = DB::connection('mysql_ta')
                            ->select("SELECT dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName, SUM(dms_cas_doccashtempinitem.decAmount) AS decAmount, dms_cas_doccashtempinitem.szDescription FROM dms_cas_doccashtempin INNER JOIN dms_cas_doccashtempinitem ON dms_cas_doccashtempin.szDocId = dms_cas_doccashtempinitem.szdocid INNER JOIN dms_fin_account ON dms_cas_doccashtempinitem.szAccountId = dms_fin_account.szId WHERE dms_cas_doccashtempin.dtmDoc BETWEEN '$start_dms' AND '$end_dms' AND (dms_fin_account.szName LIKE 'HPT%' OR dms_fin_account.szName LIKE 'HJPT%') AND dms_cas_doccashtempin.szBranchId = '$pilihdepo' GROUP BY dms_cas_doccashtempin.dtmDoc,dms_cas_doccashtempinitem.szAccountId,dms_fin_account.szName");
            }
        }

        //-----REKENING
        if(request()->created_at_bank != ''){
            $date_bank = explode(' - ' ,request()->created_at_bank);
            $start_bank = Carbon::parse($date_bank[0])->format('Y-m-d');
            $end_bank = Carbon::parse($date_bank[1])->format('Y-m-d');
        }

        

        if (request()->norek_bank == '')
        {
            //$kredit = DB::table('catatan_rekenings')->get();
            $kredit = MutasiRekening::whereBetween('tanggal_rek', [$start_bank, $end_bank])
                                    ->get();
        }else{
            $kredit = MutasiRekening::whereBetween('tanggal_rek', [$start_bank, $end_bank])
                                    ->where('norek', request()->norek_bank)->get();
        }

        return view('rekon.tagihan_tunai.index', compact('kredit_dms','kredit','perusahaan_dms','perusahaan_bank','depo_dms','rekening'));
    }
}
