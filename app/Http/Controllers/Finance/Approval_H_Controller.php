<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class Approval_H_Controller extends Controller
{
    public function index()
    {
        return view('finance.approval_h.index');
    }

    public function getDataIzinH(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));
        
        //===========================
        $data_pengajuan_cek_terima = DB::table('izin_pengajuan_cek_giro_h')
                        ->select(
                            'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.keterangan',
                            'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                            'ms_pembawa_resi.pembawa_resi',
                            'izin_h.id_penerima',
                            'pengambil.pembawa_resi as pengambil_buku',
                            'izin_pengajuan_cek_giro_h.id_user_input',
                            'izin_h.kode_terima_cek',
                            'izin_h.tgl_izin AS tgl_terima',
                            'users.name','izin_h.status_approval'
                        )
                        ->join('ms_pembawa_resi', 'izin_pengajuan_cek_giro_h.kode_pembawa_resi', '=', 'ms_pembawa_resi.id')
                        ->join('users', 'izin_pengajuan_cek_giro_h.id_user_input', '=', 'users.id')
                        ->join('izin_pengajuan_cek_giro_d', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
                        ->leftJoin('izin_h', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_h.kode_pengajuan_cek')
                        ->join('ms_pembawa_resi as pengambil','izin_h.id_penerima', '=', 'pengambil.id')
                        ->whereBetween('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', [$date_start,$date_end])
                        ->whereNotNull('izin_h.kode_terima_cek')
                        ->groupBy(
                            'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.keterangan',
                            'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                            'ms_pembawa_resi.pembawa_resi',
                            'izin_h.id_penerima',
                            'pengambil.pembawa_resi',
                            'izin_pengajuan_cek_giro_h.id_user_input',
                            'izin_h.kode_terima_cek',
                            'izin_h.tgl_izin',
                            'users.name','izin_h.status_approval'
                        );
        //===========================
        if (!isset($request->value)) {
            if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
                $data_pengajuan_cek_terima
                            ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
            }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--
                $data_pengajuan_cek_terima
                            ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
                            //->where('izin_h.status_approval', '1');

            }
        }else{
            if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
                // $data_pengajuan_cek_terima
                //         ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                //         ->orWhere('izin_h.kode_buku', 'like', "%$request->value%")
                //         ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                //         ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                //         ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                //         ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                //         ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
            }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--      
                // $data_pengajuan_cek_terima
                //         ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                //         ->where('izin_h.status_approval', '1')
                //         ->orWhere('izin_h.kode_buku', 'like', "%$request->value%")
                //         ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                //         ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                //         ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                //         ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                //         ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");

            }
        }

        $data  = $data_pengajuan_cek_terima->get();
        $count = ($data_pengajuan_cek_terima->count() == 0) ? 0 : $data->count();
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

        //===========================
        $data_pengajuan_cek_terima = DB::table('izin_pengajuan_cek_giro_h')
                        ->select(
                            'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.keterangan',
                            'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                            'ms_pembawa_resi.pembawa_resi',
                            'izin_h.id_penerima',
                            'pengambil.pembawa_resi as pengambil_buku',
                            'izin_pengajuan_cek_giro_h.id_user_input',
                            'izin_h.kode_terima_cek',
                            'izin_h.tgl_izin AS tgl_terima',
                            'users.name','izin_h.status_approval'
                        )
                        ->join('ms_pembawa_resi', 'izin_pengajuan_cek_giro_h.kode_pembawa_resi', '=', 'ms_pembawa_resi.id')
                        ->join('users', 'izin_pengajuan_cek_giro_h.id_user_input', '=', 'users.id')
                        ->join('izin_pengajuan_cek_giro_d', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
                        ->leftJoin('izin_h', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek', '=', 'izin_h.kode_pengajuan_cek')
                        ->join('ms_pembawa_resi as pengambil','izin_h.id_penerima', '=', 'pengambil.id')
                        ->whereBetween('izin_pengajuan_cek_giro_h.tgl_pengajuan_cek', [$date_start,$date_end])
                        ->whereNotNull('izin_h.kode_terima_cek')
                        ->groupBy(
                            'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.tgl_pengajuan_cek',
                            'izin_pengajuan_cek_giro_h.keterangan',
                            'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                            'ms_pembawa_resi.pembawa_resi',
                            'izin_h.id_penerima',
                            'pengambil.pembawa_resi',
                            'izin_pengajuan_cek_giro_h.id_user_input',
                            'izin_h.kode_terima_cek',
                            'izin_h.tgl_izin',
                            'users.name','izin_h.status_approval'
                        );
        //===========================

        if (!isset($request->value)) {
            if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
                $data_pengajuan_cek_terima
                    ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
            }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--   
                $data_pengajuan_cek_terima
                    ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
                    //->where('izin_h.status_approval', '1');
            }
        }else{
            if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
                // $data_pengajuan_cek_terima
                //     ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                //     ->orWhere('izin_h.kode_buku', 'like', "%$request->value%")
                //     ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                //     ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                //     ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                //     ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                //     ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
            }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--   
                // $data_pengajuan_cek_terima
                //     ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                //     ->where('izin_h.status_approval', '1')
                //     ->orWhere('izin_h.kode_buku', 'like', "%$request->value%")
                //     ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                //     ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                //     ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                //     ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                //     ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
            }
        }       
        
        $data  = $data_pengajuan_cek_terima->get();
        $count = ($data_pengajuan_cek_terima->count() == 0) ? 0 : $data->count();
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
        $dataDetail = DB::table('izin_h')
                ->join('izin_h_detail','izin_h.kode_buku','izin_h_detail.kode_buku')
                ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                ->select('izin_h.kode_buku','izin_h.tgl_izin','izin_h.no_izin','izin_h.no_urut',
                    'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan','izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                    'izin_h_detail.id_cek','izin_h_detail.no_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir',
                    'izin_h_detail.jenis_warkat','izin_h_detail.no_urut','izin_h.kode_terima_cek')
                ->where('izin_h.kode_terima_cek', $request->no_izin)
                // ->where('izin_h_detail.kode_seri_warkat',  $request->kode_seri_warkat)
                // ->where('izin_h_detail.seri_awal',  $request->seri_awal)
                // ->where('izin_h_detail.seri_akhir',  $request->seri_akhir)
                //->orderBy('izin_h_detail.id_cek', 'ASC')
                ->get();

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $dataDetail
        ];

        return response()->json($output, 200);
    }

    public function pdf(Request $request)
    {
        $header = DB::table('izin_h')
                    ->join('users','izin_h.id_user_input','=','users.id')
                    ->leftJoin('users as user_approval','izin_h.id_user_approval','=','user_approval.id')
                    ->leftJoin('users as user_approval_bod','izin_h.id_user_approval_bod','=','user_approval_bod.id')
                    ->select('izin_h.judul_izin','izin_h.no_izin','izin_h.tgl_izin','izin_h.no_urut','izin_h.id_user_input','users.name',
                            'izin_h.status_approval','izin_h.id_user_approval','user_approval.name as name_approval','izin_h.tgl_approval','izin_h.keterangan_approval','izin_h.kode_approval',
                            'izin_h.status_approval_bod','izin_h.id_user_approval_bod','user_approval_bod.name as name_approval_bod','izin_h.tgl_approval_bod','izin_h.keterangan_approval_bod','izin_h.kode_approval_bod')
                    ->where('izin_h.kode_buku', $request->no_izin)
                    ->first();

        $detail = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->join('users','izin_h.id_user_input','=','users.id')
                    ->select('izin_h.no_izin','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                        'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                        'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut')
                    ->groupBy('izin_h.no_izin','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                        'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                        'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut')
                    ->where('izin_h.kode_buku', $request->no_izin)
                    ->get();

        $total_jml = DB::table('izin_h_detail')
                        ->select(DB::raw('count(izin_h_detail.jml_lembar) as total'))
                        ->where('izin_h.kode_buku', $request->no_izin) 
                        ->first();           

        $pdf = PDF::loadview('finance.approval_h.pdf', compact('header','detail','total_jml'))->setPaper('a4', 'portrait'); //landscape,portrait
        return $pdf->stream();
    }

    public function approved(Request $request)
    {   
        $tahun = (date('Y'));
        $bulan = (date('m'));
        $tgl = (date('d'));

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

        if(Auth::user()->kode_divisi == '5'){ //-- Jika Finance--
            $kode_app = 'APP'.'/'.'TUA'.'/'.'FNC'.'/'.$tgl.'/'.$bulan_romawi.'/'.$tahun;

            $no_izin = $request->izin_no;
            $approved = DB::table('izin_h')->where('kode_terima_cek', $no_izin)
                    ->update([
                        'status_approval' => 1,
                        'id_user_approval' => Auth::user()->id,
                        'tgl_approval' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => 'Ok',
                        'kode_approval' => $kode_app,
                ]);
        }elseif(Auth::user()->kode_divisi == '14'){ //-- BOD--
            $kode_app = 'APP'.'/'.'TUA'.'/'.'BOD'.'/'.$tgl.'/'.$bulan_romawi.'/'.$tahun;

            $no_izin = $request->izin_no;
            $approved = DB::table('izin_h')->where('kode_terima_cek', $no_izin)
                    ->update([
                        'status_approval_bod' => 1,
                        'id_user_approval_bod' => Auth::user()->id,
                        'tgl_approval_bod' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval_bod' => 'Ok',
                        'kode_approval_bod' => $kode_app,
                ]);
        }

        $output = [
            'msg'  => 'Transaksi baru berhasil ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    }
}
