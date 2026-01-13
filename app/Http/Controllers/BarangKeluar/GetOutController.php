<?php

namespace App\Http\Controllers\BarangKeluar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Area;
use App\Area_sub;
use App\BarangDagang_Out;
use App\BarangDagang_Out_Detail;
use App\BarangDagang_Out_History;
use App\BarangDagang_Out_History_Detail;
use Carbon\carbon;
use Auth;
use DB;

class GetOutController extends Controller
{
    public function index(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_depo == '337'){ //BOGOR
            $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '337')
                    ->get();
        }else if(Auth::user()->kode_depo == '901'){ //PARUNG
            $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '901')
                    ->get();
        }else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
            $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '342')
                    ->get();
        }else{
            $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', Auth::user()->kode_depo)
                    ->get();
        }

        return view ('keluar_barang.checker_out.index',  compact('out'));
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
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '337')
                    ->get();
            }else{
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '337')
                    ->Where('barang_dagang_out.kategori', $kategori)
                    ->get();
            }
            
        }else if(Auth::user()->kode_depo == '901'){ //PARUNG
            if($kategori=='')
            {
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '901')
                    ->get();
            }else{
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '901')
                    ->Where('barang_dagang_out.kategori', $kategori)
                    ->get();
            }
            
        }else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
            if($kategori=='')
            {
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '342')
                    ->get();
            }else{
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', '342')
                    ->Where('barang_dagang_out.kategori', $kategori)
                    ->get();
            }
            
        }else{
            if($kategori=='')
            {
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', Auth::user()->kode_depo)
                    ->get();
            }else{
                $out = DB::table('barang_dagang_out')
                    ->join('perusahaans','barang_dagang_out.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_out.kode_depo','=','depos.kode_depo')
                    ->WhereBetween('barang_dagang_out.tanggal', [$date_start,$date_end])
                    ->Where('barang_dagang_out.kode_depo', Auth::user()->kode_depo)
                    ->Where('barang_dagang_out.kategori', $kategori)
                    ->get();
            }
        }
        return view ('keluar_barang.checker_out.index',  compact('out'));
    }

    public function view($doc_id)
    {
        $kategori_out =  DB::table('barang_dagang_out')
                    ->select('barang_dagang_out.kategori')
                    ->where('barang_dagang_out.doc_id', $doc_id)  
                    ->first();  

        if($kategori_out->kategori == 'Primary'){
            $head = DB::table('barang_dagang_out')
                ->join('area','barang_dagang_out.kode_zona','=','area.kode_area')
                ->join('area_sub','barang_dagang_out.kode_zona_sub','=','area_sub.kode_sub_area')
                ->join('area as area_bs','barang_dagang_out.kode_zona_bs','=','area_bs.kode_area')
                ->join('area_sub as area_sub_bs','barang_dagang_out.kode_zona_sub_bs','=','area_sub_bs.kode_sub_area')
                ->join('checker','barang_dagang_out.id_checker','=','checker.id_checker')
                ->join('checker as checker_bs','barang_dagang_out.id_checker_bs','=','checker_bs.id_checker')
                ->select('barang_dagang_out.doc_id','barang_dagang_out.no_mobil','barang_dagang_out.kode_driver','barang_dagang_out.nama_driver','area.nama_area','area_sub.nama_sub_area','checker.nama_checker','area_bs.nama_area as nama_area_bs','area_sub_bs.nama_sub_area as nama_sub_area_bs','checker_bs.nama_checker as nama_checker_bs','barang_dagang_out.from')
                ->Where('barang_dagang_out.doc_id', $doc_id)
                ->first();
        }else if($kategori_out->kategori == 'Secondary'){
            $head = DB::table('barang_dagang_out')
                ->join('area','barang_dagang_out.kode_zona','=','area.kode_area')
                ->join('area_sub','barang_dagang_out.kode_zona_sub','=','area_sub.kode_sub_area')
                ->join('checker','barang_dagang_out.id_checker','=','checker.id_checker')
                ->select('barang_dagang_out.doc_id','barang_dagang_out.no_mobil','barang_dagang_out.kode_driver','barang_dagang_out.nama_driver','area.nama_area','area_sub.nama_sub_area','checker.nama_checker','barang_dagang_out.from')
                ->Where('barang_dagang_out.doc_id', $doc_id)
                ->first();
        }

        

        $detail = DB::table('barang_dagang_out_detail')
                ->join('product_dagang','barang_dagang_out_detail.kode_produk','=','product_dagang.kode_produk')
                ->Where('barang_dagang_out_detail.doc_id', $doc_id)
                ->get();

        return view ('keluar_barang.checker_out.view', compact('head','detail','kategori_out'));  
    }

    public function ajax_zona_primary_layak_out(Request $request) // dropdown perusahaan dan depo
    {
        if(Auth::user()->kode_depo == '902'){
                $zona_primary_layak = Area_sub::Where('kode_area', $request->zona_primary_layak_id)->Where('kode_depo', 902)
                                ->pluck('kode_sub_area','nama_sub_area');
                return response()->json($zona_primary_layak);
        }else{
                $zona_primary_layak = Area_sub::Where('kode_area', $request->zona_primary_layak_id)
                                ->pluck('kode_sub_area','nama_sub_area');
                return response()->json($zona_primary_layak);
        }

        // $zona_primary_layak = Area_sub::Where('kode_area', $request->zona_primary_layak_id)
        //                         ->pluck('kode_sub_area','nama_sub_area');
        // return response()->json($zona_primary_layak);
    }

    public function ajax_zona_primary_bs_out(Request $request) // dropdown perusahaan dan depo
    {
        $zona_primary_bs = Area_sub::Where('kode_area', $request->zona_primary_bs_id)
                                ->pluck('kode_sub_area','nama_sub_area');
        return response()->json($zona_primary_bs);
    }

    public function ajax_zona_secondary_layak_out(Request $request) // dropdown perusahaan dan depo
    {
        if(Auth::user()->kode_depo == '902'){
                $zona_secondary_layak = Area_sub::Where('kode_area', $request->zona_secondary_layak_id)->Where('kode_depo', 902)
                                ->pluck('kode_sub_area','nama_sub_area');
                return response()->json($zona_secondary_layak);
        }else{
                $zona_secondary_layak = Area_sub::Where('kode_area', $request->zona_secondary_layak_id)
                                ->pluck('kode_sub_area','nama_sub_area');
                return response()->json($zona_secondary_layak);
        }
        
        // $zona_secondary_layak = Area_sub::Where('kode_area', $request->zona_secondary_layak_id)
        //                         ->pluck('kode_sub_area','nama_sub_area');
        // return response()->json($zona_secondary_layak);
    }

    public function ajax_zona_secondary_bs_out(Request $request) // dropdown perusahaan dan depo
    {
        $zona_secondary_bs = Area_sub::Where('kode_area', $request->zona_secondary_bs_id)
                                ->pluck('kode_sub_area','nama_sub_area');
        return response()->json($zona_secondary_bs);
    }

    

    public function create(Request $request)
    {
        if(Auth::user()->kode_depo == '337'){ //BOGOR
            $checker_layak=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'Layak')
                        ->Where('checker.kode_depo', '337')
                        ->get();

            $checker_bs=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'BS')
                        ->Where('checker.kode_depo', '337')
                        ->get();


            $area = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', '337')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();
            $kode_area = $request->get('1');
            $sub_area = DB::table('warehouse')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->select('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->Where('warehouse.kode_depo', '337')
                    ->Where('warehouse.kode_area', $kode_area)
                    ->groupBy('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->get();

            $area_bs = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', '337')
                    ->Where('area.nama_area', 'like', '%BS%')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

        }else if(Auth::user()->kode_depo == '901'){ //PARUNG
            $checker_layak=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'Layak')
                        ->Where('checker.kode_depo', '901')
                        ->get();

            $checker_bs=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'BS')
                        ->Where('checker.kode_depo', '901')
                        ->get();


            $area = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', '901')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

            $sub_area = DB::table('warehouse')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->select('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->Where('warehouse.kode_depo', '901')
                    ->groupBy('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->get();

            $area_bs = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', '901')
                    ->Where('area.nama_area', 'like', '%BS%')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

        }else if(Auth::user()->kode_depo == '342'){ //CITEUREUP
            $checker_layak=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'Layak')
                        ->Where('checker.kode_depo', '342')
                        ->get();

            $checker_bs=DB::table('checker')
                        ->Where('checker.kode_depo', Auth::user()->kode_depo)
                        ->Where('checker.kategori', 'BS')
                        ->Where('checker.kode_depo', '342')
                        ->get();


            $area = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', '342')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();

            $sub_area = DB::table('warehouse')
                    ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                    ->select('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->Where('warehouse.kode_depo', '342')
                    ->groupBy('warehouse.kode_sub_area','area_sub.nama_sub_area')
                    ->get();

            $area_bs = DB::table('warehouse')
                    ->join('area','warehouse.kode_area','=','area.kode_area')
                    ->select('warehouse.kode_area','area.nama_area')
                    ->Where('warehouse.kode_depo', '342')
                    ->Where('area.nama_area', 'like', '%BS%')
                    ->groupBy('warehouse.kode_area','area.nama_area')
                    ->get();
        }else{
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


            $area = DB::table('area')
                    ->Where('area.kode_depo', Auth::user()->kode_depo)
                    ->get();

            $area_bs = DB::table('area')
                    ->Where('area.kode_depo', Auth::user()->kode_depo)
                    ->get();

            // $area = DB::table('warehouse')
            //         ->join('area','warehouse.kode_area','=','area.kode_area')
            //         ->select('warehouse.kode_area','area.nama_area')
            //         ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
            //         ->groupBy('warehouse.kode_area','area.nama_area')
            //         ->get();

            $sub_area = DB::table('warehouse')
                     ->join('area_sub','warehouse.kode_sub_area','=','area_sub.kode_sub_area')
                     ->select('warehouse.kode_sub_area','area_sub.nama_sub_area')
                     ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
                     ->groupBy('warehouse.kode_sub_area','area_sub.nama_sub_area')
                     ->get();

            // $area_bs = DB::table('warehouse')
            //         ->join('area','warehouse.kode_area','=','area.kode_area')
            //         ->select('warehouse.kode_area','area.nama_area')
            //         ->Where('warehouse.kode_depo', Auth::user()->kode_depo)
            //         ->Where('area.nama_area', 'like', '%BS%')
            //         ->groupBy('warehouse.kode_area','area.nama_area')
            //         ->get();
        }
    	

    	return view('keluar_barang.checker_out.create', compact('checker_layak','checker_bs','sub_area','area','area_bs'));
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
	
	public function actionProductOut(Request $request)
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

        if(request()->kategori == 'Primary'){
            $this->validate($request,[
                
            ]);

            BarangDagang_Out::create([
                'doc_id' => $request->get('surat_jalan'),
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'waktu' => Carbon::now()->format('H:i:s'),
                'kode_perusahaan' => Auth::user()->kode_perusahaan,
                'kode_depo' => Auth::user()->kode_depo,
                'kategori' => 'Primary',
                'no_mobil' => $request->get('no_mobil_primary'),
                'kode_driver' => '-',
                'nama_driver' => $request->get('nama_sopir_primary'),
                'kode_zona' => $request->get('zona_primary_layak'),
                'kode_zona_sub' => $request->get('sub_zona_primary_layak'),
                'kode_zona_bs' => $request->get('zona_primary_bs'),
                'kode_zona_sub_bs' => $request->get('sub_zona_primary_bs'),
                'id_checker' => $request->get('id_checker_primary'),
                'id_checker_bs' => $request->get('id_checker_primary_bs'),
                'id_user_input' => Auth::user()->id,
                'from' => $request->get('pabrik')
            ]);

            BarangDagang_Out_History::create([
                'doc_id' => $request->get('surat_jalan'),
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'waktu' => Carbon::now()->format('H:i:s'),
                'kode_perusahaan' => Auth::user()->kode_perusahaan,
                'kode_depo' => Auth::user()->kode_depo,
                'kategori' => 'Primary',
                'no_mobil' => $request->get('no_mobil_primary'),
                'kode_driver' => '-',
                'nama_driver' => $request->get('nama_sopir_primary'),
                'kode_zona' => $request->get('zona_primary_layak'),
                'kode_zona_sub' => $request->get('sub_zona_primary_layak'),
                'kode_zona_bs' => $request->get('zona_primary_bs'),
                'kode_zona_sub_bs' => $request->get('sub_zona_primary_bs'),
                'id_checker' => $request->get('id_checker_primary'),
                'id_checker_bs' => $request->get('id_checker_primary_bs'),
                'id_user_input' => Auth::user()->id,
                'from' => $request->get('pabrik')
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
                    $data = new BarangDagang_Out_Detail;

                    $data->doc_id = $request->get('surat_jalan');
                    $data->kode_produk = $request->get("kode_produk")[$key];
                    $data->qty_all = $request->get("qty")[$key];
                    $data->qty_layak = $request->get("qty_layak")[$key];
                    $data->qty_bs = $request->get("qty_bs")[$key];

                    $data->save();
                }

                foreach ($request->input("kode_produk") as $key => $value) {
                    $data = new BarangDagang_Out_History_Detail;

                    $data->doc_id = $request->get('surat_jalan');
                    $data->kode_produk = $request->get("kode_produk")[$key];
                    $data->qty_all = $request->get("qty")[$key];
                    $data->qty_layak = $request->get("qty_layak")[$key];
                    $data->qty_bs = $request->get("qty_bs")[$key];

                    $data->save();
                }
            }

        }else if(request()->kategori == 'Secondary'){
            $this->validate($request,[
                //'bkb' => 'required',
                //'kode_perusahaan' => 'required|exists:users,kode_perusahaan',
                //'kode_depo' => 'required|exists:users,kode_depo'
            ]);

            BarangDagang_Out::create([
                'doc_id' => $request->get('bkb'),
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'waktu' => Carbon::now()->format('H:i:s'),
                'kode_perusahaan' => Auth::user()->kode_perusahaan,
                'kode_depo' => Auth::user()->kode_depo,
                'kategori' => 'Secondary',
                'no_mobil' => $request->get('no_mobil_secondary'),
                'kode_driver' => $request->get('id_sopir_secondary'),
                'nama_driver' => $request->get('nama_sopir_secondary'),
                'kode_zona' => $request->get('zona_secondary_layak'),
                'kode_zona_sub' => $request->get('sub_zona_secondary_layak'),
                'kode_zona_bs' => $request->get('zona_secondary_bs'),
                'kode_zona_sub_bs' => $request->get('sub_zona_secondary_bs'),
                'id_checker' => $request->get('id_checker_secondary'),
                'id_checker_bs' => $request->get('id_checker_secondary_bs'),
                'id_user_input' => Auth::user()->id,
                'from' => $request->get('toko')
            ]);

            BarangDagang_Out_History::create([
                'doc_id' => $request->get('bkb'),
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'waktu' => Carbon::now()->format('H:i:s'),
                'kode_perusahaan' => Auth::user()->kode_perusahaan,
                'kode_depo' => Auth::user()->kode_depo,
                'kategori' => 'Secondary',
                'no_mobil' => $request->get('no_mobil_secondary'),
                'kode_driver' => $request->get('id_sopir_secondary'),
                'nama_driver' => $request->get('nama_sopir_secondary'),
                'kode_zona' => $request->get('zona_secondary_layak'),
                'kode_zona_sub' => $request->get('sub_zona_secondary_layak'),
                'kode_zona_bs' => $request->get('zona_secondary_bs'),
                'kode_zona_sub_bs' => $request->get('sub_zona_secondary_bs'),
                'id_checker' => $request->get('id_checker_secondary'),
                'id_checker_bs' => $request->get('id_checker_secondary_bs'),
                'id_user_input' => Auth::user()->id,
                'from' => $request->get('toko')

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
                    $data = new BarangDagang_Out_Detail;

                    $data->doc_id = $request->get('bkb');
                    $data->kode_produk = $request->get("kode_produk")[$key];
                    $data->qty_all = $request->get("qty")[$key];
                    $data->qty_layak = $request->get("qty_layak")[$key];
                    $data->qty_bs = $request->get("qty_bs")[$key];

                    $data->save();
                }

                foreach ($request->input("kode_produk") as $key => $value) {
                    $data = new BarangDagang_Out_History_Detail;

                    $data->doc_id = $request->get('bkb');
                    $data->kode_produk = $request->get("kode_produk")[$key];
                    $data->qty_all = $request->get("qty")[$key];
                    $data->qty_layak = $request->get("qty_layak")[$key];
                    $data->qty_bs = $request->get("qty_bs")[$key];

                    $data->save();
                }
            }
        }

        alert()->success('Success.','Success');
        return redirect()->route('get_out.index');
    }
}
