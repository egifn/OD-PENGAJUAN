<?php

namespace App\Http\Controllers\Sparepart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;
use PDF;

class PurchaseOrderController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$po = DB::connection('sqlsrv')
    		->table('tr_part_purchase_order_h')
            ->join('tr_part_purchase_order_d','tr_part_purchase_order_h.part_purchase_order_h_code','=','tr_part_purchase_order_d.part_purchase_order_h_code')
    		->join('ms_supplier','tr_part_purchase_order_h.part_purchase_order_supplier','=','ms_supplier.supp_code')
    		->join('ms_employee','tr_part_purchase_order_h.part_purchase_order_mgr','=','ms_employee.emp_id')
    		->join('ms_employee as ms_employee_2','tr_part_purchase_order_h.part_purchase_order_approved','=','ms_employee_2.emp_id')
    		->select('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_h.part_purchase_order_reqcode','tr_part_purchase_order_h.part_purchase_order_date','tr_part_purchase_order_h.part_purchase_order_operator','tr_part_purchase_order_h.part_purchase_order_supplier','ms_supplier.supp_desc',(DB::raw('sum(tr_part_purchase_order_d.part_purchase_order_qty * tr_part_purchase_order_d.part_purchase_order_price) as total_price')),'tr_part_purchase_order_h.part_purchase_order_mgr','ms_employee.emp_name as mgr','tr_part_purchase_order_h.part_purchase_order_approved','ms_employee_2.emp_name as Appoved')
    		->WhereBetween('tr_part_purchase_order_h.part_purchase_order_date', [$date_start,$date_end])
            ->groupBy('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_h.part_purchase_order_reqcode','tr_part_purchase_order_h.part_purchase_order_date','tr_part_purchase_order_h.part_purchase_order_operator','tr_part_purchase_order_h.part_purchase_order_supplier','ms_supplier.supp_desc','tr_part_purchase_order_h.part_purchase_order_mgr','ms_employee.emp_name','tr_part_purchase_order_h.part_purchase_order_approved','ms_employee_2.emp_name')
    		->orderBy('tr_part_purchase_order_h.part_purchase_order_h_code', 'ASC')
    		->get();


         //$group = DB::table('sparepart_vendor')
           //     ->where('kode_vendor', $po->part_purchase_order_supplier)
             //   ->get();

    	return view('sparepart.purchase_order.index',compact('po'));
    }

    public function cari(Request $request)
    {
    	if(request()->date != ''){
            $date = explode(' - ' ,request()->date);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $po = DB::connection('sqlsrv')
    		->table('tr_part_purchase_order_h')
            ->join('tr_part_purchase_order_d','tr_part_purchase_order_h.part_purchase_order_h_code','=','tr_part_purchase_order_d.part_purchase_order_h_code')
    		->join('ms_supplier','tr_part_purchase_order_h.part_purchase_order_supplier','=','ms_supplier.supp_code')
    		->join('ms_employee','tr_part_purchase_order_h.part_purchase_order_mgr','=','ms_employee.emp_id')
    		->join('ms_employee as ms_employee_2','tr_part_purchase_order_h.part_purchase_order_approved','=','ms_employee_2.emp_id')
    		->select('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_h.part_purchase_order_reqcode','tr_part_purchase_order_h.part_purchase_order_date','tr_part_purchase_order_h.part_purchase_order_operator','tr_part_purchase_order_h.part_purchase_order_supplier','ms_supplier.supp_desc',(DB::raw('sum(tr_part_purchase_order_d.part_purchase_order_qty * tr_part_purchase_order_d.part_purchase_order_price) as total_price')),'tr_part_purchase_order_h.part_purchase_order_mgr','ms_employee.emp_name as mgr','tr_part_purchase_order_h.part_purchase_order_approved','ms_employee_2.emp_name as Appoved')
    		->WhereBetween('tr_part_purchase_order_h.part_purchase_order_date', [$date_start,$date_end])
            ->groupBy('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_h.part_purchase_order_reqcode','tr_part_purchase_order_h.part_purchase_order_date','tr_part_purchase_order_h.part_purchase_order_operator','tr_part_purchase_order_h.part_purchase_order_supplier','ms_supplier.supp_desc','tr_part_purchase_order_h.part_purchase_order_mgr','ms_employee.emp_name','tr_part_purchase_order_h.part_purchase_order_approved','ms_employee_2.emp_name')
    		->orderBy('tr_part_purchase_order_h.part_purchase_order_h_code', 'ASC')
    		->get();

    	return view('sparepart.purchase_order.index',compact('po'));
    }

    public function view($part_purchase_order_h_code)
    {
    	$po_head = DB::connection('sqlsrv')
    		->table('tr_part_purchase_order_h')
    		->join('ms_supplier','tr_part_purchase_order_h.part_purchase_order_supplier','=','ms_supplier.supp_code')
    		->join('ms_employee','tr_part_purchase_order_h.part_purchase_order_mgr','=','ms_employee.emp_id')
    		->join('ms_employee as ms_employee_2','tr_part_purchase_order_h.part_purchase_order_approved','=','ms_employee_2.emp_id')
    		->select('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_h.part_purchase_order_reqcode','tr_part_purchase_order_h.part_purchase_order_date','tr_part_purchase_order_h.part_purchase_order_operator','tr_part_purchase_order_h.part_purchase_order_supplier','ms_supplier.supp_desc','tr_part_purchase_order_h.part_purchase_order_mgr','ms_employee.emp_name as mgr','tr_part_purchase_order_h.part_purchase_order_approved','ms_employee_2.emp_name as Appoved')
    		->Where('tr_part_purchase_order_h.part_purchase_order_h_code', $part_purchase_order_h_code)
    		->orderBy('tr_part_purchase_order_h.part_purchase_order_h_code', 'ASC')
    		->first();

       
        $group_vendor = DB::table('sparepart_vendor')
                ->where('kode_vendor', $po_head->part_purchase_order_supplier)
                ->first();

        //$date = (date('Ym'));
        $date_1 = (date('2021-08'));
        $getRow = DB::connection('sqlsrv')
                    ->table('tr_part_purchase_order_h')
                    ->select(DB::raw('count(part_purchase_order_h_code) as NoUrut'))
                    ->Where('part_purchase_order_supplier', $po_head->part_purchase_order_supplier)
                    ->Where('part_purchase_order_date', 'like', "%".$date_1."%");
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode_urut = "00".''.($rowCount );
            } else if ($rowCount < 99) {
                    $kode_urut = "0".''.($rowCount );
            } else if ($rowCount < 999) {
                    $kode_urut = ($rowCount );
            }   
        }else{
            $kode_urut = sprintf("%03s", 1);
        }


    	$po_detail = DB::connection('sqlsrv')
    		->table('tr_part_purchase_order_h')
    		->join('tr_part_purchase_order_d','tr_part_purchase_order_h.part_purchase_order_h_code','=','tr_part_purchase_order_d.part_purchase_order_h_code')
    		->join('ms_part_master','tr_part_purchase_order_d.part_purchase_order_part_code','=','ms_part_master.part_code')
    		->join('ms_partstandard','ms_part_master.part_partstandardid','=','ms_partstandard.partstandard_id')
    		->join('ms_partname','ms_part_master.part_partnameid','=','ms_partname.partname_id')
    		->select('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_d.part_purchase_order_part_code','ms_part_master.part_desc','ms_partstandard.partstandard_Desc','ms_partname.partname_desc','ms_part_master.part_sn','tr_part_purchase_order_d.part_purchase_order_qty','tr_part_purchase_order_d.part_purchase_order_price')
    		->Where('tr_part_purchase_order_h.part_purchase_order_h_code', $part_purchase_order_h_code)
    		->get();
    

    	$po_total = DB::connection('sqlsrv')
    		->table('tr_part_purchase_order_d')
    		->select(DB::raw('sum(tr_part_purchase_order_d.part_purchase_order_qty * tr_part_purchase_order_d.part_purchase_order_price) as total_price'))
    		->where('tr_part_purchase_order_d.part_purchase_order_h_code', $part_purchase_order_h_code)
    		->first();

    	return view('sparepart.purchase_order.view', compact('po_head','po_detail','po_total','group_vendor','kode_urut'));
    }

    public function pdf($part_purchase_order_h_code)
    {
        $po_head = DB::connection('sqlsrv')
            ->table('tr_part_purchase_order_h')
            ->join('ms_supplier','tr_part_purchase_order_h.part_purchase_order_supplier','=','ms_supplier.supp_code')
            ->join('ms_employee','tr_part_purchase_order_h.part_purchase_order_mgr','=','ms_employee.emp_id')
            ->join('ms_employee as ms_employee_2','tr_part_purchase_order_h.part_purchase_order_approved','=','ms_employee_2.emp_id')
            ->select('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_h.part_purchase_order_reqcode','tr_part_purchase_order_h.part_purchase_order_date','tr_part_purchase_order_h.part_purchase_order_operator','tr_part_purchase_order_h.part_purchase_order_supplier','ms_supplier.supp_desc','tr_part_purchase_order_h.part_purchase_order_mgr','ms_employee.emp_name as mgr','tr_part_purchase_order_h.part_purchase_order_approved','ms_employee_2.emp_name as Appoved')
            ->Where('tr_part_purchase_order_h.part_purchase_order_h_code', $part_purchase_order_h_code)
            ->orderBy('tr_part_purchase_order_h.part_purchase_order_h_code', 'ASC')
            ->first();

       
        $group_vendor = DB::table('sparepart_vendor')
                ->where('kode_vendor', $po_head->part_purchase_order_supplier)
                ->first();

        //$date = (date('Ym'));
        $date_1 = (date('Y-m'));
        $getRow = DB::connection('sqlsrv')
                    ->table('tr_part_purchase_order_h')
                    ->select(DB::raw('count(part_purchase_order_h_code) as NoUrut'))
                    ->Where('part_purchase_order_supplier', $po_head->part_purchase_order_supplier)
                    ->Where('part_purchase_order_date', 'like', "%".$date_1."%");
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode_urut = "00".''.($rowCount );
            } else if ($rowCount < 99) {
                    $kode_urut = "0".''.($rowCount );
            } else if ($rowCount < 999) {
                    $kode_urut = ($rowCount );
            }   
        }else{
            $kode_urut = sprintf("%03s", 1);
        }


        $po_detail = DB::connection('sqlsrv')
            ->table('tr_part_purchase_order_h')
            ->join('tr_part_purchase_order_d','tr_part_purchase_order_h.part_purchase_order_h_code','=','tr_part_purchase_order_d.part_purchase_order_h_code')
            ->join('ms_part_master','tr_part_purchase_order_d.part_purchase_order_part_code','=','ms_part_master.part_code')
            ->join('ms_partstandard','ms_part_master.part_partstandardid','=','ms_partstandard.partstandard_id')
            ->join('ms_partname','ms_part_master.part_partnameid','=','ms_partname.partname_id')
            ->select('tr_part_purchase_order_h.part_purchase_order_h_code','tr_part_purchase_order_d.part_purchase_order_part_code','ms_part_master.part_desc','ms_partstandard.partstandard_Desc','ms_partname.partname_desc','ms_part_master.part_sn','tr_part_purchase_order_d.part_purchase_order_qty','tr_part_purchase_order_d.part_purchase_order_price')
            ->Where('tr_part_purchase_order_h.part_purchase_order_h_code', $part_purchase_order_h_code)
            ->get();
    

        $po_total = DB::connection('sqlsrv')
            ->table('tr_part_purchase_order_d')
            ->select(DB::raw('sum(tr_part_purchase_order_d.part_purchase_order_qty * tr_part_purchase_order_d.part_purchase_order_price) as total_price'))
            ->where('tr_part_purchase_order_d.part_purchase_order_h_code', $part_purchase_order_h_code)
            ->first();

        $pdf = PDF::loadview('sparepart.purchase_order.pdf', compact('po_head','group_vendor','kode_urut','po_detail','po_total'));
        return $pdf->stream();
    }
}
