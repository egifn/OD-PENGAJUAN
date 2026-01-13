<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Kontrabon;
use App\Kontrabon_Detail;
use App\Vendors;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

class SupplierBillController extends Controller
{
    public function index()
    {	
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$supplier_bill = DB::table('kontrabon')
    					->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
    					->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
    					->join('users','kontrabon.id_user_input','=','users.id')
    					->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name','kontrabon.id_cek')
    					->WhereBetween('kontrabon.tgl_kontrabon', [$date_start,$date_end])
    					->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name','kontrabon.id_cek')
    					->orderBy('kontrabon.tgl_kontrabon', 'ASC')
    					->get();

    	return view ('purchasing.supplier_bill.index', compact('supplier_bill'));
    }

    public function cari(Request $request)
    {	
    	$type = $request->type;

    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        // if(request()->type != '')
        // {
        //     $type = request()->type;
        // }

        // if ($type == 'Non Sparepart')
        // {
        // 	$supplier_bill = DB::table('kontrabon')
    				// 	->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
    				// 	->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
    				// 	->join('users','kontrabon.id_user_input','=','users.id')
    				// 	->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name')
    				// 	->WhereBetween('kontrabon.tgl_kontrabon', [$date_start,$date_end])
    					
    				// 	->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name')
    				// 	->orderBy('kontrabon.tgl_kontrabon', 'ASC')
    				// 	->get();
        // }elseif($type == 'Sparepart'){
        // 	$supplier_bill = DB::table('kontrabon')
    				// 	->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
    				// 	->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
    				// 	->join('users','kontrabon.id_user_input','=','users.id')
    				// 	->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name')
    				// 	->WhereBetween('kontrabon.tgl_kontrabon', [$date_start,$date_end])
    					
    				// 	->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name')
    				// 	->orderBy('kontrabon.tgl_kontrabon', 'ASC')
    				// 	->get();
        // }elseif($type == ){
        //     $supplier_bill = DB::table('kontrabon')
        //                 ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
        //                 ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
        //                 ->join('users','kontrabon.id_user_input','=','users.id')
        //                 ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name')
        //                 ->WhereBetween('kontrabon.tgl_kontrabon', [$date_start,$date_end])
                        
        //                 ->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name')
        //                 ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
        //                 ->get();
        // }

        $supplier_bill = DB::table('kontrabon')
                        ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                        ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
                        ->join('users','kontrabon.id_user_input','=','users.id')
                        ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name','kontrabon.id_cek')
                        ->WhereBetween('kontrabon.tgl_kontrabon', [$date_start,$date_end])
                        
                        ->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name','kontrabon.id_cek')
                        ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
                        ->get();

        return view ('purchasing.supplier_bill.index', compact('supplier_bill'));
    }

    public function view($no_kontrabon)
    {
        $bayar = DB::table('kontrabon')
                        ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                        ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
                        ->join('users','kontrabon.id_user_input','=','users.id')
                        ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name','kontrabon.id_cek')
                        ->Where('kontrabon.no_kontrabon', $no_kontrabon)
                        ->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status','kontrabon.type','kontrabon.id_user_input','users.name','kontrabon.id_cek')
                        ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
                        ->first();

        return view ('purchasing.supplier_bill.create', compact('bayar'));
    }

    public function store(Request $request)
    {
        $isi_cek = DB::table('kontrabon')
                            ->select('kontrabon.id_cek')
                            ->Where('kontrabon.no_kontrabon', $request->get("no_kontrabon"))
                            ->update([
                                'status' => 3,
                                'tgl_pengambilan_cek' => Carbon::now()->format('Y-m-d'),
                    ]);

        alert()->success('Success.','Pembayaran Berhasil');
        return redirect()->route('supplier_bill.index');
    }
    
    
}
