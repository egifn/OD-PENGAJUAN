<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Izin_G;
use App\Izin_G_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TandaTerima_G_Controller extends Controller
{
        public function index()
        {
            $date_start = (date('Y-m-d'));
            $date_end = (date('Y-m-d'));

            $data_pengiriman_cek = DB::table('izin_g')
                ->join('users', 'izin_g.id_user_input', '=', 'users.id')
                ->join('izin_g_detail', 'izin_g.kode_izin_g', '=', 'izin_g_detail.kode_izin_g')
                ->select(
                    'izin_g.kode_izin_g',
                    'izin_g.tgl_izin_g',
                    'izin_g.tgl_kirim',
                    'izin_g.no_izin_g',
                    'izin_g.judul_izin_g',
                    'izin_g.yang_ttd',
                    'izin_g.id_user_input',
                    'users.name',
                    DB::raw("COUNT(izin_g_detail.id_cek) AS jml_lembar"),
                    'izin_g.no_urut'   
                )
                ->where('izin_g.status', 0)
                ->groupBy(
                    'izin_g.kode_izin_g',
                    'izin_g.tgl_izin_g',
                    'izin_g.tgl_kirim',
                    'izin_g.no_izin_g',
                    'izin_g.judul_izin_g',
                    'izin_g.yang_ttd',
                    'izin_g.id_user_input',
                    'users.name',
                    'izin_g.no_urut'
                )
                ->orderBy('izin_g.kode_izin_g', 'ASC')
                ->get();


            $data_terima_cek = DB::table('izin_g')
                ->join('users', 'izin_g.id_user_input', '=', 'users.id')
                ->join('izin_g_detail', 'izin_g.kode_izin_g', '=', 'izin_g_detail.kode_izin_g')
                ->select(
                    'izin_g.kode_izin_g',
                    'izin_g.tgl_izin_g',
                    'izin_g.tgl_kirim',
                    'izin_g.no_izin_g',
                    'izin_g.judul_izin_g',
                    'izin_g.yang_ttd',
                    'izin_g.id_user_input',
                    'users.name',
                    DB::raw("COUNT(izin_g_detail.id_cek) AS jml_lembar"),
                    'izin_g.no_urut'   
                )
                ->where('izin_g.status', 1)
                ->groupBy(
                    'izin_g.kode_izin_g',
                    'izin_g.tgl_izin_g',
                    'izin_g.tgl_kirim',
                    'izin_g.no_izin_g',
                    'izin_g.judul_izin_g',
                    'izin_g.yang_ttd',
                    'izin_g.id_user_input',
                    'users.name',
                    'izin_g.no_urut'
                )
                ->orderBy('izin_g.kode_izin_g', 'ASC')
                ->get();

            return view ('finance.tanda_terima_cek_giro_g.index', compact('data_pengiriman_cek','data_terima_cek'));
        }
    
        public function getDataIzinB(Request $request)
        {
            date_default_timezone_set('Asia/Jakarta');
            $date_start = (date('Y-m-d'));
            $date_end = (date('Y-m-d'));
            
            $data_izin_b = DB::table('izin_b')
                            ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                            ->join('perusahaans','izin_b_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                            ->join('users','izin_b.id_user_input','=','users.id')
                            ->select('izin_b.no_izin_b','izin_b.tgl_izin_b','izin_b.judul_izin_b','izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                'izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir','izin_b_detail.kode_bank',
                                'banks.nama_bank','izin_b_detail.no_rekening','izin_b.id_user_input','users.name','izin_b.no_urut')
                            ->groupBy('izin_b.no_izin_b','izin_b.tgl_izin_b','izin_b.judul_izin_b','izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir','izin_b_detail.kode_bank',
                            'banks.nama_bank','izin_b_detail.no_rekening','izin_b.id_user_input','users.name','izin_b.no_urut');
            if (!isset($request->value)) {
                $data_izin_b
                            ->WhereBetween('izin_b.tgl_izin_b',[$date_start,$date_end]);
            }else{
                $data_izin_b
                            ->WhereBetween('izin_b.tgl_izin_b',[$date_start,$date_end])
                            ->orWhere('izin_b.no_izin_b', 'like', "%$request->value%")
                            ->orWhere('izin_b.judul_izin_b', 'like', "%$request->value%")
                            ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                            ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                            ->orWhere('izin_b_detail.kode_seri_warkat', 'like', "%$request->value%")
                            ->orWhere('izin_b_detail.no_rekening', 'like', "%$request->value%");
            }
    
            $data  = $data_izin_b->get();
            $count = ($data_izin_b->count() == 0) ? 0 : $data->count();
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
    
            $data_izin_b = DB::table('izin_b')
                            ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                            ->join('perusahaans','izin_b_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                            ->join('users','izin_b.id_user_input','=','users.id')
                            ->select('izin_b.no_izin_b','izin_b.tgl_izin_b','izin_b.judul_izin_b','izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                                'izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir','izin_b_detail.kode_bank',
                                'banks.nama_bank','izin_b_detail.no_rekening','izin_b.id_user_input','users.name','izin_b.no_urut')
                            ->groupBy('izin_b.no_izin_b','izin_b.tgl_izin_b','izin_b.judul_izin_b','izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir','izin_b_detail.kode_bank',
                            'banks.nama_bank','izin_b_detail.no_rekening','izin_b.id_user_input','users.name','izin_b.no_urut');
            if (!isset($request->value)) {
                $data_izin_b
                    ->WhereBetween('izin_b.tgl_izin_b',[$date_start,$date_end]);
            }else{
                $data_izin_b
                            ->WhereBetween('izin_b.tgl_izin_b',[$date_start,$date_end])
                            ->orWhere('izin_b.no_izin_b', 'like', "%$request->value%")
                            ->orWhere('izin_b.judul_izin_b', 'like', "%$request->value%")
                            ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                            ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                            ->orWhere('izin_b_detail.kode_seri_warkat', 'like', "%$request->value%")
                            ->orWhere('izin_b_detail.no_rekening', 'like', "%$request->value%");
            }       
            
            $data  = $data_izin_b->get();
            $count = ($data_izin_b->count() == 0) ? 0 : $data->count();
            $output = [
                'status'  => true,
                'message' => 'success',
                'count'   => $count,
                'data'    => $data
            ];
    
            return response()->json($output, 200);
        }
    
        public function getViewDetail(Request $request)
        {
            $dataDetail = DB::table('izin_b')
                    ->join('izin_b_detail','izin_b.kode_izin_b','izin_b_detail.kode_izin_b')
                    ->join('perusahaans','izin_b_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                    ->join('vendors','izin_b_detail.kode_vendor','=','vendors.kode_vendor')
                    ->join('banks as bank_vendor','izin_b_detail.kode_bank_vendor','=','bank_vendor.kode_bank')
                    ->select('izin_b.kode_izin_b','izin_b.tgl_izin_b','izin_b.no_izin_b','izin_b.no_urut',
                        'izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan','izin_b_detail.kode_bank','banks.nama_bank','izin_b_detail.no_rekening',
                        'izin_b_detail.id_cek','izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir',
                        'izin_b_detail.kode_vendor','vendors.nama_vendor','izin_b_detail.atas_nama','izin_b_detail.kode_bank_vendor','bank_vendor.nama_bank as nama_bank_vendor','izin_b_detail.no_rekening_vendor',
                        'izin_b_detail.no_urut')
                    ->where('izin_b.no_urut', $request->no_urut)
                    // ->where('izin_h_detail.kode_seri_warkat',  $request->kode_seri_warkat)
                    // ->where('izin_h_detail.seri_awal',  $request->seri_awal)
                    // ->where('izin_h_detail.seri_akhir',  $request->seri_akhir)
                    ->orderBy('izin_b_detail.id_cek', 'ASC')
                    ->get();
    
            $output = [
                'status'  => true,
                'message' => 'success',
                'data'    => $dataDetail
            ];
    
            return response()->json($output, 200);
        }
    
        public function pdf($no_urut)
        {
            $header = DB::table('izin_g')
                        ->join('users','izin_g.id_user_input','=','users.id')
                        ->leftJoin('users as user_approval','izin_g.id_user_approval','=','user_approval.id')
                        ->select('izin_g.kode_izin_g','izin_g.tgl_izin_g','izin_g.no_izin_g','izin_g.judul_izin_g','izin_g.catatan','izin_g.id_user_input','users.name',
                                    'izin_g.id_user_approval','user_approval.name AS approval','izin_g.tgl_approval')
                        ->where('izin_g.no_urut', $no_urut)
                        ->first();

            $detail = DB::table('izin_g_detail')
                ->join('perusahaans', 'izin_g_detail.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
                ->join('banks', 'izin_g_detail.kode_bank', '=', 'banks.kode_bank')
                ->select(
                    'izin_g_detail.kode_izin_g',
                    'izin_g_detail.keterangan',
                    'izin_g_detail.id_cek',
                    'izin_g_detail.kode_seri_warkat',
                    'izin_g_detail.seri_awal',
                    'izin_g_detail.seri_akhir',
                    DB::raw('(
                        SELECT COUNT(izin_g_detail_1.no_cek)
                        FROM izin_g_detail AS izin_g_detail_1
                        WHERE izin_g_detail_1.no_urut = "1" 
                        AND izin_g_detail_1.kode_seri_warkat = izin_g_detail.kode_seri_warkat
                        AND izin_g_detail_1.seri_awal = izin_g_detail.seri_awal
                        AND izin_g_detail_1.seri_akhir = izin_g_detail.seri_akhir
                        AND izin_g_detail_1.kode_perusahaan = izin_g_detail.kode_perusahaan
                    ) AS total_cek'),
                    'izin_g_detail.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'izin_g_detail.kode_bank',
                    'banks.nama_bank',
                    'izin_g_detail.no_rekening',
                    'izin_g_detail.no_urut'
                )
                ->where('izin_g_detail.no_urut', $no_urut)
                ->groupBy(
                    'izin_g_detail.kode_izin_g',
                    'izin_g_detail.keterangan',
                    'izin_g_detail.id_cek',
                    'izin_g_detail.kode_seri_warkat',
                    'izin_g_detail.seri_awal',
                    'izin_g_detail.seri_akhir',
                    'izin_g_detail.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'izin_g_detail.kode_bank',
                    'banks.nama_bank',
                    'izin_g_detail.no_rekening',
                    'izin_g_detail.no_urut'
                )
                ->get();

            $total_jml = DB::table('izin_g_detail')
                            ->select(DB::raw('count(izin_g_detail.kode_izin_g) as total'))
                            ->where('izin_g_detail.no_urut', $no_urut) 
                            ->first();  

            $pdf = PDF::loadview('finance.tanda_terima_cek_giro_g.pdf', compact('header', 'detail', 'total_jml'))->setPaper('a4', 'portrait'); //landscape,portrait
            return $pdf->stream();
        }
    
        public function create(Request $request)
        { 
            $seri_warkat = DB::table('izin_h')
                            ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                            ->select('izin_h.kode_buku','izin_h.no_izin','izin_h_detail.kode_seri_warkat')
                            ->where('izin_h.status_approval_bod', 1)
                            ->groupBy('izin_h.kode_buku','izin_h.no_izin','izin_h_detail.kode_seri_warkat')
                            ->get();
    
            $perusahaan = DB::table('perusahaans')
                            ->select('perusahaans.kode_perusahaan','perusahaans.nama_perusahaan')
                            ->orderBy('kode_perusahaan', 'ASC')
                            ->get();
    
                return view('finance.tanda_terima_cek_giro_g.create', compact('seri_warkat','perusahaan'));
        }

        public function store(Request $request)
        {
            $getRow = DB::table('izin_g')
                ->select(DB::raw('MAX(kode_izin_g) as NoUrut'));
            $rowCount = $getRow->count();

            $kode = "0001";

            if ($rowCount > 0) {
                if ($rowCount < 9) {
                    $kode = "000".''.($rowCount + 1);
                } else if ($rowCount < 99) {
                    $kode = "00".''.($rowCount + 1);
                } else if ($rowCount < 999) {
                    $kode = "0".''.($rowCount + 1);
                } else {
                    $kode = ''.($rowCount + 1);
                }
            }
            
            $tahun = date('Y', strtotime(now()));
            $bulan = date('m', strtotime(now()));

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
            
            $kode_daftar = 'G '.$kode.''.'/'.''.$bulan_romawi.''.'/'.''.$tahun;

            $getRow_urut = DB::table('izin_g')->select(DB::raw('COUNT(kode_izin_g) as NoUrut'))->first();
            if ($getRow_urut->NoUrut > 0) {
                $no_urut = $getRow_urut->NoUrut + 1;
            }else{
                $no_urut = 1;
            }

            Izin_G::create([
                'kode_izin_g' => $kode_daftar,
                'tgl_izin_g' => Carbon::now()->format('Y-m-d'),
                'tgl_kirim' => Carbon::now()->format('Y-m-d'),
                'no_izin_g' => $request->get('no_izin'),
                'judul_izin_g' => $request->get('judul_izin'),
                'catatan' =>  $request->get('catatan'),
                'yang_ttd' => $request->get('penandatangan'),
                'no_urut' => $no_urut,
                'id_user_input' => Auth::user()->id
            ]);

            $datas=[];
            foreach ($request->input('seri_awal') as $key => $value) {
                
            }

            $validator = Validator::make($request->all(), $datas);
            foreach ($request->input('seri_awal') as $key => $value) {
                $jml_lembar = 0;
                $jml = 0;
                for($i = $request->get("seri_awal")[$key]; $i <= $request->get("seri_akhir")[$key]; $i++){
                    $seri_awal = $request->get("no_cek")[$key];
                
                    $hasil_jumlah = intval($seri_awal) + $jml;
                    $tambah_otomatis = $request->get("kode_warkat")[$key] . ' ' . sprintf('%0' . strlen($seri_awal) . 'd', $hasil_jumlah);
                    
                    $data = new Izin_G_Detail();
                    $data->kode_izin_g = $kode_daftar;
                    $data->keterangan = $request->get("keterangan")[$key]; 
                    $data->id_cek = $request->get("kode_seri")[$key];
                    $data->kode_seri_warkat = $request->get("kode_warkat")[$key];
                    $data->no_cek = $tambah_otomatis;
                    $data->seri_awal = $request->get("seri_awal")[$key]; 
                    $data->seri_akhir = $request->get("seri_akhir")[$key];
                    $data->kode_perusahaan = $request->get("kode_perusahaan")[$key];
                    $data->kode_bank = $request->get("kode_bank")[$key];
                    $data->no_rekening = $request->get("no_rek")[$key];
                    $data->no_urut = $no_urut;
                    $data->status = 0;
                    $data->save();

                    $update_cek = DB::table('izin_h_detail')
                                ->select('izin_h_detail.id_cek')
                                ->Where('izin_h_detail.kode_buku', $request->get("kode_seri")[$key])
                                ->Where('izin_h_detail.id_cek', $tambah_otomatis)
                                ->update([
                                    'status' => 2,
                                ]);

                    $jml++;
                }
            }

            alert()->success('Success.','Izin G Berhasil dibuat');
            return redirect()->route('tanda_terima_g.index');
        }

        public function view($no_urut)
        {
            $header = DB::table('izin_g')
                ->where('izin_g.no_urut', $no_urut)
                ->first();

            $details = DB::table('izin_g_detail')
                ->select('izin_g_detail.kode_izin_g',
                'izin_g_detail.id_cek',
                'izin_g_detail.kode_seri_warkat',
                'izin_g_detail.no_cek',
                'izin_g_detail.seri_awal',
                'izin_g_detail.seri_akhir',
                'izin_g_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_g_detail.kode_bank',
                'banks.nama_bank',
                'izin_g_detail.no_rekening',
                'izin_g_detail.no_urut')
                ->join('perusahaans', 'izin_g_detail.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
                ->join('banks', 'izin_g_detail.kode_bank', '=', 'banks.kode_bank')
                ->where('izin_g_detail.no_urut', $no_urut)
                ->where('izin_g_detail.status', '0')
                ->get();

            return view('finance.tanda_terima_cek_giro_g.view', compact('header','details'));
        }

        public function store_terima(Request $request)
        {
            $currentYear = now()->year;
            $getRow = DB::table('izin_g_terima')
                ->select(DB::raw('SUBSTRING(kode_terima, -3) AS NoUrut'))
                ->whereYear('tgl_terima', $currentYear)
                ->first();

            $currentDate = date('dmy');

            if ($getRow) {
                $lastNoUrut = intval($getRow->NoUrut);
                $nextNoUrut = $lastNoUrut + 1;
            } else {
                // Jika belum ada data untuk tahun ini, mulai dari 1
                $nextNoUrut = 1;
            }

            $kode_terima = 'G' . $currentDate . str_pad($nextNoUrut, 3, '0', STR_PAD_LEFT);
        
            if ($request->has('chk')) {
                foreach ($request->input('chk') as $checkedIndex) {
                    $data_update = DB::table('izin_g_detail')
                        ->where('izin_g_detail.no_cek', $checkedIndex)
                        ->where('izin_g_detail.no_urut', $request->no_urut)
                        ->update([
                            'izin_g_detail.status' => '9' // 9=diterima
                        ]);

                    $sisa = DB::table('izin_g')
                        ->join('izin_g_detail', 'izin_g.kode_izin_g', '=', 'izin_g_detail.kode_izin_g')
                        ->select(
                            'izin_g.no_urut',
                            DB::raw('(
                                SELECT COUNT(izin_g_detail_1.no_cek) 
                                FROM izin_g_detail AS izin_g_detail_1
                                WHERE izin_g_detail_1.no_urut = izin_g.no_urut
                                and izin_g_detail_1.status = "0"
                                ) AS total_belum_terima')
                        )
                        ->where('izin_g.No_urut', $request->no_urut)
                        ->where('izin_g.status', 0)
                        ->groupBy(
                            'izin_g.no_urut'
                        )
                        ->orderBy('izin_g.kode_izin_g', 'ASC')
                        ->first();

                    if($sisa->total_belum_terima == 0){
                        $header_update = DB::table('izin_g')
                            ->where('izin_g.no_urut', $request->no_urut)
                            ->update([
                                'izin_g.status' => '1',
                                'izin_g.kode_terima' => $kode_terima,
                                'izin_g.tgl_terima' => Carbon::now()->format('Y-m-d'),
                                'izin_g.id_user_penerima' => $request->kode_penerima_resi
                            ]);
                    }
                }

                DB::table('izin_g_terima')->insert([
                    'kode_terima' => $kode_terima,
                    'tgl_terima' => Carbon::now()->format('Y-m-d'),
                    'kode_izin_g' => $request->kode_izin_g,
                    'id_user_penerima' => $request->kode_penerima_resi,
                    'id_user_input' => Auth::user()->id
                ]);

            }
               
            alert()->success('Success.', 'Penerimaan Cek/Giro Berhasil disimpan');
            return redirect()->route('tanda_terima_g.index');
        }
    
        public function approved(Request $request)
        {
            $approved = DB::table('tanda_terima_cek')
                            ->select('tanda_terima_cek.receipt_id')
                            ->Where('tanda_terima_cek.receipt_id', $request->get("receipt_id"))
                            ->update([
                                'status' => 4, //status kirim
                                'date_send' => Carbon::now()->format('Y-m-d'),
                            ]);
    
            $datas = [];
            foreach ($request->input('no_spp') as $key => $value) {
                   
            }
            $validator = Validator::make($request->all(), $datas);
               
            foreach ($request->input("no_spp") as $key => $value) {
                    $isi_cek = DB::table('kontrabon')
                                ->select('kontrabon.id_cek')
                                ->Where('kontrabon.no_kontrabon', $request->get("no_kontrabon")[$key])
                                ->update([
                                    'status' => 2,
                                ]);
            }
               
            alert()->success('Success.','Request Approved...');
            return redirect()->route('tanda_terima_g.index');
        }
}
