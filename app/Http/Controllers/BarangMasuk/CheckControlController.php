<?php

namespace App\Http\Controllers\BarangMasuk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\BarangDagang_In;
use App\BarangDagang_In_Detail;
use App\BarangDagang_In_History;
use App\BarangDagang_In_History_Detail;
use App\Warehouse;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckControlController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');

    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_depo == '337'){ //BOGOR
            $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '337')
                    ->get();
        }else if(Auth::user()->kode_depo == '901'){ //PARUNG
            $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '901')
                    ->get();
        }else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
            $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '342')
                    ->get();
        }else if(Auth::user()->kode_depo == '034-W01'){ //Kasomalang
            if(Auth::user()->kategori == 'Layak'){
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                    ->Where('barang_dagang_in.id_checker', '9999999')
                    ->get();
            }else{
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                    ->get();
            }
            
        }else if(Auth::user()->kode_depo == '034-W02'){ //dewan
            if(Auth::user()->kategori == 'Layak'){
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                    ->Where('barang_dagang_in.id_checker', '9999999')
                    ->get();
            }else{
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                    ->get();
            }
            
        }else{
            $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                    ->get();
        }

        

        return view ('masuk_barang.checker_control.index', compact('in'));
    }

    public function cari(Request $request)
    {   
        $kategori = $request->kategori;

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->kategori != '')
        {
            $kategori = request()->kategori;
        }

        if(Auth::user()->kode_depo == '337'){ //BOGOR
            if($kategori=='')
            {
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '337')
                    ->get();
            }else{
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '337')
                    ->Where('barang_dagang_in.kategori', $kategori)
                    ->get();
            }
        }else if(Auth::user()->kode_depo == '901'){ //PARUNG
            if($kategori=='')
            {
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '901')
                    ->get();
            }else{
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '901')
                    ->Where('barang_dagang_in.kategori', $kategori)
                    ->get();
            }
        }else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
            if($kategori=='')
            {
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '342')
                    ->get();
            }else{
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', '342')
                    ->Where('barang_dagang_in.kategori', $kategori)
                    ->get();
            }
        }else if(Auth::user()->kode_depo == '034-W01'){ //Pool Kasomalang
            if(Auth::user()->kategori == 'Layak'){
                if($kategori=='')
                {
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->Where('barang_dagang_in.id_checker', '9999999')
                        ->get();
                }else{
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->Where('barang_dagang_in.kategori', $kategori)
                        ->Where('barang_dagang_in.id_checker', '9999999')
                        ->get();
                }
            }else{
                if($kategori=='')
                {
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->get();
                }else{
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->Where('barang_dagang_in.kategori', $kategori)
                        ->get();
                }
            }
        }else if(Auth::user()->kode_depo == '034-W02'){ //Pool dewan
            if(Auth::user()->kategori == 'Layak'){
                if($kategori=='')
                {
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->Where('barang_dagang_in.id_checker', '9999999')
                        ->get();
                }else{
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->Where('barang_dagang_in.id_checker', '9999999')
                        ->Where('barang_dagang_in.kategori', $kategori)
                        ->get();
                }
            }else{
                if($kategori=='')
                {
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->get();
                }else{
                    $in = DB::table('barang_dagang_in')
                        ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                        ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                        ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                        ->Where('barang_dagang_in.kategori', $kategori)
                        ->get();
                }
            }    
        }else{
            if($kategori=='')
            {
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                    ->get();
            }else{
                $in = DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_in.kode_depo', Auth::user()->kode_depo)
                    ->Where('barang_dagang_in.kategori', $kategori)
                    ->get();
            }
        }
        
        return view ('masuk_barang.checker_control.index', compact('in'));
    }

    public function view($doc_id)
    {	

        if(Auth::user()->kategori == 'Layak'){
            $head = DB::table('barang_dagang_in_history_update')
                ->join('area','barang_dagang_in_history_update.kode_zona','=','area.kode_area')
                ->join('area_sub','barang_dagang_in_history_update.kode_zona_sub','=','area_sub.kode_sub_area')
                ->join('checker','barang_dagang_in_history_update.id_checker','=','checker.id_checker')
                ->select('barang_dagang_in_history_update.doc_id','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_history_update.from','barang_dagang_in_history_update.kategori','barang_dagang_in_history_update.kode_zona','area.nama_area','barang_dagang_in_history_update.kode_zona_sub','area_sub.nama_sub_area','barang_dagang_in_history_update.id_checker','checker.nama_checker','barang_dagang_in_history_update.status','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_history_update.kategori')
                ->Where('barang_dagang_in_history_update.doc_id', $doc_id)
                ->first();

            $detail = DB::table('barang_dagang_in_detail_history_update')
                ->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
                ->Where('barang_dagang_in_detail_history_update.doc_id', $doc_id)
                ->get(); 
        }else if(Auth::user()->kategori == 'BS'){
            $head = DB::table('barang_dagang_in_history_update')
                ->join('area','barang_dagang_in_history_update.kode_zona_bs','=','area.kode_area')
                ->join('area_sub','barang_dagang_in_history_update.kode_zona_sub_bs','=','area_sub.kode_sub_area')
                ->join('checker','barang_dagang_in_history_update.id_checker_bs','=','checker.id_checker')
                ->select('barang_dagang_in_history_update.doc_id','barang_dagang_in_history_update.no_mobil','barang_dagang_in_history_update.nama_driver','barang_dagang_in_history_update.from','barang_dagang_in_history_update.kategori','barang_dagang_in_history_update.kode_zona_bs','area.nama_area','barang_dagang_in_history_update.kode_zona_sub_bs','area_sub.nama_sub_area','barang_dagang_in_history_update.id_checker_bs','checker.nama_checker','barang_dagang_in_history_update.status_bs','barang_dagang_in_history_update.kode_produksi','barang_dagang_in_history_update.kategori')
                ->Where('barang_dagang_in_history_update.doc_id', $doc_id)
                ->first();

            $detail = DB::table('barang_dagang_in_detail_history_update')
                ->join('product_dagang','barang_dagang_in_detail_history_update.kode_produk','=','product_dagang.kode_produk')
                ->Where('barang_dagang_in_detail_history_update.doc_id', $doc_id)
                ->get(); 
        }
    	
    	return view ('masuk_barang.checker_control.view',compact('head','detail'));	
    }

    public function store(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');

        $doc_id = DB::table('barang_dagang_in_history_update')
                ->select('barang_dagang_in_history_update.kategori')
                ->where('barang_dagang_in_history_update.doc_id', $request->get("doc_id"))
                ->first();

        $datas = [];
        foreach ($request->input('kode_produk') as $key => $value) {
           
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator){
            foreach ($request->input("kode_produk") as $key => $value) {
                if(Auth::user()->kategori == 'Layak'){
                    $qty = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("id_zona_primary_layak"))
                        ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_layak"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                    $stock = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("id_zona_primary_layak"))
                        ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_layak"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                        ->update([
                            'qty' => $qty->qty + $request->get("qty_layak")[$key]
                        ]);

                    $qty_history = DB::table('barang_dagang_in_detail_history_update')
                        ->select('barang_dagang_in_detail_history_update.qty_layak')
                        ->Where('barang_dagang_in_detail_history_update.doc_id', $request->get('doc_id'))
                        ->Where ('barang_dagang_in_detail_history_update.kode_produk', $request->get("kode_produk")[$key])
                        ->first();

                    $stock_history = DB::table('barang_dagang_in_detail_history_update')
                        ->select('barang_dagang_in_detail_history_update.qty_layak')
                        ->Where('barang_dagang_in_detail_history_update.doc_id', $request->get('doc_id'))
                        ->Where ('barang_dagang_in_detail_history_update.kode_produk', $request->get("kode_produk")[$key])
                        ->update([
                            'qty_layak' => $request->get("qty_layak")[$key]
                        ]);

                }else if(Auth::user()->kategori == 'BS'){
                    $qty = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("id_zona_primary_bs"))
                        ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_bs"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                    $stock = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("id_zona_primary_bs"))
                        ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_bs"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                        ->update([
                            'qty' => $qty->qty + $request->get("qty_bs")[$key]
                        ]);

                    if($doc_id->kategori == 'Primary'){


                        if(Auth::user()->kode_depo == '337'){ //BOGOR
                            $qty = DB::table('warehouse')
                            // ->select('warehouse.qty')
                            // ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            // ->Where('warehouse.kode_area', $request->get("id_zona_primary_bs"))
                            // ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_bs"))
                            // ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();
                            
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'F')
                            ->Where('warehouse.kode_sub_area', 'D4')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                            $stock = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'F')
                            ->Where('warehouse.kode_sub_area', 'D4')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            
                            // ->select('warehouse.qty')
                            // ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            // ->Where('warehouse.kode_area', $request->get("id_zona_primary_bs"))
                            // ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_bs"))
                            // ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            
                            ->update([
                                'qty' => $qty->qty + $request->get("qty_bs_ekspedisi")[$key]
                            ]);
                        }else if(Auth::user()->kode_depo == '901'){ //PARUNG
                            $qty = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'G')
                            ->Where('warehouse.kode_sub_area', 'E1')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                            $stock = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'G')
                            ->Where('warehouse.kode_sub_area', 'E1')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            ->update([
                                'qty' => $qty->qty + $request->get("qty_bs_ekspedisi")[$key]
                            ]);
                        }else if(Auth::user()->kode_depo == '342'){ //citeureup
                            $qty = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'F')
                            ->Where('warehouse.kode_sub_area', 'D4')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                            $stock = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'F')
                            ->Where('warehouse.kode_sub_area', 'D4')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            ->update([
                                'qty' => $qty->qty + $request->get("qty_bs_ekspedisi")[$key]
                            ]);
                        }else if(Auth::user()->kode_depo == '902'){ //metro
                            $qty = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'R')
                            ->Where('warehouse.kode_sub_area', 'D9')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                            $stock = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'R')
                            ->Where('warehouse.kode_sub_area', 'D9')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            ->update([
                                'qty' => $qty->qty + $request->get("qty_bs_ekspedisi")[$key]
                            ]);
                        }else if(Auth::user()->kode_depo == '343'){ //Padalarang
                            $qty = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'T')
                            ->Where('warehouse.kode_sub_area', 'B26')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                            $stock = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', 'T')
                            ->Where('warehouse.kode_sub_area', 'B26')
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            ->update([
                                'qty' => $qty->qty + $request->get("qty_bs_ekspedisi")[$key]
                            ]);
						}else if(Auth::user()->kode_depo == '034-W01'){
                            
                        }else if(Auth::user()->kode_depo == '034-W02'){
							
                        }else{
                            //  $qty = DB::table('warehouse')
                            // ->select('warehouse.qty')
                            // ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            // ->Where('warehouse.kode_area', 'F')
                            // ->Where('warehouse.kode_sub_area', 'D4')
                            // ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                            $qty = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', $request->get("id_zona_primary_bs"))
                            ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_bs"))
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                            //$stock = DB::table('warehouse')
                            // ->select('warehouse.qty')
                            // ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            // ->Where('warehouse.kode_area', 'F')
                            // ->Where('warehouse.kode_sub_area', 'D4')
                            // ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            $stock = DB::table('warehouse')
                            ->select('warehouse.qty')
                            ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                            ->Where('warehouse.kode_area', $request->get("id_zona_primary_bs"))
                            ->Where('warehouse.kode_sub_area', $request->get("id_sub_zona_primary_bs"))
                            ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                            ->update([
                                'qty' => $qty->qty + $request->get("qty_bs_ekspedisi")[$key]
                            ]);
                        }
                    

                        $qty_history = DB::table('barang_dagang_in_detail_history_update')
                        ->select('barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_detail_history_update.qty_ekspedisi')
                        ->Where('barang_dagang_in_detail_history_update.doc_id', $request->get('doc_id'))
                        ->Where ('barang_dagang_in_detail_history_update.kode_produk', $request->get("kode_produk")[$key])
                        ->first();

                        $stock_history = DB::table('barang_dagang_in_detail_history_update')
                        ->select('barang_dagang_in_detail_history_update.qty_bs')
                        ->Where('barang_dagang_in_detail_history_update.doc_id', $request->get('doc_id'))
                        ->Where ('barang_dagang_in_detail_history_update.kode_produk', $request->get("kode_produk")[$key])
                        ->update([
                            'qty_bs' => $request->get("qty_bs")[$key],
                            'qty_ekspedisi' => $request->get("qty_bs_ekspedisi")[$key]
                        ]);


                    }else if($doc_id->kategori == 'Secondary'){
                        
                    

                        $qty_history = DB::table('barang_dagang_in_detail_history_update')
                        ->select('barang_dagang_in_detail_history_update.qty_bs','barang_dagang_in_detail_history_update.qty_ekspedisi')
                        ->Where('barang_dagang_in_detail_history_update.doc_id', $request->get('doc_id'))
                        ->Where ('barang_dagang_in_detail_history_update.kode_produk', $request->get("kode_produk")[$key])
                        ->first();

                        $stock_history = DB::table('barang_dagang_in_detail_history_update')
                        ->select('barang_dagang_in_detail_history_update.qty_bs')
                        ->Where('barang_dagang_in_detail_history_update.doc_id', $request->get('doc_id'))
                        ->Where ('barang_dagang_in_detail_history_update.kode_produk', $request->get("kode_produk")[$key])
                        ->update([
                            'qty_bs' => $request->get("qty_bs")[$key],
                            'qty_ekspedisi' => $request->get("qty_bs_ekspedisi")[$key]
                        ]);
                    

                    }

                    
                }
                
            }
        }

        if(Auth::user()->kode_depo == '034-W01'){
            $barang_dagang_update = BarangDagang_In::find($request->get('doc_id'));
            $barang_dagang_update->update([
                    'status_bs' => '1',
                    'status' => '1',
                    'kode_produksi' => 'BB'.' '.$request->get("tgl_kode_produksi")
            ]);

            $barang_dagang_update = BarangDagang_In_History::find($request->get('doc_id'));
            $barang_dagang_update->update([
                    'status_bs' => '1',
                    'status' => '1',
                    'waktu' => Carbon::now()->format('H:i:s'),
                    'kode_produksi' => 'BB'.' '.$request->get("tgl_kode_produksi")
            ]);
        }else if(Auth::user()->kode_depo == '034-W02'){
            $barang_dagang_update = BarangDagang_In::find($request->get('doc_id'));
            $barang_dagang_update->update([
                    'status_bs' => '1',
                    'status' => '1',
                    'kode_produksi' => 'BB'.' '.$request->get("tgl_kode_produksi")
            ]);

            $barang_dagang_update = BarangDagang_In_History::find($request->get('doc_id'));
            $barang_dagang_update->update([
                    'status_bs' => '1',
                    'status' => '1',
                    'waktu' => Carbon::now()->format('H:i:s'),
                    'kode_produksi' => 'BB'.' '.$request->get("tgl_kode_produksi")
            ]);
        }else{
            if(Auth::user()->kategori == 'Layak'){
                $barang_dagang_update = BarangDagang_In::find($request->get('doc_id'));
                $barang_dagang_update->update([
                    'status' => '1',
                    'kode_produksi' => $request->get("kode_produksi")
                ]);

                $barang_dagang_update = BarangDagang_In_History::find($request->get('doc_id'));
                $barang_dagang_update->update([
                    'status' => '1',
                    'waktu' => Carbon::now()->format('H:i:s'),
                    'kode_produksi' => $request->get("kode_produksi")
                ]);
            }else if(Auth::user()->kategori == 'BS'){
                $barang_dagang_update = BarangDagang_In::find($request->get('doc_id'));
                $barang_dagang_update->update([
                    'status_bs' => '1',
                    'kode_produksi' => $request->get("kode_produksi")
                ]);

                $barang_dagang_update = BarangDagang_In_History::find($request->get('doc_id'));
                $barang_dagang_update->update([
                    'status_bs' => '1',
                    'waktu' => Carbon::now()->format('H:i:s'),
                    'kode_produksi' => $request->get("kode_produksi")
                ]);
            } 
        }
        
        alert()->success('Success.','Update Success');
        return redirect()->route('check_control.index');

        //return redirect(route('check_control.index'))->with(['success' => 'Update Success']);
    }
}
