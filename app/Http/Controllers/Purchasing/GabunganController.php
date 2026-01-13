<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pembelian;
use App\Pembelian_Detail;
use App\Perusahaan;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GabunganController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        return view('purchasing.gabungan.index');
    }

    public function getDataCreatePo()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_po = DB::table('rekap_pengajuan')
            ->join('rekap_pengajuan_detail', 'rekap_pengajuan.kode_rekap', '=', 'rekap_pengajuan_detail.kode_rekap')
            ->join('products', 'rekap_pengajuan_detail.kode_product', '=', 'products.kode')
            ->select(
                'rekap_pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                DB::raw('SUM(rekap_pengajuan_detail.qty_jadi) as qty'),
                'products.satuan',
                'products.price'
            )
            ->WhereBetween('rekap_pengajuan.tgl_rekap', [$date_start, $date_end])
            ->WhereIn('rekap_pengajuan.status',['1'])
            ->groupBy(
                'rekap_pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                'products.satuan',
                'products.price'
            );

        $data = $data_po->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];
        
        return response()->json($output, 200);
    }

    public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ', $request->tgl_cari);
        
        $date_start = Carbon::parse($date[0])->format('Y-m-d');  //'2023-11-29'; 
        $date_end = Carbon::parse($date[1])->format('Y-m-d'); //'2023-11-29';

        $date_start_2 = '2025-11-12';//Carbon::parse($date[0])->format('Y-m-d'); //
        $date_end_2 = '2025-11-12';//Carbon::parse($date[1])->format('Y-m-d'); //

        $data_po = DB::table('rekap_pengajuan')
        ->join('rekap_pengajuan_detail', 'rekap_pengajuan.kode_rekap', '=', 'rekap_pengajuan_detail.kode_rekap')
        ->join('products', 'rekap_pengajuan_detail.kode_product', '=', 'products.kode')
        ->leftJoin('pembelian', 'rekap_pengajuan.kode_rekap', '=', 'pembelian.kode_pengajuan')
        ->leftJoin('pembelian_detail', 'pembelian.kode_pembelian', '=', 'pembelian_detail.kode_pembelian')
        ->whereBetween('rekap_pengajuan.tgl_rekap', [$date_start, $date_end])
        ->whereIn('rekap_pengajuan.status', [1])
        ->groupBy('rekap_pengajuan.kode_rekap','rekap_pengajuan_detail.kode_product', 'products.nama_barang', 'products.merk', 'products.ket', 'products.satuan', 'products.price','rekap_pengajuan_detail.qty_jadi')
        ->select(
            'rekap_pengajuan.kode_rekap',
            'rekap_pengajuan_detail.kode_product',
            'products.nama_barang',
            'products.merk',
            'products.ket',
            'rekap_pengajuan_detail.qty_jadi as qty',
            'products.satuan',
            DB::raw('COALESCE((SELECT sum(pembelian_detail.qty_po) as qty_po FROM pembelian INNER JOIN pembelian_detail ON pembelian.kode_pembelian = pembelian_detail.kode_pembelian WHERE pembelian.tgl_pembelian BETWEEN ? AND ? AND pembelian_detail.kode_product = rekap_pengajuan_detail.kode_product GROUP BY pembelian_detail.kode_product),0) AS qty_po'),
            'products.price as harga_satuan',
            DB::raw('(rekap_pengajuan_detail.qty_jadi - COALESCE((SELECT sum(pembelian_detail.qty_po) as qty_po FROM pembelian INNER JOIN pembelian_detail ON pembelian.kode_pembelian = pembelian_detail.kode_pembelian WHERE pembelian.tgl_pembelian BETWEEN ? AND ? AND pembelian_detail.kode_product = rekap_pengajuan_detail.kode_product GROUP BY pembelian_detail.kode_product),0)) AS sisa_qty')
        )
        ->addBinding($date_start, 'select')
        ->addBinding($date_end, 'select')
        ->addBinding($date_start_2, 'select')
        ->addBinding($date_end_2, 'select');

        $data = $data_po->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function actionVendor(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = DB::table('vendors')
                    ->where('vendors.kode_vendor', 'like', '%' . $query . '%')
                    ->orWhere('vendors.nama_vendor', 'like', '%' . $query . '%')
                    ->get();
            } else {
                $data = DB::table('vendors')
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_vendor" data-kode_vendor="' . $row->kode_vendor . '" data-nama_vendor="' . $row->nama_vendor . '">
                            <td>' . $row->kode_vendor . '</td>
                            <td>' . $row->nama_vendor . '</td>
                        </tr>
                    ';
                }
            } else {
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
        
        $data['perusahaans'] = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        $date = (date('Ym'));
        $date_1 = (date('Ymd'));
        //$date_filter = (date('m'));
        //$date_filter_2 = (date('m'));
		
		//$tanggal = $request->tgl_rekap;
		//$date_rekap = new DateTime($tanggal);
		//$bulan_rekap = $date->format('m');
		
		$date_filter = '11';
        $date_filter_2 = '11';
		$kode_rekap = $request->kode_rekap;

        $getRow = DB::table('pembelian')->select(DB::raw('MAX(RIGHT(kode_pembelian,6)) as NoUrut'))
            ->where('kode_pembelian', 'like', "%" . $date . "%");
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                $kode = "PO" . $date_1 . "00000" . '' . ($rowCount + 1);
            } else if ($rowCount < 99) {
                $kode = "PO" . $date_1 . "0000" . '' . ($rowCount + 1);
            } else if ($rowCount < 999) {
                $kode = "PO" . $date_1 . "000" . '' . ($rowCount + 1);
            } else if ($rowCount < 9999) {
                $kode = "PO" . $date_1 . "00" . '' . ($rowCount + 1);
            } else if ($rowCount < 99999) {
                $kode = "PO" . $date_1 . "0" . '' . ($rowCount + 1);
            } else {
                $kode = "PO" . $date_1 . ($rowCount + 1);
            }
        } else {
            $kode = "PO" . $date_1 . sprintf("%06s", 1);
        }
		

        //===== data HEADER =====//
        $data['datas_po_header'] = DB::table('rekap_pengajuan')
            ->join('rekap_pengajuan_detail', 'rekap_pengajuan.kode_rekap', '=', 'rekap_pengajuan_detail.kode_rekap')
            ->join('products', 'rekap_pengajuan_detail.kode_product', '=', 'products.kode')
            ->select(
                'rekap_pengajuan.kode_rekap'
            )
            ->WhereRaw('MONTH(rekap_pengajuan.tgl_rekap) = ?', $date_filter)
            ->WhereIn('rekap_pengajuan.status',['1'])
			->Where('rekap_pengajuan.kode_rekap', $kode_rekap)
			->WhereIn('rekap_pengajuan.status_approval_pc',['1'])
            ->groupBy(
                'rekap_pengajuan.kode_rekap'
            )
            ->first();
        //===== data HEADER =====//
		

        $kode_produk = $request->kode_produk;
        $data['kode'] = $kode;
        $data['datas_po'] = DB::table('rekap_pengajuan')
        ->join('rekap_pengajuan_detail', 'rekap_pengajuan.kode_rekap', '=', 'rekap_pengajuan_detail.kode_rekap')
        ->join('products', 'rekap_pengajuan_detail.kode_product', '=', 'products.kode')
        ->select(
            'rekap_pengajuan_detail.kode_rekap',
            'rekap_pengajuan_detail.kode_product',
            'products.nama_barang',
            'products.merk',
            'products.ket',
            DB::raw('SUM(rekap_pengajuan_detail.qty_jadi) as qty'),
            DB::raw('COALESCE((SELECT SUM(pembelian_detail.qty_po) FROM pembelian INNER JOIN pembelian_detail ON pembelian.kode_pembelian = pembelian_detail.kode_pembelian WHERE month(pembelian.tgl_pembelian) = ? AND pembelian_detail.kode_product = rekap_pengajuan_detail.kode_product GROUP BY pembelian_detail.kode_product),0) AS sisa_qty_po'),
            DB::raw('(rekap_pengajuan_detail.qty_jadi - COALESCE((SELECT SUM(pembelian_detail.qty_po) FROM pembelian INNER JOIN pembelian_detail ON pembelian.kode_pembelian = pembelian_detail.kode_pembelian WHERE month(pembelian.tgl_pembelian) = ? AND pembelian.kode_pengajuan = rekap_pengajuan_detail.kode_rekap AND pembelian_detail.kode_product = rekap_pengajuan_detail.kode_product GROUP BY pembelian_detail.kode_product),0)) AS total_sisa_qty_po'),
            'products.satuan',
            'products.price'
        )
        ->WhereRaw('MONTH(rekap_pengajuan.tgl_rekap) = ?', $date_filter)
        ->WhereIn('rekap_pengajuan.status',['1'])
		->WhereIn('rekap_pengajuan_detail.kode_product', $kode_produk)
        ->where('rekap_pengajuan.kode_rekap', $kode_rekap)
		->WhereIn('rekap_pengajuan.status_approval_pc',['1'])
        
        ->where('rekap_pengajuan_detail.status', 0)
        ->groupBy(
            'rekap_pengajuan_detail.kode_rekap',
            'rekap_pengajuan_detail.kode_product',
            'products.nama_barang',
            'products.merk',
            'products.ket',
            'products.satuan',
            'products.price',
            'rekap_pengajuan_detail.qty_jadi'
        )
        ->addBinding($date_filter, 'select')
        ->addBinding($date_filter_2, 'select')
        ->get();
       
        $data['datas_po_all'] = DB::table('rekap_pengajuan')
            ->join('rekap_pengajuan_detail', 'rekap_pengajuan.kode_rekap', '=', 'rekap_pengajuan_detail.kode_rekap')
            ->join('products', 'rekap_pengajuan_detail.kode_product', '=', 'products.kode')
            ->select(
                'rekap_pengajuan.kode_rekap',
                'rekap_pengajuan.tgl_rekap',
                'rekap_pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                'rekap_pengajuan_detail.qty_jadi as qty',
                'products.satuan',
                'products.price'
            )
            ->WhereIn('rekap_pengajuan_detail.kode_product', $kode_produk)
            ->WhereIn('rekap_pengajuan.status',['1'])
			->where('rekap_pengajuan.kode_rekap',  $kode_rekap)
			->WhereIn('rekap_pengajuan.status_approval_pc',['1'])
            ->orderBy('products.nama_barang')
            ->get();
            

            return view ('purchasing.gabungan.create', $data);
    }

    public function store(Request $request)
    {
        $kode_perusahaan = $request->get("kode_perusahaan_tujuan");
        
        $tahun = date('Y', strtotime($request->get('tgl_pembelian')));
        $bulan = date('m', strtotime($request->get('tgl_pembelian')));

        if ($bulan == '01'){
            $bulan_romawi = 'I';
            $nama_bulan = 'Januari'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
            $nama_bulan = 'Februari';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
            $nama_bulan = 'Maret';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
            $nama_bulan = 'April';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
            $nama_bulan = 'Mei';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
            $nama_bulan = 'Juni';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
            $nama_bulan = 'Juli';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
            $nama_bulan = 'Agustus';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
            $nama_bulan = 'September';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
            $nama_bulan = 'Oktober';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
            $nama_bulan = 'November';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
            $nama_bulan = 'Desember';
        }

        $date = (date('Ym'));
        $getRow = DB::table('pembelian')
            ->select(DB::raw('MAX((kode_pembelian)) as NoUrut'))
            ->where('kode_pembelian', 'like', "%".$kode_perusahaan."%")
            ->whereMonth('tgl_pembelian',$bulan)
            ->whereYear('tgl_pembelian',$tahun);
        $rowCount = $getRow->count();

        if($rowCount > 0){
            if ($rowCount < 9) {
                $no_po = 'PO '.'000'.''.($rowCount + 1).'/'. $kode_perusahaan.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_po = 'PO '.'00'.''.($rowCount + 1).'/'. $kode_perusahaan.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_po = 'PO '.'0'.''.($rowCount + 1).'/'. $kode_perusahaan.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_po = 'PO '.''.($rowCount + 1).'/'. $kode_perusahaan.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            $no_po = 'PO '.'0001'.'/'. $kode_perusahaan.'/'.$bulan_romawi.'/'.$tahun;
        } 

        // $getRow_urut_po = DB::table('pembelian')
        //     ->select(DB::raw('MAX((kode_pembelian)) as NoUrut'))
        //     ->where('kode_pembelian', 'like', "%".$kode_perusahaan."%")
        //     ->whereMonth('tgl_pembelian',$bulan)
        //     ->whereYear('tgl_pembelian',$tahun);
        // $rowCount_urut_po = $getRow_urut_po->count();

        // if($rowCount_urut_po > 0){
        //     $no_urut_po = $rowCount_urut_po + 1;
        // }else{
        //     $no_urut_po = 1;
        // }

        $getRow = DB::table('pembelian')->select(DB::raw('COUNT(kode_pembelian) as NoUrut'))->first();
        if ($getRow->NoUrut > 0) {
            $no_urut_po = $getRow->NoUrut + 1;
        }else{
            $no_urut_po = 1;
        }

        $this->validate($request, [
            'kode_supp' => 'required|exists:vendors,kode_vendor'
        ]);

        Pembelian::create([
            'kode_pembelian' => $no_po,
            'tgl_pembelian' => Carbon::now()->format('Y-m-d'),
            'kode_perusahaan' => $request->get('kode_perusahaan_tujuan'),
            'periode' => $nama_bulan,
            'kode_vendor' => $request->get('kode_supp'),
            'kode_pengajuan' => $request->get('kode'),
            //'ket_transaksi' => $request->get('jenis'),
            'status' => '1',
            'id_user_input' => Auth::user()->id,
            'no_urut_po' => $no_urut_po
        ]);

        $datas_1 = [];
        foreach ($request->input('kode_produk') as $key => $value) {
            $datas_1["kode_produk.{$key}"] = 'required';
            $datas_1["harga.{$key}"] = 'required'; 
            $datas_1["qty.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas_1);
        foreach ($request->input("kode_produk") as $key => $value) {  
            $data = new Pembelian_Detail;
            $data->kode_pembelian = $no_po;
            $data->kode_product = $request->get("kode_produk")[$key];
            $data->harga_satuan =  str_replace(",", "", $request->get("harga")[$key]);
            $data->qty = $request->get("qty")[$key];
            $data->qty_po = $request->get("qty_po")[$key];
            $data->satuan = $request->get("satuan")[$key];
            //$data->harga_total = str_replace(",", "", $request->get("harga")[$key])*$request->get("qty_po")[$key];
            $data->harga_total = str_replace(",", "", $request->get("total")[$key]);
            $data->no_urut_po = $no_urut_po;
            $data->save();

            // $update_status = DB::table('rekap_pengajuan_detail')
            //         ->select('rekap_pengajuan_detail.status')
            //         ->Where('rekap_pengajuan_detail.kode_rekap', $request->get("kode_rekap")[$key])
            //         ->update([
            //             'status' => 1
            // ]);
        }


        // $datas = [];
        // foreach ($request->input('kode_produk_temp') as $key => $value) {
           
        // }

        // $validator = Validator::make($request->all(), $datas);
        // foreach ($request->input("kode_produk_temp") as $key => $value) {
        //     $pengajuan_po = DB::table('pengajuan')
        //             ->select('pengajuan.status_pengajuan')
        //             ->Where('pengajuan.kode_pengajuan', $request->get("kode_pengajuan")[$key])
        //             ->update([
        //                 'status_pengajuan' => 5
        //     ]);
        // }

        alert()->success('Success.','New order has been created');
        return redirect()->route('po_gabungan.index');
    }
}
