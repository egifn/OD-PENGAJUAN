<?php

namespace App\Http\Controllers\Sparepart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Kontrabon;
use App\Kontrabon_Detail;
use App\Vendor;
use Carbon\carbon;
use DB;
use Auth;
use PDF;

class KontraController extends Controller
{
    public function index()
    {	
    	$kontra = DB::table('kontrabon')
                    ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                    ->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
                    ->join('users','kontrabon.id_user_input','=','users.id')
                    ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.id_user_input','users.name')
                    ->where('kontrabon.type', 'Sparepart')
                    ->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.id_user_input','users.name')
                    ->orderBy('kontrabon.tgl_kontrabon', 'ASC')->paginate(8);

    	return view('sparepart.kontrabon.index', compact('kontra'));
    }

    public function view($no_kontrabon)
    {
        $kontra_head = DB::table('kontrabon')
                    ->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
                    ->join('users','kontrabon.id_user_input','=','users.id')
                    ->where('kontrabon.no_kontrabon', $no_kontrabon)
                    ->first();

        $kontra_detail = DB::table('kontrabon')
                    ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                    ->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
                    ->join('users','kontrabon.id_user_input','=','users.id')
                    ->select('kontrabon.no_kontrabon','kontrabon_detail.no_transaksi','kontrabon_detail.no_faktur','kontrabon_detail.tgl_faktur','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon_detail.total_faktur','kontrabon.id_user_input','users.name')
                    ->where('kontrabon.no_kontrabon', $no_kontrabon)
                    ->groupBy('kontrabon.no_kontrabon','kontrabon_detail.no_transaksi','kontrabon_detail.no_faktur','kontrabon_detail.tgl_faktur','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon_detail.total_faktur','kontrabon.id_user_input','users.name')
                    ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
                    ->get();

        return view('sparepart.kontrabon.view',compact('kontra_head','kontra_detail'));
    }

