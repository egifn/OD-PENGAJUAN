<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PengajuanBiayaBbmSales;
use App\Pengajuan_Upload_Bbm;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PengajuanBiayaBbmSalesController extends Controller
{
    public function index()
    {
        return view ('pengajuan.pengajuan_biaya_bbm_sales.index');
    }

    public function getDataBbm(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));
        
        $getDataBbm = DB::table('pengajuan_biaya_bbm_sales')
                        ->join('ms_pengeluaran','pengajuan_biaya_bbm_sales.id_pengeluaran','=','ms_pengeluaran.id')
                        ->join('perusahaans','pengajuan_biaya_bbm_sales.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya_bbm_sales.kode_depo','=','depos.kode_depo')
                        ->join('ms_bahan_bakar','pengajuan_biaya_bbm_sales.kode_bbm','=','ms_bahan_bakar.kode_bbm')
                        ->join('users','pengajuan_biaya_bbm_sales.id_user_input','=','users.id')
                        ->select('pengajuan_biaya_bbm_sales.kode_pengajuan_bbm',
                        'pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',
                        'pengajuan_biaya_bbm_sales.id_pengeluaran',
                        'ms_pengeluaran.nama_pengeluaran',
                        'pengajuan_biaya_bbm_sales.kode_perusahaan',
                        'perusahaans.nama_perusahaan',
                        'pengajuan_biaya_bbm_sales.kode_depo',
                        'depos.nama_depo',
                        'pengajuan_biaya_bbm_sales.nopol',
                        'pengajuan_biaya_bbm_sales.nama_sales',
                        'pengajuan_biaya_bbm_sales.divisi',
                        'pengajuan_biaya_bbm_sales.segmen',
                        'pengajuan_biaya_bbm_sales.km_akhir',
                        'pengajuan_biaya_bbm_sales.kode_bbm',
                        'ms_bahan_bakar.nama_bbm',
                        'pengajuan_biaya_bbm_sales.volume_perliter',
                        'pengajuan_biaya_bbm_sales.harga_perliter',
                        'pengajuan_biaya_bbm_sales.total',
                        'pengajuan_biaya_bbm_sales.status',
                        'pengajuan_biaya_bbm_sales.id_user_input',
                        'users.name');
        if (!isset($request->value)) {
            $getDataBbm
                        ->WhereBetween('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',[$date_start,$date_end])
                        ->where('pengajuan_biaya_bbm_sales.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->where('pengajuan_biaya_bbm_sales.kode_depo', Auth::user()->kode_depo);
        }else{
            $getDataBbm
                        ->WhereBetween('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',[$date_start,$date_end])
                        ->where('pengajuan_biaya_bbm_sales.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->where('pengajuan_biaya_bbm_sales.kode_depo', Auth::user()->kode_perusahaan);
                        // ->orWhere('izin_h.no_izin', 'like', "%$request->value%")
                        // ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                        // ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                        // ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
        }

        $data  = $getDataBbm->get();
        $count = ($getDataBbm->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ' ,$request->tgl_cari);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');

        $getDataBbmCari = DB::table('pengajuan_biaya_bbm_sales')
                        ->join('ms_pengeluaran','pengajuan_biaya_bbm_sales.id_pengeluaran','=','ms_pengeluaran.id')
                        ->join('perusahaans','pengajuan_biaya_bbm_sales.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan_biaya_bbm_sales.kode_depo','=','depos.kode_depo')
                        ->join('ms_bahan_bakar','pengajuan_biaya_bbm_sales.kode_bbm','=','ms_bahan_bakar.kode_bbm')
                        ->join('users','pengajuan_biaya_bbm_sales.id_user_input','=','users.id')
                        ->select('pengajuan_biaya_bbm_sales.kode_pengajuan_bbm',
                        'pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',
                        'pengajuan_biaya_bbm_sales.id_pengeluaran',
                        'ms_pengeluaran.nama_pengeluaran',
                        'pengajuan_biaya_bbm_sales.kode_perusahaan',
                        'perusahaans.nama_perusahaan',
                        'pengajuan_biaya_bbm_sales.kode_depo',
                        'depos.nama_depo',
                        'pengajuan_biaya_bbm_sales.nopol',
                        'pengajuan_biaya_bbm_sales.nama_sales',
                        'pengajuan_biaya_bbm_sales.divisi',
                        'pengajuan_biaya_bbm_sales.segmen',
                        'pengajuan_biaya_bbm_sales.km_akhir',
                        'pengajuan_biaya_bbm_sales.kode_bbm',
                        'ms_bahan_bakar.nama_bbm',
                        'pengajuan_biaya_bbm_sales.volume_perliter',
                        'pengajuan_biaya_bbm_sales.harga_perliter',
                        'pengajuan_biaya_bbm_sales.total',
                        'pengajuan_biaya_bbm_sales.status',
                        'pengajuan_biaya_bbm_sales.id_user_input',
                        'users.name');

        if (!isset($request->value)) {
            $getDataBbmCari
                ->WhereBetween('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',[$date_start,$date_end])
                ->where('pengajuan_biaya_bbm_sales.kode_perusahaan', Auth::user()->kode_perusahaan)
                ->where('pengajuan_biaya_bbm_sales.kode_depo', Auth::user()->kode_depo);
        }else{
            $getDataBbmCari
                ->WhereBetween('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',[$date_start,$date_end])
                ->where('pengajuan_biaya_bbm_sales.kode_perusahaan', Auth::user()->kode_perusahaan)
                ->where('pengajuan_biaya_bbm_sales.kode_depo', Auth::user()->kode_depo);
                // ->orWhere('izin_h.no_izin', 'like', "%$request->value%")
                // ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                // ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                // ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                // ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                // ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
        }       
        
        $data  = $getDataBbmCari->get();
        $count = ($getDataBbmCari->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function create(Request $request)
    {
        $bbm = DB::table('ms_bahan_bakar')
                                  ->get();
        return view ('pengajuan.pengajuan_biaya_bbm_sales.create', compact('bbm'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        $tahun = date('Y', strtotime($request->get('tgl')));
        $bulan = date('m', strtotime($request->get('tgl')));
        // $tanggal = date('d', strtotime($request->get('tgl')));

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
         //----End baru ------------------------------------------------//

        // //$kd_perusahaan = $request->get('kode_perusahaan');
        // $kd_perusahaan_tujuan = $request->get('kode_perusahaan_tujuan');
        // $kode_depo = $request->get('kode_depo');
        // $kode_divisi = $request->get('kode_divisi');
        // //$id_kat = $request->get('id_pengeluaran');

        

        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo', Auth::user()->kode_depo)->first();

        $getRow = DB::table('pengajuan_biaya_bbm_sales')
                    ->select(DB::raw('MAX(kode_pengajuan_bbm) as NoUrut'))
                    ->where('kode_perusahaan', Auth::user()->kode_perusahaan)
                    ->where('kode_depo', Auth::user()->kode_depo);
        $rowCount = $getRow->count();

        if($rowCount > 0){
            //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
            if ($rowCount < 9) {
                $no_pengajuan_biaya = 'BBM'.'000'.''.($rowCount + 1).'/'.Auth::user()->kode_perusahaan.'-'.$alias_depo->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_pengajuan_biaya = 'BBM'.'00'.''.($rowCount + 1).'/'.Auth::user()->kode_perusahaan.'-'.$alias_depo->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_pengajuan_biaya = 'BBM'.'0'.''.($rowCount + 1).'/'.Auth::user()->kode_perusahaan.'-'.$alias_depo->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_pengajuan_biaya = 'BBM'.''.($rowCount + 1).'/'.Auth::user()->kode_perusahaan.'-'.$alias_depo->alias.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
            $no_pengajuan_biaya = 'BBM'.'0001'.'/'.Auth::user()->kode_perusahaan.'-'.$alias_depo->alias.'/'.$bulan_romawi.'/'.$tahun;
        }

        PengajuanBiayaBbmSales::create([
            'kode_pengajuan_bbm' => $no_pengajuan_biaya,
            'tgl_pengajuan_bbm' => Carbon::now()->format('Y-m-d'),
            'id_pengeluaran' => '19',
            'kode_perusahaan' => Auth::user()->kode_perusahaan,
            'kode_depo' => Auth::user()->kode_depo,
            'no_faktur' => $request->get('no_faktur'),
            'tgl_faktur' => Carbon::now()->format('Y-m-d'),
            'nopol' => $request->get('no_kendaraan'),
            'nama_sales' => $request->get('driver'),
            'divisi' => $request->get('divisi'),
            'segmen' => $request->get('segmen'),
            'km_akhir' => $request->get('km_kendaraan'),
            'kode_bbm' => $request->get('bahan_bakar'),
            'volume_perliter' => $request->get('liter'),
            'harga_perliter' => $request->get('hargaliter'),
            'total' => str_replace(",", "", $request->get('total')),
            'status' => '0',
            'id_user_input' => Auth::user()->id
        ]);


        if($request->hasfile('filename')) { 
            foreach ($request->file('filename') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);
                       
                    Pengajuan_Upload_Bbm::create([
                        'kode_pengajuan_bbm' =>  $no_pengajuan_biaya,
                        'no_description' => $request->get('no_faktur'),
                        'description' => $request->get('bahan_bakar'),
                        'filename' => $filename
                    ]);
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }

        alert()->success('Success.','New request has been created');
        return redirect()->route('pengajuan_biaya_bbm_sales.index');
    }
}
