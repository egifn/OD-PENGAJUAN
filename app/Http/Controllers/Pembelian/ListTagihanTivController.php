<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;

class ListTagihanTivController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $list = DB::table('import_tagihan_tiv')
            ->select(
                    'import_tagihan_tiv.kode',
                    'import_tagihan_tiv.tgl_import',
                    'import_tagihan_tiv.purchase_order_number',
                    'import_tagihan_tiv.order_number',
                    'import_tagihan_tiv.invoice_date',
                    'import_tagihan_tiv.actual_goods_issue_date',
                    'import_tagihan_tiv.sales_document_type',
                    'import_tagihan_tiv.ship_to',
                    'import_tagihan_tiv.sold_to_party',
                    'import_tagihan_tiv.plant',
                    'import_tagihan_tiv.plant_description',
                    'import_tagihan_tiv.delivery_number',
                    'import_tagihan_tiv.material_id',
                    'import_tagihan_tiv.external_delivery_id',
                    'import_tagihan_tiv.means_of_trans_id',
                    'import_tagihan_tiv.ship_to_name',
                    'import_tagihan_tiv.sold_to_name',
                    'import_tagihan_tiv.material_description',
                    'import_tagihan_tiv.billing_document',
                    'import_tagihan_tiv.delivery_sum',
                    'import_tagihan_tiv.invoice_cab',
                    'import_tagihan_tiv.invoice_caf',
                    'import_tagihan_tiv.invoice_vat_amount',
                    'import_tagihan_tiv.subsidi',
                    'import_tagihan_tiv.original_amount',
                    'import_tagihan_tiv.id_user_input'
                )
            ->whereBetween('import_tagihan_tiv.tgl_import', [$date_start,$date_end])
    		->get();

        return view('pembelian.list_tagihan_tiv.index', compact('list'));
    }

    public function cari()
    {
        date_default_timezone_set('Asia/Jakarta');
		
		if(request()->tanggal != ''){
			 $date = explode(' - ' ,request()->tanggal);
			 $date_start = Carbon::parse($date[0])->format('Y-m-d 00:00:00');
			 $date_end = Carbon::parse($date[1])->format('Y-m-d 23:59:59');
        }

        $list = DB::table('import_tagihan_tiv')
            ->select(
                    'import_tagihan_tiv.kode',
                    'import_tagihan_tiv.tgl_import',
                    'import_tagihan_tiv.purchase_order_number',
                    'import_tagihan_tiv.order_number',
                    'import_tagihan_tiv.invoice_date',
                    'import_tagihan_tiv.actual_goods_issue_date',
                    'import_tagihan_tiv.sales_document_type',
                    'import_tagihan_tiv.ship_to',
                    'import_tagihan_tiv.sold_to_party',
                    'import_tagihan_tiv.plant',
                    'import_tagihan_tiv.plant_description',
                    'import_tagihan_tiv.delivery_number',
                    'import_tagihan_tiv.material_id',
                    'import_tagihan_tiv.external_delivery_id',
                    'import_tagihan_tiv.means_of_trans_id',
                    'import_tagihan_tiv.ship_to_name',
                    'import_tagihan_tiv.sold_to_name',
                    'import_tagihan_tiv.material_description',
                    'import_tagihan_tiv.billing_document',
                    'import_tagihan_tiv.delivery_sum',
                    'import_tagihan_tiv.invoice_cab',
                    'import_tagihan_tiv.invoice_caf',
                    'import_tagihan_tiv.invoice_vat_amount',
                    'import_tagihan_tiv.subsidi',
                    'import_tagihan_tiv.original_amount',
                    'import_tagihan_tiv.id_user_input'
                )
            ->whereBetween('import_tagihan_tiv.tgl_import', [$date_start,$date_end])
    		->get();

        return view('pembelian.list_tagihan_tiv.index', compact('list'));        
    }
}
