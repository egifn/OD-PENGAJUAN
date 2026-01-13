<?php

namespace App\Http\Controllers\AssetList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index()
    {
    	return view ('asset_list.index');
    }

    public function getDataAsset(Request $request)
	{
		$data_asset = DB::table('asset_list')
                    ->join('users','asset_list.id_user_input','=','users.id');

		if (!isset($request->value)) {

        }else{
            $data_asset->where('asset_list.nama_asset', 'like', "%$request->value%");
        }

        $data  = $data_asset->get();
        $count = ($data_asset->count() == 0) ? 0 : $data->count();
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
        DB::table('asset_list')->insert([
        	'nama_asset' => $request->nama_asset,
        	'id_user_input' => Auth::user()->id
        ]);

        $output = [
            'msg'  => 'Data Asset Berhasil Ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    }
}
