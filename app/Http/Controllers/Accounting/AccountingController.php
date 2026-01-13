<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Penerimaan;
use App\Penerimaan_Detail;
use App\Vendors;
use App\Kontrabon;
use App\Kontrabon_Detail;
use App\Product;
use Carbon\carbon;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class AccountingController extends Controller
{
    public function index()
    {
    	$invoice = DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
    									->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
    									->join('users','penerimaan.id_user_input','=','users.id')
    					->select('penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_vendor','vendors.nama_vendor',DB::raw('SUM(penerimaan_detail.harga_total) as total'),'users.name','penerimaan.status')
    					->groupBy('penerimaan.no_faktur','penerimaan.tgl_faktur','penerimaan.kode_vendor','vendors.nama_vendor','users.name','penerimaan.status')
    					->get();

    	return view ('accounting.receivable.index',compact('invoice'));

    }

    public function create($no_faktur)
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

        $kontrabon = DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                                            ->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','penerimaan.id_user_input','=','users.id')
                                            ->select('penerimaan.no_faktur','penerimaan.kode_vendor','vendors.nama_vendor',DB::raw('SUM(penerimaan_detail.harga_total) as total'))
                                            ->where('penerimaan.no_faktur', $no_faktur)
                                            ->groupBy('penerimaan.no_faktur','penerimaan.kode_vendor','vendors.nama_vendor')
                                            ->first();

        $kontrabon_detail = DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                        ->select('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur',DB::raw('SUM(penerimaan_detail.harga_total) as total'))
                        ->where('penerimaan.no_faktur', $no_faktur)
                        ->groupBy('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur')
                        ->get();

        return view('accounting.receivable.create',compact('no_kb','kontrabon','kontrabon_detail'));
    }

    public function view($no_faktur)
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

        

        return view('accounting.receivable.view',compact('invoice','invoice_detail'));
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
            'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('no_faktur') as $key => $value) {
            $datas["no_faktur.{$key}"] = 'required';
            $datas["tanggal.{$key}"] = 'required'; 
            $datas["total.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input("no_faktur") as $key => $value) {
                $data = new Kontrabon_Detail;

                $data->no_kontrabon = $request->get('no_kb');
                $data->no_faktur = $request->get("no_faktur")[$key];
                $data->tgl_faktur = $request->get("tanggal")[$key];
                $data->total_faktur = str_replace(",", "", $request->get("total")[$key]); //$request->get("total")[$key];

                $data->save();

                $penerimaan_update = Penerimaan::find($request->get('no_btb')[$key]);
                $penerimaan_update->update([
                    'status' => '1'
                ]);
            }
        }

        alert()->success('Success.','New Counter Bill has been created');
        return redirect()->route('receivable.index');
    }
}
