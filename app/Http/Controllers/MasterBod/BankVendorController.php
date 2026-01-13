<?php

namespace App\Http\Controllers\MasterBod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankVendorController extends Controller
{
    public function index()
    {
        return view ('bod.master_bod.bank_vendor.index');
    }

    public function getDataBankVendor(Request $request)
    {
        $data_rekening = DB::table('vendors')
                        ->leftJoin('perusahaans','vendors.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('rekening_fin','vendors.kode_vendor','=','rekening_fin.kode_vendor')
                        ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                        ->select(
                            'vendors.kode_vendor',
                            'vendors.nama_vendor',
                            'vendors.kode_perusahaan',
                            'perusahaans.nama_perusahaan',
                            'vendors.cara_bayar', 
                            'rekening_fin.norek',
                            'rekening_fin.kode_bank',
                            'banks.nama_bank'
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
