<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use App\Vendor;
use Auth;
use DB;

class ApprovalVendorController extends Controller
{
    public function index(Request $request)
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $app_vendor = DB::table('pengajuan_vendor')
        			->join('users as a','pengajuan_vendor.id_user_input','=','a.id')
        			->leftJoin('users as b','pengajuan_vendor.id_user_app','=','b.id')
        			->select('pengajuan_vendor.kode_pengajuan_v','pengajuan_vendor.tgl_pengajuan_v','pengajuan_vendor.nama_vendor','pengajuan_vendor.alamat','pengajuan_vendor.telepon','pengajuan_vendor.kategori_vendor','pengajuan_vendor.id_user_input','a.name as nama','pengajuan_vendor.status','pengajuan_vendor.id_user_app','b.name as nama_app')
        			->WhereBetween('pengajuan_vendor.tgl_pengajuan_v', [$date_start,$date_end])
        			->orderBy('pengajuan_vendor.tgl_pengajuan_v', 'DESC')
        			->get();

       	return view('approval.approval_vendor.index', compact('app_vendor')); 
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $app_vendor = DB::table('pengajuan_vendor')
        			->join('users as a','pengajuan_vendor.id_user_input','=','a.id')
        			->leftJoin('users as b','pengajuan_vendor.id_user_app','=','b.id')
        			->select('pengajuan_vendor.kode_pengajuan_v','pengajuan_vendor.tgl_pengajuan_v','pengajuan_vendor.nama_vendor','pengajuan_vendor.alamat','pengajuan_vendor.telepon','pengajuan_vendor.kategori_vendor','pengajuan_vendor.id_user_input','a.name as nama','pengajuan_vendor.status','pengajuan_vendor.id_user_app','b.name as nama_app')
        			->WhereBetween('pengajuan_vendor.tgl_pengajuan_v', [$date_start,$date_end])
        			->orderBy('pengajuan_vendor.tgl_pengajuan_v', 'DESC')
        			->get();

       	return view('approval.approval_vendor.index', compact('app_vendor')); 
    }

    public function view($kode_pengajuan_v)
    {
    	$v_app_vendor = DB::table('pengajuan_vendor')
        			->join('users as a','pengajuan_vendor.id_user_input','=','a.id')
        			->leftJoin('users as b','pengajuan_vendor.id_user_app','=','b.id')
        			->select('pengajuan_vendor.kode_pengajuan_v','pengajuan_vendor.tgl_pengajuan_v','pengajuan_vendor.nama_vendor','pengajuan_vendor.alamat','pengajuan_vendor.telepon','pengajuan_vendor.kategori_vendor','pengajuan_vendor.id_user_input','a.name as nama','pengajuan_vendor.status','pengajuan_vendor.id_user_app','b.name as nama_app')
        			->Where('pengajuan_vendor.kode_pengajuan_v', $kode_pengajuan_v)
        			->first();

       	return view('approval.approval_vendor.view', compact('v_app_vendor')); 
    }

    public function store(Request $request)
    {
    	$kode_pengajuan_v = request()->kode_pengajuan_v;
    	$nama_vendor = request()->nama_vendor;
    	$alamat = request()->alamat;
    	$telepon = request()->telepon;
    	$kategori = request()->kategori;

    	$approved = DB::table('pengajuan_vendor')->where('kode_pengajuan_v', $kode_pengajuan_v)
    					->update([
    						'status' => 1,
    						'id_user_app' => Auth::user()->id,
    						'tgl_app' => Carbon::now()->format('Y-m-d')
    					]);

    	//Simpan ke master vendor
    	$getRow = Vendor::orderBy('kode_vendor', 'ASC')->get();
        $rowCount = $getRow->count();

        $lastId = $getRow->first();

        $kode = "0000000001";

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode = "000000000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $kode = "00000000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $kode = "0000000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $kode = "000000".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $kode = "00000".''.($rowCount + 1);
            } else {
                    $kode = '0000'.($rowCount + 1);
            }
        } 

        Vendor::create([
            'kode_vendor' => $kode,
            'nama_vendor' => $request->get('nama_vendor'),
            'alamat' => $request->get('alamat'),
            'telp' => $request->get('telepon'),
            'keterangan' => $request->get('kategori'),
            'id_user_input' => Auth::user()->id
        ]);

    	alert()->success('Success.','Pengajuan Vendor disetujui...');
        return redirect()->route('home');
    }

    public function pending($kode_pengajuan)
    {
    	$kode_pengajuan_v = request()->kode_pengajuan_v;
    	$pending = DB::table('pengajuan_vendor')->where('kode_pengajuan_v',$kode_pengajuan_v)
                    ->update([
                        'status' => 2,
                        'id_user_app' => Auth::user()->id,
                        'tgl_app' => Carbon::now()->format('Y-m-d')
                    ]);
        //return redirect(route('approval.index'))->with(['success' => 'Request Denied...']);
        alert()->error('Oops...','Pengajuan Vendor ditunda...');
        return redirect()->route('home');
    }

    public function denied(Request $request)
    {
    	$kode_pengajuan_v = request()->kode_pengajuan_v;
    	$denied = DB::table('pengajuan_vendor')->where('kode_pengajuan_v',$kode_pengajuan_v)
                    ->update([
                        'status' => 3,
                        'id_user_app' => Auth::user()->id,
                        'tgl_app' => Carbon::now()->format('Y-m-d')
                    ]);
        //return redirect(route('approval.index'))->with(['success' => 'Request Denied...']);
        alert()->error('Oops...','Pengajuan vendor ditolak...');
        return redirect()->route('home');
    }

    
}
