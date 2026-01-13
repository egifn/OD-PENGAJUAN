<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportSapTagihanTiv extends Model
{
    protected $table = 'import_tagihan_tiv';
	protected $fillable = [
        'tgl_import',
        'purchase_order_number',
        'order_number',
        'invoice_date',
        'actual_goods_issue_date',
        'sales_document_type',
        'ship_to',
        'sold_to_party',
        'plant',
        'plant_description',
        'delivery_number',
        'material_id',
        'external_delivery_id',
        'means_of_trans_id',
        'ship_to_name',
        'sold_to_name',
        'material_description',
        'billing_document',
        'delivery_sum',
        'invoice_cab',
        'invoice_caf',
        'invoice_vat_amount',
        'subsidi',
        'original_amount',
        'id_user_input'
    ];
}
