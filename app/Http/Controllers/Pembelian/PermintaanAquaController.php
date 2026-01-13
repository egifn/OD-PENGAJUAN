<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pembelian;
use App\Pembelian_Detail;
use App\Penerimaan;
use App\Penerimaan_Detail;
use Carbon\carbon;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class PermintaanAquaController extends Controller
{
	public function index()
	{
		$date_start = (date('Y-m-d'));
	    $date_end = (date('Y-m-d'));
	    

	    $pembelian = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
	                                            ->Join('users','pembelian.id_user_input','=','users.id')
                                                ->leftJoin('penerimaan','penerimaan.kode_pembelian','=','pembelian.kode_pembelian')
                                                ->select('pembelian.kode_pembelian','pembelian.tgl_pembelian','pembelian.kode_vendor','vendors.nama_vendor','penerimaan.no_faktur','pembelian.status','users.name')
                                                ->WhereBetween('pembelian.tgl_pembelian', [$date_start,$date_end])
	                                            ->Where('pembelian.ket_transaksi', 'Barang Dagang')
	                                            ->orderBy('pembelian.tgl_pembelian', 'DESC')
	                                            ->get();

	   	return view ('pembelian.aqua_permintaan.index', compact('pembelian'));
	}
    
   	public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $pembelian = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->leftJoin('penerimaan','penerimaan.kode_pembelian','=','pembelian.kode_pembelian')
                                            ->select('pembelian.kode_pembelian','pembelian.tgl_pembelian','pembelian.kode_vendor','vendors.nama_vendor','penerimaan.no_faktur','pembelian.status','users.name')
                                            ->WhereBetween('pembelian.tgl_pembelian', [$date_start,$date_end])
                                            ->Where('pembelian.ket_transaksi', 'Barang Dagang')
                                            ->orderBy('pembelian.tgl_pembelian', 'DESC')
                                            ->get();

        return view ('pembelian.aqua_permintaan.index', compact('pembelian'));
    }

    public function cari_permintaan(Request $request)
    {	
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

    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('d/m/Y');
            $date_end = Carbon::parse($date[1])->format('d/m/Y');
        }

        $permintaan = DB::table('import_otm_h')
                        ->join('import_otm','import_otm_h.kode_otm_h','=','import_otm.kode_otm_h')
                        ->join('product_dagang_pembelian','import_otm.material_id','=','product_dagang_pembelian.kode_produk')
                        ->select('import_otm_h.kode_otm_h','import_otm_h.tgl_otm_h','import_otm.material_id','import_otm.material_desc','product_dagang_pembelian.harga',DB::raw('SUM(import_otm.actual_quantity) AS actual_quantity'))
                        ->WhereBetween('import_otm.actual_pickup_date', [$date_start,$date_end])
                        ->groupBy('import_otm_h.kode_otm_h','import_otm_h.tgl_otm_h','import_otm.material_id','import_otm.material_desc','product_dagang_pembelian.harga')
                        ->get();

        return view ('pembelian.aqua_permintaan.create', compact('kode','permintaan'));
    }

    public function create()
    {
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

        $permintaan = DB::table('import_otm_h')
                        ->join('import_otm','import_otm_h.kode_otm_h','=','import_otm.kode_otm_h')
                        ->join('product_dagang_pembelian','import_otm.material_id','=','product_dagang_pembelian.kode_produk')
                        ->select('import_otm_h.kode_otm_h','import_otm_h.tgl_otm_h','import_otm.material_id','import_otm.material_desc','product_dagang_pembelian.harga',DB::raw('SUM(import_otm.actual_quantity) AS actual_quantity'))
                        ->WhereBetween('import_otm.actual_pickup_date', ['-','-'])
                        ->groupBy('import_otm_h.kode_otm_h','import_otm_h.tgl_otm_h','import_otm.material_id','import_otm.material_desc','product_dagang_pembelian.harga')
                        ->get();

     	return view('pembelian.aqua_permintaan.create', compact('kode','permintaan'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [

        ]);
    	Pembelian::create([
            'kode_pembelian' => $request->get('kode_pembelian'),
            'tgl_pembelian' => Carbon::now()->format('Y-m-d'),
            'kode_vendor' => $request->get('kode_supp'),
            'kode_pengajuan' => $request->get('kode_pembelian'),
            'ket_transaksi' => 'Barang Dagang',
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
        if($validator->passes()){
            foreach ($request->input("kode_produk") as $key => $value) {
                $data = new Pembelian_Detail;

                $data->kode_pembelian = $request->get('kode_pembelian');
                $data->kode_product = $request->get("kode_produk")[$key];
                $data->harga_satuan = $request->get("harga")[$key];
                $data->qty = $request->get("qty")[$key];
                $data->harga_total = $request->get("total")[$key];

                $data->save();
            }
        }

        alert()->success('Success.','Pengajuan Berhasil');
        return redirect()->route('permintaan_aqua.index');
    }

    public function view($kodepembelian)
    {
        $pembelian_v = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->where('pembelian.kode_pembelian', $kodepembelian)
                                            ->first();


        $detail = DB::table('pembelian_detail')->join('product_dagang_pembelian','pembelian_detail.kode_product','=','product_dagang_pembelian.kode_produk')
                                                ->where('pembelian_detail.kode_pembelian', $kodepembelian)
                                                ->get();

        $total_jml = Pembelian_Detail::where('kode_pembelian', $kodepembelian)
                                ->get()->sum('harga_total');
                                

        return view('pembelian.aqua_permintaan.view', compact('pembelian_v','detail','total_jml'));
    }

    public function accept($kodepembelian)
    {
        $penerimaan_v = DB::table('pembelian')->join('vendors','pembelian.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','pembelian.id_user_input','=','users.id')
                                            ->where('pembelian.kode_pembelian', $kodepembelian)
                                            ->first();

        $penerimaan_detail = DB::table('pembelian_detail')->join('product_dagang_pembelian','pembelian_detail.kode_product','=','product_dagang_pembelian.kode_produk')
                                                ->where('pembelian_detail.kode_pembelian', $kodepembelian)
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

        return view('pembelian.aqua_permintaan.accept', compact('penerimaan_v','penerimaan_detail','no_btb'));
    }

    public function accepted(Request $request)
    {
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
        if($validator->passes()){
            foreach ($request->input("kode_produk") as $key => $value) {
                $data = new Penerimaan_Detail;

                $data->no_btb = $request->get('btb');
                $data->kode_product = $request->get("kode_produk")[$key];
                $data->harga_satuan = str_replace(",", "", $request->get("harga")[$key]); //$request->get("harga")[$key];
                $data->qty_terima = $request->get("qty")[$key];
                $data->harga_total = str_replace(",", "", $request->get("total")[$key]); //$request->get("total")[$key];

                $data->save();
            }
        }

        $pembelian_update = Pembelian::find($request->get('kode_pembelian'));
        $pembelian_update->update([
            'status' => '2'
        ]);

        alert()->success('Success.','New order has been received');
        return redirect()->route('permintaan_aqua.index');
    }
}
