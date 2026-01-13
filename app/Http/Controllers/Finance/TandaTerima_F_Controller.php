<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Tanda_Terima_Cek_Vendor;
use App\Tanda_Terima_Cek_Vendor_Detail;
use App\Pengisian_Cekgiro_Detail;

use App\Izin_F;
use App\Izin_F_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TandaTerima_F_Controller extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_izin_f = DB::table('izin_f')
            ->join('izin_f_detail', 'izin_f.kode_izin_f', '=', 'izin_f_detail.kode_izin_f')
            ->join('users', 'izin_f.id_user_input', '=', 'users.id')
            ->join('ms_pembawa_resi', 'izin_f.id_user_pengaju', '=', 'ms_pembawa_resi.id')
            ->select(
                'izin_f.kode_izin_f',
                'izin_f.tgl_izin_f',
                'izin_f.no_izin_f',
                'izin_f.judul_izin_f',
                'izin_f.no_urut',
                'izin_f.id_user_input',
                'users.name',
                'izin_f.id_user_pengaju',
                'ms_pembawa_resi.pembawa_resi'
            )
            ->WhereBetween('izin_f.tgl_izin_f', [$date_start,$date_end])
            ->groupBy(
                'izin_f.kode_izin_f',
                'izin_f.tgl_izin_f',
                'izin_f.no_izin_f',
                'izin_f.judul_izin_f',
                'izin_f.no_urut',
                'izin_f.id_user_input',
                'users.name',
                'izin_f.id_user_pengaju',
                'ms_pembawa_resi.pembawa_resi'
            )
            ->orderBy('izin_f.kode_izin_f', 'ASC')
            ->get();

        return view('finance.tanda_terima_cek_giro_f.index', compact('data_izin_f'));
    }

    public function cari(Request $request)
    {
        if (request()->tanggal != '') {
            $date = explode(' - ', request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        } else {
            $date_start = (date('Y-m-d'));
            $date_end = (date('Y-m-d'));
        }

        $data_izin_f = DB::table('izin_f')
            ->join('izin_f_detail', 'izin_f.kode_izin_f', '=', 'izin_f_detail.kode_izin_f')
            ->join('users', 'izin_f.id_user_input', '=', 'users.id')
            ->join('ms_pembawa_resi', 'izin_f.id_user_pengaju', '=', 'ms_pembawa_resi.id')
            ->select(
                'izin_f.kode_izin_f',
                'izin_f.tgl_izin_f',
                'izin_f.no_izin_f',
                'izin_f.judul_izin_f',
                'izin_f.no_urut',
                'izin_f.id_user_input',
                'users.name',
                'izin_f.id_user_pengaju',
                'ms_pembawa_resi.pembawa_resi'
            )
            ->WhereBetween('izin_f.tgl_izin_f', [$date_start,$date_end])
            ->groupBy(
                'izin_f.kode_izin_f',
                'izin_f.tgl_izin_f',
                'izin_f.no_izin_f',
                'izin_f.judul_izin_f',
                'izin_f.no_urut',
                'izin_f.id_user_input',
                'users.name',
                'izin_f.id_user_pengaju',
                'ms_pembawa_resi.pembawa_resi'
            )
            ->orderBy('izin_f.kode_izin_f', 'ASC')
            ->get();

        return view('finance.tanda_terima_cek_giro_f.index', compact('data_izin_f'));
    }

    public function getDataIzinB(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));
        
        $data_izin_b = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('perusahaans','izin_b_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                        ->join('users','izin_b.id_user_input','=','users.id')
                        ->select('izin_b.no_izin_b','izin_b.tgl_izin_b','izin_b.judul_izin_b','izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir','izin_b_detail.kode_bank',
                            'banks.nama_bank','izin_b_detail.no_rekening','izin_b.id_user_input','users.name','izin_b.no_urut')
                        ->groupBy('izin_b.no_izin_b','izin_b.tgl_izin_b','izin_b.judul_izin_b','izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                        'izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir','izin_b_detail.kode_bank',
                        'banks.nama_bank','izin_b_detail.no_rekening','izin_b.id_user_input','users.name','izin_b.no_urut');
        if (!isset($request->value)) {
            $data_izin_b
                        ->WhereBetween('izin_b.tgl_izin_b',[$date_start,$date_end]);
        }else{
            $data_izin_b
                        ->WhereBetween('izin_b.tgl_izin_b',[$date_start,$date_end])
                        ->orWhere('izin_b.no_izin_b', 'like', "%$request->value%")
                        ->orWhere('izin_b.judul_izin_b', 'like', "%$request->value%")
                        ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                        ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                        ->orWhere('izin_b_detail.kode_seri_warkat', 'like', "%$request->value%")
                        ->orWhere('izin_b_detail.no_rekening', 'like', "%$request->value%");
        }

        $data  = $data_izin_b->get();
        $count = ($data_izin_b->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function getViewDetail(Request $request)
    {
        $dataDetail = DB::table('izin_b')
                ->join('izin_b_detail','izin_b.kode_izin_b','izin_b_detail.kode_izin_b')
                ->join('perusahaans','izin_b_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                ->join('vendors','izin_b_detail.kode_vendor','=','vendors.kode_vendor')
                ->join('banks as bank_vendor','izin_b_detail.kode_bank_vendor','=','bank_vendor.kode_bank')
                ->select('izin_b.kode_izin_b','izin_b.tgl_izin_b','izin_b.no_izin_b','izin_b.no_urut',
                    'izin_b_detail.kode_perusahaan','perusahaans.nama_perusahaan','izin_b_detail.kode_bank','banks.nama_bank','izin_b_detail.no_rekening',
                    'izin_b_detail.id_cek','izin_b_detail.kode_seri_warkat','izin_b_detail.seri_awal','izin_b_detail.seri_akhir',
                    'izin_b_detail.kode_vendor','vendors.nama_vendor','izin_b_detail.atas_nama','izin_b_detail.kode_bank_vendor','bank_vendor.nama_bank as nama_bank_vendor','izin_b_detail.no_rekening_vendor',
                    'izin_b_detail.no_urut')
                ->where('izin_b.no_urut', $request->no_urut)
                // ->where('izin_h_detail.kode_seri_warkat',  $request->kode_seri_warkat)
                // ->where('izin_h_detail.seri_awal',  $request->seri_awal)
                // ->where('izin_h_detail.seri_akhir',  $request->seri_akhir)
                ->orderBy('izin_b_detail.id_cek', 'ASC')
                ->get();

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $dataDetail
        ];

        return response()->json($output, 200);
    }

    public function pdf($no_urut)
    {
        $header = DB::table('izin_f')
                    ->join('users','izin_f.id_user_input','=','users.id')
                    ->join('ms_pembawa_resi','izin_f.id_user_pengaju','=','ms_pembawa_resi.id')
                    ->leftJoin('users as user_approval','izin_f.id_user_approval','=','user_approval.id')
                    ->select('izin_f.kode_izin_f','izin_f.tgl_izin_f','izin_f.no_izin_f','izin_f.judul_izin_f','izin_f.id_user_input','users.name',
                                'izin_f.id_user_pengaju','ms_pembawa_resi.pembawa_resi','izin_f.id_user_approval','user_approval.name AS approval','izin_f.tgl_approval')
                    ->where('izin_f.no_urut', $no_urut)
                    ->first();
        
        $detail = DB::table('izin_f')
                    ->join('izin_f_detail','izin_f.kode_izin_f','=','izin_f_detail.kode_izin_f')
                    ->join('rekening_fin_comp','izin_f_detail.no_rekening','=','rekening_fin_comp.norek')
                    ->join('banks','izin_f_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_f.kode_izin_f','izin_f.tgl_izin_f','izin_f.no_izin_f','izin_f.judul_izin_f','izin_f_detail.keterangan','izin_f_detail.id_cek',
                                'izin_f_detail.kode_seri_warkat','izin_f_detail.seri_awal','izin_f_detail.seri_akhir',
                                'rekening_fin_comp.kode_perusahaan','izin_f_detail.kode_bank','banks.nama_bank','izin_f_detail.no_rekening')
                    ->groupBy('izin_f.kode_izin_f','izin_f.tgl_izin_f','izin_f.no_izin_f','izin_f.judul_izin_f','izin_f_detail.keterangan','izin_f_detail.id_cek',
                                'izin_f_detail.kode_seri_warkat','izin_f_detail.seri_awal','izin_f_detail.seri_akhir',
                                'rekening_fin_comp.kode_perusahaan','izin_f_detail.kode_bank','banks.nama_bank','izin_f_detail.no_rekening')
                    ->where('izin_f.no_urut', $no_urut)
                    ->get();            

        $total_jml = DB::table('izin_f_detail')
                        ->select(DB::raw('count(izin_f_detail.kode_izin_f) as total'))
                        ->where('izin_f_detail.no_urut', $no_urut) 
                        ->first();           

        $pdf = PDF::loadview('finance.tanda_terima_cek_giro_f.pdf', compact('header','detail','total_jml'))->setPaper('a4', 'potrait'); //landscape,portrait
        return $pdf->stream();
    }

    public function create(Request $request)
    { 
        $seri_warkat = DB::table('izin_h')
                        ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                        ->select('izin_h.kode_buku','izin_h.no_izin','izin_h_detail.kode_seri_warkat')
                        ->where('izin_h.status_approval_bod', 1)
                        ->groupBy('izin_h.kode_buku','izin_h.no_izin','izin_h_detail.kode_seri_warkat')
                        ->get();

        $perusahaan = DB::table('perusahaans')
                        ->select('perusahaans.kode_perusahaan','perusahaans.nama_perusahaan')
                        ->orderBy('kode_perusahaan', 'ASC')
                        ->get();

    	return view('finance.tanda_terima_cek_giro_f.create', compact('seri_warkat','perusahaan'));
    }

    public function ajax_seri_warkat(Request $request)
    {
        $kd_seri_warkat = DB::table('izin_h')
                            ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                            ->where('izin_h_detail.kode_seri_warkat', $request->kd_seri)
                            ->pluck('no_cek','id_cek');
        return response()->json($kd_seri_warkat);
    }

    public function ajax_perusahaan_bank(Request $request)
    {
        $perusahaan_bank = DB::table('rekening_fin_comp')
                            ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                            ->select('rekening_fin_comp.kode_bank','banks.nama_bank')
                            ->where('rekening_fin_comp.kode_perusahaan', $request->perusahaan_id)
                            ->pluck('kode_bank','nama_bank');
        return response()->json($perusahaan_bank);
    }

    public function ajax_perusahaan_bank_rekening(Request $request)
    {
        $perusahaan_bank_rekening = DB::table('rekening_fin_comp')
                            ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                            ->select('rekening_fin_comp.kode_bank','rekening_fin_comp.norek')
                            ->where('rekening_fin_comp.kode_perusahaan', $request->perusahaan_id)
                            ->where('rekening_fin_comp.kode_bank', $request->bank_id)
                            ->pluck('norek','norek');
        return response()->json($perusahaan_bank_rekening);
    }

    public function actionVendor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('rekening_fin')
                                ->join('vendors','rekening_fin.kode_vendor','=','vendors.kode_vendor')
                                ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                                ->select('rekening_fin.kode_vendor','vendors.nama_vendor','rekening_fin.atas_nama','rekening_fin.kode_bank','banks.nama_bank','rekening_fin.norek')
                                ->where('rekening_fin.kode_vendor','like','%'.$query.'%')
                                ->orWhere('vendors.nama_vendor','like','%'.$query.'%')
                                ->orWhere('rekening_fin.atas_nama','like','%'.$request.'%')
                                ->orWhere('banks.nama_bank','like','%'.$request.'%')
                                ->orWhere('rekening_fin.norek','like','%'.$request.'%')
                                ->get();
            }else{
                $data = DB::table('rekening_fin')
                                ->join('vendors','rekening_fin.kode_vendor','=','vendors.kode_vendor')
                                ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                                ->select('rekening_fin.kode_vendor','vendors.nama_vendor','rekening_fin.atas_nama','rekening_fin.kode_bank','banks.nama_bank','rekening_fin.norek')
                                ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_vendor" data-kodevendor="'.$row->kode_vendor.'" data-namavendor="'.$row->nama_vendor.'" data-atasnama="'.$row->atas_nama.'" data-kodebank="'.$row->kode_bank.'" data-namabank="'.$row->nama_bank.'" data-norek="'.$row->norek.'">
                            <td>'.$row->kode_vendor.'</td>
                            <td>'.$row->nama_vendor.'</td>
                            <td>'.$row->atas_nama.'</td>
                            <td hidden>'.$row->kode_bank.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->norek.'</td>
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
                $data = DB::table('pengisian_cekgiro')
                ->join('pengisian_cekgiro_detail','pengisian_cekgiro.kode_pengisian','=','pengisian_cekgiro_detail.kode_pengisian')
                ->join('spp','pengisian_cekgiro_detail.no_spp','=','spp.no_spp')
                ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                ->select('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro.description','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro_detail.total_spp','pengisian_cekgiro_detail.total_cek','pengisian_cekgiro.tgl_pengisian','pengisian_cekgiro.kode_perusahaan','spp.for','banks.nama_bank','spp.pembayaran','rekening_fin.atas_nama')
                ->Where('pengisian_cekgiro_detail.status', 0)
                ->Where('pengisian_cekgiro_detail.id_cek','like','%'.$query.'%')
                ->orderBy('pengisian_cekgiro_detail.id_cek','ASC')
                ->get();
            }else{
                $data = DB::table('pengisian_cekgiro')
                ->join('pengisian_cekgiro_detail','pengisian_cekgiro.kode_pengisian','=','pengisian_cekgiro_detail.kode_pengisian')
                ->join('spp','pengisian_cekgiro_detail.no_spp','=','spp.no_spp')
                ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                ->select('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro.description','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro_detail.total_spp','pengisian_cekgiro_detail.total_cek','pengisian_cekgiro.tgl_pengisian','pengisian_cekgiro.kode_perusahaan','spp.for','banks.nama_bank','spp.pembayaran','rekening_fin.atas_nama')
                ->Where('pengisian_cekgiro_detail.status', 0)
                ->orderBy('pengisian_cekgiro_detail.id_cek','ASC')
                ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih" data-description="'.$row->description.'" data-totalspp="'.number_format($row->total_spp).'" data-total="'.number_format($row->total_cek).'" data-cek="'.$row->id_cek.'" data-tanggal="'.$row->tgl_pengisian.'" data-perusahaan="'.$row->kode_perusahaan.'" data-pembayaran="'.$row->pembayaran.'" data-for="'.$row->for.'" data-bank="'.$row->nama_bank.'" data-an="'.$row->atas_nama.'">
                            <td>'.$row->kode_pengisian.'</td>
                            <td hidden>'.$row->description.'</td>
                            <td>'.$row->id_cek.'</td>
                            <td align="right">'. number_format($row->total_spp).'</td>
                            <td align="right" hidden>'. number_format($row->total_cek).'</td>
                            <td hidden>'.$row->tgl_pengisian.'</td>
                            <td hidden>'.$row->kode_perusahaan.'</td>
                            
                            <td hidden>'. $row->pembayaran.'</td>
                            <td>'.$row->for.'</td>
                            <td hidden>'.$row->nama_bank.'</td>
                            <td hidden>'.$row->atas_nama.'</td>
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

    public function action_seri_awal(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.no_cek')
                    ->Where('izin_h_detail.status', 1)
                    ->Where('izin_h_detail.id_cek','like','%'.$query.'%')
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }else{
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.no_cek')
                    ->Where('izin_h_detail.status', 1)
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_seri_awal" data-kode_buku="'.$row->kode_buku.'" data-no_izin="'.$row->no_izin.'" data-kode_perusahaan="'.$row->kode_perusahaan.'" data-nama_perusahaan="'.$row->nama_perusahaan.'" data-kode_bank="'.$row->kode_bank.'" data-nama_bank="'.$row->nama_bank.'" data-no_rek="'.$row->no_rekening.'" data-id_cek="'.$row->id_cek.'" data-kode_seri="'.$row->kode_seri_warkat.'" data-no_cek="'.$row->no_cek.'">
                            <td>'.$row->kode_buku.'</td>
                            <td>'.$row->no_izin.'</td>
                            <td>'.$row->judul_izin.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->id_cek.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->no_rekening.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="7">No Data Found</td>
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

    public function action_seri_akhir(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek')
                    ->Where('izin_h_detail.status', 1)
                    ->Where('izin_h_detail.id_cek','like','%'.$query.'%')
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }else{
                $data = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->select('izin_h.kode_buku','izin_h.no_izin','izin_h.judul_izin',
                            'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                            'izin_h_detail.id_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.no_cek')
                    ->Where('izin_h_detail.status', 1)
                    //->orderBy('izin_h_detail.id_cek','ASC')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_seri_akhir" data-kode_buku="'.$row->kode_buku.'" data-no_izin="'.$row->no_izin.'" data-no_rek="'.$row->no_rekening.'" data-id_cek="'.$row->id_cek.'">
                            <td>'.$row->kode_buku.'</td>
                            <td>'.$row->no_izin.'</td>
                            <td>'.$row->judul_izin.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->id_cek.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->no_rekening.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="7">No Data Found</td>
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
        $getRow = DB::table('izin_f')
            ->select(DB::raw('MAX(kode_izin_f) as NoUrut'));
        $rowCount = $getRow->count();

        $kode = "0001";

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                $kode = "000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                $kode = "00".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                $kode = "0".''.($rowCount + 1);
            } else {
                $kode = ''.($rowCount + 1);
            }
        }
        
        $tahun = date('Y', strtotime(now()));
        $bulan = date('m', strtotime(now()));

        if ($bulan == '01'){
            $bulan_romawi = 'I'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
        }
        
        $kode_daftar = 'f '.$kode.''.'/'.''.$bulan_romawi.''.'/'.''.$tahun;

        $getRow_urut = DB::table('izin_f')->select(DB::raw('COUNT(kode_izin_f) as NoUrut'))->first();
        if ($getRow_urut->NoUrut > 0) {
            $no_urut = $getRow_urut->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        Izin_F::create([
            'kode_izin_f' => $kode_daftar,
            'tgl_izin_f' => Carbon::now()->format('Y-m-d'),
            'no_izin_f' => $request->get('no_izin'),
            'judul_izin_f' => $request->get('judul_izin'),
            'catatan_f' =>  $request->get('catatan'),
            'no_urut' => $no_urut,
            'id_user_input' => Auth::user()->id,
            'id_user_pengaju' => $request->get('kode_pengaju')
        ]);

        $datas=[];
        foreach ($request->input('seri_awal') as $key => $value) {
            
        }

        $validator = Validator::make($request->all(), $datas);
        foreach ($request->input('seri_awal') as $key => $value) {
            $jml_lembar = 0;
            $jml = 0;
            for($i = $request->get("seri_awal")[$key]; $i <= $request->get("seri_akhir")[$key]; $i++){
                $seri_awal = $request->get("no_cek")[$key];
               
                $hasil_jumlah = intval($seri_awal) + $jml;
                $tambah_otomatis = $request->get("kode_warkat")[$key] . ' ' . sprintf('%0' . strlen($seri_awal) . 'd', $hasil_jumlah);
                
                $data = new Izin_F_Detail();
                $data->kode_izin_f = $kode_daftar;
                $data->keterangan = $request->get("tbl_keterangan")[$key];
                $data->id_cek = $request->get("kode_seri")[$key];
                $data->kode_seri_warkat = $request->get("kode_warkat")[$key];
                $data->no_cek = $tambah_otomatis;
                $data->seri_awal = $request->get("seri_awal")[$key]; 
                $data->seri_akhir = $request->get("seri_akhir")[$key];
                $data->kode_perusahaan = $request->get("kode_perusahaan")[$key];
                $data->kode_bank = $request->get("kode_bank")[$key];
                $data->no_rekening = $request->get("no_rek")[$key];
                $data->jml_lembar = 0;
                $data->no_urut = $no_urut;
                $data->status = 0;
                $data->save();

                $update_cek = DB::table('izin_h_detail')
                            ->select('izin_h_detail.id_cek')
                            ->Where('izin_h_detail.kode_buku', $request->get("kode_seri")[$key])
                            ->Where('izin_h_detail.id_cek', $tambah_otomatis)
                            ->update([
                                'status' => 2,
                            ]);
                $jml++;
            }
        }

        alert()->success('Berhasil.','Izin F Berhasil dibuat');
        return redirect()->route('tanda_terima_f.index');
    }

    // public function pdf($receipt_id)
    // {
    //     $tanda_terima_head = DB::table('tanda_terima_cek')
    //             ->Where('tanda_terima_cek.receipt_id', $receipt_id)
    //             ->first();

    //     $tanda_terima_detail = DB::table('tanda_terima_cek')
    //             ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
    //             ->Where('tanda_terima_cek.receipt_id', $receipt_id)
    //             ->get();

    //     $total_jml = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
    //                             ->get()->sum('total');

    //     $count = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
    //                             ->get()->count('receipt_id');

    //     $pdf = PDF::loadview('finance.tanda_terima_cek_giro_b.pdf', compact('tanda_terima_head','tanda_terima_detail','total_jml','count'))->setPaper('a4', 'landscape');
    //     return $pdf->stream();
    // }

    public function approved(Request $request)
    {
        // $approved = DB::table('tanda_terima_cek')
        //                 ->select('tanda_terima_cek.receipt_id')
        //                 ->Where('tanda_terima_cek.receipt_id', $request->get("receipt_id"))
        //                 ->update([
        //                     'status' => 4, //status kirim
        //                     'date_send' => Carbon::now()->format('Y-m-d'),
        //                 ]);

        // $datas = [];
        // foreach ($request->input('no_spp') as $key => $value) {
               
        // }
        // $validator = Validator::make($request->all(), $datas);
           
        // foreach ($request->input("no_spp") as $key => $value) {
        //         $isi_cek = DB::table('kontrabon')
        //                     ->select('kontrabon.id_cek')
        //                     ->Where('kontrabon.no_kontrabon', $request->get("no_kontrabon")[$key])
        //                     ->update([
        //                         'status' => 2,
        //                     ]);
        // }
           
        // alert()->success('Success.','Request Approved...');
        // return redirect()->route('tanda_terima_f.index');
    }
}
