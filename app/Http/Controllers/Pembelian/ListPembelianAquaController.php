<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;

class ListPembelianAquaController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $list = DB::table('import_otm_h')
    		->join('import_otm','import_otm_h.kode_otm_h','=','import_otm.kode_otm_h')
    		->join('users','import_otm_h.id_user_input','=','users.id')
    		->select('import_otm_h.kode_otm_h',
				'import_otm_h.tgl_otm_h',
				'import_otm.order_id',
				'import_otm.shipment_id',
				'import_otm.sap_order_no',
				'import_otm.order_creation_date',
				'import_otm.order_type',
				'import_otm.material_id',
				'import_otm.material_desc',
				'import_otm.source_id',
				'import_otm.source_name',
				'import_otm.dest_id',
				'import_otm.dest_name',
				'import_otm.sap_delivery_code',
				'import_otm.storage_loc',
				'import_otm.planned_transporter_id',
				'import_otm.planned_transporter_name',
				'import_otm.actual_transporter_id',
				'import_otm.actual_transporter_name',
				'import_otm.planned_quantity',
				'import_otm.actual_quantity',
				'import_otm.planned_pickup_date',
				'import_otm.actual_pickup_date',
				'import_otm.dn_number',
				'import_otm.sj_depo',
				'import_otm.qa',
				'import_otm.qb',
				'import_otm.blank',
				'import_otm.truck_type',
				'import_otm.id_user_input',
				'users.name')
    		->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
    		->get();

    	return view('pembelian.list_aqua.index', compact('list'));
    }

    public function cari()
    {
    	date_default_timezone_set('Asia/Jakarta');
		
		if(request()->tanggal != ''){
			 $date = explode(' - ' ,request()->tanggal);
			 $date_start = Carbon::parse($date[0])->format('Y-m-d 00:00:00');
			 $date_end = Carbon::parse($date[1])->format('Y-m-d 23:59:59');
        }

        $list = DB::table('import_otm_h')
    		->join('import_otm','import_otm_h.kode_otm_h','=','import_otm.kode_otm_h')
    		->join('users','import_otm_h.id_user_input','=','users.id')
    		->select('import_otm_h.kode_otm_h','import_otm_h.tgl_otm_h','import_otm.order_id','import_otm.shipment_id','import_otm.sap_order_no','import_otm.order_creation_date','import_otm.order_type','import_otm.material_id','import_otm.material_desc','import_otm.source_id','import_otm.source_name','import_otm.dest_id','import_otm.dest_name','import_otm.sap_delivery_code','import_otm.storage_loc','import_otm.planned_transporter_id','import_otm.planned_transporter_name','import_otm.actual_transporter_id','import_otm.actual_transporter_name','import_otm.planned_quantity','import_otm.actual_quantity','import_otm.planned_pickup_date','import_otm.actual_pickup_date','import_otm.dn_number','import_otm.sj_depo','import_otm.qa','import_otm.qb','import_otm.blank','import_otm.truck_type','import_otm.id_user_input','users.name')
    		->whereBetween('import_otm_h.tgl_otm_h', [$date_start,$date_end])
    		->get();

        return view('pembelian.list_aqua.index', compact('list'));
    }
}
