<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Tanda_Terima_Cek_Vendor;
use App\Tanda_Terima_Cek_Vendor_Detail;
use App\Pengisian_Cekgiro_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TandaTerimaController extends Controller
{
    public function index()
    {	
    	$receipt = DB::table('tanda_terima_cek')->join('users','tanda_terima_cek.id_user_input','=','users.id')
                                                ->Where('tanda_terima_cek.keterangan_id','like','C%')
    											->orderBy('tanda_terima_cek.receipt_id', 'ASC')
    											->get();

    	return view('finance.tandaterima_cek_giro.index', compact('receipt'));
    }

    public function view($receipt_id)
    {
        $tanda_terima_head = DB::table('tanda_terima_cek')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->first();

        // $tanda_terima_detail = DB::table('tanda_terima_cek')
        //         ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
        //         ->select('tanda_terima_cek.receipt_id','tanda_terima_cek_detail.jenis_pengeluaran','tanda_terima_cek_detail.total','tanda_terima_cek_detail.cek_giro','tanda_terima_cek_detail.tanggal','tanda_terima_cek_detail.kd_perusahaan','tanda_terima_cek_detail.bank','tanda_terima_cek_detail.norek_perusahaan','tanda_terima_cek_detail.vendor','tanda_terima_cek_detail.atas_nama','tanda_terima_cek_detail.bank_vendor','tanda_terima_cek_detail.norek_vendor')
        //         ->Where('tanda_terima_cek.receipt_id', $receipt_id)
        //         ->get();

        $tanda_terima_detail = DB::table('tanda_terima_cek')
                ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
                ->join('pengisian_cekgiro_detail','tanda_terima_cek_detail.cek_giro','=','pengisian_cekgiro_detail.id_cek')
                ->join('spp','pengisian_cekgiro_detail.no_spp','=','spp.no_spp')
                ->select('tanda_terima_cek.receipt_id','tanda_terima_cek_detail.jenis_pengeluaran','tanda_terima_cek_detail.total','tanda_terima_cek_detail.cek_giro','tanda_terima_cek_detail.tanggal','tanda_terima_cek_detail.kd_perusahaan','tanda_terima_cek_detail.bank','tanda_terima_cek_detail.norek_perusahaan','tanda_terima_cek_detail.vendor','tanda_terima_cek_detail.atas_nama','tanda_terima_cek_detail.bank_vendor','tanda_terima_cek_detail.norek_vendor','tanda_terima_cek_detail.status','pengisian_cekgiro_detail.no_spp','spp.no_kontrabon')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->get();

        $total_jml = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->sum('total');

        $count = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->count('receipt_id');

        return view('finance.tandaterima_cek_giro.view',compact('tanda_terima_head','tanda_terima_detail','total_jml','count'));
    }

    public function actionCek(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                        ->select('izin_b.kode_izin_b','izin_b.no_izin_b','izin_b_detail.keterangan','izin_b_detail.id_cek',
                        'izin_b_detail.kode_perusahaan','izin_b_detail.kode_bank','banks.nama_bank','izin_b_detail.no_rekening')
                        ->get();
            }else{
                $data = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                        ->select('izin_b.kode_izin_b','izin_b.no_izin_b','izin_b_detail.keterangan','izin_b_detail.id_cek',
                        'izin_b_detail.kode_perusahaan','izin_b_detail.kode_bank','banks.nama_bank','izin_b_detail.no_rekening')
                        ->get();
                
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_cek" data-kode="'.$row->kode_izin_b.'" data-id_cek="'.$row->id_cek.'" data-kode_perusahaan="'.$row->kode_perusahaan.'" data-kode_bank="'.$row->kode_bank.'" data-nama_bank="'.$row->nama_bank.'" data-no_rek="'.$row->no_rekening.'">
                            <td hidden>'.$row->kode_izin_b.'</td>
                            <td>'.$row->id_cek.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->no_rekening.'</td>
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

    public function actionModalCek(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                        ->select('izin_b.kode_izin_b','izin_b.no_izin_b','izin_b_detail.keterangan','izin_b_detail.id_cek',
                        'izin_b_detail.kode_perusahaan','izin_b_detail.kode_bank','banks.nama_bank','izin_b_detail.no_rekening')
                        ->get();
            }else{
                $data = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                        ->select('izin_b.kode_izin_b','izin_b.no_izin_b','izin_b_detail.keterangan','izin_b_detail.id_cek',
                        'izin_b_detail.kode_perusahaan','izin_b_detail.kode_bank','banks.nama_bank','izin_b_detail.no_rekening')
                        ->get();
                
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_modal_cek" data-kode="'.$row->kode_izin_b.'" data-id_modal_cek="'.$row->id_cek.'">
                            <td hidden>'.$row->kode_izin_b.'</td>
                            <td>'.$row->id_cek.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->no_rekening.'</td>
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

    public function actionCekgiro(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('spp')
                ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                ->join('vendors','spp.kode_vendor','=','vendors.kode_vendor')
                ->select('spp.no_spp','spp.keterangan','spp.jumlah','spp.kode_vendor','vendors.nama_vendor','spp.for','spp.pembayaran','banks.kode_bank','banks.nama_bank','rekening_fin.atas_nama')
                ->Where('spp.status', 0)
                ->Where('spp.no_spp','like','%'.$query.'%')
                ->orderBy('spp.no_spp','ASC')
                ->get();
            }else{
                $data = DB::table('spp')
                ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                ->join('vendors','spp.kode_vendor','=','vendors.kode_vendor')
                ->select('spp.no_spp','spp.keterangan','spp.jumlah','spp.kode_vendor','vendors.nama_vendor','spp.for','spp.pembayaran','banks.kode_bank','banks.nama_bank','rekening_fin.atas_nama')
                ->Where('spp.status', 0)
                ->orderBy('spp.no_spp','ASC')
                ->get();
                
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih" data-spp="'.$row->no_spp.'" data-keterangan="'.$row->keterangan.'" data-totalspp="'.number_format($row->jumlah).'" data-kode_vendor="'.$row->kode_vendor.'" data-nama_vendor="'.$row->nama_vendor.'" data-norek="'.$row->pembayaran.'" data-kode_bank="'.$row->kode_bank.'" data-bank="'.$row->nama_bank.'" data-an="'.$row->atas_nama.'">
                            <td>'.$row->no_spp.'</td>
                            <td>'.$row->keterangan.'</td>
                            <td align="right">'. number_format($row->jumlah).'</td>
                            <td>'.$row->nama_vendor.'</td>
                            <td>'.$row->pembayaran.'</td>
                            <td>'. $row->nama_bank.'</td>
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

    public function create(Request $request)
    {	
    	$date = (date('Ym'));
        $date_1 = (date('Ymd'));
        $id = 'C';

        $getRow = DB::table('tanda_terima_cek')->select(DB::raw('MAX(RIGHT(receipt_id,6)) as NoUrut'))
        										->where('receipt_id', 'like', "%".$date."%");
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $receipt = $date_1."00000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $receipt = $date_1."0000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $receipt = $date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $receipt = $date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $receipt = $date_1."0".''.($rowCount + 1);
            } else {
                    $receipt = $date_1.($rowCount + 1);
            }
        }else{
            $receipt = $date_1.sprintf("%06s", 1);
        } 

        $getRowCode = DB::table('tanda_terima_cek')->select(DB::raw('count(keterangan_id) as NoUrut'))
                                ->Where('keterangan_id', 'like', "%".$id."%");
        $rowCountCode = $getRowCode->count();
        if ($rowCountCode > 0) {
            $keterangan_id = "C-".''.($rowCountCode + 1);
        }else{
            $keterangan_id = "C-1";
        }

    	$cek_giro = DB::table('pengisian_cekgiro')->join('pengisian_cekgiro_detail','pengisian_cekgiro.kode_pengisian','=','pengisian_cekgiro_detail.kode_pengisian')
    					->join('perusahaans','pengisian_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
    					->join('categories_fin','pengisian_cekgiro.id_categories','=','categories_fin.id_categories')
    					->join('categories_fin_sub','pengisian_cekgiro.id_sub_categories','=','categories_fin_sub.id_sub_categories')
    					->join('pendaftaran_cekgiro_detail','pengisian_cekgiro_detail.id_cek','=','pendaftaran_cekgiro_detail.id_cek')
    					->join('pendaftaran_cekgiro','pendaftaran_cekgiro_detail.kode_daftar','=','pendaftaran_cekgiro.kode_daftar')
    					->join('banks','pendaftaran_cekgiro.kode_bank','=','banks.kode_bank')
    					->where('pengisian_cekgiro_detail.status', 0)
    					->get();

    	return view('finance.tandaterima_cek_giro.create', compact('cek_giro','receipt','keterangan_id'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            //'no_spp' => 'required|string|max:255',
            //'kontrabon' => 'required|string|max:255',
            //'no_order' => 'required|string|max:255'

            //'no_spp' => 'required|string|max:255'
        ]); 

        Tanda_Terima_Cek_Vendor::create([
        	'receipt_id' => $request->get('receipt'),
        	'date_receipt' => Carbon::parse($request->get('tgl_receipt')),
            'penerima' => $request->get('penerima'),
        	'keterangan' => $request->get('description'),
            'keterangan_id' => $request->get('description_id'),
        	'status' => '0',
        	'id_user_input' => Auth::user()->id
        ]);

        $datas = [];
        foreach ($request->input('cek') as $key => $value) {
            $datas["desc.{$key}"] = 'required';
            $datas["total.{$key}"] = 'required'; 
            $datas["cek.{$key}"] = 'required';
            $datas["tanggal.{$key}"] = 'required';
            $datas["perusahaan.{$key}"] = 'required';
            $datas["bank.{$key}"] = 'required';
            $datas["pembayaran.{$key}"] = 'required';
            $datas["for_1.{$key}"] = 'required';
            $datas["atas_nama.{$key}"] = 'required';
            $datas["bank_vendor.{$key}"] = 'required';
            $datas["norek_vendor.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
        
        foreach ($request->input("cek") as $key => $value) {
            $data = new Tanda_Terima_Cek_Vendor_Detail;

            $data->receipt_id = $request->get('receipt');
            $data->jenis_pengeluaran = $request->get("desc")[$key];
            $data->total = str_replace(",", "", $request->get("total")[$key]);
            $data->cek_giro = $request->get("cek")[$key];
            $data->tanggal = $request->get("tanggal")[$key];
            $data->kd_perusahaan = $request->get("perusahaan")[$key];
            $data->bank = $request->get("bank")[$key];
            $data->norek_perusahaan = $request->get("pembayaran")[$key];
            $data->vendor = $request->get("for_1")[$key];
            $data->atas_nama = $request->get("atas_nama")[$key];
            $data->bank_vendor = $request->get("bank_vendor")[$key];;
            $data->norek_vendor = $request->get("norek_vendor")[$key];;
            $data->status = '0';

            $data->save();

            $cekgiro_update = DB::table('pengisian_cekgiro_detail')->where('id_cek', $request->get("cek")[$key])
                          ->update([
                              'status' => 1
                          ]);
        }
        
        alert()->success('Success.','New Receipt successfully created');
        return redirect()->route('tanda_terima.index');
    }

    public function pdf($receipt_id)
    {
        $tanda_terima_head = DB::table('tanda_terima_cek')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->first();

        $tanda_terima_detail = DB::table('tanda_terima_cek')
                ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->get();

        $total_jml = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->sum('total');

        $count = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->count('receipt_id');

    	$pdf = PDF::loadview('finance.tandaterima_cek_giro.pdf', compact('tanda_terima_head','tanda_terima_detail','total_jml','count'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function approved(Request $request)
    {
        $approved = DB::table('tanda_terima_cek')
                        ->select('tanda_terima_cek.receipt_id')
                        ->Where('tanda_terima_cek.receipt_id', $request->get("receipt_id"))
                        ->update([
                            'status' => 4, //status kirim
                            'date_send' => Carbon::now()->format('Y-m-d'),
                        ]);

        $datas = [];
        foreach ($request->input('no_spp') as $key => $value) {
               
        }
        $validator = Validator::make($request->all(), $datas);
            
        foreach ($request->input("no_spp") as $key => $value) {
            $isi_cek = DB::table('kontrabon')
                            ->select('kontrabon.id_cek')
                            ->Where('kontrabon.no_kontrabon', $request->get("no_kontrabon")[$key])
                            ->update([
                                'status' => 2,
            ]);
        }
            

        alert()->success('Success.','Request Approved...');
        return redirect()->route('tanda_terima.index');
    }
}
