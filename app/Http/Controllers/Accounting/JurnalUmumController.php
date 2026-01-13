<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JurnalUmum;
use Carbon\carbon;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class JurnalUmumController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$jurnal_umum = DB::table('jurnal_umum')
    					->join('coa_lv4','jurnal_umum.kode_account','=','coa_lv4.kode_lv4')
    					->select('jurnal_umum.tgl','jurnal_umum.kode_transaksi','jurnal_umum.kode_account','coa_lv4.account_name','jurnal_umum.debit','jurnal_umum.kredit')
    					->WhereBetween('jurnal_umum.tgl', [$date_start,$date_end])
    					->get();

        $debit = JurnalUmum::WhereBetween('jurnal_umum.tgl', [$date_start,$date_end])
                                ->get()->sum('debit');

        $kredit = JurnalUmum::WhereBetween('jurnal_umum.tgl', [$date_start,$date_end])
                                ->get()->sum('kredit');

    	return view ('accounting.jurnal_umum.index', compact('jurnal_umum','debit','kredit'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $jurnal_umum = DB::table('jurnal_umum')
    					->join('coa_lv4','jurnal_umum.kode_account','=','coa_lv4.kode_lv4')
    					->select('jurnal_umum.tgl','jurnal_umum.kode_transaksi','jurnal_umum.kode_account','coa_lv4.account_name','jurnal_umum.debit','jurnal_umum.kredit')
    					->WhereBetween('jurnal_umum.tgl', [$date_start,$date_end])
    					->get();

    	$debit = JurnalUmum::WhereBetween('jurnal_umum.tgl', [$date_start,$date_end])
                                ->get()->sum('debit');

        $kredit = JurnalUmum::WhereBetween('jurnal_umum.tgl', [$date_start,$date_end])
                                ->get()->sum('kredit');

    	return view ('accounting.jurnal_umum.index', compact('jurnal_umum','debit','kredit'));
    }
}
