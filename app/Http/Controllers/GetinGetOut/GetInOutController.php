<?php

namespace App\Http\Controllers\GetinGetOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class GetInOutController extends Controller
{
    public function index()
    {
    	//return view ('finance.spp.index', compact('spp'));
    	//return view ('getin_getout.index');
    }

    public function create()
    {
    	$bkb_head = DB::connection('mysql_tua')
              ->table('dms_inv_docstockoutbranch')
              ->join('dms_pi_employee','dms_inv_docstockoutbranch.szEmployeeId','=','dms_pi_employee.szId')
              ->where('dms_inv_docstockoutbranch.szDocId', 0)
              ->first();

    	$bkb_data = DB::connection('mysql_tua')
              ->table('dms_inv_docstockoutbranch')
              ->join('dms_inv_docstockoutbranchitem','dms_inv_docstockoutbranch.szDocId','=','dms_inv_docstockoutbranchitem.szDocId')
              ->join('dms_inv_product','dms_inv_docstockoutbranchitem.szProductId','=','dms_inv_product.szId')
              ->where('dms_inv_docstockoutbranch.szDocId', 0)
              ->get();
    	
    	return view ('getin_getout.create', compact('bkb_data','bkb_head'));	
    }

    public function cari(Request $request)
    {
    	if(request()->no_bkb != '')
      {
          $bkb = request()->no_bkb;
      }

        if ($bkb == '')
        {
        	$bkb_head = DB::connection('mysql_tua')
              ->table('dms_inv_docstockoutbranch')
              ->join('dms_pi_employee','dms_inv_docstockoutbranch.szEmployeeId','=','dms_pi_employee.szId')
              ->where('dms_inv_docstockoutbranch.szDocId', 0)
              ->first();

        	$bkb_data = DB::connection('mysql_tua')
              ->table('dms_inv_docstockoutbranch')
              ->join('dms_inv_docstockoutbranchitem','dms_inv_docstockoutbranch.szDocId','=','dms_inv_docstockoutbranchitem.szDocId')
              ->join('dms_inv_product','dms_inv_docstockoutbranchitem.szProductId','=','dms_inv_product.szId')
              ->where('dms_inv_docstockoutbranch.szDocId', 0)
              ->get();
        }else{
        	$bkb_head = DB::connection('mysql_tua')
              ->table('dms_inv_docstockoutbranch')
              ->join('dms_pi_employee','dms_inv_docstockoutbranch.szEmployeeId','=','dms_pi_employee.szId')
              ->where('dms_inv_docstockoutbranch.szDocId', $bkb)
              ->first();

        	$bkb_data = DB::connection('mysql_tua')
              ->table('dms_inv_docstockoutbranch')
              ->join('dms_inv_docstockoutbranchitem','dms_inv_docstockoutbranch.szDocId','=','dms_inv_docstockoutbranchitem.szDocId')
              ->join('dms_inv_product','dms_inv_docstockoutbranchitem.szProductId','=','dms_inv_product.szId')
              ->where('dms_inv_docstockoutbranch.szDocId', $bkb)
              ->get();
        }

        return view ('getin_getout.create', compact('bkb_data','bkb_head'));	
    }
}
