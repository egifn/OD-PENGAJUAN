<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChequeController extends Controller
{
    public function index()
    {
        return view ('bod.master_bod.cheque.index');
    }

    public function getDataCheque(Request $request)
    {
        $data_rekening = DB::table('izin_h')
            ->select(
                'izin_h.kode_pengajuan_cek',
                'izin_h.kode_terima_cek',
                'izin_h.kode_buku',
                'izin_h_detail.id_cek',
                'izin_h_detail.no_rekening',
                'izin_h_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_h_detail.kode_bank',
                'banks.nama_bank',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_h.id_penerima',
                'pengambil.pembawa_resi AS pengambil',
                'izin_b.catatan_b AS tujuan',
                DB::raw('SUM(izin_a_detail.nominal_cek) AS total_cek')
            )
            ->join('izin_h_detail', 'izin_h.kode_buku', '=', 'izin_h_detail.kode_buku')
            ->join('perusahaans', 'izin_h_detail.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('banks', 'izin_h_detail.kode_bank', '=', 'banks.kode_bank')
            ->join('izin_pengajuan_cek_giro_h', 'izin_h.kode_pengajuan_cek', '=', 'izin_pengajuan_cek_giro_h.kode_pengajuan_cek')
            ->join('ms_pembawa_resi', 'izin_pengajuan_cek_giro_h.kode_pembawa_resi', '=', 'ms_pembawa_resi.id')
            ->join('ms_pembawa_resi as pengambil', 'izin_h.id_penerima', '=', 'pengambil.id')
            ->leftJoin('izin_b_detail', 'izin_h_detail.id_cek', '=', 'izin_b_detail.no_cek')
            ->leftJoin('izin_b', 'izin_b_detail.kode_izin_b', '=', 'izin_b.kode_izin_b')
            ->leftJoin('izin_a', 'izin_h_detail.id_cek', '=', 'izin_a.no_cek')
            ->leftJoin('izin_a_detail', 'izin_a.kode_izin_a', '=', 'izin_a_detail.kode_izin_a')
            //->where('izin_h_detail.id_cek', '=', 'NNV 181277')
            ->groupBy(
                'izin_h.kode_pengajuan_cek',
                'izin_h.kode_terima_cek',
                'izin_h.kode_buku',
                'izin_h_detail.id_cek',
                'izin_h_detail.no_rekening',
                'izin_h_detail.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'izin_h_detail.kode_bank',
                'banks.nama_bank',
                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                'ms_pembawa_resi.pembawa_resi',
                'izin_h.id_penerima',
                'pengambil.pembawa_resi',
                'izin_b.catatan_b'
            );

        
        if (!isset($request->value)) {

        }else{
            //$data_rekening->where('rekening_outlet.nama_toko', 'like', "%$request->value%");
        }

        $data = $data_rekening->get();
        $output = [
            'status' => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }
}
