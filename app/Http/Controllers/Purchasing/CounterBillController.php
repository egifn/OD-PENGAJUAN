<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Kontrabon;
use App\Kontrabon_Detail;
use App\Vendor;
use App\Penerimaan;
use App\Penerimaan_Detail;
use App\JurnalUmum;
use Auth;
use DB;
use Carbon\carbon;

class CounterBillController extends Controller
{
    public function index()
    {
    	$counter_bill = DB::table('kontrabon')
            ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
            ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
            ->join('users','kontrabon.id_user_input','=','users.id')
            ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.id_user_input','users.name')
            ->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.id_user_input','users.name')
            ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
            ->get();

    	return view ('purchasing.counter_bill.index', compact('counter_bill'));
    }

    public function actionVendor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('vendors')
                        ->where('vendors.kode_vendor','like', '%'.$query.'%')
                        ->orWhere('vendors.nama_vendor','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('vendors')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_vendor" data-kode_vendor="'.$row->kode_vendor.'" data-nama_vendor="'.$row->nama_vendor.'" data-status="'.$row->status_1.'">
                            <td>'.$row->kode_vendor.'</td>
                            <td>'.$row->nama_vendor.'</td>
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
                $data=DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                                            ->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','penerimaan.id_user_input','=','users.id')
                                            ->select('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_vendor','vendors.nama_vendor',DB::raw('SUM(penerimaan_detail.harga_total) as total'))
                                            ->Where('penerimaan.status',0)
                                            ->Where('penerimaan.kode_vendor', $query)
                                            ->groupBy('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_vendor','vendors.nama_vendor')
                                            ->get();
            }else{
                $data = DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                                            ->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','penerimaan.id_user_input','=','users.id')
                                            ->select('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_vendor','vendors.nama_vendor',DB::raw('SUM(penerimaan_detail.harga_total) as total'))
                                            ->Where('penerimaan.status',0)
                                            ->groupBy('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_vendor','vendors.nama_vendor')
                                            ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih" data-btb="'.$row->no_btb.'" data-invoice="'.$row->no_faktur.'" data-tgl="'.$row->tgl_faktur.'" data-vendor="'.$row->kode_vendor.'" data-total="'.$row->total.'">
                            <td hidden>'.$row->no_btb.'</td>
                            <td>'.$row->no_faktur.'</td>
                            <td>'.$row->tgl_faktur.'</td>
                            <td hidden>'.$row->kode_vendor.'</td>
                            <td>'.$row->nama_vendor.'</td>
                            <td align="right">'. number_format($row->total).'</td>
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

    public function actionCategory(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('ms_pengeluaran')
                        ->join('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
                        ->join('coa_transaksi_detail','coa_transaksi.no','=','coa_transaksi_detail.no')
                        ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->where('ms_pengeluaran.id','like','%'.$query.'%')
                        ->orWhere('ms_pengeluaran.nama_pengeluaran','like','%'.$query.'%')
                        ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi')
                        ->get();
            }else{
                $data = DB::table('ms_pengeluaran')
                        ->join('coa_transaksi','ms_pengeluaran.coa','coa_transaksi.no')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                         ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_category" data-id="'.$row->id.'" data-nama_pengeluaran="'.$row->nama_pengeluaran.'" data-sifat="'.$row->sifat.'" data-jenis="'.$row->jenis.'" data-pembayaran="'.$row->pembayaran.'" data-kategori="'.$row->kategori.'" data-coa="'.$row->coa.'" data-kode_coa="'.$row->no.'" data-nama_coa="'.$row->nama_transaksi.'" data-debit="'.$row->debit_1.'" data-kredit="'.$row->kredit_1.'">
                            <td>'.$row->id.'</td>
                            <td>'.$row->nama_pengeluaran.'</td>
                            <td>'.$row->sifat.'</td>
                            <td hidden>'.$row->jenis.'</td>
                            <td hidden>'.$row->pembayaran.'</td>
                            <td hidden>'.$row->kategori.'</td>
                            <td hidden>'.$row->coa.'</td>
                            <td hidden>'.$row->no.'</td>
                            <td hidden>'.$row->nama_transaksi.'</td>
                            <td hidden>'.$row->debit_1.'</td>
                            <td hidden>'.$row->kredit_1.'</td>
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


        
        

    	return view ('purchasing.counter_bill.create', compact('no_kb'));
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
            'no_kb' => 'required|string',
            'kode_supp' => 'required|exists:vendors,kode_vendor',
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
            'type' => $request->get('id_pengeluaran'),
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
                $data->total_faktur = str_replace(",", "", $request->get("total")[$key]); //$request->get("total")[$key];

                $data->save();

                

                $penerimaan_update = DB::table('penerimaan')->where('no_faktur', $request->get("invoice")[$key])
                                    ->update([
                                        'status' =>'1'
                                    ]);
 
            }
        }

        JurnalUmum::create([
            'tgl' => Carbon::now()->format('Y-m-d'),
            'no_coa_transaksi' => $request->get('kode_coa'), 
            'kode_transaksi' => $request->get('no_kb'),
            'kode_account' => $request->get('debet'),
            'debit' => str_replace(",", "", $request->get('total_head')),
            'kredit' => '0' 
        ]);

        JurnalUmum::create([
            'tgl' => Carbon::now()->format('Y-m-d'),
            'no_coa_transaksi' => $request->get('kode_coa'), 
            'kode_transaksi' => $request->get('no_kb'),
            'kode_account' => $request->get('kredit'),
            'debit' => '0',
            'kredit' => str_replace(",", "", $request->get('total_head')) 
        ]);

        alert()->success('Success.','New Counter Bill has been created');
        return redirect()->route('counter_bill.index');
    }

    public function view_detail($no_faktur)
    {
        $invoice = DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                                            ->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','penerimaan.id_user_input','=','users.id')
                                            ->select('penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_pembelian','vendors.nama_vendor','vendors.alamat',DB::raw('SUM(penerimaan_detail.harga_total) as total'))
                                            ->where('penerimaan.no_faktur', $no_faktur)
                                            ->groupBy('penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_pembelian','vendors.nama_vendor','vendors.alamat')
                                            ->first();

        $invoice_detail = DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                                            ->join('products','penerimaan_detail.kode_product','=','products.kode')
                                            ->where('penerimaan.no_faktur', $no_faktur)
                                            ->get();

        return view('purchasing.counter_bill.view',compact('invoice','invoice_detail'));
    }

    public function view($no_kontrabon)
    {

        $kontrabon = DB::table('kontrabon')->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
                                            ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','vendors.nama_vendor','kontrabon.total','kontrabon.termin','kontrabon.jatuh_tempo','kontrabon.keterangan')
                                            ->where('kontrabon.no_kontrabon', $no_kontrabon)
                                            ->first();

        $kontrabon_detail = DB::table('kontrabon_detail')
                                ->where('kontrabon_detail.no_kontrabon', $no_kontrabon)
                                ->get();

        return view('purchasing.counter_bill.view_detail',compact('kontrabon','kontrabon_detail'));
    }
}
