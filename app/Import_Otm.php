<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import_Otm extends Model
{
    protected $table = 'import_otm';
    protected $fillable = [
    		'kode_otm_h',
	    	'order_id',
	    	'shipment_id',
	    	'sap_order_no',
	    	'order_creation_date',
			'order_creation_reason',
	    	'order_type',
	    	'material_id',
	    	'material_desc',
	    	'source_id',
	    	'source_name',
	    	'dest_id',
	    	'dest_name',
	    	'sap_delivery_code',
	    	'storage_loc',
	    	'planned_transporter_id',
	    	'planned_transporter_name',
	    	'actual_transporter_id',
	    	'actual_transporter_name',
	    	'planned_quantity',
	    	'actual_quantity',
	    	'planned_pickup_date',
	    	'actual_pickup_date',
			'planned_window',
			'actual_window',
			'cancel_reason',
			'order_status',
			'dispatch_number',
			'order_approval_status',
			'shipment_tatus',
	    	'dn_number',
			'truck_type',
	    	'id_user_input'
    	];
}