    public function actionVendor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::connection('sqlsrv')
                        ->table('ms_supplier')
                        ->where('ms_supplier.supp_code','like', '%'.$query.'%')
                        ->orWhere('ms_supplier.supp_desc','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::connection('sqlsrv')
                        ->table('ms_supplier')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_vendor" data-kode_vendor="'.$row->supp_code.'" data-nama_vendor="'.$row->supp_desc.'">
                            <td>'.$row->supp_code.'</td>
                            <td>'.$row->supp_desc.'</td>
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

    public function actionInvoice(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::connection('sqlsrv')
                    ->table('tr_partinsupp_h')
                    ->join('tr_partin_h','tr_partinsupp_h.partinsupp_partincode','=','tr_partin_h.partin_code')
                    ->whereBetween('tr_partinsupp_h.rec_datecreated', ['2021-07-01 00:01:11.420','2021-08-30 23:59:11.420'])
                    ->Where('tr_partinsupp_h.partinsupp_suppcode', $query)
                    ->get();
            }else{
                $data = DB::connection('sqlsrv')
                        ->table('tr_partinsupp_h')
                        ->join('tr_partin_h','tr_partinsupp_h.partinsupp_partincode','=','tr_partin_h.partin_code')
                        ->whereBetween('tr_partinsupp_h.rec_datecreated', ['2021-07-01 00:01:11.420','2021-08-30 23:59:11.420'])
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih" data-btb="'.$row->partinsupp_code.'" data-invoice="'.$row->partinsupp_nobon.'" data-tgl="'.$row->rec_datecreated.'" data-total="'.$row->partin_total.'">
                            <td>'.$row->partinsupp_code.'</td>
                            <td>'.$row->rec_datecreated.'</td>
                            <td>'.$row->partinsupp_nobon.'</td>
                            <td align="right">'.number_format($row->partin_total).'</td>
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

    public function actionInvoiceTire(Request $request)
    {
        if($request->ajax())
        {   
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::connection('sqlsrv')
                    ->table('tr_tireoriginalin_h')
                    ->join('tr_tireoriginalin_d','tr_tireoriginalin_h.tireoriginin_code','=','tr_tireoriginalin_d.tireoriginin_code')
                    ->select('tr_tireoriginalin_h.tireoriginin_code','tr_tireoriginalin_h.tireoriginin_date','tr_tireoriginalin_h.tireoriginin_suppliercode','tr_tireoriginalin_h.tireoriginin_do_no','tr_tireoriginalin_h.tireoriginin_price')
                    ->whereBetween('tr_tireoriginalin_h.tireoriginin_date', ['2021-07-01 00:01:11.420','2021-08-30 23:59:11.420'])
                    ->Where('tr_tireoriginalin_h.tireoriginin_suppliercode', $query)
                    ->groupBy('tr_tireoriginalin_h.tireoriginin_code','tr_tireoriginalin_h.tireoriginin_date','tr_tireoriginalin_h.tireoriginin_suppliercode','tr_tireoriginalin_h.tireoriginin_do_no','tr_tireoriginalin_h.tireoriginin_price')
                    ->get();
            }else{
                $data = DB::connection('sqlsrv')
                    ->table('tr_tireoriginalin_h')
                    ->join('tr_tireoriginalin_d','tr_tireoriginalin_h.tireoriginin_code','=','tr_tireoriginalin_d.tireoriginin_code')
                     ->select('tr_tireoriginalin_h.tireoriginin_code','tr_tireoriginalin_h.tireoriginin_date','tr_tireoriginalin_h.tireoriginin_suppliercode','tr_tireoriginalin_h.tireoriginin_do_no','tr_tireoriginalin_h.tireoriginin_price')
                    ->whereBetween('tr_tireoriginalin_h.tireoriginin_date', ['2021-07-01 00:01:11.420','2021-08-30 23:59:11.420'])
                    ->groupBy('tr_tireoriginalin_h.tireoriginin_code','tr_tireoriginalin_h.tireoriginin_date','tr_tireoriginalin_h.tireoriginin_suppliercode','tr_tireoriginalin_h.tireoriginin_do_no','tr_tireoriginalin_h.tireoriginin_price')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih" data-btb="'.$row->tireoriginin_code.'" data-invoice="'.$row->tireoriginin_do_no.'" data-tgl="'.$row->tireoriginin_date.'" data-total="'.$row->tireoriginin_price.'">
                            <td>'.$row->tireoriginin_code.'</td>
                            <td>'.$row->tireoriginin_date.'</td>
                            <td>'.$row->tireoriginin_do_no.'</td>
                            <td align="right">'.number_format($row->tireoriginin_price).'</td>
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

    public function create(Request $request)
    {
    	$date = (date('Ym'));
        $date_1 = (date('Ymd'));

        $getRow = DB::table('kontrabon')->select(DB::raw('MAX(RIGHT(no_kontrabon,6)) as NoUrut'))
                                        ->where('no_kontrabon', 'like', "%".$date."%");
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $no_kb = "KB".$date_1."00000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $no_kb = "KB".$date_1."0000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $no_kb = "KB".$date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $no_kb = "KB".$date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $no_kb = "KB".$date_1."0".''.($rowCount + 1);
            } else {
                    $no_kb = "KB".$date_1.($rowCount + 1);
            }
        }else{
            $no_kb = "KB".$date_1.sprintf("%06s", 1);
        }

        $kode_supp = $request->kode_supp;
        if(request()->kode_supp != '')
        {
            $kode_supp = request()->kode_supp;
        }

        if ($kode_supp == '')
        {
            $invoice = DB::connection('sqlsrv')
              ->table('tr_partinsupp_h')
              ->join('tr_partin_h','tr_partinsupp_h.partinsupp_partincode','=','tr_partin_h.partin_code')
              ->whereBetween('tr_partinsupp_h.rec_datecreated', ['2021-07-01 00:01:11.420','2021-08-31 23:59:11.420'])
              ->get();
        }else{
            $invoice = DB::connection('sqlsrv')
              ->table('tr_partinsupp_h')
              ->join('tr_partin_h','tr_partinsupp_h.partinsupp_partincode','=','tr_partin_h.partin_code')
              ->whereBetween('tr_partinsupp_h.rec_datecreated', ['2021-07-01 00:01:11.420','2021-08-31 23:59:11.420'])
              ->Where('tr_partinsupp_h.partinsupp_suppcode', $kode_supp)
              ->get();
        }

        
        return view ('sparepart.kontrabon.create', compact('no_kb','invoice'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'no_kb' => 'required|string',
            //'kode_supp' => 'required|exists:vendors,kode_vendor',
            'termin' => 'required|string',
            'description' => 'required|string'
        ]);

        Kontrabon::create([
            'no_kontrabon' => $request->get('no_kb'),
            'tgl_kontrabon' => Carbon::now()->format('Y-m-d'),
            'kode_vendor' => $request->get('kode_supp'),
            'total' => str_replace(",", "", $request->get('total_head')), //$request->get('total_head'),
            'termin' => $request->get('termin'),
            'jatuh_tempo' => $request->get('jatuh_tempo'),
            'keterangan' => $request->get('description'),
            'status' => '0',
            'type' => 'Sparepart',
            'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('invoice') as $key => $value) {
            $datas["invoice.{$key}"] = 'required';
            $datas["tgl.{$key}"] = 'required'; 
            $datas["total.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input("invoice") as $key => $value) {
                $data = new Kontrabon_Detail;

                $data->no_kontrabon = $request->get('no_kb');
                $data->no_faktur = $request->get("invoice")[$key];
                $data->tgl_faktur = $request->get("tgl")[$key];
                $data->total_faktur = str_replace(",", "", $request->get("total")[$key]);
                $data->no_transaksi = $request->get("no_btb")[$key];
                $data->save();
            }
        }
        alert()->success('Success.','New Kontrabon has been created');
        return redirect()->route('kontrabon.index');
    }

    public function pdf($no_kontrabon)
    {
        $kontra_print_head = DB::table('kontrabon')
                    ->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
                    ->join('users','kontrabon.id_user_input','=','users.id')
                    ->where('kontrabon.no_kontrabon', $no_kontrabon)
                    ->first();

        $kontra_print_detail = DB::table('kontrabon')
                    ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                    ->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
                    ->join('users','kontrabon.id_user_input','=','users.id')
                    ->select('kontrabon.no_kontrabon','kontrabon_detail.no_transaksi','kontrabon_detail.no_faktur','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon_detail.total_faktur','kontrabon.id_user_input','users.name')
                    ->where('kontrabon.no_kontrabon', $no_kontrabon)
                    ->groupBy('kontrabon.no_kontrabon','kontrabon_detail.no_transaksi','kontrabon_detail.no_faktur','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon_detail.total_faktur','kontrabon.id_user_input','users.name')
                    ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
                    ->get();

        $pdf = PDF::loadview('sparepart.kontrabon.pdf', compact('kontra_print_detail','kontra_print_head'));
        return $pdf->stream();
    }
}
