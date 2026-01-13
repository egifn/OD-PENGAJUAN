<?php

namespace App\Http\Controllers\SupplyDemand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Pengajuan_Pabrik;
use App\Pengajuan_Pabrik_Detail;
use Carbon\carbon;
use Auth;
use DB;
use PDF;

class SupplyRequestController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $sd=DB::table('pengajuan_pabrik')
            ->join('perusahaans','pengajuan_pabrik.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_pabrik.kode_depo','=','depos.kode_depo')
            ->join('users','pengajuan_pabrik.id_user_input','=','users.id')
            ->WhereBetween('pengajuan_pabrik.tgl_pesan', [$date_start,$date_end])
            ->orderBy('pengajuan_pabrik.tgl_pesan', 'DESC')
            ->get();

    	return view ('supply_demand.request.index', compact('sd'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $sd=DB::table('pengajuan_pabrik')
            ->join('perusahaans','pengajuan_pabrik.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_pabrik.kode_depo','=','depos.kode_depo')
            ->join('users','pengajuan_pabrik.id_user_input','=','users.id')
            ->WhereBetween('pengajuan_pabrik.tgl_pesan', [$date_start,$date_end])
            ->orderBy('pengajuan_pabrik.tgl_pesan', 'DESC')
            ->get();

        return view ('supply_demand.request.index', compact('sd'));
    }

    public function view($kode_pesan)
    {
        $head = DB::table('pengajuan_pabrik')
            ->join('perusahaans','pengajuan_pabrik.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_pabrik.kode_depo','=','depos.kode_depo')
            ->join('users','pengajuan_pabrik.id_user_input','=','users.id')
            ->Where('pengajuan_pabrik.kode_pesan', $kode_pesan)
            ->first();

        $detail = DB::table('pengajuan_pabrik_detail')
            ->Where('pengajuan_pabrik_detail.kode_pesan', $kode_pesan)
            ->get();

        return view('supply_demand.request.view', compact('head','detail'));
    }

    public function actionProduct(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
               

                $data = DB::connection('mysql_tua')
                		->table('dms_inv_product')
                		->Where('dms_inv_product.szId','like','%'.$query.'%')
                		->orWhere('dms_inv_product.szName','like','%'.$query.'%')
                		->get();
            }else{
               

                $data = DB::connection('mysql_tua')
                		->table('dms_inv_product')
                		->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih" data-kode_produk="'.$row->szId.'" data-nama_produk="'.$row->szName.'" data-merk="'.$row->szUomId.'">
                            <td>'.$row->szId.'</td>
                            <td>'.$row->szName.'</td>
                            <td>'.$row->szUomId.'</td>
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

    public function ajax(Request $request) // dropdown perusahaan dan depo
    {
        $perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
    }

    public function create(Request $request)
    {
    	$date = (date('Ym'));
        $date_1 = (date('Ymd'));

        $getRow = DB::table('pengajuan_pabrik')->select(DB::raw('MAX(RIGHT(kode_pesan,6)) as NoUrut'))
                                        ->where('kode_pesan', 'like', "%".$date."%");
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode = "PO".$date_1."00000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $kode = "PO".$date_1."0000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $kode = "PO".$date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $kode = "PO".$date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $kode = "PO".$date_1."0".''.($rowCount + 1);
            } else {
                    $kode = "PO".$date_1.($rowCount + 1);
            }
        }else{
            $kode = "PO".$date_1.sprintf("%06s", 1);
        } 

        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

    	return view ('supply_demand.request.create', compact('perusahaan','depo','kode'));	
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        Pengajuan_Pabrik::create([
            'kode_pesan' => $request->get('kode_pembelian'),
            'tgl_pesan' => Carbon::now()->format('Y-m-d'),
            'kode_pabrik' => $request->get('kode_pabrik'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kode_depo' => $request->get('kode_depo'),
            'keterangan' => '',
            'status' => '1',
            'id_user_input' => Auth::user()->id
        ]);

        $datas=[];
        foreach ($request->input("kode_produk") as $key => $value) {
            $datas["kode_produk.{$key}"] = 'required';
        }
        
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input("kode_produk") as $key => $value) {
                $data = new Pengajuan_Pabrik_Detail;
                $data->kode_pesan = $request->get('kode_pembelian');
                $data->kode_produk = $request->get("kode_produk")[$key];
                $data->nama_produk = $request->get("nama_produk")[$key];
                $data->unit = $request->get("merk")[$key];
                $data->qty = $request->get("qty")[$key];
                $data->harga_satuan = $request->get("harga")[$key];
                $data->harga_total = $request->get("total")[$key];

                $data->save();
            }
        }

        alert()->success('Success.','New request has been created');
        return redirect()->route('supply_demand.index');
    }
}
