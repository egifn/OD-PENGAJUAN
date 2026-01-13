<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Perusahaan;
use App\Bank;
use App\KategoriBuku;
use App\Pendaftaran_Cekgiro;
use App\Izin_E;
use App\Izin_E_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TandaTerima_E_Controller extends Controller
{
    public function index()
    {    
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_pengiriman_cek = DB::table('izin_e')
            ->join('users', 'izin_e.id_user_input', '=', 'users.id')
            ->join('izin_e_detail', 'izin_e.kode_izin_e', '=', 'izin_e_detail.kode_izin_e')
            ->select(
                'izin_e.kode_izin_e',
                'izin_e.tgl_izin_e',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'izin_e.no_urut',
                'users.name',
                DB::raw("COUNT(izin_e_detail.id_cek) AS jml_lembar"),
                DB::raw('(
                    SELECT COUNT(izin_e_detail_1.no_cek) 
                    FROM izin_e_detail AS izin_e_detail_1
                    WHERE izin_e_detail_1.no_urut = izin_e.no_urut
                    and izin_e_detail_1.status = "0"
                    ) AS total_belum_terima'),
                'izin_e.no_urut'   
            )
            ->where('izin_e.status', 0)
            ->groupBy(
                'izin_e.kode_izin_e',
                'izin_e.tgl_izin_e',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'users.name',
                'izin_e.no_urut'
            )
            ->orderBy('izin_e.kode_izin_e', 'ASC')
            ->get();


        $data_terima_cek = DB::table('izin_e_terima')
            ->join('izin_e', 'izin_e_terima.kode_izin_e', '=', 'izin_e.kode_izin_e')
            ->join('izin_e_detail', 'izin_e.kode_izin_e', '=', 'izin_e_detail.kode_izin_e')
            ->join('users','izin_e.id_user_input', '=', 'users.id')
            ->select(
                'izin_e_terima.kode_terima',
                'izin_e_terima.tgl_terima',
                'izin_e.kode_izin_e AS kode_kirim',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                DB::raw("COUNT(izin_e_detail.id_cek) AS jml_lembar"),
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'users.name',
                'izin_e.no_urut'   
            )
            ->whereBetween('izin_e_terima.tgl_terima', [$date_start, $date_end])
            ->where('izin_e_detail.status', 9)
            ->groupBy(
                'izin_e_terima.kode_terima',
                'izin_e_terima.tgl_terima',
                'izin_e.kode_izin_e',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'users.name',
                'izin_e.no_urut'
            )
            ->get();

        return view ('finance.tanda_terima_cek_giro_e.index', compact('data_pengiriman_cek','data_terima_cek'));
    }

    public function cari(Request $request)
    {
        if (request()->tanggal != '') {
            $date = explode(' - ', request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        } else {
            $date_start = (date('Y-m-d'));
            $date_end = (date('Y-m-d'));
        }

        $data_pengiriman_cek = DB::table('izin_e')
            ->join('users', 'izin_e.id_user_input', '=', 'users.id')
            ->join('izin_e_detail', 'izin_e.kode_izin_e', '=', 'izin_e_detail.kode_izin_e')
            ->select(
                'izin_e.kode_izin_e',
                'izin_e.tgl_izin_e',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'users.name',
                DB::raw("COUNT(izin_e_detail.id_cek) AS jml_lembar"),
                'izin_e.no_urut'   
            )
            ->where('izin_e.status', 0)
            ->groupBy(
                'izin_e.kode_izin_e',
                'izin_e.tgl_izin_e',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'users.name',
                'izin_e.no_urut'
            )
            ->orderBy('izin_e.kode_izin_e', 'ASC')
            ->get();

        
            $data_terima_cek = DB::table('izin_e_terima')
            ->join('izin_e', 'izin_e_terima.kode_izin_e', '=', 'izin_e.kode_izin_e')
            ->join('izin_e_detail', 'izin_e.kode_izin_e', '=', 'izin_e_detail.kode_izin_e')
            ->join('users','izin_e.id_user_input', '=', 'users.id')
            ->select(
                'izin_e_terima.kode_terima',
                'izin_e_terima.tgl_terima',
                'izin_e.kode_izin_e AS kode_kirim',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                DB::raw("COUNT(izin_e_detail.id_cek) AS jml_lembar"),
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'users.name',
                'izin_e.no_urut'   
            )
            ->where('izin_e_detail.status', 9)
            ->whereBetween('izin_e_terima.tgl_terima', [$date_start, $date_end])
            ->groupBy(
                'izin_e_terima.kode_terima',
                'izin_e_terima.tgl_terima',
                'izin_e.kode_izin_e',
                'izin_e.tgl_kirim',
                'izin_e.no_izin_e',
                'izin_e.judul_izin_e',
                'izin_e.yang_ttd',
                'izin_e.id_user_input',
                'users.name',
                'izin_e.no_urut'
            )
            ->get();

        return view ('finance.tanda_terima_cek_giro_e.index', compact('data_pengiriman_cek','data_terima_cek'));
    }

    public function create(Request $request)
    {
        return view('finance.tanda_terima_cek_giro_e.create');
    }

    public function action_seri_awal(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.no_cek')
                    ->Where('izin_h_detail.status', 1)
                    ->Where('izin_h_detail.id_cek','like','%'.$query.'%')
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }else{
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.no_cek')
                    ->Where('izin_h_detail.status', 1)
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_seri_awal" data-kode_buku="'.$row->kode_buku.'" data-no_izin="'.$row->no_izin.'" data-kode_perusahaan="'.$row->kode_perusahaan.'" data-nama_perusahaan="'.$row->nama_perusahaan.'" data-kode_bank="'.$row->kode_bank.'" data-nama_bank="'.$row->nama_bank.'" data-no_rek="'.$row->no_rekening.'" data-id_cek="'.$row->id_cek.'" data-kode_seri="'.$row->kode_seri_warkat.'" data-no_cek="'.$row->no_cek.'">
                            <td>'.$row->kode_buku.'</td>
                            <td>'.$row->no_izin.'</td>
                            <td>'.$row->judul_izin.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->id_cek.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->no_rekening.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="7">No Data Found</td>
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

    public function action_seri_akhir(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek')
                    ->Where('izin_h_detail.status', 1)
                    ->Where('izin_h_detail.id_cek','like','%'.$query.'%')
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }else{
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.no_cek')
                    ->Where('izin_h_detail.status', 1)
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_seri_akhir" data-kode_buku="'.$row->kode_buku.'" data-no_izin="'.$row->no_izin.'" data-no_rek="'.$row->no_rekening.'" data-id_cek="'.$row->id_cek.'">
                            <td>'.$row->kode_buku.'</td>
                            <td>'.$row->no_izin.'</td>
                            <td>'.$row->judul_izin.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->id_cek.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->no_rekening.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="7">No Data Found</td>
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
        $getRow = DB::table('izin_e')
            ->select(DB::raw('MAX(kode_izin_e) as NoUrut'));
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
        
        $kode_daftar = 'E '.$kode.''.'/'.''.$bulan_romawi.''.'/'.''.$tahun;

        $getRow_urut = DB::table('izin_e')->select(DB::raw('COUNT(kode_izin_e) as NoUrut'))->first();
        if ($getRow_urut->NoUrut > 0) {
            $no_urut = $getRow_urut->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        Izin_E::create([
            'kode_izin_e' => $kode_daftar,
            'tgl_izin_e' => Carbon::now()->format('Y-m-d'),
            'tgl_kirim' => Carbon::now()->format('Y-m-d'),
            'no_izin_e' => $request->get('no_izin'),
            'judul_izin_e' => $request->get('judul_izin'),
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
                
                $data = new Izin_E_Detail();
                $data->kode_izin_e = $kode_daftar;
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

        alert()->success('Berhasil.','Izin E Berhasil dibuat');
        return redirect()->route('tanda_terima_e.index');
    }

    public function view($no_urut)
    {
        $header = DB::table('izin_e')
            ->where('izin_e.no_urut', $no_urut)
            ->first();

        $details = DB::table('izin_e_detail')
            ->select('izin_e_detail.kode_izin_e',
            'izin_e_detail.id_cek',
            'izin_e_detail.kode_seri_warkat',
            'izin_e_detail.no_cek',
            'izin_e_detail.seri_awal',
            'izin_e_detail.seri_akhir',
            // DB::raw('(
            //     SELECT COUNT(izin_e_detail_1.no_cek) 
            //     FROM izin_e_detail AS izin_e_detail_1
            //     WHERE izin_e_detail_1.no_urut = "1" 
            //     AND izin_e_detail_1.kode_seri_warkat = izin_e_detail.kode_seri_warkat
            //     AND izin_e_detail_1.seri_awal = izin_e_detail.seri_awal
            //     AND izin_e_detail_1.seri_akhir = izin_e_detail.seri_akhir
            //     AND izin_e_detail_1.kode_perusahaan = izin_e_detail.kode_perusahaan) AS total_cek'),
            'izin_e_detail.kode_perusahaan',
            'perusahaans.nama_perusahaan',
            'izin_e_detail.kode_bank',
            'banks.nama_bank',
            'izin_e_detail.no_rekening',
            'izin_e_detail.no_urut')
            ->join('perusahaans', 'izin_e_detail.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('banks', 'izin_e_detail.kode_bank', '=', 'banks.kode_bank')
            ->where('izin_e_detail.no_urut', $no_urut)
            ->where('izin_e_detail.status', '0')
            // ->groupBy(
            //     'izin_e_detail.kode_izin_e',
            //     'izin_e_detail.id_cek',
            //     'izin_e_detail.kode_seri_warkat',
            //     'izin_e_detail.seri_awal',
            //     'izin_e_detail.seri_akhir',
            //     'izin_e_detail.kode_perusahaan',
            //     'perusahaans.nama_perusahaan',
            //     'izin_e_detail.kode_bank',
            //     'banks.nama_bank',
            //     'izin_e_detail.no_rekening',
            //     'izin_e_detail.no_urut')
            ->get();

        return view('finance.tanda_terima_cek_giro_e.view', compact('header','details'));
    }

    public function store_terima(Request $request)
    {
        $currentYear = now()->year;
        $getRow = DB::table('izin_e_terima')
            ->select(DB::raw('SUBSTRING(kode_terima, -3) AS NoUrut'))
            ->whereYear('tgl_terima', $currentYear)
            //->orderBy('NoUrut', 'desc')
            ->first();

        $currentDate = date('dmy');

        if ($getRow) {
            $lastNoUrut = intval($getRow->NoUrut);
            $nextNoUrut = $lastNoUrut + 1;
        } else {
            // Jika belum ada data untuk tahun ini, mulai dari 1
            $nextNoUrut = 1;
        }

        $kode_terima = 'E' . $currentDate . str_pad($nextNoUrut, 3, '0', STR_PAD_LEFT);
        
        if ($request->has('chk')) {
            foreach ($request->input('chk') as $checkedIndex) {
                $data_update = DB::table('izin_e_detail')
                        ->where('izin_e_detail.no_cek', $checkedIndex)
                        ->where('izin_e_detail.no_urut', $request->no_urut)
                        ->update([
                            'izin_e_detail.status' => '9' // 9=diterima
                        ]);

                $sisa = DB::table('izin_e')
                        ->join('izin_e_detail', 'izin_e.kode_izin_e', '=', 'izin_e_detail.kode_izin_e')
                        ->select(
                            'izin_e.no_urut',
                            DB::raw('(
                                SELECT COUNT(izin_e_detail_1.no_cek) 
                                FROM izin_e_detail AS izin_e_detail_1
                                WHERE izin_e_detail_1.no_urut = izin_e.no_urut
                                and izin_e_detail_1.status = "0"
                                ) AS total_belum_terima')
                        )
                        ->where('izin_e.No_urut', $request->no_urut)
                        ->where('izin_e.status', 0)
                        ->groupBy(
                            'izin_e.no_urut'
                        )
                        ->orderBy('izin_e.kode_izin_e', 'ASC')
                        ->first();     
                    
                if($sisa->total_belum_terima == 0){
                    $header_update = DB::table('izin_e')
                        ->where('izin_e.no_urut', $request->no_urut)
                        ->update([
                            'izin_e.status' => '1',
                            'izin_e.kode_terima' => $kode_terima,
                            'izin_e.tgl_terima' => Carbon::now()->format('Y-m-d'),
                            'izin_e.id_user_penerima' => $request->kode_penerima_resi
                        ]);
                }   
            }

            DB::table('izin_e_terima')->insert([
                'kode_terima' => $kode_terima,
                'tgl_terima' => Carbon::now()->format('Y-m-d'),
                'kode_izin_e' => $request->kode_izin_e,
                'id_user_penerima' => $request->kode_penerima_resi,
                'id_user_input' => Auth::user()->id
            ]);
        }
                        
        alert()->success('Success.', 'Penerimaan Cek/Giro Berhasil disimpan');
        return redirect()->route('tanda_terima_e.index');
    }

    public function pdf($no_urut)
    {
        $header = DB::table('izin_e')
                    ->join('users','izin_e.id_user_input','=','users.id')
                    ->leftJoin('users as user_approval','izin_e.id_user_approval','=','user_approval.id')
                    ->select('izin_e.kode_izin_e','izin_e.tgl_izin_e','izin_e.no_izin_e','izin_e.judul_izin_e','izin_e.catatan','izin_e.id_user_input','users.name',
                                'izin_e.id_user_approval','user_approval.name AS approval','izin_e.tgl_approval')
                    ->where('izin_e.no_urut', $no_urut)
                    ->first();

        $detail = DB::table('izin_e_detail')
            ->join('perusahaans', 'izin_e_detail.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('banks', 'izin_e_detail.kode_bank', '=', 'banks.kode_bank')
            ->select(
                'izin_e_detail.kode_izin_e',
                'izin_e_detail.id_cek',
                'izin_e_detail.kode_seri_warkat',
                'izin_e_detail.seri_awal',
                'izin_e_detail.seri_akhir',
                'izin_e_detail.no_urut',
                DB::raw('(
                    SELECT COUNT(izin_e_detail_1.no_cek)
                    FROM izin_e_detail AS izin_e_detail_1
                    WHERE izin_e_detail_1.no_urut = izin_e_detail.no_urut 
                    AND izin_e_detail_1.kode_seri_warkat = izin_e_detail.kode_seri_warkat
                    AND izin_e_detail_1.seri_awal = izin_e_detail.seri_awal
                    AND izin_e_detail_1.seri_akhir = izin_e_detail.seri_akhir
                    AND izin_e_detail_1.kode_perusahaan = izin_e_detail.kode_perusahaan
                ) AS total_cek'),
                'izin_e_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_e_detail.kode_bank',
                'banks.nama_bank',
                'izin_e_detail.no_rekening',
                'izin_e_detail.no_urut'
            )
            ->where('izin_e_detail.no_urut', $no_urut)
            ->groupBy(
                'izin_e_detail.kode_izin_e',
                'izin_e_detail.id_cek',
                'izin_e_detail.kode_seri_warkat',
                'izin_e_detail.seri_awal',
                'izin_e_detail.seri_akhir',
                'izin_e_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_e_detail.kode_bank',
                'banks.nama_bank',
                'izin_e_detail.no_rekening',
                'izin_e_detail.no_urut'
            )
            ->get();

        $total_jml = DB::table('izin_e_detail')
                        ->select(DB::raw('count(izin_e_detail.kode_izin_e) as total'))
                        ->where('izin_e_detail.no_urut', $no_urut) 
                        ->first();  

        $pdf = PDF::loadview('finance.tanda_terima_cek_giro_e.pdf', compact('header', 'detail', 'total_jml'))->setPaper('a4', 'portrait'); //landscape,portrait
        return $pdf->stream();
    }
}

