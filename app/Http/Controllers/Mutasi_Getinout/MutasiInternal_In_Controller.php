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

class MutasiInternal_In_Controller extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

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
            //->Where('mutasi_gudang.id_user_input', Auth::user()->id)
            ->WhereIn('mutasi_gudang.status', ['1','2'])
        	->get();

    	return view('mutasi_getinout.internal_in.index', compact('mutasi'));
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
            ->WhereIn('mutasi_gudang.status', ['1','2'])
            ->get();


        return view('mutasi_getinout.internal_in.index', compact('mutasi'));
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
        	->select('mutasi_gudang.kode_mutasi','mutasi_gudang.tanggal','mutasi_gudang.waktu','mutasi_gudang.kode_area_asal','area_asal.nama_area as nama_area_asal','mutasi_gudang.kode_sub_area_asal','area_sub_asal.nama_sub_area as nama_sub_area_asal','mutasi_gudang.kode_area_tujuan','area_tujuan.nama_area as nama_area_tujuan','mutasi_gudang.kode_sub_area_tujuan','area_sub_tujuan.nama_sub_area as nama_sub_area_tujuan','mutasi_gudang.status')
        	->Where('mutasi_gudang.kode_mutasi', $kode_mutasi)
        	->first();

        $detail = DB::table('mutasi_gudang_detail')
                ->join('product_dagang','mutasi_gudang_detail.kode_produk','=','product_dagang.kode_produk')
                ->Where('mutasi_gudang_detail.kode_mutasi', $kode_mutasi)
                ->get();

    	return view ('mutasi_getinout.internal_in.view', compact('head','detail'));  
    }

    public function store(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$kode_depo = Auth::user()->kode_depo;
    	$date_1 = (date('dmY'));

        $update_data = MutasiGudang::find($request->get('doc_id'));
        $update_data->update([
            'status' => '2',
            'id_user_input_masuk' => Auth::user()->id
        ]);


        $datas = [];
        foreach ($request->input('kode_produk') as $key => $value) {
    
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
        	foreach ($request->input("kode_produk") as $key => $value) {
                //mengurangi dari zona asal
                $qty_asal = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("kd_dari_zona"))
                        ->Where('warehouse.kode_sub_area', $request->get("kd_dari_sub_zona"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                        ->first();

                    $stock_asal = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("kd_dari_zona"))
                        ->Where('warehouse.kode_sub_area', $request->get("kd_dari_sub_zona"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                        ->update([
                            'qty' => $qty_asal->qty - $request->get("qty")[$key]
                        ]);

                //bertambah di zona tujuan
                $qty_tujuan = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("kd_ke_zona"))
                        ->Where('warehouse.kode_sub_area', $request->get("kd_ke_sub_zona"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)->first();

                    $stock_tujuan = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get("kd_ke_zona"))
                        ->Where('warehouse.kode_sub_area', $request->get("kd_ke_sub_zona"))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                        ->update([
                            'qty' => $qty_tujuan->qty + $request->get("qty")[$key]
                        ]);
            }	
        }

       

        alert()->success('Success.','Success');
        return redirect()->route('mutasi_internal_in.index');

    }
}
