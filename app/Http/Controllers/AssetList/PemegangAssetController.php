<?php

namespace App\Http\Controllers\AssetList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemegangAssetController extends Controller
{
    public function index()
    {
    	return view ('asset_pemegang.index');
    }

    public function getDataPemegang(Request $request)
	{
		$data_pemegang = DB::table('asset_list_pemegang')
                    ->join('users','asset_list_pemegang.id_user_input','=','users.id');

		if (!isset($request->value)) {

        }else{
            $data_pemegang->where('asset_list_pemegang.nama_pemegang', 'like', "%$request->value%");
        }

        $data  = $data_pemegang->get();
        $count = ($data_pemegang->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
	}

    public function store(Request $request)
    {
        DB::table('asset_list_pemegang')->insert([
        	'nama_pemegang' => $request->nama_pemegang,
        	'id_user_input' => Auth::user()->id
        ]);

        $output = [
            'msg'  => 'Data Berhasil Ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    }
}
