<?php

namespace App\Http\Controllers\Ga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Auth;
use DB;

class RabController extends Controller
{
    public function index()
    {

    	return view('ga.rab.index');	
    }

    public function cari(Request $request)
    {

    }

    public function create(Request $request)
    {
    	return view('ga.rab.create');	
    }

    public function actionRab(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('ms_rab')
                        ->join('vendors_rab','ms_rab.kd_vendor','=','vendors_rab.id')
                        ->select('ms_rab.id as id_pekerjaan','ms_rab.nama_pekerjaan','ms_rab.kd_vendor','ms_rab.satuan','ms_rab.harga_satuan','vendors_rab.nama_vendor')
                        ->where('ms_rab.nama_pekerjaan','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('ms_rab')
                        ->join('vendors_rab','ms_rab.kd_vendor','=','vendors_rab.id')
                        ->select('ms_rab.id as id_pekerjaan','ms_rab.nama_pekerjaan','ms_rab.kd_vendor','ms_rab.satuan','ms_rab.harga_satuan','vendors_rab.nama_vendor')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih" data-kode_id="'.$row->id_pekerjaan.'" data-pekerjaan="'.$row->nama_pekerjaan.'" data-kode_vendor="'.$row->kd_vendor.'" data-nama_vendor="'.$row->nama_vendor.'" data-satuan="'.$row->satuan.'" data-harga="'.$row->harga_satuan.'">
                        <td>'.$row->id_pekerjaan.'</td>
                        <td>'.$row->nama_pekerjaan.'</td>
                        <td>'.$row->kd_vendor.'</td>
                        <td>'.$row->nama_vendor.'</td>
                        <td>'.$row->satuan.'</td>
                        <td>'.$row->harga_satuan.'</td>
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


}
