<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index()
    {
        return view ('bod.master_bod.transfer.index');
    }

    public function getDataTransfer(Request $request)
    {
        // $data_rekening = DB::table('izin_pengajuan_cek_giro_h')
        //                 ->join('izin_pengajuan_cek_giro_d','izin_pengajuan_cek_giro_h.kode_pengajuan_cek','=','izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
        //                 ->join('perusahaans','izin_pengajuan_cek_giro_d.kode_perusahaan','=','perusahaans.kode_perusahaan')
        //                 ->join('banks','izin_pengajuan_cek_giro_d.kode_bank','=','banks.kode_bank')
        //                 ->join('ms_pembawa_resi','izin_pengajuan_cek_giro_h.kode_pembawa_resi','=','ms_pembawa_resi.id')
        //                 ->join('izin_h','izin_pengajuan_cek_giro_h.kode_pengajuan_cek','=','izin_h.kode_pengajuan_cek') 
        //                 ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
        //                 ->join('ms_pembawa_resi as pengambil','izin_h.id_penerima','=','pengambil.id')
        //                 ->select(
        //                     'izin_pengajuan_cek_giro_h.kode_pengajuan_cek',
        //                     'izin_h.kode_buku',
        //                     'izin_h_detail.id_cek',
        //                     'izin_pengajuan_cek_giro_d.no_rekening',
        //                     'izin_pengajuan_cek_giro_d.kode_perusahaan',
        //                     'perusahaans.nama_perusahaan',
        //                     'izin_pengajuan_cek_giro_d.kode_bank',
        //                     'banks.nama_bank',
        //                     'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
        //                     'ms_pembawa_resi.pembawa_resi',
        //                     'izin_h.id_penerima',
        //                     'pengambil.pembawa_resi as pengambil'
        //                 );

        $data_rekening = DB::table('rekening_fin_comp')
                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                        ->leftJoin('virtualaccounts','rekening_fin_comp.norek','=','virtualaccounts.norek')
                        ->select(
                            'rekening_fin_comp.norek',
                            'virtualaccounts.virtualaccount',
                            'rekening_fin_comp.kode_perusahaan',
                            'perusahaans.nama_perusahaan',
                            'rekening_fin_comp.kode_bank',
                            'banks.nama_bank',
                            'rekening_fin_comp.fungsi_rek',
                            'rekening_fin_comp.internet_banking',
                            'rekening_fin_comp.token',
                            'rekening_fin_comp.jml_pemegang_token_viewer',
                            'rekening_fin_comp.jml_pemegang_token_maker',
                            'rekening_fin_comp.jml_pemegang_token_verifier',
                            'rekening_fin_comp.jml_pemegang_token_authorizer'
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
