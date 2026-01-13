<?php

namespace App\Http\Controllers\Purchasing;

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
use App\JurnalUmum;
use Auth;
use DB;
use Carbon\carbon;

class AcceptedController extends Controller
{
    public function index()
    {	
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$accepted = DB::table('penerimaan')->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
    										->join('users','penerimaan.id_user_input','=','users.id')
                                            ->WhereBetween('penerimaan.tgl_terima', [$date_start,$date_end])
    										->orderBy('penerimaan.tgl_terima', 'DESC')
    										->get();

    	return view ('purchasing.accepted.index', compact('accepted'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $accepted = DB::table('penerimaan')->join('vendors','penerimaan.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','penerimaan.id_user_input','=','users.id')
                                            ->WhereBetween('penerimaan.tgl_terima', [$date_start,$date_end])
                                            ->orderBy('penerimaan.tgl_terima', 'DESC')
                                            ->get();

        return view ('purchasing.accepted.index', compact('accepted'));
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

    public function actionCoa(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                //$data = DB::table('coa_lv4')
                  //      ->WhereIn('coa_lv4.kode_lv3', ['200102200'])
                    //    ->Where('coa_lv4.kode_lv4','like','%'.$query.'%')
                      //  ->orWhere('coa_lv4.account_name','like','%'.$query.'%')
                        //->get();

                $data = DB::table('coa_transaksi')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                        ->select('coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->Where('coa_transaksi.no','like','%'.$query.'%')
                        ->orWhere('coa_transaksi.nama_transaksi','like','%'.$query.'%')
                        ->groupBy('coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
            }else{
                //$data = DB::table('coa_lv4')
                  //      ->WhereIn('coa_lv4.kode_lv3', ['200102200'])
                    //    ->get();

                $data = DB::table('coa_transaksi')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                         ->select('coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->groupBy('coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_coa" data-kode_coa="'.$row->no.'" data-coa="'.$row->nama_transaksi.'" data-debit="'.$row->debit_1.'" data-kredit="'.$row->kredit_1.'">
                            <td>'.$row->no.'</td>
                            <td>'.$row->nama_transaksi.'</td>
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
                                            ->join('pembelian','penerimaan.kode_pembelian','=','pembelian.kode_pembelian')
                                            ->select('penerimaan.no_faktur','penerimaan.kode_vendor','vendors.nama_vendor',DB::raw('SUM(penerimaan_detail.harga_total) as total'),'pembelian.ket_transaksi')
                                            ->where('penerimaan.no_faktur', $no_faktur)
                                            ->groupBy('penerimaan.no_faktur','penerimaan.kode_vendor','vendors.nama_vendor','pembelian.ket_transaksi')
                                            ->first();

        $kontrabon_coa = DB::table('penerimaan')->join('pembelian','penerimaan.kode_pembelian','=','pembelian.kode_pembelian')
                                            ->join('pengajuan','pembelian.kode_pengajuan','=','pengajuan.kode_pengajuan')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->join('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
                                            ->join('coa_transaksi_detail','coa_transaksi.no','=','coa_transaksi_detail.no')
                                            ->select('penerimaan.no_faktur','pembelian.ket_transaksi','pengajuan.jenis','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.coa','coa_transaksi.nama_transaksi',
                                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debet_1"),
                                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                                            ->where('penerimaan.no_faktur', $no_faktur)
                                            ->groupBy('penerimaan.no_faktur','pembelian.ket_transaksi','pengajuan.jenis','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.coa','coa_transaksi.nama_transaksi','coa_transaksi.no')
                                            ->first();

        $kontrabon_detail = DB::table('penerimaan')->join('penerimaan_detail','penerimaan.no_btb','=','penerimaan_detail.no_btb')
                        ->select('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur',DB::raw('SUM(penerimaan_detail.harga_total) as total'))
                        ->where('penerimaan.no_faktur', $no_faktur)
                        ->groupBy('penerimaan.no_btb','penerimaan.no_faktur','penerimaan.tgl_faktur')
                        ->get();

     

        return view('purchasing.accepted.created',compact('no_kb','kontrabon','kontrabon_coa','kontrabon_detail'));
    }

	public function view_accepted($no_faktur)
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

        

        return view('purchasing.accepted.view',compact('invoice','invoice_detail'));
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

        

        return view('purchasing.accepted.view_detail',compact('invoice','invoice_detail'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'no_kb' => 'required|string',
            'kode_supp' => 'required|exists:vendors,kode_vendor',
            'description' => 'required|string'
        ]);

        Kontrabon::create([
            'no_kontrabon' => $request->get('no_kb'),
            'tgl_kontrabon' => Carbon::now()->format('Y-m-d'),
            'kode_vendor' => $request->get('kode_supp'),
            'total' => str_replace(",", "", $request->get('total_head')), //$request->get('total_head'),
            'termin' => '',
            'jatuh_tempo' => $request->get('jatuh_tempo'),
            'keterangan' => $request->get('description'),
            'status' => '0',
            'type' => $request->get('id_pengeluaran'),
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
        return redirect()->route('accepted.index');
    }

}
