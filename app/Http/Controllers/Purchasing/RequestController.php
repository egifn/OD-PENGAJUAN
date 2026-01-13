<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Category;
use App\Divisi;
use App\Product;
use App\Vendor;
use App\Pengajuan;
use App\Pengajuan_Detail;
use App\Pembelian;
use App\Pembelian_Detail;
use App\JurnalUmum;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$request = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                        ->join('users','pengajuan.id_user_input','=','users.id')
                                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                        ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                        //->WhereIn('pengajuan.status_pengajuan',['6','5','9','1'])
										->WhereIn('pengajuan.status_bod',['1'])
                                        ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                        ->get();
    	return view ('purchasing.request.index', compact('request'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $request = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                        ->join('users','pengajuan.id_user_input','=','users.id')
                                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                        ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                        //->WhereIn('pengajuan.status_pengajuan',['6','5','9','1'])
										->WhereIn('pengajuan.status_bod',['1'])
                                        ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                        ->get();
        return view ('purchasing.request.index', compact('request'));


    }

    public function view($kodepengajuan)
    {
        $pengajuan_v = DB::table('pengajuan')->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                             ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                             ->join('users','pengajuan.id_user_input','=','users.id')
                                             ->join('products','pengajuan_detail.kode_product','=','products.kode')
                                             ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                             ->where('pengajuan.no_urut', $kodepengajuan)->first();

            $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
                                                ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
            									->join('categories','products.category_id','=','categories.id')
            									->where('pengajuan_detail.no_urut', $kodepengajuan)->get();

            return view('purchasing.request.view', compact('pengajuan_v','details'));
    }

    public function create($kodepengajuan)
    {
    	$produk = Product::orderBy('kode', 'ASC')->get();
     	$vendor = Vendor::orderBy('nama_vendor','ASC')->get();


        $head = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                        ->join('users','pengajuan.id_user_input','=','users.id')
                                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                        ->leftJoin('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
                                        ->leftJoin('coa_transaksi_detail','coa_transaksi.no','=','coa_transaksi_detail.no')
                                        ->select('pengajuan.kode_pengajuan','pengajuan.jenis','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.coa','coa_transaksi.nama_transaksi',
                                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debet_1"),
                                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                                        ->where('pengajuan.no_urut', $kodepengajuan)
                                        ->first();

     	$details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
            								->join('categories','products.category_id','=','categories.id')
            								->where('pengajuan_detail.no_urut', $kodepengajuan)->get();


        $total = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
                                            ->join('categories','products.category_id','=','categories.id')
                                            ->select(DB::raw('SUM((pengajuan_detail.qty)*(products.price)) AS total'))
                                            ->where('pengajuan_detail.no_urut', $kodepengajuan)->get();
        

        $kode_pengajuan = $kodepengajuan;                                   

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

     	return view('purchasing.request.create', compact('produk','vendor','kode','head','details','total','kode_pengajuan'));
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

    public function store(Request $request)
    {   
        $datas_0 = [];
        foreach ($request->input('cvendor') as $key => $value) {
            $datas_0["cvendor.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas_0);
        if($validator->passes()){
            foreach ($request->input("cvendor") as $key => $value) {
                $kd_vendor = $request->get("cvendor")[$key];
                $getRow_vendor = DB::table('pembelian')->select('kode_vendor')
                            ->Where('kode_pengajuan', $request->get('kode_pengajuan'))
                            ->Where('kode_vendor', $request->get("cvendor")[$key]);
                $rowCount_vendor = $getRow_vendor->count();
                if($rowCount_vendor > 0){
                    //Jika Hasil nya 1 di Skip
                }else{
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

                    Pembelian::create([
                        'kode_pembelian' => $kode,
                        'tgl_pembelian' => Carbon::now()->format('Y-m-d'),
                        'kode_vendor' => $request->get("cvendor")[$key],
                        'kode_pengajuan' => $request->get('kode_pengajuan'),
                        'ket_transaksi' => $request->get('jenis'),
                        'status' => '1',
                        'id_user_input' => Auth::user()->id
                    ]);

                    $datas_1 = [];
                    foreach ($request->input('kode_produk') as $key => $value) {
                        $datas_1["kode_produk.{$key}"] = 'required';
                        $datas_1["harga.{$key}"] = 'required'; 
                        $datas_1["qty.{$key}"] = 'required';
                    }
                    $validator = Validator::make($request->all(), $datas_1);
                    if($validator->passes()){
                        foreach ($request->input("kode_produk") as $key => $value) {
                            if($request->get("cvendor")[$key] == $kd_vendor){
                                $data = new Pembelian_Detail;

                                $data->kode_pembelian = $kode;
                                $data->kode_product = $request->get("kode_produk")[$key];
                                $data->harga_satuan = $request->get("harga")[$key];
                                $data->qty = $request->get("qty")[$key];
                                $data->harga_total = $request->get("total")[$key];

                                $data->save();
                            }
                        }
                    }
                }
            }

            $kode_pengajuan = request()->kode_pengajuan;
            $approved = DB::table('pengajuan')->where('kode_pengajuan', $kode_pengajuan)
                        ->update([
                            'status_pengajuan' => 5
                        ]);
        }


        //====================================================================
        // $this->validate($request, [
        //     'kode_supp' => 'required|exists:vendors,kode_vendor'
        // ]);

        // Pembelian::create([
        //     'kode_pembelian' => $request->get('kode_pembelian'),
        //     'tgl_pembelian' => Carbon::now()->format('Y-m-d'),
        //     'kode_vendor' => $request->get('kode_supp'),
        //     'kode_pengajuan' => $request->get('kode_pengajuan'),
        //     'ket_transaksi' => $request->get('jenis'),
        //     'status' => '1',
        //     'id_user_input' => Auth::user()->id
        // ]);

        // $datas = [];
        // foreach ($request->input('kode_produk') as $key => $value) {
        //     $datas["kode_produk.{$key}"] = 'required';
        //     $datas["harga.{$key}"] = 'required'; 
        //     $datas["qty.{$key}"] = 'required';
        // }
        // $validator = Validator::make($request->all(), $datas);
        // if($validator->passes()){
        //     foreach ($request->input("kode_produk") as $key => $value) {
        //         $data = new Pembelian_Detail;

        //         $data->kode_pembelian = $request->get('kode_pembelian');
        //         $data->kode_product = $request->get("kode_produk")[$key];
        //         $data->harga_satuan = $request->get("harga")[$key];
        //         $data->qty = $request->get("qty")[$key];
        //         $data->harga_total = $request->get("total")[$key];

        //         $data->save();
        //     }
        // }

        // $kode_pengajuan = request()->kode_pengajuan;
        // $approved = DB::table('pengajuan')->where('kode_pengajuan', $kode_pengajuan)
        //             ->update([
        //                 'status_pengajuan' => 5
        //             ]);

        //--COA--//
        // JurnalUmum::create([
        //     'tgl' => Carbon::now()->format('Y-m-d'),
        //     'no_coa_transaksi' => $request->get('kode_coa'), 
        //     'kode_transaksi' => $request->get('kode_pembelian'),
        //     'kode_account' => $request->get('debet'),
        //     'debit' => str_replace(",", "", $request->get('total_harga')),
        //     'kredit' => '0' 
        // ]);

        // JurnalUmum::create([
        //     'tgl' => Carbon::now()->format('Y-m-d'),
        //     'no_coa_transaksi' => $request->get('kode_coa'), 
        //     'kode_transaksi' => $request->get('kode_pembelian'),
        //     'kode_account' => $request->get('kredit'),
        //     'debit' => '0',
        //     'kredit' => str_replace(",", "", $request->get('total_harga')) 
        // ]);

        alert()->success('Success.','New order has been created');
        return redirect()->route('request_purchasing.index');
    }
}
