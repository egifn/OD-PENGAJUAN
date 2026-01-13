<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Product;
use App\Vendor;
use App\Pembelian;
use App\Pembelian_Detail;
use App\Penerimaan;
use App\Penerimaan_Detail;
use App\Pengajuan;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use RealRashid\SweetAlert\Facades\Alert;

class PurchasingController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $pembelian = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->leftJoin('penerimaan','pembelian.kode_pembelian','=','penerimaan.kode_pembelian')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->select('pembelian.kode_pembelian','pembelian.tgl_pembelian','pembelian.kode_vendor','vendors.nama_vendor','pembelian.status','penerimaan.no_faktur','pembelian.id_user_input','users.name','pembelian.no_urut_po')
                                            ->WhereBetween('pembelian.tgl_pembelian', [$date_start,$date_end])
                                            ->orderBy('pembelian.tgl_pembelian', 'DESC')
                                            ->get();

    	return view ('purchasing.purchasing.index', compact('pembelian'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $pembelian = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->leftJoin('penerimaan','pembelian.kode_pembelian','=','penerimaan.kode_pembelian')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->select('pembelian.kode_pembelian','pembelian.tgl_pembelian','pembelian.kode_vendor','vendors.nama_vendor','pembelian.status','penerimaan.no_faktur','pembelian.id_user_input', 'users.name','pembelian.no_urut_po')
                                            ->WhereBetween('pembelian.tgl_pembelian', [$date_start,$date_end])
                                            ->orderBy('pembelian.tgl_pembelian', 'DESC')
                                            ->get();

        return view ('purchasing.purchasing.index', compact('pembelian'));
    }

    public function actionVendor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('vendors')
                        ->where('vendors.kode_vendor','like','%'.$query.'%')
                        ->orWhere('vendors.nama_vendor','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('vendors')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_vendor" data-kode_vendor="'.$row->kode_vendor.'" data-nama_vendor="'.$row->nama_vendor.'">
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

    public function actionProduct(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('products')
                        ->where('products.kode','like','%'.$query.'%')
                        ->orWhere('products.nama_barang','like','%'.$query.'%')
                        ->orWhere('products.merk','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('products')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih" data-kode_produk="'.$row->kode.'" data-nama_produk="'.$row->nama_barang.'" data-merk="'.$row->merk.'" data-ket="'.$row->ket.'" data-price="'.$row->price.'">
                            <td>'.$row->kode.'</td>
                            <td>'.$row->nama_barang.'</td>
                            <td>'.$row->merk.'</td>
                            <td>'.$row->ket.'</td>
                            <td align="right">'. number_format($row->price).'</td>
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

    public function view($no_urut_po)
    {
        $pembelian_v = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->where('pembelian.no_urut_po', $no_urut_po)
                                            ->first();


        $detail = DB::table('pembelian_detail')->join('products','pembelian_detail.kode_product','=','products.kode')
                                                ->where('pembelian_detail.no_urut_po', $no_urut_po)
                                                ->get();

        $total_jml = Pembelian_Detail::where('no_urut_po', $no_urut_po)
                                ->get()->sum('harga_total');
                                

        return view('purchasing.purchasing.view', compact('pembelian_v','detail','total_jml'));
    }

    public function accept($no_urut_po)
    {
        $penerimaan_v = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->where('pembelian.no_urut_po', $no_urut_po)
                                            ->first();

        $penerimaan_detail = DB::table('pembelian_detail')->join('products','pembelian_detail.kode_product','=','products.kode')
                                                ->where('pembelian_detail.no_urut_po', $no_urut_po)
                                                ->get();

        $date = (date('Ym'));
        $date_1 = (date('Ymd'));

        $getRow = DB::table('penerimaan')->select(DB::raw('MAX(RIGHT(no_btb,6)) as NoUrut'))
                                        ->where('no_btb', 'like', "%".$date."%");
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $no_btb = "TB".$date_1."00000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $no_btb = "TB".$date_1."0000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $no_btb = "TB".$date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $no_btb = "TB".$date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $no_btb = "TB".$date_1."0".''.($rowCount + 1);
            } else {
                    $no_btb = "TB".$date_1.($rowCount + 1);
            }
        }else{
            $no_btb = "TB".$date_1.sprintf("%06s", 1);
        } 

        return view('purchasing.purchasing.accept', compact('penerimaan_v','penerimaan_detail','no_btb'));
    }

    public function create()
    {
        
        // $getRow = Pembelian::orderBy('kode_pembelian', 'DESC')->get();
        // $rowCount = $getRow->count();
        // $lastId = $getRow->first();

        // $kode = "000001";

        // if ($rowCount > 0) {
        //     if ($rowCount < 9) {
        //             $kode = "00000".''.($rowCount + 1);
        //     } else if ($rowCount < 99) {
        //             $kode = "0000".''.($rowCount + 1);
        //     } else if ($rowCount < 999) {
        //             $kode = "000".''.($rowCount + 1);
        //     } else if ($rowCount < 9999) {
        //             $kode = "00".''.($rowCount + 1);
        //     } else if ($rowCount < 99999) {
        //             $kode = "0".''.($rowCount + 1);
        //     } else {
        //             $kode = ''.($rowCount + 1);
        //     }
        // }

        $date = (date('Ym'));
        $date_1 = (date('Ymd'));

        $getRow = DB::table('pembelian')->select(DB::raw('MAX(RIGHT(kode_pembelian,6)) as NoUrut'))
                                        ->where('kode_pembelian', 'like', "%".$date."%");
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

     	return view('purchasing.purchasing.create', compact('kode'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_supp' => 'required|exists:vendors,kode_vendor'
        ]);

        Pembelian::create([
            'kode_pembelian' => $request->get('kode_pembelian'),
            'tgl_pembelian' => Carbon::now()->format('Y-m-d'),
            'kode_vendor' => $request->get('kode_supp'),
            'status' => '1',
            'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('kode_produk') as $key => $value) {
            $datas["kode_produk.{$key}"] = 'required';
            $datas["harga.{$key}"] = 'required'; 
            $datas["qty.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
            foreach ($request->input("kode_produk") as $key => $value) {
                $data = new Pembelian_Detail;

                $data->kode_pembelian = $request->get('kode_pembelian');
                $data->kode_product = $request->get("kode_produk")[$key];
                $data->harga_satuan = str_replace(",", "", $request->get("harga")[$key]);
                $data->qty = $request->get("qty")[$key];
                $data->harga_total = $request->get("total")[$key];

                $data->save();
            }
        

        alert()->success('Success.','New order has been created');
        return redirect()->route('purchasing.index');
    }

    public function accepted(Request $request)
    {
        $this->validate($request, [
            'kode_supp' => 'required|exists:vendors,kode_vendor',
            'invoice' => 'required|string'

        ]);

        Penerimaan::create([
            'no_btb' => $request->get('btb'),
            'tgl_terima' => Carbon::now()->format('Y-m-d'),
            'kode_vendor' => $request->get('kode_supp'),
            'kode_pembelian' => $request->get('kode_pembelian'),
            'no_faktur' => $request->get('invoice'),
            'tgl_faktur' => Carbon::now()->format('Y-m-d'),
            'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('kode_produk') as $key => $value) {
            $datas["kode_produk.{$key}"] = 'required';
            $datas["harga.{$key}"] = 'required'; 
            $datas["qty.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
            foreach ($request->input("kode_produk") as $key => $value) {
                $data = new Penerimaan_Detail;

                $data->no_btb = $request->get('btb');
                $data->kode_product = $request->get("kode_produk")[$key];
                $data->harga_satuan = str_replace(",", "", $request->get("harga")[$key]); //$request->get("harga")[$key];
                $data->qty_terima = $request->get("qty")[$key];
                $data->harga_total = str_replace(",", "", $request->get("total")[$key]); //$request->get("total")[$key];

                $data->save();

                $stock = Product::find($request->get("kode_produk")[$key]);
                $stock->update([
                    'stock' => $stock->stock + $request->get("qty")[$key],
                    'price' => str_replace(",", "", $request->get("harga")[$key]) //$request->get("harga")[$key]
                ]);
            }

        $pembelian_update = Pembelian::find($request->get('kode_pembelian'));
        $pembelian_update->update([
            'status' => '2'
        ]);

        // $pengajuan = Pengajuan::find($pembelian_update->kode_pengajuan);
        // $pengajuan->update([
        //     'status_pengajuan' => '9'
        // ]);
       

        alert()->success('Success.','New order has been received');
        return redirect()->route('purchasing.index');
    }

    public function pdf($no_urut_po)
    {
        $pembelian_v = DB::table('pembelian')->join('perusahaans','pembelian.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->leftJoin('rekening_fin','vendors.kode_vendor','=','rekening_fin.kode_vendor')
                                            ->leftJoin('banks', 'rekening_fin.kode_bank','=','banks.kode_bank')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->where('pembelian.no_urut_po', $no_urut_po)
                                            ->first();

        $detail = DB::table('pembelian_detail')->join('products','pembelian_detail.kode_product','=','products.kode')
                                                ->where('pembelian_detail.no_urut_po', $no_urut_po)
                                                ->get();

        $total_jml = Pembelian_Detail::where('no_urut_po', $no_urut_po)
                                ->get()->sum('harga_total');

        
        $pdf = PDF::loadview('purchasing.purchasing.pdf', compact('pembelian_v','detail','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
	
	public function excel($no_urut_po)
    {
        $pembelian_v = DB::table('pembelian')->join('perusahaans','pembelian.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->leftJoin('rekening_fin','vendors.kode_vendor','=','rekening_fin.kode_vendor')
                                            ->leftJoin('banks', 'rekening_fin.kode_bank','=','banks.kode_bank')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->where('pembelian.no_urut_po', $no_urut_po)
                                            ->first();

        $detail = DB::table('pembelian_detail')->join('products','pembelian_detail.kode_product','=','products.kode')
                                                ->where('pembelian_detail.no_urut_po', $no_urut_po)
                                                ->get();

        $total_jml = Pembelian_Detail::where('no_urut_po', $no_urut_po)
                                ->get()->sum('harga_total');

        return view ('purchasing.purchasing.excel', compact('pembelian_v','detail','total_jml'));
    }

    public function pdf_penerimaan($nofaktur)
    {
        $penerimaan_head = DB::table('penerimaan')
                            ->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
                            ->select('penerimaan.kode_vendor','vendors.nama_vendor','vendors.alamat',
                            'penerimaan.no_btb','penerimaan.tgl_terima','penerimaan.kode_pembelian','penerimaan.no_faktur')
                            ->where('penerimaan.no_faktur', $nofaktur)
                            ->first();

        $penerimaan_detail = DB::table('penerimaan')
                            ->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                            ->join('products','penerimaan_detail.kode_product','=','products.kode')
                            ->where('penerimaan.no_faktur', $nofaktur)
                            ->get();

        $total_jml = Pembelian_Detail::where('kode_pembelian', $nofaktur)
                                ->get()->sum('harga_total');

        
        $pdf = PDF::loadview('purchasing.purchasing.pdf_penerimaan', compact('penerimaan_head','penerimaan_detail','total_jml'));
        return $pdf->stream();
    }



}
