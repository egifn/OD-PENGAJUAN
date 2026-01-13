<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BodSppTransferCekController extends Controller
{
    public function index()
    {
        return view ('bod.master_bod.spp_transfer_cek.index');
    }

    public function getDataSppTransferCek(Request $request)
    {
        $data_rekening = DB::table('pengajuan_biaya')
                        ->join('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                        ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                        ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                        ->select(
                            'pengajuan_biaya.kode_pengajuan_b',
                            'pengajuan_biaya.tgl_pengajuan_b',
                            'pengajuan_biaya.kode_perusahaan_tujuan',
                            'pengajuan_biaya.keterangan',
                            'pengajuan_biaya.no_spp',
                            'spp.tgl_spp',
                            'spp.kode_vendor',
                            'spp.for',
                            'spp.pembayaran',
                            'rekening_fin.kode_bank',
                            'banks.nama_bank',
                            'spp.jumlah',
                            'spp.jenis'
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
