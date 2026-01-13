<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pengajuan_Biaya;
use App\Pengajuan_Biaya_Detail;
use App\Pengajuan_Upload;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PengajuanBiayaBbmSalesLanjutanController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $pengajuan_bbm = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftJoin('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users as users_1','pengajuan_biaya.id_user_input','=','users_1.id')
                        //->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                        ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.no_surat_program','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                        'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan','pengajuan_biaya_detail.qty',
                        'pengajuan_biaya_detail.tharga','pengajuan_biaya.id_user_input','users_1.name','pengajuan_biaya.no_urut')
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->WhereIn('pengajuan_biaya.kategori', ['19'])
                        ->where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();

        return view ('pengajuan.pengajuan_biaya_bbm_sales_lanjutan.index', compact('pengajuan_bbm'));
    }

    public function cari_index(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $pengajuan_bbm = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftJoin('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users as users_1','pengajuan_biaya.id_user_input','=','users_1.id')
                        //->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                        ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.no_surat_program','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                        'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan','pengajuan_biaya_detail.qty',
                        'pengajuan_biaya_detail.tharga','pengajuan_biaya.id_user_input','users_1.name','pengajuan_biaya.no_urut')
                        ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                        ->WhereIn('pengajuan_biaya.kategori', ['19'])
                        ->where('pengajuan_biaya.kode_depo', Auth::user()->kode_depo)
                        ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                        ->get();

        return view ('pengajuan.pengajuan_biaya_bbm_sales_lanjutan.index', compact('pengajuan_bbm'));

    }

    public function view($no_urut)
    {
        $view_pengajuan_h = DB::table('pengajuan_biaya')
                        ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftJoin('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                        ->join('users as users_1','pengajuan_biaya.id_user_input','=','users_1.id')
                        //->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                        ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                        ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.no_surat_program','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan',
                        'perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.keterangan','pengajuan_biaya_detail.qty',
                        'pengajuan_biaya_detail.tharga','pengajuan_biaya.id_user_input','users_1.name','pengajuan_biaya.no_urut')
                        ->Where('pengajuan_biaya.no_urut', $no_urut)
                        ->WhereIn('pengajuan_biaya.kategori', ['19'])
                        ->first();

        
        $date = explode(' - ' ,$view_pengajuan_h->no_surat_program);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');
        

        $view_pengajuan_d = DB::table('pengajuan_biaya_bbm_sales')
                        ->join('ms_bahan_bakar','pengajuan_biaya_bbm_sales.kode_bbm','ms_bahan_bakar.kode_bbm')
                        ->select('pengajuan_biaya_bbm_sales.kode_pengajuan_bbm','pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm','pengajuan_biaya_bbm_sales.id_pengeluaran',
                        'pengajuan_biaya_bbm_sales.kode_perusahaan','pengajuan_biaya_bbm_sales.kode_depo','pengajuan_biaya_bbm_sales.no_faktur','pengajuan_biaya_bbm_sales.tgl_faktur','pengajuan_biaya_bbm_sales.nopol',
                        'pengajuan_biaya_bbm_sales.nama_sales','pengajuan_biaya_bbm_sales.divisi','pengajuan_biaya_bbm_sales.segmen','pengajuan_biaya_bbm_sales.km_akhir',
                        'pengajuan_biaya_bbm_sales.kode_bbm','ms_bahan_bakar.nama_bbm','pengajuan_biaya_bbm_sales.volume_perliter','pengajuan_biaya_bbm_sales.harga_perliter','pengajuan_biaya_bbm_sales.total')
                        ->WhereBetween('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm', [$date_start,$date_end])
                        ->get();

        $view_total_d = DB::table('pengajuan_biaya_bbm_sales')
                        ->join('ms_bahan_bakar','pengajuan_biaya_bbm_sales.kode_bbm','ms_bahan_bakar.kode_bbm')
                        ->select(
                            DB::raw('sum(pengajuan_biaya_bbm_sales.volume_perliter) as total_vol'),
                            DB::raw('sum(pengajuan_biaya_bbm_sales.total) as total_biaya'))
                        ->WhereBetween('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm', [$date_start,$date_end])

                        ->first();

        return view('pengajuan.pengajuan_biaya_bbm_sales_lanjutan.view', compact('view_pengajuan_h','view_pengajuan_d','view_total_d'));
    }

    public function cari(Request $request)
    {
        

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        // $pengajuan_bbm = DB::table('pengajuan_biaya_bbm_sales')
        //                     ->join('perusahaans','pengajuan_biaya_bbm_sales.kode_perusahaan','=','perusahaans.kode_perusahaan')
        //                     ->join('depos','pengajuan_biaya_bbm_sales.kode_depo','=','depos.kode_depo')
        //                     ->join('ms_bahan_bakar','pengajuan_biaya_bbm_sales.kode_bbm','=','ms_bahan_bakar.kode_bbm')
        //                     ->select('pengajuan_biaya_bbm_sales.kode_pengajuan_bbm','pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',
        //                     'pengajuan_biaya_bbm_sales.kode_perusahaan','perusahaans.nama_perusahaan',
        //                     'pengajuan_biaya_bbm_sales.kode_depo','depos.nama_depo',
        //                     'pengajuan_biaya_bbm_sales.no_faktur','pengajuan_biaya_bbm_sales.tgl_faktur','pengajuan_biaya_bbm_sales.nopol',
        //                     'pengajuan_biaya_bbm_sales.nama_sales','pengajuan_biaya_bbm_sales.divisi','pengajuan_biaya_bbm_sales.segmen',
        //                     'pengajuan_biaya_bbm_sales.km_akhir','pengajuan_biaya_bbm_sales.kode_bbm','ms_bahan_bakar.nama_bbm',
        //                     'pengajuan_biaya_bbm_sales.volume_perliter','pengajuan_biaya_bbm_sales.harga_perliter','pengajuan_biaya_bbm_sales.total',
        //                     'pengajuan_biaya_bbm_sales.status')
        //                     ->WhereBetween('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm', [$date_start,$date_end])
        //                     ->where('pengajuan_biaya_bbm_sales.status', 0)
        //                     ->where('pengajuan_biaya_bbm_sales.kode_perusahaan', request()->kode_perusahaan)
        //                     ->where('pengajuan_biaya_bbm_sales.kode_depo', request()->kode_depo)
        //                     ->orderBy('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm', 'DESC')
        //                     ->get();

        $pengajuan_bbm = DB::connection('mysql_fleet')
                            ->table('dt_tr_bbm')
                            ->join('dt_branch','dt_tr_bbm.code_branch','=','dt_branch.name_branch')
                            ->leftJoin('dt_file_upload','dt_tr_bbm.kode_bbm','=','dt_file_upload.kode')
                            ->select('dt_tr_bbm.kode_bbm',
                            'dt_tr_bbm.tanggal_bbm',
                            'dt_tr_bbm.perusahaan',
                            'dt_branch.code_branch AS kode_depo',
                            'dt_tr_bbm.code_branch AS nama_depo',
                            'dt_tr_bbm.no_vocer',
                            'dt_tr_bbm.tanggal_bbm AS tgl_voucer',
                            'dt_tr_bbm.no_polisi',
                            'dt_tr_bbm.salesman',
                            'dt_tr_bbm.segmen',
                            'dt_tr_bbm.jenis_bbm',
                            'dt_tr_bbm.kilometer',
                            'dt_tr_bbm.liter_qty',
                            'dt_tr_bbm.harga_perliter',
                            'dt_tr_bbm.biaya_bbm',
                            'dt_file_upload.filename',
                            'dt_tr_bbm.status')
                            ->WhereBetween('dt_tr_bbm.tanggal_bbm', [$date_start,$date_end])
                            ->where('dt_tr_bbm.status', 0)
                            ->where('dt_tr_bbm.perusahaan', request()->kode_perusahaan)
                            ->where('dt_branch.code_branch', request()->kode_depo)
                            ->orderBy('dt_tr_bbm.tanggal_bbm', 'DESC')
                            ->get();

        return view ('pengajuan.pengajuan_biaya_bbm_sales_lanjutan.create', compact('pengajuan_bbm')); 

    }

    public function create(Request $request)
    {
       

        $pengajuan_bbm = DB::table('pengajuan_biaya_bbm_sales')
                            ->join('perusahaans','pengajuan_biaya_bbm_sales.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya_bbm_sales.kode_depo','=','depos.kode_depo')
                            ->join('ms_bahan_bakar','pengajuan_biaya_bbm_sales.kode_bbm','=','ms_bahan_bakar.kode_bbm')
                            ->select('pengajuan_biaya_bbm_sales.kode_pengajuan_bbm','pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm',
                            'pengajuan_biaya_bbm_sales.kode_perusahaan','perusahaans.nama_perusahaan',
                            'pengajuan_biaya_bbm_sales.kode_depo','depos.nama_depo',
                            'pengajuan_biaya_bbm_sales.no_faktur','pengajuan_biaya_bbm_sales.tgl_faktur','pengajuan_biaya_bbm_sales.nopol',
                            'pengajuan_biaya_bbm_sales.nama_sales','pengajuan_biaya_bbm_sales.divisi','pengajuan_biaya_bbm_sales.segmen',
                            'pengajuan_biaya_bbm_sales.km_akhir','pengajuan_biaya_bbm_sales.kode_bbm','ms_bahan_bakar.nama_bbm',
                            'pengajuan_biaya_bbm_sales.volume_perliter','pengajuan_biaya_bbm_sales.harga_perliter','pengajuan_biaya_bbm_sales.total',
                            'pengajuan_biaya_bbm_sales.status')
                            ->where('pengajuan_biaya_bbm_sales.status', '-')
                            ->where('pengajuan_biaya_bbm_sales.kode_perusahaan', '')
                            ->where('pengajuan_biaya_bbm_sales.kode_depo', '')
                            ->orderBy('pengajuan_biaya_bbm_sales.tgl_pengajuan_bbm', 'DESC')
                            ->get();

        $total_pengajuan_bbm = DB::table('pengajuan_biaya_bbm_sales')
                            ->join('perusahaans','pengajuan_biaya_bbm_sales.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('depos','pengajuan_biaya_bbm_sales.kode_depo','=','depos.kode_depo')
                            ->join('ms_bahan_bakar','pengajuan_biaya_bbm_sales.kode_bbm','=','ms_bahan_bakar.kode_bbm')
                            ->select(
                                DB::raw('sum(pengajuan_biaya_bbm_sales.volume_perliter) as total_liter'),
                                DB::raw('sum(pengajuan_biaya_bbm_sales.total) as sub_total')
                            )
                            
                            ->where('pengajuan_biaya_bbm_sales.status', '-')
                            ->where('pengajuan_biaya_bbm_sales.kode_perusahaan', '')
                            ->where('pengajuan_biaya_bbm_sales.kode_depo', '')
                            ->first();

        return view ('pengajuan.pengajuan_biaya_bbm_sales_lanjutan.create', compact('pengajuan_bbm','total_pengajuan_bbm'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            
        ]);

        $tahun = date('Y', strtotime(Carbon::now()->format('Y-m-d')));
        $bulan = date('m', strtotime(Carbon::now()->format('Y-m-d')));

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

        //$kd_perusahaan = $request->get('kode_perusahaan');
        $kd_perusahaan = $request->get('kode_perusahaan');
        $kode_depo = $request->get('kode_depo');
        $kode_divisi = $request->get('kode_divisi');
        //$id_kat = $request->get('id_pengeluaran');

        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',$kode_depo)->first();

        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getRow = DB::table('pengajuan_biaya')
                    ->select(DB::raw('MAX(kode_pengajuan_b) as NoUrut'))
                    ->where('kode_perusahaan', $kd_perusahaan)
                    ->where('kode_depo', $kode_depo)
                    ->where('kode_divisi', $kode_divisi);
        $rowCount = $getRow->count();

        if($rowCount > 0){
            //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
            if ($rowCount < 9) {
                $no_pengajuan_biaya = 'REQ '.'B'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_pengajuan_biaya = 'REQ '.'B'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_pengajuan_biaya = 'REQ '.'B'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_pengajuan_biaya = 'REQ '.'B'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
            $no_pengajuan_biaya = 'REQ '.'B'.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        }

        $getRow = DB::table('pengajuan_biaya')->select(DB::raw('COUNT(kode_pengajuan_b) as NoUrut'))->first();
        if ($getRow->NoUrut > 0) {
            $no_urut = $getRow->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        //==Header==//
        Pengajuan_Biaya::create([
            'kode_pengajuan_b' => $no_pengajuan_biaya,
            'tgl_pengajuan_b' => Carbon::now()->format('Y-m-d'),
            'kategori' => $request->id_pengeluaran,
            'kode_perusahaan' => $request->kode_perusahaan,
            'kode_depo' => $request->kode_depo,
            'kode_divisi' => $request->kode_divisi,
            'kode_perusahaan_tujuan' => $request->kode_perusahaan_tujuan,
            'no_surat_program' => $request->tgl_pengisian,
            'status' => '0',
            'keterangan' => $request->keterangan,
            'id_user_input' => Auth::user()->id,
            'no_urut' => $no_urut
        ]);
        //==End Header==//
        
        //==detail==//
        Pengajuan_Biaya_detail::create([
            'kode_pengajuan_b' => $no_pengajuan_biaya,
            'no_description_detail' => 1,
            'description' => $request->keterangan,
            'spesifikasi' => 'Bio Solar/Pertalite/Pertamax/Dexlite',
            'qty' => $request->jml_liter,
            'harga' => 0,
            'jml_harga' => $request->jml_total,
            'potongan' => 0,
            'tharga' => $request->jml_total,
            'no_urut' => $no_urut
        ]);
        //==End Detail==//

        $kode_pengajan_bbm = $request->kode_pengajan_bbm;
        for ($i=0; $i < count((array)$kode_pengajan_bbm); $i++) {
            // $update = DB::table('pengajuan_biaya_bbm_sales')
            //         ->where('kode_pengajuan_bbm', $kode_pengajan_bbm[$i])
            //         ->update([
            //             'status' => 1,
            //             'kode_pengajuan_b' => $no_pengajuan_biaya,
            //         ]);

            $update = DB::connection('mysql_fleet')
                    ->table('dt_tr_bbm')
                    ->where('dt_tr_bbm.kode_bbm', $kode_pengajan_bbm[$i])
                    ->update([
                        'status' => 1,
                        'kode_pengajuan_b' => $no_pengajuan_biaya,
                    ]);
        }

        //upload file
        if($request->hasfile('filename')) { 
            foreach ($request->file('filename') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);
                       
                    Pengajuan_Upload::create([
                        'kode_pengajuan' => $no_pengajuan_biaya,
                        'description' => $request->keterangan,
                        'filename' => $filename
                    ]);
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }

        $output = [
            'msg'  => 'Transaksi baru berhasil ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);

        alert()->success('Success.','Pengajuan berhasil dibuat');
        return redirect()->route('pengajuan_b_bbm_sales_lnjtn.index');

    }
}
