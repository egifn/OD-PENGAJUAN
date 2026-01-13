<?php

namespace App\Http\Controllers\FilterPengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilterPengajuanController extends Controller
{
    public function index()
    {
        return view ('filter_pengajuan.pengajuan.index');
    }

    public function getDataPengajuan(Request $request)
    {
        $query = DB::table('pengajuan')
                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                    ->join('products','pengajuan_detail.kode_product','=','products.kode')
                    ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                    ->where('pengajuan.kode_perusahaan','TUA');
        // if (!isset($request->value)) {
        //     // $query->paginate(8);
        // }else{
        //     $query->where('nama_pelanggan', 'like', "%$request->value%");
        // }

        $data  = $query->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function getDataPengajuanTa(Request $request)
    {
        $query = DB::table('pengajuan')
                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                    ->join('products','pengajuan_detail.kode_product','=','products.kode')
                    ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                    ->where('pengajuan.kode_perusahaan','WPS');
        // if (!isset($request->value)) {
        //     // $query->paginate(8);
        // }else{
        //     $query->where('nama_pelanggan', 'like', "%$request->value%");
        // }

        $data  = $query->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function getDataPengajuanTu(Request $request)
    {
        $query = DB::table('pengajuan')
                    ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                    ->join('products','pengajuan_detail.kode_product','=','products.kode')
                    ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                    ->where('pengajuan.kode_perusahaan','LP');
        // if (!isset($request->value)) {
        //     // $query->paginate(8);
        // }else{
        //     $query->where('nama_pelanggan', 'like', "%$request->value%");
        // }

        $data  = $query->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }
}
