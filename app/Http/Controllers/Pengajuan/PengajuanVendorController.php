<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Pengajuan_Vendor;
use Carbon\carbon;
use Auth;
use DB;

class PengajuanVendorController extends Controller
{
    public function index(Request $request)
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $pengajuan_vendor = DB::table('pengajuan_vendor')
                ->join('users','pengajuan_vendor.id_user_input','=','users.id')
                ->WhereBetween('pengajuan_vendor.tgl_pengajuan_v', [$date_start,$date_end])
                ->orderBy('pengajuan_vendor.tgl_pengajuan_v', 'DESC')
                ->get();

    	return view('pengajuan.pengajuan_vendor.index', compact('pengajuan_vendor'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $pengajuan_vendor = DB::table('pengajuan_vendor')
                ->join('users','pengajuan_vendor.id_user_input','=','users.id')
                ->WhereBetween('pengajuan_vendor.tgl_pengajuan_v', [$date_start,$date_end])
                ->orderBy('pengajuan_vendor.tgl_pengajuan_v', 'DESC')
                ->get();

        return view('pengajuan.pengajuan_vendor.index', compact('pengajuan_vendor'));
    }

    public function create(Request $request)
    {
    	return view('pengajuan.pengajuan_vendor.create');
    }

    public function view($kode_pengajuan_v)
    {
        $view_pengajuan_v = DB::table('pengajuan_vendor')
                            ->join('users','pengajuan_vendor.id_user_input','=','users.id')
                            ->select('pengajuan_vendor.kode_pengajuan_v','pengajuan_vendor.tgl_pengajuan_v','pengajuan_vendor.nama_vendor','pengajuan_vendor.alamat','pengajuan_vendor.telepon','pengajuan_vendor.kategori_vendor','pengajuan_vendor.id_user_input','users.name')
                            ->where('pengajuan_vendor.kode_pengajuan_v', $kode_pengajuan_v)
                            ->first();

        return view('pengajuan.pengajuan_vendor.view', compact('view_pengajuan_v'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [

        ]);

        Pengajuan_Vendor::create([
            'tgl_pengajuan_v' => Carbon::now()->format('Y-m-d'),
            'nama_vendor' => $request->get('nama_vendor'),
            'alamat' => $request->get('alamat'),
            'telepon' => $request->get('telepon'),
            'kategori_vendor' => $request->get('kategori'),
            'id_user_input' => Auth::user()->id,
            'status' => '0',
        ]);

        alert()->success('Success.','Pengajuan Vendor berhasil');
        return redirect()->route('pengajuan_vendor.index');
    }

}
