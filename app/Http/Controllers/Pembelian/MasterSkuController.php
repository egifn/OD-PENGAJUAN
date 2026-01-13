<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterSkuController extends Controller
{
    public function index()
    {
        return view ('pembelian.sku.index');
    }

    public function getDataSku(Request $request)
    {
        $data_sku = DB::table('ms_harga_sku')
                        ->join('users','ms_harga_sku.id_user_input','=','users.id')
                        ->select('ms_harga_sku.id','ms_harga_sku.kode_sku','ms_harga_sku.nama_sku','ms_harga_sku.perusahaan',
                                'ms_harga_sku.pabrik','ms_harga_sku.harga','ms_harga_sku.id_user_input','users.name');
        
        if (!isset($request->value)) {

        }else{
            $data_sku->where('ms_harga_sku.nama_sku', 'like', "%$request->value%");
        }

        $data = $data_sku->get();
        $output = [
            'status' => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function store(Request $request)
    {
        DB::table('ms_harga_sku')->insert([
            'kode_sku' => $request->kode_sku,
            'nama_sku' => $request->nama_sku,
            'perusahaan' => $request->perusahaan,
            'pabrik' => $request->pabrik,
            'harga' => $request->harga,
        	'id_user_input' => Auth::user()->id
        ]);

        $output = [
            'msg'  => 'Data Berhasil Ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    }

    public function getDataSkuEdit(Request $request)
    {
        $data = DB::table('rekening_outlet')
                ->join('depos','rekening_outlet.kode_depo','=','depos.kode_depo')
                ->join('users','rekening_outlet.id_user_input','=','users.id')
                ->select('rekening_outlet.id','rekening_outlet.kode_depo','depos.nama_depo','rekening_outlet.kode_toko','rekening_outlet.nama_toko',
                        'rekening_outlet.program','rekening_outlet.nama_pemilik','rekening_outlet.no_rekening','rekening_outlet.nama_rekening',
                        'rekening_outlet.bank_rekening','rekening_outlet.keterangan','rekening_outlet.id_user_input','users.name')
		        ->where('rekening_outlet.id', $request->kode)
                ->first();

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];
        
        return response()->json($output, 200);
    }

    public function update(Request $request)
    {
        DB::table('ms_harga_sku')->where('ms_harga_sku.id', $request->kode)->update([
            'nama_sku' => $request->nama_sku_update,
            'perusahaan' => $request->perusahaan_update,
            'pabrik' => $request->pabrik_update,
            'harga' => $request->harga_update,
        ]);

        $output = [
            'message'  => 'Data Berhasil Diubah',
            'status'  => true,
        ];
        return response()->json($output, 200);        
    }
}
