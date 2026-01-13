<?php

namespace App\Http\Controllers\Coa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Coa_Transaksi;
use App\Coa_Transaksi_Detail;
use Carbon\carbon;
use Auth;
use DB;

class AccountTransaksiController extends Controller
{
    public function index()
    {   
        //$account =  DB::table('coa_transaksi')
        //        ->orderBy('coa_transaksi.no', 'ASC')
        //        ->get();
        $account = DB::table('coa_transaksi')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                        ->select('coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->groupBy('coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();

    	return view('coa.index_transaksi', compact('account'));
    }

    public function create(Request $request)
    {	
        $getRow = DB::table('coa_transaksi')->select(DB::raw('MAX(no) as NoUrut'));
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
            $no_urut = $rowCount + 1;
        }else{
            $no_urut = 1;
        }

    	return view('coa.create_transaksi', compact('no_urut'));
    }

    public function actionCoa(Request $request)
    {
    	if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('coa_lv4')
                    	->join('coa_lv3','coa_lv4.kode_lv3','=','coa_lv3.kode_lv3')
                    	->join('coa_lv2','coa_lv3.kode_lv2','=','coa_lv2.kode_lv2')
                    	->join('coa_lv1','coa_lv2.kode_lv1','=','coa_lv1.kode_lv1')
                    	->select('coa_lv4.kode_lv4','coa_lv1.account_name as account_lv_1','coa_lv2.account_name as account_lv_2','coa_lv3.account_name AS account_lv_3','coa_lv4.account_name AS account_lv_4')
                        ->Where('coa_lv4.kode_lv4','like','%'.$query.'%')
                        ->orWhere('coa_lv1.account_name','like','%'.$query.'%')
                        ->orWhere('coa_lv2.account_name','like','%'.$query.'%')
                        ->orWhere('coa_lv3.account_name','like','%'.$query.'%')
                        ->orWhere('coa_lv4.account_name','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('coa_lv4')
                        ->join('coa_lv3','coa_lv4.kode_lv3','=','coa_lv3.kode_lv3')
                        ->join('coa_lv2','coa_lv3.kode_lv2','=','coa_lv2.kode_lv2')
                        ->join('coa_lv1','coa_lv2.kode_lv1','=','coa_lv1.kode_lv1')
                    	->select('coa_lv4.kode_lv4','coa_lv1.account_name as account_lv_1','coa_lv2.account_name as account_lv_2','coa_lv3.account_name AS account_lv_3','coa_lv4.account_name AS account_lv_4')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_coa" data-kode_coa="'.$row->kode_lv4.'" data-coa="'.$row->account_lv_4.'">
                            <td>'.$row->kode_lv4.'</td>
                            <td>'.$row->account_lv_1.'</td>
                            <td>'.$row->account_lv_2.'</td>
                            <td>'.$row->account_lv_3.'</td>
                            <td>'.$row->account_lv_4.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function actionCoaKredit(Request $request)
    {
    	if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('coa_lv4')
                    	->join('coa_lv3','coa_lv4.kode_lv3','=','coa_lv3.kode_lv3')
                    	->join('coa_lv2','coa_lv3.kode_lv2','=','coa_lv2.kode_lv2')
                    	->join('coa_lv1','coa_lv2.kode_lv1','=','coa_lv1.kode_lv1')
                    	->select('coa_lv4.kode_lv4','coa_lv1.account_name as account_lv_1','coa_lv2.account_name as account_lv_2','coa_lv3.account_name AS account_lv_3','coa_lv4.account_name AS account_lv_4')
                        ->Where('coa_lv4.kode_lv4','like','%'.$query.'%')
                        ->orWhere('coa_lv1.account_name','like','%'.$query.'%')
                        ->orWhere('coa_lv2.account_name','like','%'.$query.'%')
                        ->orWhere('coa_lv3.account_name','like','%'.$query.'%')
                        ->orWhere('coa_lv4.account_name','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('coa_lv4')
                        ->join('coa_lv3','coa_lv4.kode_lv3','=','coa_lv3.kode_lv3')
                        ->join('coa_lv2','coa_lv3.kode_lv2','=','coa_lv2.kode_lv2')
                        ->join('coa_lv1','coa_lv2.kode_lv1','=','coa_lv1.kode_lv1')
                    	->select('coa_lv4.kode_lv4','coa_lv1.account_name as account_lv_1','coa_lv2.account_name as account_lv_2','coa_lv3.account_name AS account_lv_3','coa_lv4.account_name AS account_lv_4')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_coa_kredit" data-kode_coa_kredit="'.$row->kode_lv4.'" data-coa_kredit="'.$row->account_lv_4.'">
                            <td>'.$row->kode_lv4.'</td>
                            <td>'.$row->account_lv_1.'</td>
                            <td>'.$row->account_lv_2.'</td>
                            <td>'.$row->account_lv_3.'</td>
                            <td>'.$row->account_lv_4.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode' => 'required',
            'account_desc' => 'required'
        ]);

        Coa_Transaksi::create([
            'no' => $request->get('kode'),
            'nama_transaksi' => $request->get('account_desc'),
            'id_user_input' => Auth::user()->id
        ]);

        // DEBET===================================================
        $datas=[];
        foreach ($request->input('kode_coa') as $key => $value) {
            $datas["kode_coa.{$key}"] = 'required';
            $datas["coa.{$key}"] = 'required'; 
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input('kode_coa') as $key => $value) {
                $data = new Coa_Transaksi_Detail;

                $data->no = $request->get('kode');
                $data->id_debit = $request->get("kode_coa")[$key];

                $data->save();
            }
        }

        // CREDIT===================================================
        $datas=[];
        foreach ($request->input('kode_coa_kredit') as $key => $value) {
            $datas["kode_coa_kredit.{$key}"] = 'required';
            $datas["coa_kredit.{$key}"] = 'required'; 
        }
        $validator = Validator::make($request->all(), $datas);
        if($validator->passes()){
            foreach ($request->input('kode_coa_kredit') as $key => $value) {
                $data = new Coa_Transaksi_Detail;

                $data->no = $request->get('kode');
                $data->id_kredit = $request->get("kode_coa_kredit")[$key];

                $data->save();
            }
        }

        alert()->success('Success.','New request has been created');
        return redirect()->route('coa_transaction.index');
    }
}
