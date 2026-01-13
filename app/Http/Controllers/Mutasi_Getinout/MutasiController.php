<?php

namespace App\Http\Controllers\Mutasi_Getinout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Area;
use App\Area_sub;
use App\MutasiGudang;
use App\MutasiGudang_Detail;
use Carbon\carbon;
use Auth;
use DB;

class MutasiController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        // $in = DB::table('barang_dagang_in')
        //             ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
        //             ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
        //             ->WhereBetween('barang_dagang_in.tanggal', [$date_start,$date_end])
        //             ->Where('barang_dagang_in.kode_depo', '337')
        //             ->get();

        $mutasi = DB::table('mutasi_gudang')
        	->join('perusahaans','mutasi_gudang.kode_perusahaan','=','perusahaans.kode_perusahaan')
        	->join('depos','mutasi_gudang.kode_depo','=','depos.kode_depo')
        	->join('area as area_asal','mutasi_gudang.kode_area_asal','=','area_asal.kode_area')
        	->join('area_sub as area_sub_asal','mutasi_gudang.kode_sub_area_asal','area_sub_asal.kode_sub_area')
        	->join('area as area_tujuan','mutasi_gudang.kode_area_tujuan','=','area_tujuan.kode_area')
        	->join('area_sub as area_sub_tujuan','mutasi_gudang.kode_sub_area_tujuan','=','area_sub_tujuan.kode_sub_area')
        	->join('users','mutasi_gudang.id_user_input','=','users.id')
        	->select('mutasi_gudang.kode_mutasi','mutasi_gudang.tanggal','mutasi_gudang.waktu','area_asal.nama_area as nama_area_asal','area_sub_asal.nama_sub_area as nama_sub_area_asal','area_tujuan.nama_area as nama_area_tujuan','area_sub_tujuan.nama_sub_area as nama_sub_area_tujuan','mutasi_gudang.status')
        	->WhereBetween('mutasi_gudang.tanggal', [$date_start,$date_end])
        	->Where('mutasi_gudang.kode_depo', Auth::user()->kode_depo)
            ->Where('mutasi_gudang.id_user_input', Auth::user()->id)
        	->get();

    	return view('mutasi_getinout.internal.index', compact('mutasi'));
    }

    public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $mutasi = DB::table('mutasi_gudang')
            ->join('perusahaans','mutasi_gudang.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang.kode_depo','=','depos.kode_depo')
            ->join('area as area_asal','mutasi_gudang.kode_area_asal','=','area_asal.kode_area')
            ->join('area_sub as area_sub_asal','mutasi_gudang.kode_sub_area_asal','area_sub_asal.kode_sub_area')
            ->join('area as area_tujuan','mutasi_gudang.kode_area_tujuan','=','area_tujuan.kode_area')
            ->join('area_sub as area_sub_tujuan','mutasi_gudang.kode_sub_area_tujuan','=','area_sub_tujuan.kode_sub_area')
            ->join('users','mutasi_gudang.id_user_input','=','users.id')
            ->select('mutasi_gudang.kode_mutasi','mutasi_gudang.tanggal','mutasi_gudang.waktu','area_asal.nama_area as nama_area_asal','area_sub_asal.nama_sub_area as nama_sub_area_asal','area_tujuan.nama_area as nama_area_tujuan','area_sub_tujuan.nama_sub_area as nama_sub_area_tujuan','mutasi_gudang.status')
            ->WhereBetween('mutasi_gudang.tanggal', [$date_start,$date_end])
            ->Where('mutasi_gudang.kode_depo', Auth::user()->kode_depo)
            ->Where('mutasi_gudang.id_user_input', Auth::user()->id)
            ->get();


        return view('mutasi_getinout.internal.index', compact('mutasi'));
    }

    public function view($kode_mutasi)
    {
        $head = DB::table('mutasi_gudang')
        	->join('perusahaans','mutasi_gudang.kode_perusahaan','=','perusahaans.kode_perusahaan')
        	->join('depos','mutasi_gudang.kode_depo','=','depos.kode_depo')
        	->join('area as area_asal','mutasi_gudang.kode_area_asal','=','area_asal.kode_area')
        	->join('area_sub as area_sub_asal','mutasi_gudang.kode_sub_area_asal','area_sub_asal.kode_sub_area')
        	->join('area as area_tujuan','mutasi_gudang.kode_area_tujuan','=','area_tujuan.kode_area')
        	->join('area_sub as area_sub_tujuan','mutasi_gudang.kode_sub_area_tujuan','=','area_sub_tujuan.kode_sub_area')
        	->join('users','mutasi_gudang.id_user_input','=','users.id')
        	->select('mutasi_gudang.kode_mutasi','mutasi_gudang.tanggal','mutasi_gudang.waktu','area_asal.nama_area as nama_area_asal','area_sub_asal.nama_sub_area as nama_sub_area_asal','area_tujuan.nama_area as nama_area_tujuan','area_sub_tujuan.nama_sub_area as nama_sub_area_tujuan','mutasi_gudang.status')
        	->Where('mutasi_gudang.kode_mutasi', $kode_mutasi)
        	->first();

        $detail = DB::table('mutasi_gudang_detail')
                ->join('product_dagang','mutasi_gudang_detail.kode_produk','=','product_dagang.kode_produk')
                ->Where('mutasi_gudang_detail.kode_mutasi', $kode_mutasi)
                ->get();

    	return view ('mutasi_getinout.internal.view', compact('head','detail'));  
    }

    public function ajax_zona_mutasi(Request $request) // dropdown perusahaan dan depo
    {
        $dari_zona = Area_sub::Where('kode_area', $request->dari_zona_)
                                ->pluck('kode_sub_area','nama_sub_area');
        return response()->json($dari_zona);
    }

    public function ajax_zona_mutasi_ke(Request $request) // dropdown perusahaan dan depo
    {
        $ke_zona = Area_sub::Where('kode_area', $request->ke_zona_)
                                ->pluck('kode_sub_area','nama_sub_area');
        return response()->json($ke_zona);
    }

    public function create(Request $request)
    {
    	$area_dari = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

        $area_ke = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

    	return view('mutasi_getinout.internal.create', compact('area_dari','area_ke'));
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

    public function store(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$kode_depo = Auth::user()->kode_depo;
    	$date_1 = (date('dmY'));

    	$getRow = DB::table('mutasi_gudang')->select(DB::raw('MAX(RIGHT(kode_mutasi,4)) as NoUrut'));
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
        	if ($rowCount < 9) {
                    $kode_mutasi = $kode_depo.'-'.$date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $kode_mutasi = $kode_depo.'-'.$date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $kode_mutasi = $kode_depo.'-'.$date_1."0".''.($rowCount + 1);
            } else {
                    $kode_mutasi = $kode_depo.'-'.$date_1.($rowCount + 1);
            }
        }else{
        	$kode_mutasi = $kode_depo.'-'.$date_1.sprintf("%04s", 1);
        }

        MutasiGudang::create([
        	'kode_mutasi' => $kode_mutasi,
        	'kode_perusahaan' => Auth::user()->kode_perusahaan,
        	'kode_depo' => Auth::user()->kode_depo,
        	'tanggal' => Carbon::now()->format('Y-m-d'),
            'waktu' => Carbon::now()->format('H:i:s'),
        	'kode_area_asal' => $request->get('dari_zona'),
        	'kode_sub_area_asal' => $request->get('dari_sub_zona'), 
        	'kode_area_tujuan' => $request->get('ke_zona'),
        	'kode_sub_area_tujuan' => $request->get('ke_sub_zona'),
        	'status' => '0',
        	'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('kode_produk') as $key => $value) {
            //$datas["kode_produk.{$key}"] = 'required';
            //$datas["qty.{$key}"] = 'required'; 
            //$datas["qty_layak.{$key}"] = 'required';
            //$datas["qty_bs.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
        	foreach ($request->input("kode_produk") as $key => $value) {
                $data = new MutasiGudang_Detail;

                $data->kode_mutasi = $kode_mutasi;
                $data->kode_produk = $request->get("kode_produk")[$key];
                $data->qty = $request->get("qty")[$key];
                    
                $data->save();

                //mengurangi dari zona asal
                // $qty_asal = DB::table('warehouse')
                //         ->select('warehouse.qty')
                //         ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                //         ->Where('warehouse.kode_area', $request->get("dari_zona"))
                //         ->Where('warehouse.kode_sub_area', $request->get("dari_sub_zona"))
                //         ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                //         ->first();

                //     $stock_asal = DB::table('warehouse')
                //         ->select('warehouse.qty')
                //         ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                //         ->Where('warehouse.kode_area', $request->get("dari_zona"))
                //         ->Where('warehouse.kode_sub_area', $request->get("dari_sub_zona"))
                //         ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                //         ->update([
                //             'qty' => $qty_asal->qty - $request->get("qty")[$key]
                //         ]);

                // //bertambah di zona tujuan
                // $qty_tujuan = DB::table('warehouse')
                //         ->select('warehouse.qty')
                //         ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                //         ->Where('warehouse.kode_area', $request->get("ke_zona"))
                //         ->Where('warehouse.kode_sub_area', $request->get("ke_sub_zona"))
                //         ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                //     $stock_tujuan = DB::table('warehouse')
                //         ->select('warehouse.qty')
                //         ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                //         ->Where('warehouse.kode_area', $request->get("ke_zona"))
                //         ->Where('warehouse.kode_sub_area', $request->get("ke_sub_zona"))
                //         ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                //         ->update([
                //             'qty' => $qty_tujuan->qty - $request->get("qty")[$key]
                //         ]);
            }	
        }

        //===============================================
        //===============================================
        //Buat update stock di master warehouse dan stock
        //===============================================
        //===============================================

        alert()->success('Success.','Success');
        return redirect()->route('mutasi.index');

    }
}
