<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;

class TagihanController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $qty_aqua = DB::table('import_otm')
          ->select(
                    DB::raw("sum(import_otm.actual_quantity) as qty_aqua")
                  )
          ->leftJoin('ms_harga_sku','import_otm.material_desc','=','ms_harga_sku.nama_sku')
          ->join('import_otm_h','import_otm.kode_otm_h','=','import_otm_h.kode_otm_h')
          ->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
          ->first();

        $qty_vit = DB::table('import_vit_compas_co')
    		  ->select(
                    DB::raw("sum(import_vit_compas_co.qty_real) as qty_vit")
                  )
          ->leftJoin('ms_harga_sku','import_vit_compas_co.sku','=','ms_harga_sku.nama_sku')
          ->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
          ->first();

        $total_aqua = DB::table('import_otm')
          ->select(
                    DB::raw("sum(import_otm.actual_quantity * ms_harga_sku.harga) as total")
                  )
          ->leftJoin('ms_harga_sku','import_otm.material_desc','=','ms_harga_sku.nama_sku')
          ->join('import_otm_h','import_otm.kode_otm_h','=','import_otm_h.kode_otm_h')
          ->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
          ->first();

        $total_vit = DB::table('import_vit_compas_co')
    		  ->select(
                    DB::raw("sum(import_vit_compas_co.qty_real * ms_harga_sku.harga) as total")
                  )
          ->leftJoin('ms_harga_sku','import_vit_compas_co.sku','=','ms_harga_sku.nama_sku')
          ->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
          ->first();

        $list_aqua = DB::table('import_otm')
    		->select('import_otm.shipment_id as po_number',
                  'import_otm.sap_order_no as order_number',
                  'import_otm.sap_delivery_code',
                  'import_otm.source_id',
                  'import_otm.source_name',
                  'import_otm.dn_number',
                  'import_otm.material_id',
                  'import_otm.dest_name as ship_to_name',
                  'import_otm.planned_transporter_name as sold_to_name',
                  'import_otm.material_desc as sku',
                  'import_otm.actual_quantity as delivery_sum',
                  'ms_harga_sku.harga')
        ->leftJoin('ms_harga_sku','import_otm.material_desc','=','ms_harga_sku.nama_sku')
        ->join('import_otm_h','import_otm.kode_otm_h','=','import_otm_h.kode_otm_h')
    		->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
    		->get();

        $list_vit = DB::table('import_vit_compas_co')
    		->select('import_vit_compas_co.dn as po_number',
                  'import_vit_compas_co.dn as order_number',
                  'import_vit_compas_co.dn as sap_delivery_code',
                  'import_vit_compas_co.dn as source_id',
                  'import_vit_compas_co.dn as source_name',
                  'import_vit_compas_co.dn as dn_number',
                  'import_vit_compas_co.dn as material_id',
                  'import_vit_compas_co.plant as ship_to_name',
                  'import_vit_compas_co.depo_tujuan as sold_to_name',
                  'import_vit_compas_co.sku',
                  'import_vit_compas_co.qty_real as delivery_sum',
                  'ms_harga_sku.harga')
        ->leftJoin('ms_harga_sku','import_vit_compas_co.sku','=','ms_harga_sku.nama_sku')
    		->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
    		->get();

        $list_tagihan = $list_aqua->merge($list_vit);

    	  return view('pembelian.tagihan.tagihan', compact('list_tagihan','total_aqua','total_vit','qty_aqua','qty_vit'));
    }

    public function cari()
    {
    	  date_default_timezone_set('Asia/Jakarta');
		
        if(request()->tanggal != ''){
          $date = explode(' - ' ,request()->tanggal);
          $date_start = Carbon::parse($date[0])->format('Y-m-d 00:00:00');
          $date_end = Carbon::parse($date[1])->format('Y-m-d 23:59:59');
        }

        $qty_aqua = DB::table('import_otm')
          ->select(
                    DB::raw("sum(import_otm.actual_quantity) as qty_aqua")
                  )
          ->leftJoin('ms_harga_sku','import_otm.material_desc','=','ms_harga_sku.nama_sku')
          ->join('import_otm_h','import_otm.kode_otm_h','=','import_otm_h.kode_otm_h')
          ->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
          ->first();

        $qty_vit = DB::table('import_vit_compas_co')
    		  ->select(
                    DB::raw("sum(import_vit_compas_co.qty_real) as qty_vit")
                  )
          ->leftJoin('ms_harga_sku','import_vit_compas_co.sku','=','ms_harga_sku.nama_sku')
          ->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
          ->first();

        $total_aqua = DB::table('import_otm')
          ->select(
                    DB::raw("sum(import_otm.actual_quantity * ms_harga_sku.harga) as total")
                  )
          ->leftJoin('ms_harga_sku','import_otm.material_desc','=','ms_harga_sku.nama_sku')
          ->join('import_otm_h','import_otm.kode_otm_h','=','import_otm_h.kode_otm_h')
          ->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
          ->first();

        $total_vit = DB::table('import_vit_compas_co')
    		  ->select(
                    DB::raw("sum(import_vit_compas_co.qty_real * ms_harga_sku.harga) as total")
                  )
          ->leftJoin('ms_harga_sku','import_vit_compas_co.sku','=','ms_harga_sku.nama_sku')
          ->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
          ->first();

        $list_aqua = DB::table('import_otm')
    		->select('import_otm.shipment_id as po_number',
                  'import_otm.sap_order_no as order_number',
                  'import_otm.sap_delivery_code',
                  'import_otm.source_id',
                  'import_otm.source_name',
                  'import_otm.dn_number',
                  'import_otm.material_id',
                  'import_otm.dest_name as ship_to_name',
                  'import_otm.planned_transporter_name as sold_to_name',
                  'import_otm.material_desc as sku',
                  'import_otm.actual_quantity as delivery_sum',
                  'ms_harga_sku.harga')
        ->leftJoin('ms_harga_sku','import_otm.material_desc','=','ms_harga_sku.nama_sku')
        ->join('import_otm_h','import_otm.kode_otm_h','=','import_otm_h.kode_otm_h')
    		->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
    		->get();

        $list_vit = DB::table('import_vit_compas_co')
    		->select('import_vit_compas_co.dn as po_number',
                  'import_vit_compas_co.dn as order_number',
                  'import_vit_compas_co.dn as sap_delivery_code',
                  'import_vit_compas_co.dn as source_id',
                  'import_vit_compas_co.dn as source_name',
                  'import_vit_compas_co.dn as dn_number',
                  'import_vit_compas_co.dn as material_id',
                  'import_vit_compas_co.plant as ship_to_name',
                  'import_vit_compas_co.depo_tujuan as sold_to_name',
                  'import_vit_compas_co.sku',
                  'import_vit_compas_co.qty_real as delivery_sum',
                  'ms_harga_sku.harga')
        ->leftJoin('ms_harga_sku','import_vit_compas_co.sku','=','ms_harga_sku.nama_sku')
    		->whereBetween('import_vit_compas_co.tgl_import', [$date_start,$date_end])
    		->get();

        $list_tagihan = $list_aqua->merge($list_vit);

        return view('pembelian.tagihan.tagihan', compact('list_tagihan','total_aqua','total_vit','qty_aqua','qty_vit'));
    }
}
