<?php

namespace App\Http\Controllers\BarangMasuk_Gudang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Product_Dagang;
use App\Warehouse;
use App\Perusahaan;
use App\Depo;
use DB;
use Auth;

class CheckControlReportController extends Controller
{	
	public function ajax_depo_stok_gudang_in(Request $request)
	{
		$perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
	}

    public function index(Request $request)
    {
    	$perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        $k_depo = DB::table('warehouse')
    				->Where('warehouse.kode_depo', 337)
    				->first();

    	
    	$report=DB::table('warehouse')
    		->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
    		->select('warehouse.kode_produk','nama_produk',
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A1') AS A1"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A2') AS A2"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A3') AS A3"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B1') AS B1"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B2') AS B2"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C6') AS C6"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C7') AS C7"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C8') AS C8"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D4') AS D4"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D5') AS D5"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D6') AS D6"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D7') AS D7"))
    		->Where('warehouse.kode_depo', '')
    		->groupBy('warehouse.kode_produk','product_dagang.nama_produk','A1','A2','A3','B1','B2','C6','C7','C8','D4','D5','D6','D7')
    		->get();
    	
    	
    	return view ('masuk_barang_gudang.checker_report.index', compact('report','perusahaan','depo','k_depo'));	
    }

    public function cari(Request $request)
    {
    	$perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        $perusahaan_cari = $request->kode_perusahaan;
    	$depo_cari = $request->kode_depo;

    	if($perusahaan_cari == '' && $depo_cari == '')
    	{

    	}elseif($perusahaan_cari == 'LP' && $depo_cari == '337'){ //BOGOR
    		$k_depo = DB::table('warehouse')
    				->Where('warehouse.kode_depo', '337')
    				->first();

    		$report=DB::table('warehouse')
    		->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
    		->select('warehouse.kode_produk','nama_produk',
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A1') AS A1"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A2') AS A2"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A3') AS A3"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B1') AS B1"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B2') AS B2"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C6') AS C6"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C7') AS C7"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C8') AS C8"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D4') AS D4"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D5') AS D5"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D6') AS D6"),
    			DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D7') AS D7"))
    		->Where('warehouse.kode_depo', '337')
    		->groupBy('warehouse.kode_produk','product_dagang.nama_produk','A1','A2','A3','B1','B2','C6','C7','C8','D4','D5','D6','D7')
    		->get();
    	}elseif($perusahaan_cari == 'LP' && $depo_cari == '901'){ //PARUNG
    		$k_depo = DB::table('warehouse')
    				->Where('warehouse.kode_depo', '901')
    				->first();

    		$report=DB::table('warehouse')
            ->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
            ->select('warehouse.kode_produk','nama_produk',
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A1') AS A1"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A2') AS A2"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A3') AS A3"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A4') AS A4"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A5') AS A5"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A6') AS A6"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A7') AS A7"),

                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A8') AS A8"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A9') AS A9"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A10') AS A10"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A11') AS A11"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A12') AS A12"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A13') AS A13"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A14') AS A14"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A15') AS A15"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A16') AS A16"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A17') AS A17"),

                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B1') AS B1"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B2') AS B2"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B3') AS B3"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B4') AS B4"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B5') AS B5"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B6') AS B6"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B7') AS B7"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B8') AS B8"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B9') AS B9"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B10') AS B10"),

                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B11') AS B11"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B12') AS B12"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B13') AS B13"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B14') AS B14"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B15') AS B15"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B16') AS B16"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B17') AS B17"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B18') AS B18"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B19') AS B19"),

                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C1') AS C1"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C2') AS C2"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C3') AS C3"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C4') AS C4"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C5') AS C5"),

                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C6') AS C6"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C7') AS C7"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C8') AS C8"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C9') AS C9"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C10') AS C10"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C11') AS C11"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C12') AS C12"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C13') AS C13"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C14') AS C14"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C15') AS C15"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C16') AS C16"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C17') AS C17"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C18') AS C18"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C19') AS C19"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C20') AS C20"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C21') AS C21"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C22') AS C22"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C23') AS C23"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C24') AS C24"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C25') AS C25"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C26') AS C26"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C27') AS C27"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C28') AS C28"),
               
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D1') AS D1"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D2') AS D2"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D3') AS D3"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='E1') AS E1"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='E2') AS E2"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='E3') AS E3"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='E4') AS E4"))
            ->Where('warehouse.kode_depo', '901')
            ->groupBy('warehouse.kode_produk','product_dagang.nama_produk','A1','A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13','A14','A15','A16','A17','B1','B2','B3','B4','B5','B6','B7','B8','B9','B10','B11','B12','B13','B14','B15','B16','B17','B18','B19','C1','C2','C3','C4','C5','C6','C7','C8','C9','C10','C11','C12','C13','C14','C15','C16','C17','C18','C19','C20','C21','C22','C23','C24','C25','C26','C27','C28','D1','D2','D3','E1','E2','E3','E4')
            ->get();
    	}elseif($perusahaan_cari == 'LP' && $depo_cari == '342' ){ //CITEUREUP
    		$k_depo = DB::table('warehouse')
    				->Where('warehouse.kode_depo', '342')
    				->first();

    		$report=DB::table('warehouse')
            ->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
            ->select('warehouse.kode_produk','nama_produk',
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A1') AS A1"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A2') AS A2"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A3') AS A3"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B1') AS B1"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B2') AS B2"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C6') AS C6"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C7') AS C7"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D4') AS D4"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D5') AS D5"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D6') AS D6"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D7') AS D7"))
            ->Where('warehouse.kode_depo', '342')
            ->groupBy('warehouse.kode_produk','product_dagang.nama_produk','A1','A2','A3','B1','B2','C6','C7','D4','D5','D6','D7')
            ->get();
		
		}elseif($perusahaan_cari == 'TUA' && $depo_cari == '902' ){ //METRO
            $k_depo = DB::table('warehouse')
                    ->Where('warehouse.kode_depo', '902')
                    ->first();

            $report=DB::table('warehouse')
            ->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
            ->select('warehouse.kode_produk','product_dagang.nama_produk',
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A23') AS A23"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A24') AS A24"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A25') AS A25"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A26') AS A26"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A27') AS A27"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B20') AS B20"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B21') AS B21"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B22') AS B22"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B23') AS B23"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B24') AS B24"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C31') AS C31"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C32') AS C32"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C33') AS C33"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C34') AS C34"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D8') AS D8"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D9') AS D9"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D10') AS D10"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D11') AS D11"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D12') AS D12"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='E5') AS E5"))
            ->Where('warehouse.kode_depo', '902')
            ->groupBy('warehouse.kode_produk','depos.kode_depo','product_dagang.kode_produk','product_dagang.nama_produk','A23','A24','A25','A26','A27','B20','B21','B22','B23','B24','C31','C32','C33','C34','D8','D9','D10','D11','D12','E5')
            ->get();
			
		}elseif($perusahaan_cari == 'TUA' && $depo_cari == '343' ){ //Padalarang
            $k_depo = DB::table('warehouse')
                    ->Where('warehouse.kode_depo', '343')
                    ->first();

            $report=DB::table('warehouse')
            ->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
            ->select('warehouse.kode_produk','product_dagang.nama_produk',
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A23') AS A23"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A24') AS A24"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A25') AS A25"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A26') AS A26"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B25') AS B25"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B26') AS B26"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B27') AS B27"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B28') AS B28"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='B29') AS B29"),
				DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='C35') AS C35"),
				DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='D13') AS D13"))
            ->Where('warehouse.kode_depo', '343')
            ->groupBy('warehouse.kode_produk','depos.kode_depo','product_dagang.kode_produk','product_dagang.nama_produk','A23','A24','A25','A26','B25','B26','B27','B28','B29','C35','D13')
            ->get();
			
		}elseif($perusahaan_cari == 'LP' && $depo_cari == '915' ){ //SENTUL
            $k_depo = DB::table('warehouse')
                    ->Where('warehouse.kode_depo', '915')
                    ->first();

            $report=DB::table('warehouse')
            ->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
            ->select('warehouse.kode_produk','nama_produk',
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915A') AS A915A"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915B') AS A915B"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915C') AS A915C"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915D') AS A915D"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915E') AS A915E"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915F') AS A915F"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915G') AS A915G"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915H') AS A915H"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915I') AS A915I"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915J') AS A915J"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-915K') AS A915K"))
            ->Where('warehouse.kode_depo', '915')
            ->groupBy('warehouse.kode_produk','depos.kode_depo','product_dagang.kode_produk','product_dagang.nama_produk','A915A','A915B','A915C','A915D','A915E','A915F','A915G','A915H','A915I','A915J','A915K')
            ->get();
		}elseif($perusahaan_cari == 'WPS' && $depo_cari == '034-W01'){ //Pool Kasomalang
            $k_depo = DB::table('warehouse')
                    ->Where('warehouse.kode_depo', '034-W01')
                    ->first();

            $report=DB::table('warehouse')
            ->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
            ->select('warehouse.kode_produk','nama_produk',
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-034-W01A') AS A034W01A"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-034-W01B') AS A034W01B"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-034-W01C') AS A034W01C"))
            ->Where('warehouse.kode_depo', '034-W01')
            ->groupBy('warehouse.kode_produk','depos.kode_depo','product_dagang.kode_produk','product_dagang.nama_produk','A034W01A','A034W01B','A034W01C')
            ->get();
        }else if($perusahaan_cari == 'WPS' && $depo_cari == '034-W02'){ //Pool Dewan
            $k_depo = DB::table('warehouse')
                    ->Where('warehouse.kode_depo', '034-W02')
                    ->first();

            $report=DB::table('warehouse')
            ->join('product_dagang','warehouse.kode_produk','product_dagang.kode_produk')
            ->join('depos','warehouse.kode_depo','depos.kode_depo')
            ->select('warehouse.kode_produk','nama_produk',
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-034-W02A') AS A034W02A"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-034-W02B') AS A034W02B"),
                DB::raw("(SELECT warehouse.qty FROM warehouse WHERE warehouse.kode_produk = product_dagang.kode_produk AND warehouse.kode_depo = depos.kode_depo AND warehouse.kode_sub_area='A-034-W02C') AS A034W02C"))
            ->Where('warehouse.kode_depo', '034-W02')
            ->groupBy('warehouse.kode_produk','depos.kode_depo','product_dagang.kode_produk','product_dagang.nama_produk','A034W02A','A034W02B','A034W02C')
            ->get();
        }
    	

    	return view ('masuk_barang_gudang.checker_report.index', compact('report','perusahaan','depo','k_depo'));	
    }
}
