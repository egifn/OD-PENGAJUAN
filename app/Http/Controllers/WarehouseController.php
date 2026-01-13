<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Area;
use App\Area_Sub;
use App\Warehouse;
use App\Perusahaan;
use App\Depo;
use Auth;
use DB;

class WarehouseController extends Controller
{   
    public function ajax_depo_warehouse(Request $request) // dropdown perusahaan dan depo
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

        if(Auth::user()->kode_divisi == '22'){
            $warehouse = DB::table('warehouse')
                    ->join('perusahaans','warehouse.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','warehouse.kode_depo','=','depos.kode_depo')
                    ->join('product_dagang','warehouse.kode_produk','=','product_dagang.kode_produk')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->Where('warehouse.kode_depo', '')
                    ->orderBy('warehouse.id_warehouse', 'ASC')
                    ->get();
        }else{
            if(Auth::user()->kode_depo == '337'){ //BOGOR
                $warehouse = DB::table('warehouse')
                    ->join('perusahaans','warehouse.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','warehouse.kode_depo','=','depos.kode_depo')
                    ->join('product_dagang','warehouse.kode_produk','=','product_dagang.kode_produk')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->Where('warehouse.kode_depo', '337')
                    ->orderBy('warehouse.id_warehouse', 'ASC')
                    ->get();
            }else if(Auth::user()->kode_depo == '901'){ //PARUNG
                $warehouse = DB::table('warehouse')
                    ->join('perusahaans','warehouse.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','warehouse.kode_depo','=','depos.kode_depo')
                    ->join('product_dagang','warehouse.kode_produk','=','product_dagang.kode_produk')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->Where('warehouse.kode_depo', '901')
                    ->orderBy('warehouse.kode_sub_area', 'ASC')
                    ->get();
            }else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
                $warehouse = DB::table('warehouse')
                    ->join('perusahaans','warehouse.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','warehouse.kode_depo','=','depos.kode_depo')
                    ->join('product_dagang','warehouse.kode_produk','=','product_dagang.kode_produk')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->Where('warehouse.kode_depo', '342')
                    ->orderBy('warehouse.id_warehouse', 'ASC')
                    ->get();
            }else{
                $warehouse = DB::table('warehouse')
                    ->join('perusahaans','warehouse.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','warehouse.kode_depo','=','depos.kode_depo')
                    ->join('product_dagang','warehouse.kode_produk','=','product_dagang.kode_produk')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->orderBy('warehouse.id_warehouse', 'ASC')
                    ->get();
            }
        }
    	
    	return view('masuk_barang.warehouse.index', compact('warehouse','perusahaan','depo'));
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
            $warehouse = DB::table('warehouse')
                    ->join('perusahaans','warehouse.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','warehouse.kode_depo','=','depos.kode_depo')
                    ->join('product_dagang','warehouse.kode_produk','=','product_dagang.kode_produk')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->Where('warehouse.kode_perusahaan', '')
                    ->Where('warehouse.kode_depo', '')
                    ->orderBy('warehouse.id_warehouse', 'ASC')
                    ->get();
        }elseif($perusahaan_cari != '' && $depo_cari != ''){
            $warehouse = DB::table('warehouse')
                    ->join('perusahaans','warehouse.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','warehouse.kode_depo','=','depos.kode_depo')
                    ->join('product_dagang','warehouse.kode_produk','=','product_dagang.kode_produk')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->Where('warehouse.kode_perusahaan', $perusahaan_cari)
                    ->Where('warehouse.kode_depo', $depo_cari)
                    ->orderBy('warehouse.id_warehouse', 'ASC')
                    ->get();
        }

        return view('masuk_barang.warehouse.index', compact('warehouse','perusahaan','depo'));
    }

    public function ajax_area(Request $request)
    {
    	$sub_area = Area_Sub::Where('kode_area', $request->area_id)->pluck('kode_sub_area','nama_sub_area');
    	return response()->json($sub_area);
    }

    public function create(Request $request)
    {
    	//$area = Area::orderBy('kode_area','ASC')->get();
    	$area = DB::table('area')
                    ->Where('area.kode_depo', Auth::user()->kode_depo)
                    ->get();
		$kode_area = $request->get('1');
    	$area_sub = DB::table('area_sub')->where('kode_area', $kode_area)
    					->orderBy('kode_sub_area', 'ASC')
    					->get();

    	return view('masuk_barang.warehouse.create', compact('area','area_sub'));
    }

    public function actionProduct(Request $request)
    {
    	if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('product_dagang')
                        ->where('product_dagang.kode_produk','like','%'.$query.'%')
                        ->orWhere('product_dagang.nama_produk','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('product_dagang')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih" data-kode_produk="'.$row->kode_produk.'" data-nama_produk="'.$row->nama_produk.'">
                        <td>'.$row->kode_produk.'</td>
                        <td>'.$row->nama_produk.'</td>
                    </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function store_2(Request $request)
    {
    	$this->validate($request, [
    		'kode_produk' => 'required|string',
            'kode_area' => 'required|string',
            'kode_sub_area' => 'required|string'
    	]);

    	Warehouse::create([
    		'kode_perusahaan' => Auth::user()->kode_perusahaan,
    		'kode_depo' => Auth::user()->kode_depo,
    		'kode_produk' => $request->get('kode_produk'),
            'kode_area' => $request->get('kode_area'),
            'kode_sub_area' => $request->get('kode_sub_area'),
            'qty' => 0
    	]);

    	return redirect(route('warehouse.index'))->with(['success' => 'New area added']);
    }

    public function store_1(Request $request)
    {

        $datas = [];
        foreach ($request->input('id_warehouse') as $key => $value) {
           
        }
        
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input("id_warehouse") as $key => $value) {
                $stock = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.id_warehouse', $request->get("id_warehouse")[$key])
                        ->update([
                            'qty' => $request->get("qty")[$key]
                ]);
            }
        }

        alert()->success('Success.','Update Success');
        return redirect()->route('warehouse.index');
    }
}
