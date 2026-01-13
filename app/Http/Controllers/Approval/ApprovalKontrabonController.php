<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\carbon;

class ApprovalKontrabonController extends Controller
{
    public function index()
    {
        $counter_bill = DB::table('kontrabon')
            ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
            ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
            ->join('users','kontrabon.id_user_input','=','users.id')
            ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status_kontra','kontrabon.id_user_input','users.name')
            ->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status_kontra','kontrabon.id_user_input','users.name')
            ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
            ->get();

    	return view ('approval.approval_kontrabon.index', compact('counter_bill'));
    }
	
	public function cari(Request $requst)
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $counter_bill = DB::table('kontrabon')
            ->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
            ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
            ->join('users','kontrabon.id_user_input','=','users.id')
            ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status_kontra','kontrabon.id_user_input','users.name')
            ->WhereBetween('kontrabon.tgl_kontrabon', [$date_start,$date_end])
            ->groupBy('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.status_kontra','kontrabon.id_user_input','users.name')
            ->orderBy('kontrabon.tgl_kontrabon', 'ASC')
            ->get();

    	return view ('approval.approval_kontrabon.index', compact('counter_bill'));
    }

    public function view($no_kontrabon)
    {

        $kontrabon = DB::table('kontrabon')->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
                                            ->select('kontrabon.no_kontrabon','kontrabon.tgl_kontrabon','vendors.nama_vendor','kontrabon.total','kontrabon.termin','kontrabon.jatuh_tempo','kontrabon.keterangan')
                                            ->where('kontrabon.no_kontrabon', $no_kontrabon)
                                            ->first();

        $kontrabon_detail = DB::table('kontrabon_detail')
                                ->where('kontrabon_detail.no_kontrabon', $no_kontrabon)
                                ->get();

        return view('approval.approval_kontrabon.view',compact('kontrabon','kontrabon_detail'));
    }
}
