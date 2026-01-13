<?php

namespace App\Http\Controllers\Mutasi_Getinout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MutasiGudangEks;
use App\MutasiGudangEks_Detail;
use Carbon\carbon;
use DB;
use Auth;

class MutasiEksternalCheckerInController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data = DB::table('mutasi_gudang_eks')
            ->join('perusahaans','mutasi_gudang_eks.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang_eks.kode_depo','=','depos.kode_depo')
            ->join('area as area_asal','mutasi_gudang_eks.kode_area_asal','=','area_asal.kode_area')
            ->join('area_sub as area_sub_asal','mutasi_gudang_eks.kode_sub_area_asal','area_sub_asal.kode_sub_area')
            ->join('perusahaans AS perusahaan_tujuan','mutasi_gudang_eks.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos AS depo_tujuan','mutasi_gudang_eks.kode_depo_tujuan','=','depo_tujuan.kode_depo')
            ->join('users','mutasi_gudang_eks.id_user_input','=','users.id')
            ->select('mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.doc_id','mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.tanggal','mutasi_gudang_eks.waktu','mutasi_gudang_eks.kategori','mutasi_gudang_eks.kode_perusahaan','mutasi_gudang_eks.kode_depo','perusahaans.nama_perusahaan','depos.nama_depo','area_asal.nama_area AS nama_area_asal','area_sub_asal.nama_sub_area AS nama_sub_area_asal','mutasi_gudang_eks.no_mobil','mutasi_gudang_eks.nama_driver','mutasi_gudang_eks.kode_perusahaan_tujuan','mutasi_gudang_eks.kode_depo_tujuan','perusahaan_tujuan.nama_perusahaan AS perusahaan_tujuan','depo_tujuan.nama_depo AS depo_tujuan','mutasi_gudang_eks.status','mutasi_gudang_eks.status_bm','mutasi_gudang_eks.id_user_input','users.name')
            ->WhereBetween('mutasi_gudang_eks.tanggal', [$date_start,$date_end])
            ->Where('mutasi_gudang_eks.status', '1')
            ->Where('mutasi_gudang_eks.kode_depo_tujuan', Auth::user()->kode_depo)
            ->orderBy('mutasi_gudang_eks.tanggal', "DESC")
            ->get();

    	return view('mutasi_getinout.eksternal_checker_in.index', compact('data'));
    }

    public function cari(Request $request)
    {
    	$kategori = $request->kategori;
        
        date_default_timezone_set('Asia/Jakarta');

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->kategori != '')
        {
            $kategori = request()->kategori;
        }

        if($kategori=='')
        {
            $data = DB::table('mutasi_gudang_eks')
            ->join('perusahaans','mutasi_gudang_eks.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang_eks.kode_depo','=','depos.kode_depo')
            ->join('area as area_asal','mutasi_gudang_eks.kode_area_asal','=','area_asal.kode_area')
            ->join('area_sub as area_sub_asal','mutasi_gudang_eks.kode_sub_area_asal','area_sub_asal.kode_sub_area')
            ->join('perusahaans AS perusahaan_tujuan','mutasi_gudang_eks.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos AS depo_tujuan','mutasi_gudang_eks.kode_depo_tujuan','=','depo_tujuan.kode_depo')
            ->join('users','mutasi_gudang_eks.id_user_input','=','users.id')
            ->select('mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.doc_id','mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.tanggal','mutasi_gudang_eks.waktu','mutasi_gudang_eks.kategori','mutasi_gudang_eks.kode_perusahaan','mutasi_gudang_eks.kode_depo','perusahaans.nama_perusahaan','depos.nama_depo','area_asal.nama_area AS nama_area_asal','area_sub_asal.nama_sub_area AS nama_sub_area_asal','mutasi_gudang_eks.no_mobil','mutasi_gudang_eks.nama_driver','mutasi_gudang_eks.kode_perusahaan_tujuan','mutasi_gudang_eks.kode_depo_tujuan','perusahaan_tujuan.nama_perusahaan AS perusahaan_tujuan','depo_tujuan.nama_depo AS depo_tujuan','mutasi_gudang_eks.status','mutasi_gudang_eks.status_bm','mutasi_gudang_eks.id_user_input','users.name')
            ->WhereBetween('mutasi_gudang_eks.tanggal', [$date_start,$date_end])
            ->Where('mutasi_gudang_eks.status', '1')
            ->Where('mutasi_gudang_eks.kode_depo_tujuan', Auth::user()->kode_depo)
            ->orderBy('mutasi_gudang_eks.tanggal', "DESC")
            ->get();
        }else{
            $data = DB::table('mutasi_gudang_eks')
            ->join('perusahaans','mutasi_gudang_eks.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang_eks.kode_depo','=','depos.kode_depo')
            ->join('area as area_asal','mutasi_gudang_eks.kode_area_asal','=','area_asal.kode_area')
            ->join('area_sub as area_sub_asal','mutasi_gudang_eks.kode_sub_area_asal','area_sub_asal.kode_sub_area')
            ->join('perusahaans AS perusahaan_tujuan','mutasi_gudang_eks.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos AS depo_tujuan','mutasi_gudang_eks.kode_depo_tujuan','=','depo_tujuan.kode_depo')
            ->join('users','mutasi_gudang_eks.id_user_input','=','users.id')
            ->select('mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.doc_id','mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.tanggal','mutasi_gudang_eks.waktu','mutasi_gudang_eks.kategori','mutasi_gudang_eks.kode_perusahaan','mutasi_gudang_eks.kode_depo','perusahaans.nama_perusahaan','depos.nama_depo','area_asal.nama_area AS nama_area_asal','area_sub_asal.nama_sub_area AS nama_sub_area_asal','mutasi_gudang_eks.no_mobil','mutasi_gudang_eks.nama_driver','mutasi_gudang_eks.kode_perusahaan_tujuan','mutasi_gudang_eks.kode_depo_tujuan','perusahaan_tujuan.nama_perusahaan AS perusahaan_tujuan','depo_tujuan.nama_depo AS depo_tujuan','mutasi_gudang_eks.status','mutasi_gudang_eks.status_bm','mutasi_gudang_eks.id_user_input','users.name')
            ->WhereBetween('mutasi_gudang_eks.tanggal', [$date_start,$date_end])
            ->Where('mutasi_gudang_eks.status', '1')
            ->Where('mutasi_gudang_eks.kode_depo_tujuan', Auth::user()->kode_depo)
            ->Where('mutasi_gudang_eks.kategori', $kategori)
            ->orderBy('mutasi_gudang_eks.tanggal', "DESC")
            ->get();
        }
        return view('mutasi_getinout.eksternal_checker_in.index', compact('data'));
    }

    public function view($kode_mutasi_eks)
    {
        $data_head = DB::table('mutasi_gudang_eks')
            ->join('perusahaans','mutasi_gudang_eks.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang_eks.kode_depo','=','depos.kode_depo')
            ->join('users','mutasi_gudang_eks.id_user_input','=','users.id')
            ->leftJoin('area as area_asal','mutasi_gudang_eks.kode_area_tujuan','=','area_asal.kode_area')
            ->leftJoin('area_sub as area_sub_asal','mutasi_gudang_eks.kode_sub_area_tujuan','area_sub_asal.kode_sub_area')
            ->leftJoin('checker','mutasi_gudang_eks.id_checker_tujuan','=','checker.id_checker')
            ->Where('mutasi_gudang_eks.kode_mutasi_eks', $kode_mutasi_eks)
            ->first();

        $data_detail = DB::table('mutasi_gudang_eks_detail')
                ->join('product_dagang','mutasi_gudang_eks_detail.kode_produk','=','product_dagang.kode_produk')
                ->Where('mutasi_gudang_eks_detail.kode_mutasi_eks', $kode_mutasi_eks)
                ->get();

        return view ('mutasi_getinout.eksternal_checker_in.view', compact('data_head','data_detail'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $update_data = MutasiGudangEks::find($request->get('bkb_mutasi'));
        $update_data->update([
            'status_bm' => '2'
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
                        ->Where('warehouse.kode_area', $request->get('kd_zona_eksternal_in'))
                        ->Where('warehouse.kode_sub_area', $request->get('kd_sub_zona_eksternal_in'))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                        ->first();

                    $stock_asal = DB::table('warehouse')
                        ->select('warehouse.qty')
                        ->Where('warehouse.kode_produk', $request->get("kode_produk")[$key])
                        ->Where('warehouse.kode_area', $request->get('kd_zona_eksternal_in'))
                        ->Where('warehouse.kode_sub_area', $request->get('kd_sub_zona_eksternal_in'))
                        ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                        ->update([
                            'qty' => $qty_asal->qty + $request->get("qty")[$key]
                        ]);
            }   
        }

        alert()->success('Success.','Success');
        return redirect()->route('mutasi_eksternal_in_checker.index');
    }
}
