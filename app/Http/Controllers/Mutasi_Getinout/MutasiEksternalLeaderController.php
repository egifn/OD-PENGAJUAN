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

class MutasiEksternalLeaderController extends Controller
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
            ->Where('mutasi_gudang_eks.kode_depo', Auth::user()->kode_depo)
            ->orderBy('mutasi_gudang_eks.tanggal', "DESC")
            ->get();

    	return view('mutasi_getinout.eksternal_leader.index', compact('data'));
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
            ->Where('mutasi_gudang_eks.kode_depo', Auth::user()->kode_depo)
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
            ->Where('mutasi_gudang_eks.kode_depo', Auth::user()->kode_depo)
            ->Where('mutasi_gudang_eks.kategori', $kategori)
            ->orderBy('mutasi_gudang_eks.tanggal', "DESC")
            ->get();
        }

        

        return view('mutasi_getinout.eksternal_leader.index', compact('data'));
    }

    public function view($kode_mutasi_eks)
    {
        $data_head = DB::table('mutasi_gudang_eks')
            ->join('perusahaans','mutasi_gudang_eks.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','mutasi_gudang_eks.kode_depo','=','depos.kode_depo')
            ->join('area as area_asal','mutasi_gudang_eks.kode_area_asal','=','area_asal.kode_area')
            ->join('area_sub as area_sub_asal','mutasi_gudang_eks.kode_sub_area_asal','area_sub_asal.kode_sub_area')
            ->join('perusahaans AS perusahaan_tujuan','mutasi_gudang_eks.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos AS depo_tujuan','mutasi_gudang_eks.kode_depo_tujuan','=','depo_tujuan.kode_depo')
            ->join('users','mutasi_gudang_eks.id_user_input','=','users.id')
            ->join('checker','mutasi_gudang_eks.id_checker_asal','=','checker.id_checker')
            ->select('mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.doc_id','mutasi_gudang_eks.kode_mutasi_eks','mutasi_gudang_eks.tanggal','mutasi_gudang_eks.waktu','mutasi_gudang_eks.kategori','mutasi_gudang_eks.kode_perusahaan','mutasi_gudang_eks.kode_depo','perusahaans.nama_perusahaan','depos.nama_depo','area_asal.nama_area AS nama_area_asal','area_sub_asal.nama_sub_area AS nama_sub_area_asal','mutasi_gudang_eks.no_mobil','mutasi_gudang_eks.nama_driver','mutasi_gudang_eks.kode_perusahaan_tujuan','mutasi_gudang_eks.kode_depo_tujuan','perusahaan_tujuan.nama_perusahaan AS perusahaan_tujuan','depo_tujuan.nama_depo AS depo_tujuan','mutasi_gudang_eks.status','mutasi_gudang_eks.id_user_input','users.name','checker.nama_checker','mutasi_gudang_eks.keterangan')
            ->Where('mutasi_gudang_eks.kode_mutasi_eks', $kode_mutasi_eks)
            ->first();

        $data_detail = DB::table('mutasi_gudang_eks_detail')
            ->join('product_dagang','mutasi_gudang_eks_detail.kode_produk','=','product_dagang.kode_produk')
            ->Where('mutasi_gudang_eks_detail.kode_mutasi_eks', $kode_mutasi_eks)
            ->get();

        return view ('mutasi_getinout.eksternal_leader.view',compact('data_head','data_detail'));
    }

    public function ajax_zona_primary_eks(Request $request) // dropdown perusahaan dan depo
    {
        $zona_primary_layak = Area_sub::Where('kode_area', $request->zona_primary_eks)
                                ->pluck('kode_sub_area','nama_sub_area');
        return response()->json($zona_primary_layak);
    }

    public function ajax_zona_secondary_eks(Request $request) // dropdown perusahaan dan depo
    {
        $zona_secondary_layak = Area_sub::Where('kode_area', $request->zona_secondary_eks)
                                ->pluck('kode_sub_area','nama_sub_area');
        return response()->json($zona_secondary_layak);
    }

    public function ajax_perusahaan_primary_eks(Request $request) // dropdown perusahaan dan depo
    {
        $perusahaan_primary_eks = Depo::Where('kode_perusahaan', $request->perusahaan_id_pri)
                                ->pluck('kode_depo','nama_depo');
        return response()->json($perusahaan_primary_eks);
    }

    public function ajax_perusahaan_secondary_eks(Request $request) // dropdown perusahaan dan depo
    {
        $perusahaan_secondary_eks = Depo::Where('kode_perusahaan', $request->perusahaan_id_secondary)
                                ->pluck('kode_depo','nama_depo');
        return response()->json($perusahaan_secondary_eks);
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

   

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if(request()->kategori == 'Primary'){
            $date_1 = (date('dmY'));

            $getRow = DB::table('mutasi_gudang_eks')
                ->select(DB::raw('MAX(RIGHT(kode_mutasi,4)) as NoUrut'))
                ->where('kode_depo', Auth::user()->kode_depo);
            $rowCount = $getRow->count();
            if ($rowCount > 0) {
                if ($rowCount < 9) {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1."000".''.($rowCount + 1);
                } else if ($rowCount < 99) {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1."00".''.($rowCount + 1);
                } else if ($rowCount < 999) {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1."0".''.($rowCount + 1);
                } else {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1.($rowCount + 1);
                }
            }else{
                $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1.sprintf("%04s", 1);
            }

            $this->validate($request,[
                
            ]);

            MutasiGudangEks::create([
                'kode_mutasi_eks' => $kode_mutasi,
                'doc_id' => $request->get('surat_jalan'),
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'waktu' => Carbon::now()->format('H:i:s'),
                'kode_perusahaan' => Auth::user()->kode_perusahaan,
                'kode_depo' => Auth::user()->kode_depo,
                'kategori' => 'Primary',
                'no_mobil' => $request->get('no_mobil_primary'),
                'kode_driver' => '-',
                'nama_driver' => $request->get('nama_sopir_primary'),
                'kode_area_asal' => $request->get('zona_primary_layak'),
                'kode_sub_area_asal' => $request->get('sub_zona_primary_layak'),
                'id_checker_asal' => $request->get('id_checker_primary'),
                'kode_perusahaan_tujuan' => $request->get('perusahaan_tujuan_pri'),
                'kode_depo_tujuan' => $request->get('depo_tujuan_pri'),
                'kode_area_tujuan' => '',
                'kode_sub_area_tujuan' => '',
                'id_checker_tujuan' => '0',
                'keterangan' => $request->get('keterangan_primary'),
                'status' => '0',
                'status_bm' => '0',
                'id_user_input' => Auth::user()->id
            ]);
        }else if(request()->kategori == 'Secondary'){
            $date_1 = (date('dmY'));
            
            $getRow = DB::table('mutasi_gudang_eks')
                ->select(DB::raw('MAX(RIGHT(kode_mutasi,4)) as NoUrut'))
                ->where('kode_depo', Auth::user()->kode_depo);
            $rowCount = $getRow->count();
            if ($rowCount > 0) {
                if ($rowCount < 9) {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1."000".''.($rowCount + 1);
                } else if ($rowCount < 99) {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1."00".''.($rowCount + 1);
                } else if ($rowCount < 999) {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1."0".''.($rowCount + 1);
                } else {
                        $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1.($rowCount + 1);
                }
            }else{
                $kode_mutasi = Auth::user()->kode_depo.'-'.$date_1.sprintf("%04s", 1);
            }

            $this->validate($request,[
                
            ]);

            MutasiGudangEks::create([
                'kode_mutasi_eks' => $kode_mutasi,
                'doc_id' => $request->get('bkb'),
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'waktu' => Carbon::now()->format('H:i:s'),
                'kode_perusahaan' => Auth::user()->kode_perusahaan,
                'kode_depo' => Auth::user()->kode_depo,
                'kategori' => 'Secondary',
                'no_mobil' => $request->get('no_mobil_secondary'),
                'kode_driver' => '-',
                'nama_driver' => $request->get('nama_sopir_secondary'),
                'kode_area_asal' => $request->get('zona_secondary_layak'),
                'kode_sub_area_asal' => $request->get('sub_zona_secondary_layak'),
                'id_checker_asal' => $request->get('id_checker_secondary'),
                'kode_perusahaan_tujuan' => $request->get('perusahaan_tujuan_secondary'),
                'kode_depo_tujuan' => $request->get('depo_tujuan_secondary'),
                'kode_area_tujuan' => '',
                'kode_sub_area_tujuan' => '0',
                'keterangan' => $request->get('keterangan_secondary'),
                'status' => '0',
                'status_bm' => '0',
                'id_user_input' => Auth::user()->id
            ]);
        }

        $datas = [];
        foreach ($request->input('kode_produk') as $key => $value) {
                
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input("kode_produk") as $key => $value) {
                $data = new MutasiGudangEks_Detail;

                $data->kode_mutasi_eks = $kode_mutasi;
                $data->kode_produk = $request->get("kode_produk")[$key];
                $data->qty = $request->get("qty")[$key];
                
                $data->save();
            }
        }

        alert()->success('Success.','Success');
        return redirect()->route('mutasi_eksternal_leader.index');
    }
}
