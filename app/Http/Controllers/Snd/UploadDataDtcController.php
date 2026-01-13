<?php

namespace App\Http\Controllers\Snd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

class UploadDataDtcController extends Controller
{
    public function index()
    {
        $data = DB::table('data_center_upload')
                    ->select('data_center_upload.id','data_center_upload.tgl_upload','data_center_upload.filename_upload','data_center_upload.keterangan','data_center_upload.id_user_input')
                    ->get();

        return view ('snd.upload_data_dtc.index', compact('data'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data = DB::table('data_center_upload')
                    ->select('data_center_upload.id','data_center_upload.tgl_upload','data_center_upload.filename_upload','data_center_upload.keterangan','data_center_upload.id_user_input')
                    ->WhereBetween('data_center_upload.tgl_upload', [$date_start,$date_end])
                    ->get();

        return view ('snd.upload_data_dtc.index', compact('data'));
    }
    
}
