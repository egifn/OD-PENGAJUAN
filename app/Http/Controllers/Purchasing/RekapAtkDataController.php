<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class RekapAtkDataController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_rekap = DB::table('rekap_pengajuan')   
                ->join('users','rekap_pengajuan.id_user_input','=','users.id') 
                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                        'users.name','rekap_pengajuan.status','rekap_pengajuan.no_urut')
                ->WhereBetween('rekap_pengajuan.tgl_rekap', [$date_start,$date_end])
                ->orderBy('rekap_pengajuan.tgl_rekap', 'DESC')
                ->get();

        return view('purchasing.rekap_atk_data.index', compact('data_rekap'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data_rekap = DB::table('rekap_pengajuan')   
                ->join('users','rekap_pengajuan.id_user_input','=','users.id') 
                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                        'users.name','rekap_pengajuan.status','rekap_pengajuan.no_urut')
                ->WhereBetween('rekap_pengajuan.tgl_rekap', [$date_start,$date_end])
                ->orderBy('rekap_pengajuan.tgl_rekap', 'DESC')
                ->get();

        return view('purchasing.rekap_atk_data.index', compact('data_rekap'));
    }

    public function view($no_urut)
    {
        $header = DB::table('rekap_pengajuan')
                    ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                            'rekap_pengajuan.status','rekap_pengajuan.no_urut')
                    ->where('rekap_pengajuan.no_urut', $no_urut)->first();

        $rekap_pengajuan_v = DB::table('rekap_pengajuan')
                            ->join('rekap_pengajuan_detail','rekap_pengajuan.kode_rekap','=','rekap_pengajuan_detail.kode_rekap')
                            ->join('users','rekap_pengajuan.id_user_input','=','users.id')
                            ->join('products','rekap_pengajuan_detail.kode_product','=','products.kode')
                            ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.no_urut','rekap_pengajuan_detail.kode_product','products.nama_barang',
                                    'products.merk','products.ket','rekap_pengajuan_detail.qty_awal','rekap_pengajuan_detail.qty_jadi','products.satuan',
                                    'rekap_pengajuan_detail.harga','rekap_pengajuan_detail.total_harga','rekap_pengajuan_detail.status')
                            ->where('rekap_pengajuan.no_urut', $no_urut)->get();

        $total_rekap = DB::table('rekap_pengajuan_detail')
                        ->where('rekap_pengajuan_detail.no_urut', $no_urut)
                        ->get()->sum('rekap_pengajuan_detail.total_harga');

        $total_rekap = DB::table('rekap_pengajuan_detail')
                        ->select(DB::raw('SUM(rekap_pengajuan_detail.total_harga) as total_all'))
                        ->where('rekap_pengajuan_detail.no_urut', $no_urut)
                        ->first();

        return view('purchasing.rekap_atk_data.view', compact('header','rekap_pengajuan_v','total_rekap')); 
    }

    public function ubah($no_urut)
    {
        $header = DB::table('rekap_pengajuan')
                    ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                            'rekap_pengajuan.status','rekap_pengajuan.no_urut')
                    ->where('rekap_pengajuan.no_urut', $no_urut)->first();

        $rekap_pengajuan_v = DB::table('rekap_pengajuan')
                            ->join('rekap_pengajuan_detail','rekap_pengajuan.kode_rekap','=','rekap_pengajuan_detail.kode_rekap')
                            ->join('users','rekap_pengajuan.id_user_input','=','users.id')
                            ->join('products','rekap_pengajuan_detail.kode_product','=','products.kode')
                            ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.no_urut','rekap_pengajuan_detail.kode_product','products.nama_barang',
                                    'products.merk','products.ket','rekap_pengajuan_detail.qty_awal','rekap_pengajuan_detail.qty_jadi','products.satuan',
                                    'rekap_pengajuan_detail.harga','rekap_pengajuan_detail.total_harga','rekap_pengajuan_detail.status')
                            ->where('rekap_pengajuan.no_urut', $no_urut)->get();


        $total_rekap = DB::table('rekap_pengajuan_detail')
                        ->select(DB::raw('SUM(rekap_pengajuan_detail.total_harga) as total_all'))
                        ->where('rekap_pengajuan_detail.no_urut', $no_urut)
                        ->first();

        return view('purchasing.rekap_atk_data.update', compact('header','rekap_pengajuan_v','total_rekap')); 
    }

    public function update(Request $request)
    {
        $no_urut = $request->no_urut;

        $approved = DB::table('rekap_pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status' => 0,
        ]);

        $kode_product = $request->kode_product;
        $ceklist = $request->ceklist;
        $nama_barang = $request->nama_barang;

        $merk = $request->merk;
        $ket = $request->ket;
        $qty_awal = $request->qty_awal;
        $qty_jadi = $request->qty_jadi;
        $satuan = $request->satuan;
        $harga = $request->harga;
        $total_harga = $request->total_harga;

        for ($i=0; $i < count((array)$kode_product); $i++) { 
            if($ceklist[$i] == 1){
                $chkd = 1; 
            }else{
                $chkd = 0; 
            }

            $update = DB::table('rekap_pengajuan_detail')
                        ->Where('no_urut', request()->no_urut)
                        ->Where('kode_product', $kode_product[$i])
                        ->update([
                            'qty_jadi' => $qty_jadi[$i],
                            'total_harga' => $qty_jadi[$i]*str_replace(",", "", $harga[$i]) 
                        ]);
        }
        
        $output = [
            'msg'  => 'Data berhasil diubah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);

        alert()->success('Berhasil.','Data berhasil diubah...');
        return redirect()->route('rekap_data_atk.index');
    }

    public function rekap(Request $request)
    {
        $no_urut = $request->input('no_urut');
        $tombol_excel = $request->input('btn_excel');
        $tombol_pdf = $request->input('btn_pdf');

        if($tombol_excel == 'excel'){
            $header = DB::table('rekap_pengajuan')
                    ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                            'rekap_pengajuan.status','rekap_pengajuan.no_urut')
                    ->where('rekap_pengajuan.no_urut', $no_urut)->first();

            $rekap_pengajuan_v = DB::table('rekap_pengajuan')
                                ->join('rekap_pengajuan_detail','rekap_pengajuan.kode_rekap','=','rekap_pengajuan_detail.kode_rekap')
                                ->join('users','rekap_pengajuan.id_user_input','=','users.id')
                                ->join('products','rekap_pengajuan_detail.kode_product','=','products.kode')
                                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.no_urut','rekap_pengajuan_detail.kode_product','products.nama_barang',
                                        'products.merk','products.ket','rekap_pengajuan_detail.qty_awal','rekap_pengajuan_detail.qty_jadi','products.satuan',
                                        'rekap_pengajuan_detail.harga','rekap_pengajuan_detail.total_harga','rekap_pengajuan_detail.status')
                                ->where('rekap_pengajuan.no_urut', $no_urut)->get();

            $total_rekap = DB::table('rekap_pengajuan_detail')
                            ->where('rekap_pengajuan_detail.no_urut', $no_urut)
                            ->get()->sum('rekap_pengajuan_detail.total_harga');

            $total_rekap = DB::table('rekap_pengajuan_detail')
                            ->select(DB::raw('SUM(rekap_pengajuan_detail.total_harga) as total_all'))
                            ->where('rekap_pengajuan_detail.no_urut',$no_urut)
                            ->first();

            return view ('purchasing.rekap_atk_data.view_excel', compact('header','rekap_pengajuan_v','total_rekap'));
        }elseif($tombol_pdf == 'pdf'){
            $header = DB::table('rekap_pengajuan')
                    ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                            'rekap_pengajuan.status','rekap_pengajuan.no_urut')
                    ->where('rekap_pengajuan.no_urut', $no_urut)->first();

            $rekap_pengajuan_v = DB::table('rekap_pengajuan')
                                ->join('rekap_pengajuan_detail','rekap_pengajuan.kode_rekap','=','rekap_pengajuan_detail.kode_rekap')
                                ->join('users','rekap_pengajuan.id_user_input','=','users.id')
                                ->join('products','rekap_pengajuan_detail.kode_product','=','products.kode')
                                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.no_urut','rekap_pengajuan_detail.kode_product','products.nama_barang',
                                        'products.merk','products.ket','rekap_pengajuan_detail.qty_awal','rekap_pengajuan_detail.qty_jadi','products.satuan',
                                        'rekap_pengajuan_detail.harga','rekap_pengajuan_detail.total_harga','rekap_pengajuan_detail.status')
                                ->where('rekap_pengajuan.no_urut', $no_urut)->get();

            $total_rekap = DB::table('rekap_pengajuan_detail')
                            ->where('rekap_pengajuan_detail.no_urut', $no_urut)
                            ->get()->sum('rekap_pengajuan_detail.total_harga');

            $total_rekap = DB::table('rekap_pengajuan_detail')
                            ->select(DB::raw('SUM(rekap_pengajuan_detail.total_harga) as total_all'))
                            ->where('rekap_pengajuan_detail.no_urut', $no_urut)
                            ->first();

            $pdf = PDF::loadview('purchasing.rekap_atk_data.view_pdf', compact('header','rekap_pengajuan_v','total_rekap'))->setPaper('a4', 'landscape');
            return $pdf->stream();
        }
        
        
    }
	
	public function pdf($no_urut)
    {
        
        $rekap_head = DB::table('rekap_pengajuan')
						->leftJoin('users','rekap_pengajuan.id_user_approval_pc','=','users.id')
                        ->where('rekap_pengajuan.no_urut', $no_urut)
                        ->first();

        $rekap_detail = DB::table('rekap_pengajuan')
                        ->join('rekap_pengajuan_detail','rekap_pengajuan.kode_rekap','=','rekap_pengajuan_detail.kode_rekap')
                        ->select('rekap_pengajuan.kode_rekap',
                                DB::raw('SUM(rekap_pengajuan_detail.harga) as harga'),
                                DB::raw('SUM(rekap_pengajuan_detail.total_harga) as total_harga'))
                        ->where('rekap_pengajuan.no_urut', $no_urut)
                        ->groupBy('rekap_pengajuan.kode_rekap')
                        ->get();

        $rekap_total = DB::table('rekap_pengajuan')
                        ->join('rekap_pengajuan_detail','rekap_pengajuan.kode_rekap','=','rekap_pengajuan_detail.kode_rekap')
                        ->select('rekap_pengajuan.kode_rekap',
                                DB::raw('SUM(rekap_pengajuan_detail.total_harga) as total'))
                        ->where('rekap_pengajuan.no_urut', $no_urut)
                        ->groupBy('rekap_pengajuan.kode_rekap')
                        ->first();

        $tahun = date('Y', strtotime($rekap_head->tgl_rekap));
        $bulan = date('m', strtotime($rekap_head->tgl_rekap));

        if ($bulan == '01'){
            $bulan_romawi = 'I'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
        }

        $app_ga = 'APP '.'000'.''.'1'.'/'.'TUA-HO'.'/'.'GA'.'/'.$bulan_romawi.'/'.$tahun;
        $app_ops = 'APP '.'000'.''.'1'.'/'.'TUA-HO'.'/'.'OPS'.'/'.$bulan_romawi.'/'.$tahun;
        $app_pc = '';


        $pdf = PDF::loadview('purchasing.rekap_atk_data.pdf', compact('rekap_head','rekap_detail','rekap_total','app_ga','app_ops','app_pc'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
