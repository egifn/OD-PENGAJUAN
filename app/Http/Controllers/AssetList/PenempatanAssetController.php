<?php

namespace App\Http\Controllers\AssetList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenempatanAssetController extends Controller
{
    public function index()
    {
    	return view ('asset_penempatan.index');
    }

    public function getDataPenempatan(Request $request)
	{
		$data_penempatan = DB::table('asset_list_penempatan')
                    ->join('users','asset_list_penempatan.id_user_input','=','users.id');

		if (!isset($request->value)) {

        }else{
            $data_penempatan->where('asset_list_penempatan.penempatan', 'like', "%$request->value%");
        }

        $data  = $data_penempatan->get();
        $count = ($data_penempatan->count() == 0) ? 0 : $data->count();
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
        DB::table('asset_list_penempatan')->insert([
        	'penempatan' => $request->nama_tempat,
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
