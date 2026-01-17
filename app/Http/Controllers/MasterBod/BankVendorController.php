<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankVendorController extends Controller
{
    public function index()
    {
        // $type = request('type');
        // if ($type === 'barang') {
        //     return view('bod.master_bod.bank_vendor.barang');
        // } elseif ($type === 'jasa') {
        //     return view('bod.master_bod.bank_vendor.jasa');
        // }
        return view('bod.master_bod.bank_vendor.index');
    }

    public function getDataBankVendor(Request $request)
    {
        $type = $request->type;
        $data_rekening = DB::table('vendors')
            ->leftJoin('perusahaans', 'vendors.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('rekening_fin', 'vendors.kode_vendor', '=', 'rekening_fin.kode_vendor')
            ->join('banks', 'rekening_fin.kode_bank', '=', 'banks.kode_bank')
            ->select(
                'vendors.kode_vendor',
                'vendors.nama_vendor',
                'vendors.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'vendors.cara_bayar',
                'rekening_fin.norek',
                'rekening_fin.kode_bank',
                'banks.nama_bank',
            );

        // if ($type === 'barang') {
        //     $data_rekening->where('vendors.jenis_vendor', 'barang');
        // } elseif ($type === 'jasa') {
        //     $data_rekening->where('vendors.jenis_vendor', 'jasa');
        // }

        $data = $data_rekening->get();
        $output = [
            'status' => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function jasa()
    {
        return view('bod.master_bod.bank_vendor.jasa');
    }

    public function barang()
    {
        return view('bod.master_bod.bank_vendor.barang');
    }
}
