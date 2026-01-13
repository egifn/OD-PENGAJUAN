<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Data_Pelunasan;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekonPelunasanController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_piutang = DB::table('data_pelunasan')
                        ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                        ->Where('data_pelunasan.status_validasi', 0)
                        ->get();

        $total_piutang = DB::table('data_pelunasan')
                    ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                    ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                    ->Where('data_pelunasan.status_validasi', 0)
                    ->first();

        $pelunasan = DB::table('data_pelunasan')
                        ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                        ->Where('data_pelunasan.status_ceklis', 1)
                        ->Where('data_pelunasan.status_validasi', 0)
                        ->get();

        $total = DB::table('data_pelunasan')
                    ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                    ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                    ->Where('data_pelunasan.status_ceklis', 1)
                    ->Where('data_pelunasan.status_validasi', 0)
                    ->first();

        $catatan_rek = DB::table('catatan_rekenings')
                        ->join('catatan_saldo','catatan_rekenings.description','=','catatan_saldo.description')
                        ->select('catatan_rekenings.id','catatan_rekenings.tanggal_rek','catatan_rekenings.norek','catatan_rekenings.description','catatan_rekenings.nilai')
                        ->WhereBetween(DB::raw('DATE(catatan_saldo.updated_at)'), [$date_start,$date_end])
                        ->where('catatan_saldo.status', 1)
                        ->get();

        $total_catatan_rek = DB::table('catatan_rekenings')
                                ->join('catatan_saldo','catatan_rekenings.description','=','catatan_saldo.description')
                                ->select(DB::raw('SUM(catatan_rekenings.nilai) as total_catatan_rekening'))
                                ->WhereBetween(DB::raw('DATE(catatan_saldo.updated_at)'), [$date_start,$date_end])
                                ->where('catatan_saldo.status', 1)
                                ->first();

    	return view('rekon.pelunasan.index', compact('data_piutang','total_piutang','pelunasan','total','catatan_rek','total_catatan_rek'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data_piutang = DB::table('data_pelunasan')
                        ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                        ->Where('data_pelunasan.status_validasi', 0)
                        ->get();

        $total_piutang = DB::table('data_pelunasan')
                    ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                    ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                    ->Where('data_pelunasan.status_validasi', 0)
                    ->first();

        $pelunasan = DB::table('data_pelunasan')
                        ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                        ->Where('data_pelunasan.status_ceklis', 1)
                        ->Where('data_pelunasan.status_validasi', 0)
                        ->get();

        $total = DB::table('data_pelunasan')
                    ->select(DB::raw('SUM(data_pelunasan.nominal) as total'))
                    ->WhereBetween('data_pelunasan.tanggal', [$date_start,$date_end])
                    ->Where('data_pelunasan.status_ceklis', 1)
                    ->Where('data_pelunasan.status_validasi', 0)
                    ->first();

        $catatan_rek = DB::table('catatan_rekenings')
                    ->join('catatan_saldo','catatan_rekenings.description','=','catatan_saldo.description')
                    ->select('catatan_rekenings.id','catatan_rekenings.tanggal_rek','catatan_rekenings.norek','catatan_rekenings.description','catatan_rekenings.nilai')
                    ->WhereBetween(DB::raw('DATE(catatan_saldo.updated_at)'), [$date_start,$date_end])
                    ->where('catatan_saldo.status', 1)
                    ->get();

        $total_catatan_rek = DB::table('catatan_rekenings')
                            ->join('catatan_saldo','catatan_rekenings.description','=','catatan_saldo.description')
                            ->select(DB::raw('SUM(catatan_rekenings.nilai) as total_catatan_rekening'))
                            ->WhereBetween(DB::raw('DATE(catatan_saldo.updated_at)'), [$date_start,$date_end])
                            ->where('catatan_saldo.status', 1)
                            ->first();

        return view('rekon.pelunasan.index', compact('data_piutang','total_piutang','pelunasan','total','catatan_rek','total_catatan_rek'));
    }

    public function getDmsInvoice(Request $request)
    {

        // $query = DB::connection('mysql_tua')
        //         ->table('dms_cas_bgpayment')
        //         ->where('dms_cas_bgpayment.szId', 'MTR/DAKOTA4/EQ 107536/220822')
        //         ->get();

        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');

            

            if($query != ''){
                $data = DB::connection('mysql_tua')
                    ->table('dms_cas_bgpayment')
                    //->where('dms_cas_bgpayment.szId', 'like','%'.$query.'%')
                    ->where('dms_cas_bgpayment.szId', $query)
                    ->get();
            }else{
                $data = DB::connection('mysql_tua')
                    ->table('dms_cas_bgpayment')
                    ->where('dms_cas_bgpayment.szId', $query)
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                        <td>'.$row->szId.'</td>
                        <td>'.$row->szCustomerId.'</td>
                        <td>'.$row->szRefInvoiceId.'</td>
                        <td>'.$row->szPaymentType.'</td>
                        <td>'.$row->decAmount.'</td>
                        <td>'.$row->szStatus.'</td>
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

    public function approval(Request $request)
    {
        $datas = [];
        foreach ($request->input('no_cek_k') as $key => $value) {
           
        }

        $validator = Validator::make($request->all(), $datas);
        // if($validator->passes()){
            $no = 1;
            foreach ($request->input('no_cek_k') as $key => $value) {
                if($request->get("chk_k".$no) == 1){
                    $chkd = 1; 
                    $status_valid = 'Terima';
                }else{
                    $chkd = 2;
                    $status_valid = 'Tolak'; 
                }
                $stock = DB::table('data_pelunasan')
                        ->select('data_pelunasan.status_validasi','data_pelunasan.status_cek')
                        ->Where('data_pelunasan.no_cek', $request->get("no_cek_k")[$key])
                        ->update([
                            'status_validasi' => $chkd,
                            'status_cek' => $status_valid
                ]);
                $no++;
            }
        // }

        alert()->success('Berhasil.','Pengiriman Data Pelunasan Berhasil...');
        return redirect()->route('rekon_pelunasan.index');


    }
}
