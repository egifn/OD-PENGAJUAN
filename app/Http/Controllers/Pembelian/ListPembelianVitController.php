<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;

class ListPembelianVitController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$list = DB::table('import_vit_compas_co')
    		->leftJoin('import_vit_compas_botol','import_vit_compas_co.co','=','import_vit_compas_botol.co')
    		->select('import_vit_compas_co.co','import_vit_compas_co.plant','import_vit_compas_co.sj','import_vit_compas_co.no_polisi','import_vit_compas_co.sopir','import_vit_compas_co.tgl_real','import_vit_compas_co.sj','import_vit_compas_co.sku','import_vit_compas_co.qty_real','import_vit_compas_botol.terima_retur','import_vit_compas_botol.ttl_btl_kosong','import_vit_compas_botol.ttl_tolakan_retur','import_vit_compas_botol.ttl_tolakan_btl_kosong','import_vit_compas_co.dn','import_vit_compas_co.gr','import_vit_compas_co.tl','import_vit_compas_co.distributor','import_vit_compas_co.depo_tujuan','import_vit_compas_co.remark')
    		->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
    		->get();
    

    	return view('pembelian.list_vit.index', compact('list'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $list = DB::table('import_vit_compas_co')
            ->join('import_vit_compas_botol','import_vit_compas_co.co','=','import_vit_compas_botol.co')
            ->select('import_vit_compas_co.co','import_vit_compas_co.plant','import_vit_compas_co.sj','import_vit_compas_co.no_polisi','import_vit_compas_co.sopir','import_vit_compas_co.tgl_real','import_vit_compas_co.sj','import_vit_compas_co.sku','import_vit_compas_co.qty_real','import_vit_compas_botol.terima_retur','import_vit_compas_botol.ttl_btl_kosong','import_vit_compas_botol.ttl_tolakan_retur','import_vit_compas_botol.ttl_tolakan_btl_kosong','import_vit_compas_co.dn','import_vit_compas_co.gr','import_vit_compas_co.tl','import_vit_compas_co.distributor','import_vit_compas_co.depo_tujuan','import_vit_compas_co.remark')
            ->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
            ->get();

        return view('pembelian.list_vit.index', compact('list'));
    }
}
