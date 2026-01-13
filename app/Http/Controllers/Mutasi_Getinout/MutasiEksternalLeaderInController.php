<?php

namespace App\Http\Controllers\Mutasi_Getinout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\carbon;
use App\Area;
use App\Area_sub;
use App\Depo;
use App\Perusahaan;
use App\MutasiGudangEks;
use App\MutasiGudangEks_Detail;
use Auth;
use DB;

class MutasiEksternalLeaderInController extends Controller
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
            ->select('mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.doc_id','mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.tanggal','mutasi_gudang_eks.waktu','mutasi_gudang_eks.kategori','mutasi_gudang_eks.kode_perusahaan','mutasi_gudang_eks.kode_depo','perusahaans.nama_perusahaan','depos.nama_depo','area_asal.nama_area AS nama_area_asal','area_sub_asal.nama_sub_area AS nama_sub_area_asal','mutasi_gudang_eks.no_mobil','mutasi_gudang_eks.nama_driver','mutasi_gudang_eks.kode_perusahaan_tujuan','mutasi_gudang_eks.kode_depo_tujuan','perusahaan_tujuan.nama_perusahaan AS perusahaan_tujuan','depo_tujuan.nama_depo AS depo_tujuan','mutasi_gudang_eks.status','mutasi_gudang_eks.id_user_input','users.name')
            ->WhereBetween('mutasi_gudang_eks.tanggal', [$date_start,$date_end])
            ->Where('mutasi_gudang_eks.kode_depo_tujuan', Auth::user()->kode_depo)
            ->orderBy('mutasi_gudang_eks.tanggal', "DESC")
            ->get();

    	return view('mutasi_getinout.eksternal_leader_in.index', compact('data'));
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
            ->select('mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.doc_id','mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.tanggal','mutasi_gudang_eks.waktu','mutasi_gudang_eks.kategori','mutasi_gudang_eks.kode_perusahaan','mutasi_gudang_eks.kode_depo','perusahaans.nama_perusahaan','depos.nama_depo','area_asal.nama_area AS nama_area_asal','area_sub_asal.nama_sub_area AS nama_sub_area_asal','mutasi_gudang_eks.no_mobil','mutasi_gudang_eks.nama_driver','mutasi_gudang_eks.kode_perusahaan_tujuan','mutasi_gudang_eks.kode_depo_tujuan','perusahaan_tujuan.nama_perusahaan AS perusahaan_tujuan','depo_tujuan.nama_depo AS depo_tujuan','mutasi_gudang_eks.status','mutasi_gudang_eks.id_user_input','users.name')
            ->WhereBetween('mutasi_gudang_eks.tanggal', [$date_start,$date_end])
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
            ->select('mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.doc_id','mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.tanggal','mutasi_gudang_eks.waktu','mutasi_gudang_eks.kategori','mutasi_gudang_eks.kode_perusahaan','mutasi_gudang_eks.kode_depo','perusahaans.nama_perusahaan','depos.nama_depo','area_asal.nama_area AS nama_area_asal','area_sub_asal.nama_sub_area AS nama_sub_area_asal','mutasi_gudang_eks.no_mobil','mutasi_gudang_eks.nama_driver','mutasi_gudang_eks.kode_perusahaan_tujuan','mutasi_gudang_eks.kode_depo_tujuan','perusahaan_tujuan.nama_perusahaan AS perusahaan_tujuan','depo_tujuan.nama_depo AS depo_tujuan','mutasi_gudang_eks.status','mutasi_gudang_eks.id_user_input','users.name')
            ->WhereBetween('mutasi_gudang_eks.tanggal', [$date_start,$date_end])
            ->Where('mutasi_gudang_eks.kode_depo_tujuan', Auth::user()->kode_depo)
            ->Where('mutasi_gudang_eks.kategori', $kategori)
            ->orderBy('mutasi_gudang_eks.tanggal', "DESC")
            ->get();
        }
        return view('mutasi_getinout.eksternal_leader_in.index', compact('data'));
    }

    public function ajax_zona_eksternal_in(Request $request) // dropdown perusahaan dan depo
    {
        $zona_eksternal_in = Area_sub::Where('kode_area', $request->eksternal_in)
                                ->pluck('kode_sub_area','nama_sub_area');
        return response()->json($zona_eksternal_in);
    }

    public function view($kode_mutasi_eks)
    {
        $area = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

        $checker_layak=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'Layak')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->get();

        // $checker_bs=DB::table('checker')
        //                 ->Where('checker.kode_depo', Auth::user()->kode_depo)
        //                 ->Where('checker.kategori', 'BS')
        //                 ->Where('checker.kode_depo', Auth::user()->kode_depo)
        //                 ->get();

        $data_head = DB::table('mutasi_gudang_eks')
            ->join('perusahaans','mutasi_gudang_eks.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang_eks.kode_depo','=','depos.kode_depo')
            ->join('users','mutasi_gudang_eks.id_user_input','=','users.id')
            ->leftJoin('area','mutasi_gudang_eks.kode_area_tujuan','=','area.kode_area')
            ->leftJoin('area_sub','mutasi_gudang_eks.kode_sub_area_tujuan','=','area_sub.kode_sub_area')
            ->leftJoin ('checker','mutasi_gudang_eks.id_checker_tujuan','=','checker.id_checker')
            ->Where('mutasi_gudang_eks.kode_mutasi_eks', $kode_mutasi_eks)
            ->first();

        $data_detail = DB::table('mutasi_gudang_eks_detail')
                ->join('product_dagang','mutasi_gudang_eks_detail.kode_produk','=','product_dagang.kode_produk')
                ->Where('mutasi_gudang_eks_detail.kode_mutasi_eks', $kode_mutasi_eks)
                ->get();

        return view ('mutasi_getinout.eksternal_leader_in.view', compact('data_head','data_detail','checker_layak','area'));
    }

    public function create(Request $request)
    {
     //    $perusahaan = DB::table('perusahaans')
     //            ->get(); 

    	// $depo = DB::table('depos')
    	// 		->get(); 

        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get(); 

    	$data = DB::table('users')
    		->join('perusahaans','users.kode_perusahaan','=','perusahaans.kode_perusahaan')
    		->join('depos','users.kode_depo','=','depos.kode_depo')
    		->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
    		->Where('users.id', Auth::user()->id)
    		->first();

    	$checker_layak=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'Layak')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->get();

        $checker_bs=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'BS')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->get();


        $area = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

        $sub_area = DB::table('warehouse')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->select('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->groupBy('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->get();

        $area_bs = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                    ->Where('area.nama_area', 'like', '%BS%')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();
    	return view('mutasi_getinout.eksternal_leader.create', compact('area','sub_area','area_bs','checker_layak','checker_bs','perusahaan','depo','data'));
    }

    public function denied($kode_mutasi_eks)
    {
        //$kode_mutasi_eks = request()->bkb_mutasi;

        $approved = DB::table('mutasi_gudang_eks')->where('kode_mutasi_eks', $kode_mutasi_eks)
                    ->update([
                        'id_user_approved' => Auth::user()->id,
                        'status' => 2
                    ]);

                        // 'kode_area_tujuan' => $request->get('zona_eksternal_in'),
                        // 'kode_sub_area_tujuan' => $request->get('sub_zona_eksternal_in'),
                        // 'id_user_approved' => Auth::user()->id,
                        // 'status' => $request->get('id_checker_primary'),

        alert()->success('Success.','Request Denied...');
        return redirect()->route('mutasi_eksternal_in_leader.index');
    }

    public function store(Request $request)
    {
        $mutasi_gudang_eks = MutasiGudangEks::find($request->get('bkb_mutasi'));
        $mutasi_gudang_eks->update([
                'kode_area_tujuan' => $request->get('zona_eksternal_in'),
                'kode_sub_area_tujuan' => $request->get('sub_zona_eksternal_in'),
                'id_checker_tujuan' => $request->get('id_checker_primary'),
                'id_user_approved' => Auth::user()->id,
                'status' => 1
        ]);

        alert()->success('Success.','Success');
        return redirect()->route('mutasi_eksternal_in_leader.index');
    }
}
