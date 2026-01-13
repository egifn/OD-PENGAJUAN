<?php

namespace App\Http\Controllers\Accounting;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Acc_DueDate_alfred;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use Auth;

class DueDateAlfredController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $perusahaan_dms = DB::table('perusahaans')->get();
        $depo_dms = DB::table('depos')->get();

        //======== DB TUA =======================================================//
        $jt = DB::connection('sqlsrv_alfred') //sqlsrv_alfred
                        ->table('dms_ar_arinvoice')
                        ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                        ->whereBetween('dms_ar_arinvoice.dtmdoc', ['1900-01-01','1900-01-01'])
                        ->get();

        /**======== DB TU =======================================================//
        $jt_tu = DB::connection('mysql_tu')
                        ->table('dms_ar_arinvoice')
                        ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                        ->whereBetween('dms_ar_arinvoice.dtmdoc',['',''])
                        ->get();
        //======== DB TA =======================================================//
        $jt_ta = DB::connection('mysql_ta')
                        ->table('dms_ar_arinvoice')
                        ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                        ->whereBetween('dms_ar_arinvoice.dtmdoc',['',''])
                        ->get();
        //=====================================================================// **/

    	return view ('accounting.due_date_alfred.index', compact('perusahaan_dms','depo_dms','jt'));
    }

    public function duedatecari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $start_dms = '';
        $end_dms = '';

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->customer != '' and request()->docId == '' ){ //jika customer tidak kosong dan docId kosong
            $getRow = DB::connection('sqlsrv_alfred')
                    ->table('dms_ar_arinvoice')
                    ->Where('dms_ar_arinvoice.szCustomerId', request()->customer)
                    ->Where('dms_ar_arinvoice.bClosed', 0)
                    ->get();
            $rowCount = $getRow->count();
            if ($rowCount > 0) {
                 $jt = DB::connection('sqlsrv_alfred')
                            ->table('dms_ar_arinvoice')
                            ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                            ->Where('dms_ar_arinvoice.szCustomerId', request()->customer)
                            ->Where('dms_ar_arinvoice.bClosed', 0)
                            ->orderBy('dms_ar_arinvoice.dtmDue', 'ASC')
                            ->get();
            }else{
                // return abort(404);
                $jt = DB::connection('sqlsrv_alfred')
                    ->table('dms_ar_arinvoice')
                    ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                    ->whereBetween('dms_ar_arinvoice.dtmdoc', ['-','-'])
                    ->get();
            }
        }elseif(request()->customer == '' and request()->docId != '' ){ //jika customer kosong dan docId tidak kosong
            $getRow = DB::connection('sqlsrv_alfred')
                    ->table('dms_ar_arinvoice')
                    ->Where('dms_ar_arinvoice.szDocId', request()->docId)
                    ->Where('dms_ar_arinvoice.bClosed', 0)
                    ->get();
            $rowCount = $getRow->count();
            if ($rowCount > 0) {
                 $jt = DB::connection('sqlsrv_alfred')
                            ->table('dms_ar_arinvoice')
                            ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                            ->Where('dms_ar_arinvoice.szDocId', request()->docId)
                            ->Where('dms_ar_arinvoice.bClosed', 0)
                            ->orderBy('dms_ar_arinvoice.dtmDue', 'ASC')
                            ->get();
            }else{
                //return abort(404);
                $jt = DB::connection('sqlsrv_alfred')
                    ->table('dms_ar_arinvoice')
                    ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                    ->whereBetween('dms_ar_arinvoice.dtmdoc', ['-','-'])
                    ->get();
            }
        }elseif(request()->customer != '' and request()->docId != '' ){ //jika customer tidak kosong dan docId tidak kosong
            $getRow = DB::connection('sqlsrv_alfred')
                    ->table('dms_ar_arinvoice')
                    ->Where('dms_ar_arinvoice.szDocId', request()->docId)
                    ->Where('dms_ar_arinvoice.bClosed', 0)
                    ->get();
            $rowCount = $getRow->count();
            if ($rowCount > 0) {
                 $jt = DB::connection('sqlsrv_alfred')
                            ->table('dms_ar_arinvoice')
                            ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                            ->Where('dms_ar_arinvoice.szCustomerId', request()->customer)
                            ->Where('dms_ar_arinvoice.szDocId', request()->docId)
                            ->Where('dms_ar_arinvoice.bClosed', 0)
                            ->orderBy('dms_ar_arinvoice.dtmDue', 'ASC')
                            ->get();
            }else{
                // return abort(404);
                $jt = DB::connection('sqlsrv_alfred')
                    ->table('dms_ar_arinvoice')
                    ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                    ->whereBetween('dms_ar_arinvoice.dtmdoc', ['-','-'])
                    ->get();
            }
        }
        return view ('accounting.due_date_alfred.index', compact('jt'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datas=[];
        foreach ($request->input('szDocId') as $key => $value) {
            
        }

        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input("szDocId") as $key => $value) {
                if($request->get("tanggal")[$key] != ''){
                    $data = new Acc_DueDate_alfred;

                    $data->doc_id = $request->get('szDocId')[$key];
                    $data->customer_id = $request->get("customer_id")[$key];
                    $data->customer_name = $request->get("customer_name")[$key];
                    $data->amount = $request->get("amount")[$key];
                    $data->remain = $request->get("remain")[$key];
                    $data->doc_date = $request->get("dtm_doc")[$key];
                    $data->due_date = $request->get("dtm_due")[$key];
                    $data->due_date_updated = $request->get("tanggal")[$key];
                    //$data->kode_perusahaan = Auth::user()->kode_perusahaan; 
                    $data->id_user = Auth::user()->id;
					$data->time_update = Carbon::now()->format('H:i:s');
                    $data->save();

                    //update due_date DMS
                    $update_duedate = DB::connection('sqlsrv_alfred')->table('dms_ar_arinvoice')
                                    ->select('dms_ar_arinvoice.szDocId')
                                    ->Where('dms_ar_arinvoice.szDocId', $request->get('szDocId')[$key])
                                    ->update([
                                        'dtmDue' =>  $request->get("tanggal")[$key]
                                    ]);
                }
            }
        }

        $jt = DB::connection('sqlsrv_alfred')
                        ->table('dms_ar_arinvoice')
                        ->join('dms_ar_customer','dms_ar_arinvoice.szCustomerId','=','dms_ar_customer.szId')
                        ->Where('dms_ar_arinvoice.szCustomerId', request()->customer)
                        ->Where('dms_ar_arinvoice.bClosed', 0)
                        ->get();

        return view ('accounting.due_date_alfred.index', compact('jt'));
    }
    
}
