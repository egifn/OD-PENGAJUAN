<?php

namespace App\Http\Controllers\AssetList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Perusahaan;
use App\Depo;
use Carbon\carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerusahaanAssetController extends Controller
{
    public function index()
    {
    	return view ('asset_perusahaan.index');
    }

    public function getDataListAsset()
    {
        if(Auth::user()->kode_depo = '4'){
            $data_asset_list = DB::table('asset_list_perusahaan')
                ->join('depos','asset_list_perusahaan.kode_depo','=','depos.kode_depo')
                ->join('asset_list','asset_list_perusahaan.kode_asset','=','asset_list.kode_asset')
                ->join('asset_list_penempatan','asset_list_perusahaan.kode_penempatan','=','asset_list_penempatan.kode_penempatan')
                ->join('asset_list_pemegang','asset_list_perusahaan.kode_pemegang','=','asset_list_pemegang.kode_pemegang')
                ->join('users','asset_list_perusahaan.id_user_input','=','users.id');
        }else{
            $data_asset_list = DB::table('asset_list_perusahaan')
                ->join('depos','asset_list_perusahaan.kode_depo','=','depos.kode_depo')
                ->join('asset_list','asset_list_perusahaan.kode_asset','=','asset_list.kode_asset')
                ->join('asset_list_penempatan','asset_list_perusahaan.kode_penempatan','=','asset_list_penempatan.kode_penempatan')
                ->join('asset_list_pemegang','asset_list_perusahaan.kode_pemegang','=','asset_list_pemegang.kode_pemegang')
                ->join('users','asset_list_perusahaan.id_user_input','=','users.id')
                ->where('asset_list_perusahaan.kode_depo', Auth::user()->kode_depo);
        }

		if (!isset($request->value)) {
            
        }else{
            
        }

        $data  = $data_asset_list->get();
        $count = ($data_asset_list->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function create (Request $request)
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
    	$kode_perusahaan = $request->get('1');
    	$depo = DB::table('depos')->Where('kode_perusahaan', $kode_perusahaan)
    			->orderBy('nama_depo', 'ASC')
    			->get();

        $data = DB::table('users')
                ->join('perusahaans','users.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','users.kode_depo','=','depos.kode_depo')
                ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                ->Where('users.id', Auth::user()->id)
                ->first();
        return view ('asset_perusahaan.create', compact('perusahaan','depo','data'));
    }

    public function actionAsset(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            
            if($query != ''){
                $data = DB::table('asset_list')
                        ->select('asset_list.kode_asset','asset_list.nama_asset')
                        ->where('asset_list.nama_asset','like','%'.$query.'%')
                        ->orderBy('asset_list.nama_asset')
                        ->get();
            }else{
                $data = DB::table('asset_list')
                        ->select('asset_list.kode_asset','asset_list.nama_asset')
                        ->orderBy('asset_list.nama_asset')
                        ->get();
            }
            
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_asset" data-kode_asset="'.$row->kode_asset.'" data-nama_asset="'.$row->nama_asset.'">
                            <td>'.$row->kode_asset.'</td>
                            <td>'.$row->nama_asset.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="2">No Data Found</td>
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

    public function actionPenempatan(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            
            if($query != ''){
                $data = DB::table('asset_list_penempatan')
                        ->select('asset_list_penempatan.kode_penempatan','asset_list_penempatan.penempatan')
                        ->where('asset_list_penempatan.penempatan','like','%'.$query.'%')
                        ->orderBy('asset_list_penempatan.penempatan')
                        ->get();
            }else{
                $data = DB::table('asset_list_penempatan')
                        ->select('asset_list_penempatan.kode_penempatan','asset_list_penempatan.penempatan')
                        ->orderBy('asset_list_penempatan.penempatan')
                        ->get();
            }
            
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_penempatan" data-kode_penempatan="'.$row->kode_penempatan.'" data-nama_penempatan="'.$row->penempatan.'">
                            <td>'.$row->kode_penempatan.'</td>
                            <td>'.$row->penempatan.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="2">No Data Found</td>
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

    public function actionPemegang(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            
            if($query != ''){
                $data = DB::table('asset_list_pemegang')
                        ->select('asset_list_pemegang.kode_pemegang','asset_list_pemegang.nama_pemegang')
                        ->where('asset_list_pemegang.nama_pemegang','like','%'.$query.'%')
                        ->orderBy('asset_list_pemegang.nama_pemegang')
                        ->get();
            }else{
                $data = DB::table('asset_list_pemegang')
                        ->select('asset_list_pemegang.kode_pemegang','asset_list_pemegang.nama_pemegang')
                        ->orderBy('asset_list_pemegang.nama_pemegang')
                        ->get();
            }
            
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_pemegang" data-kode_pemegang="'.$row->kode_pemegang.'" data-nama_pemegang="'.$row->nama_pemegang.'">
                            <td>'.$row->kode_pemegang.'</td>
                            <td>'.$row->nama_pemegang.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="2">No Data Found</td>
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
        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',Auth::user()->kode_depo)->first();

        $getRow = DB::table('asset_list_perusahaan')
                    ->select(DB::raw('MAX(kode_asset_inventaris) as NoUrut'))
                    ->where('kode_depo', Auth::user()->kode_depo);
        $rowCount = $getRow->count();

        if($rowCount > 0){
            if ($rowCount < 9) {
                $kode_asset_inv = $alias_depo->alias.'00'.''.($rowCount + 1);
            } else if ($rowCount < 99) {
                $kode_asset_inv = $alias_depo->alias.'0'.''.($rowCount + 1);
            } else {
                $kode_asset_inv = $alias_depo->alias.''.($rowCount + 1);
            }
        }else{
            $kode_asset_inv = $alias_depo->alias.'001';
        }

        DB::table('asset_list_perusahaan')->insert([
            'kode_asset_inventaris' => $kode_asset_inv,
            'tgl_daftar' => Carbon::now()->format('Y-m-d'),
            'kode_perusahaan' => $request->input('kode_perusahaan'),
            'kode_depo' => $request->input('kode_depo'),
            'kode_asset' => $request->input('kode_asset'),
            'merk' => $request->input('merk'),
            'spesifikasi' => $request->input('spek'),
            'kode_penempatan' => $request->input('kode_penempatan'),
            'kode_pemegang' => $request->input('kode_pemegang'),
            'kondisi' => $request->input('kondisi'),
            'tgl_pengadaan' => $request->input('tgl_pengadaan'),
            'no_dok' => $request->input('no_dok'),
            'jml_asset' => $request->input('jml_asset'),
            'n_baik' => $request->input('baik'),
            'n_perlu_diganti' => $request->input('perlu_ganti'),
            'n_perlu_perbaikan' => $request->input('perlu_perbaikan'),
            'n_dalam_perbaikan' => $request->input('dalam_perbaikan'),
            'keterangan' => $request->input('keterangan'),
            'id_user_input' => Auth::user()->id,
        ]);

        alert()->success('Success.','Data Asset berhasil disimpan');
        return redirect()->route('asset_perusahaan.index');
    }
}

