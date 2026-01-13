<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Perusahaan;
use App\Bank;
use App\Rekening_Fin_Comp;
use App\KategoriBuku;
use App\Pendaftaran_Cekgiro;
use App\Pendaftaran_Cekgiro_Detail;

use App\Izin_H;
use App\Izin_H_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TandaTerima_H_Controller extends Controller
{
    public function index()
    {    
        return view ('finance.tanda_terima_cek_giro_h.index');
    }

    public function getDataIzinH(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));
        
        $pendaftaran = DB::table('izin_h')
                        ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                        ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                        ->join('users','izin_h.id_user_input','=','users.id')
                        ->select('izin_h.kode_buku','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                            'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut')
                        ->groupBy('izin_h.kode_buku','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                        'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                        'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut');
        if (!isset($request->value)) {
            $pendaftaran
                        ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
        }else{
            $pendaftaran
                        ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                        ->orWhere('izin_h.kode_buku', 'like', "%$request->value%")
                        ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                        ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                        ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                        ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                        ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
        }

        $data  = $pendaftaran->get();
        $count = ($pendaftaran->count() == 0) ? 0 : $data->count();
        $output = [
            'status'  => true,
            'message' => 'success',
            'count'   => $count,
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ' ,$request->tgl_cari);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');

        $pendaftaran = DB::table('izin_h')
                        ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                        ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                        ->join('users','izin_h.id_user_input','=','users.id')
                        ->select('izin_h.kode_buku','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                            'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                            'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut')
                        ->groupBy('izin_h.kode_buku','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                        'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                        'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut');

        if (!isset($request->value)) {
            $pendaftaran
                ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end]);
        }else{
            $pendaftaran
                ->WhereBetween('izin_h.tgl_izin',[$date_start,$date_end])
                ->orWhere('izin_h.kode_buku', 'like', "%$request->value%")
                ->orWhere('perusahaans.nama_perusahaan', 'like', "%$request->value%")
                ->orWhere('banks.nama_bank', 'like', "%$request->value%")
                ->orWhere('izin_h_detail.kode_seri_warkat', 'like', "%$request->value%")
                ->orWhere('izin_h_detail.no_rekening', 'like', "%$request->value%")
                ->orWhere('izin_h_detail.jenis_warkat', 'like', "%$request->value%");
        }       
        
        $data  = $pendaftaran->get();
        $count = ($pendaftaran->count() == 0) ? 0 : $data->count();
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
        $dataDetail = DB::table('izin_h')
                ->join('izin_h_detail','izin_h.kode_buku','izin_h_detail.kode_buku')
                ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                ->select('izin_h.kode_buku','izin_h.tgl_izin','izin_h.no_izin','izin_h.no_urut',
                    'izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan','izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening',
                    'izin_h_detail.id_cek','izin_h_detail.no_cek','izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir',
                    'izin_h_detail.jenis_warkat','izin_h_detail.no_urut')
                ->where('izin_h.kode_buku', $request->no_izin)
                // ->where('izin_h_detail.kode_seri_warkat',  $request->kode_seri_warkat)
                // ->where('izin_h_detail.seri_awal',  $request->seri_awal)
                // ->where('izin_h_detail.seri_akhir',  $request->seri_akhir)
                //->orderBy('izin_h_detail.id_cek', 'ASC')
                ->get();

        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $dataDetail
        ];

        return response()->json($output, 200);
    }

    public function pdf(Request $request)
    {
        $header = DB::table('izin_h')
                    ->join('users','izin_h.id_user_input','=','users.id')
                    ->leftJoin('users as user_approval','izin_h.id_user_approval','=','user_approval.id')
                    ->leftJoin('users as user_approval_bod','izin_h.id_user_approval_bod','=','user_approval_bod.id')
                    ->select('izin_h.judul_izin','izin_h.no_izin','izin_h.tgl_izin','izin_h.no_urut','izin_h.id_user_input','users.name',
                            'izin_h.status_approval','izin_h.id_user_approval','user_approval.name as name_approval','izin_h.tgl_approval','izin_h.keterangan_approval','izin_h.kode_approval',
                            'izin_h.status_approval_bod','izin_h.id_user_approval_bod','user_approval_bod.name as name_approval_bod','izin_h.tgl_approval_bod','izin_h.keterangan_approval_bod','izin_h.kode_approval_bod')
                    ->where('izin_h.kode_buku', $request->no_izin)
                    ->first();

        $detail = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->join('users','izin_h.id_user_input','=','users.id')
                    ->select('izin_h.no_izin','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                        'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                        'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut')
                    ->groupBy('izin_h.no_izin','izin_h.tgl_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                        'izin_h_detail.kode_seri_warkat','izin_h_detail.seri_awal','izin_h_detail.seri_akhir','izin_h_detail.kode_bank',
                        'banks.nama_bank','izin_h_detail.no_rekening','izin_h_detail.jml_lembar','izin_h_detail.jenis_warkat','izin_h.id_user_input','users.name','izin_h.no_urut')
                    ->where('izin_h.kode_buku', $request->no_izin)
                    ->get();

        $total_jml = DB::table('izin_h_detail')
                        ->select(DB::raw('count(izin_h_detail.jml_lembar) as total'))
                        ->where('izin_h_detail.kode_buku', $request->no_izin) 
                        ->first();           

        $pdf = PDF::loadview('finance.tanda_terima_cek_giro_h.pdf', compact('header','detail','total_jml'))->setPaper('a4', 'portrait'); //landscape,portrait
        return $pdf->stream();
    }

    public function excel(Request $request)
    {
        // $header = DB::table('izin_h')
        //             ->join('users','izin_h.id_user_input','=','users.id')
        //             ->leftJoin('users as user_approval','izin_h.id_user_approval','=','user_approval.id')
        //             ->leftJoin('users as user_approval_bod','izin_h.id_user_approval_bod','=','user_approval_bod.id')
        //             ->select('izin_h.judul_izin','izin_h.no_izin','izin_h.tgl_izin','izin_h.no_urut','izin_h.id_user_input','users.name',
        //                     'izin_h.status_approval','izin_h.id_user_approval','user_approval.name as name_approval','izin_h.tgl_approval','izin_h.keterangan_approval','izin_h.kode_approval',
        //                     'izin_h.status_approval_bod','izin_h.id_user_approval_bod','user_approval_bod.name as name_approval_bod','izin_h.tgl_approval_bod','izin_h.keterangan_approval_bod','izin_h.kode_approval_bod')
        //             ->where('izin_h.kode_buku', $request->no_izin)
        //             ->first();

        $detail = DB::table('izin_h')
                    ->join('izin_h_detail','izin_h.kode_buku','=','izin_h_detail.kode_buku')
                    ->join('perusahaans','izin_h_detail.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                    ->join('users','izin_h.id_user_input','=','users.id')
                    ->join('izin_pengajuan_cek_giro_h','izin_h.kode_pengajuan_cek','=','izin_pengajuan_cek_giro_h.kode_pengajuan_cek')
                    ->join('ms_pembawa_resi','izin_pengajuan_cek_giro_h.kode_pembawa_resi','=','ms_pembawa_resi.id')
                    ->select('izin_h.kode_buku','izin_h_detail.id_cek','izin_h.tgl_izin','izin_h.no_izin','izin_h_detail.kode_perusahaan','perusahaans.nama_perusahaan',
                    'izin_h_detail.kode_bank','banks.nama_bank','izin_h_detail.no_rekening','izin_h.id_user_input','users.name','izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                    'ms_pembawa_resi.pembawa_resi')
                    ->where('izin_h.kode_buku', 'C-ACC100001')
                    ->get();

        // $total_jml = DB::table('izin_h_detail')
        //                 ->select(DB::raw('count(izin_h_detail.jml_lembar) as total'))
        //                 ->where('izin_h_detail.kode_buku', $request->no_izin) 
        //                 ->first();           

        return view ('finance.tanda_terima_cek_giro_h.excel', compact('detail'));
    }

    public function actionRekening(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('rekening_fin_comp')->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->leftJoin('depos','rekening_fin_comp.kode_depo','=','depos.kode_depo')
                                        ->where('rekening_fin_comp.norek','like','%'.$query.'%')
                                        ->get();
            }else{
                $data = DB::table('rekening_fin_comp')->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->leftJoin('depos','rekening_fin_comp.kode_depo','=','depos.kode_depo')
                                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih" data-norek="'.$row->norek.'" data-kodebank="'.$row->kode_bank.'" data-namabank="'.$row->nama_bank.'">
                        <td>'.$row->norek.'</td>
                        <td hidden>'.$row->kode_bank.'</td>
                        <td>'.$row->nama_bank.'</td>
                        <td>'.$row->nama_depo.'</td>
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

    public function actionCategory(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('categories_fin')
                        ->where('categories_fin.categories_name','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('categories_fin')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {   
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih_kat" data-id="'.$row->id_categories.'" data-nama="'.$row->categories_name.'">
                        <td>'.$row->id_categories.'</td>
                        <td>'.$row->categories_name.'</td>
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

    public function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('izin_pengajuan_cek_giro_h')
                        ->join('izin_pengajuan_cek_giro_d','izin_pengajuan_cek_giro_h.kode_pengajuan_cek','=','izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
                        ->join('ms_pembawa_resi','izin_pengajuan_cek_giro_h.kode_pembawa_resi','=','ms_pembawa_resi.id')
                        ->join('perusahaans','izin_pengajuan_cek_giro_d.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','izin_pengajuan_cek_giro_d.kode_bank','banks.kode_bank')
                        ->select('izin_pengajuan_cek_giro_h.kode_pengajuan_cek','izin_pengajuan_cek_giro_h.tgl_pengajuan_cek','izin_pengajuan_cek_giro_h.keterangan',
                                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                                'izin_pengajuan_cek_giro_d.kode_perusahaan',
                                'perusahaans.nama_perusahaan',
                                'izin_pengajuan_cek_giro_d.kode_bank',
                                'banks.nama_bank',
                                'izin_pengajuan_cek_giro_d.no_rekening',
                                'izin_pengajuan_cek_giro_d.banyak_buku',
                                'izin_pengajuan_cek_giro_d.jenis_buku',
                                'ms_pembawa_resi.pembawa_resi')
                        ->where('izin_pengajuan_cek_giro_h.kode_pengajuan_cek','like', '%'.$query.'%')
                        ->orWhere('izin_pengajuan_cek_giro_h.keterangan','like', '%'.$query.'%')
                        ->orWwhere('ms_pembawa_resi.pembawa_resi','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('izin_pengajuan_cek_giro_h')
                        ->join('izin_pengajuan_cek_giro_d','izin_pengajuan_cek_giro_h.kode_pengajuan_cek','=','izin_pengajuan_cek_giro_d.kode_pengajuan_cek')
                        ->join('ms_pembawa_resi','izin_pengajuan_cek_giro_h.kode_pembawa_resi','=','ms_pembawa_resi.id')
                        ->join('perusahaans','izin_pengajuan_cek_giro_d.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('banks','izin_pengajuan_cek_giro_d.kode_bank','banks.kode_bank')
                        ->select('izin_pengajuan_cek_giro_h.kode_pengajuan_cek','izin_pengajuan_cek_giro_h.tgl_pengajuan_cek','izin_pengajuan_cek_giro_h.keterangan',
                                'izin_pengajuan_cek_giro_h.kode_pembawa_resi',
                                'izin_pengajuan_cek_giro_d.kode_perusahaan',
                                'perusahaans.nama_perusahaan',
                                'izin_pengajuan_cek_giro_d.kode_bank',
                                'banks.nama_bank',
                                'izin_pengajuan_cek_giro_d.no_rekening',
                                'izin_pengajuan_cek_giro_d.banyak_buku',
                                'izin_pengajuan_cek_giro_d.jenis_buku',
                                'ms_pembawa_resi.pembawa_resi',
                                'izin_pengajuan_cek_giro_d.jml_lembar')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih" data-kode="'.$row->kode_pengajuan_cek.'" data-tgl="'.$row->tgl_pengajuan_cek.'" data-keterangan="'.$row->keterangan.'" data-kode_perusahaan="'.$row->kode_perusahaan.'" data-nama_perusahaan="'.$row->nama_perusahaan.'" data-kode_bank="'.$row->kode_bank.'" data-nama_bank="'.$row->nama_bank.'" data-no_rekening="'.$row->no_rekening.'" data-banyak_buku="'.$row->banyak_buku.'" data-jenis_buku="'.$row->jenis_buku.'" data-kode_pembawa="'.$row->kode_pembawa_resi.'" data-pembawa_resi="'.$row->pembawa_resi.'" data-jml_lembar ="'.$row->jml_lembar.'">
                        <td>'.$row->kode_pengajuan_cek.'</td>
                        <td>'.$row->tgl_pengajuan_cek.'</td>
                        <td hidden>'.$row->keterangan.'</td>
                        <td hidden>'.$row->kode_perusahaan.'</td>
                        <td>'.$row->nama_perusahaan.'</td>
                        <td hidden>'.$row->kode_bank.'</td>
                        <td>'.$row->nama_bank.'</td>
                        <td>'.$row->no_rekening.'</td>
                        <td>'.$row->banyak_buku.'</td>
                        <td>'.$row->jenis_buku.'</td>
                        <td hidden>'.$row->pembawa_resi.'</td>
                        <td>'.$row->jml_lembar.'</td>
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

    public function view($no_urut)
    {   
        $pendaftaran_head = DB::table('pendaftaran_cekgiro')
                                ->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro_detail.kode_daftar','=','pendaftaran_cekgiro.kode_daftar')
                                ->where('pendaftaran_cekgiro.no_urut', $no_urut)
                                ->first();

        $pendaftaran_detail = DB::table('pendaftaran_cekgiro')
                    ->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro_detail.kode_daftar','=','pendaftaran_cekgiro.kode_daftar')
                    //->join('categories_fin','pendaftaran_cekgiro.kode_kategori','=','categories_fin.id_categories')
                    ->join('perusahaans','pendaftaran_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('banks','pendaftaran_cekgiro.kode_bank','=','banks.kode_bank')
                    ->where('pendaftaran_cekgiro.no_urut', $no_urut)
                    ->orderBy('pendaftaran_cekgiro_detail.id_cek', 'ASC')
                    ->get();

        return view('finance.pendaftaran_cek_giro.view', compact('pendaftaran_detail','pendaftaran_head'));
    }

    public function create(Request $request)
    {
    	$perusahaan = Perusahaan::orderBy('nama_perusahaan', 'ASC')->get();
    	$bank = Bank::orderBy('kode_bank', 'ASC')->get();
        $kategori = KategoriBuku::orderBy('id_categories', 'ASC')->get();
        //$rekening_fin_comp = Rekening_Fin_Comp::orderBy('norek', 'ASC')->get();

        $rekening_fin_comp = DB::table('rekening_fin_comp')->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->leftJoin('depos','rekening_fin_comp.kode_depo','=','depos.kode_depo')->get();

        $getRow = Pendaftaran_Cekgiro::orderBy('kode_daftar', 'DESC')->get();
        $rowCount = $getRow->count();

        $lastId = $getRow->first();

        //$kode = "0000001";
        $kode = "1";

        if ($rowCount > 0) {
           
            $kode = $rowCount + 1;
        } 
    	return view('finance.tanda_terima_cek_giro_h.create',  compact('perusahaan','bank','rekening_fin_comp','kode','kategori'));
    }

    public function store(Request $request)
    {
        $getRow = DB::table('izin_h')
            ->select(DB::raw('MAX(kode_izin) as NoUrut'));
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

        $kode_daftar = 'REG '.$kode.''.'/'.''.$bulan_romawi.''.'/'.''.$tahun;

        $getRow_urut = DB::table('izin_h')->select(DB::raw('COUNT(kode_izin) as NoUrut'))->first();
        if ($getRow_urut->NoUrut > 0) {
            $no_urut = $getRow_urut->NoUrut + 1;
        }else{
            $no_urut = 1;
        }
        
        Izin_H::create([
            'kode_izin' => $kode_daftar,
            'tgl_izin' => Carbon::now()->format('Y-m-d'),
            'no_izin' => $request->get('no_izin'),
            'judul_izin' => $request->get('judul_izin'),
            'catatan' =>  $request->get('catatan'),
            'no_urut' => $no_urut,
            'id_user_input' => Auth::user()->id
        ]);

        //detail
        $datas=[];
        foreach ($request->input('kode_cek') as $key => $value) {

        }

        $validator = Validator::make($request->all(), $datas);
        foreach ($request->input("kode_cek") as $key => $value) {
            $data = new Izin_H_Detail();
            $data->kode_izin = $kode_daftar;
            $data->kode_perusahaan = $request->get("perusahaan_rincian")[$key];
            $data->kode_bank = $request->get("bank_rincian")[$key];
            $data->no_rekening = $request->get("no_rek_rincian")[$key];
            $data->id_cek = $request->get("kode_cek")[$key];
            $data->no_cek = $request->get("no_cek")[$key];
            $data->kode_seri_warkat = $request->get("seri_warkat_rincian")[$key];
            $data->seri_awal = $request->get("awal_rincian")[$key];
            $data->seri_akhir = $request->get("akhir_rincian")[$key];
            $data->jenis_warkat = $request->get("jenis_rincian")[$key];
            $data->jml_lembar = $request->get("jml_lembar_rincian")[$key];
            $data->no_urut = $no_urut;
            $data->save();
        }
        alert()->success('Success.','Pendaftaran Berhasil di simpan');
        return redirect()->route('tanda_terima_h.index');
    }
}
