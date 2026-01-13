<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Category;
use App\Divisi;
use App\Product;
use App\Pengajuan;
use App\Pengajuan_Detail;
use App\Pengajuan_Upload;
use App\Pengajuan_Temp;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {   
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_divisi == '0') {
            $pengajuan = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->leftJoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('users as users_1','pengajuan.id_user_input','=','users_1.id')
                                            ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->select('pengajuan.no_urut','pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','users_1.name as input_by','pengajuan.jenis','pengajuan.status_pengajuan','users.name as app_as','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_atasan','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                            ->get();
        }else{
            if (Auth::user()->kode_divisi == '9') {
                $pengajuan = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->leftJoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('users as users_1','pengajuan.id_user_input','=','users_1.id')
                                            ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->select('pengajuan.no_urut','pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','users_1.name as input_by','pengajuan.jenis','pengajuan.status_pengajuan','users.name as app_as','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_atasan','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->WhereIn('pengajuan.kode_divisi', ['30','9','32','24'])
                                            ->orWhere('pengajuan.status_atasan', 0)
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->WhereIn('pengajuan.kode_divisi', ['30','9','32','24'])
                                            ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                            ->get();
            }else{
                $pengajuan = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->leftJoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('users as users_1','pengajuan.id_user_input','=','users_1.id')
                                            ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->select('pengajuan.no_urut','pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','users_1.name as input_by','pengajuan.jenis','pengajuan.status_pengajuan','users.name as app_as','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_atasan','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->Where('pengajuan.kode_divisi', Auth::user()->kode_divisi)
                                            ->orWhere('pengajuan.status_atasan', 0)
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->Where('pengajuan.kode_divisi', Auth::user()->kode_divisi)
                                            ->orderBy('pengajuan.tgl_pengajuan', 'ASC')
                                            ->get();
            }
        }

        $kode_pengajuan = request()->view_app;
    	return view ('pengajuan.pengajuan.index', compact('pengajuan')); //,'approved'
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_divisi == '0') {
            $pengajuan = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->leftJoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('users as users_1','pengajuan.id_user_input','=','users_1.id')
                                            ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->select('pengajuan.no_urut','pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','users_1.name as input_by','pengajuan.jenis','pengajuan.status_pengajuan','users.name as app_as','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_atasan','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                            ->get();
        }else{
            if (Auth::user()->kode_divisi == '9') {
                $pengajuan = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->leftJoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('users as users_1','pengajuan.id_user_input','=','users_1.id')
                                            ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->select('pengajuan.no_urut','pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','users_1.name as input_by','pengajuan.jenis','pengajuan.status_pengajuan','users.name as app_as','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_atasan','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->WhereIn('pengajuan.kode_divisi', ['30','9','32','24'])
                                            ->orWhere('pengajuan.status_atasan', 0)
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->WhereIn('pengajuan.kode_divisi', ['30','9','32','24'])
                                            ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                                            ->get();
            }else{
                $pengajuan = DB::table('pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                            ->leftJoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                            ->join('users as users_1','pengajuan.id_user_input','=','users_1.id')
                                            ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                            ->select('pengajuan.no_urut','pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','users_1.name as input_by','pengajuan.jenis','pengajuan.status_pengajuan','users.name as app_as','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_atasan','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc')
                                            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->Where('pengajuan.kode_divisi', Auth::user()->kode_divisi)
                                            ->orWhere('pengajuan.status_atasan', 0)
                                            ->Where('pengajuan.kode_perusahaan', Auth::user()->kode_perusahaan)
                                            ->Where('pengajuan.kode_depo', Auth::user()->kode_depo)
                                            ->Where('pengajuan.kode_divisi', Auth::user()->kode_divisi)
                                            ->orderBy('pengajuan.status_atasan', 'ASC')
                                            ->get();
            }
        }

        return view ('pengajuan.pengajuan.index', compact('pengajuan')); //,'approved'


    }

    public function actionApproved(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('pengajuan')
                    ->leftjoin('users as user_atasan','pengajuan.id_user_approval_atasan','=','user_atasan.id')
                    ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                    ->leftjoin('users as user_ga','pengajuan.id_user_approval_ga','=','user_ga.id')
                    ->leftjoin('users as user_ops','pengajuan.id_user_approval_ops','=','user_ops.id')
                    ->leftjoin('users as user_pc','pengajuan.id_user_approval_pc','=','user_pc.id')
                    ->select(
                        'user_atasan.name AS atasan',
                        DB::raw('(CASE WHEN pengajuan.status_atasan = 1 THEN Approved WHEN pengajuan.status_atasan = 2 THEN Denied WHEN pengajuan.status_atasan = 3 THEN Pending END) AS status_atasan'),
                        'users.name as it',
                        DB::raw('(CASE WHEN pengajuan.status_it = 1 THEN Approved WHEN pengajuan.status_it = 2 THEN Denied WHEN pengajuan.status_it = 3 THEN Pending END) as AS status_it'),
                        'user_ga.name as ga',
                        DB::raw('(CASE WHEN pengajuan.status_ga = 1 THEN Approved WHEN pengajuan.status_ga = 2 THEN Denied WHEN pengajuan.status_ga = 3 THEN Pending END) AS  AS status_ga'),
                        'user_ops.name as ops',
                        DB::raw('(CASE WHEN pengajuan.status_ops = 1 THEN Approved WHEN pengajuan.status_ops = 2 THEN Denied WHEN pengajuan.status_ops = 3 THEN Pending END) AS AS status_ops'),
                        'user_pc.name as pc',
                        DB::raw('(CASE WHEN pengajuan.status_pc = 1 THEN Approved WHEN pengajuan.status_pc = 2 THEN Denied WHEN pengajuan.status_pc = 3 THEN Pending END) AS AS status_pc'),
                        'pengajuan.kode_pengajuan',
                        'pengajuan.jenis'
                        )
                    ->where('pengajuan.kode_pengajuan', $query)
                    ->get();
            }else{
               $data = DB::table('pengajuan')
                    ->leftjoin('users as user_atasan','pengajuan.id_user_approval_atasan','=','user_atasan.id')
                    ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                    ->leftjoin('users as user_ga','pengajuan.id_user_approval_ga','=','user_ga.id')
                    ->leftjoin('users as user_ops','pengajuan.id_user_approval_ops','=','user_ops.id')
                    ->leftjoin('users as user_pc','pengajuan.id_user_approval_pc','=','user_pc.id')
                    ->select(
                        'user_atasan.name AS atasan',
                        DB::raw('(CASE WHEN pengajuan.status_atasan = 1 THEN Approved WHEN pengajuan.status_atasan = 2 THEN Denied WHEN pengajuan.status_atasan = 3 THEN Pending END) AS status_atasan'),
                        'users.name as it',
                        DB::raw('(CASE WHEN pengajuan.status_it = 1 THEN Approved WHEN pengajuan.status_it = 2 THEN Denied WHEN pengajuan.status_it = 3 THEN Pending END) as AS status_it'),
                        'user_ga.name as ga',
                        DB::raw('(CASE WHEN pengajuan.status_ga = 1 THEN Approved WHEN pengajuan.status_ga = 2 THEN Denied WHEN pengajuan.status_ga = 3 THEN Pending END) AS  AS status_ga'),
                        'user_ops.name as ops',
                        DB::raw('(CASE WHEN pengajuan.status_ops = 1 THEN Approved WHEN pengajuan.status_ops = 2 THEN Denied WHEN pengajuan.status_ops = 3 THEN Pending END) AS AS status_ops'),
                        'user_pc.name as pc',
                        DB::raw('(CASE WHEN pengajuan.status_pc = 1 THEN Approved WHEN pengajuan.status_pc = 2 THEN Denied WHEN pengajuan.status_pc = 3 THEN Pending END) AS AS status_pc'),
                        'pengajuan.kode_pengajuan',
                        'pengajuan.jenis'
                        )
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr>
                            <td>'.$row->it.'</td>
                            <td>'.$row->ga.'</td>
                            <td>'.$row->ops.'</td>
                            <td>'.$row->pc.'</td>
                            <td>'.$query.'</td>
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
            
            if(Auth::user()->kode_divisi == '27'){ //TGSM
                if($query != ''){
                    $data = DB::table('ms_pengeluaran')
                            ->leftJoin('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
                            ->leftJoin('coa_transaksi_detail','coa_transaksi.no','=','coa_transaksi_detail.no')
                            ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi',
                                DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                                DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                            ->whereIn('ms_pengeluaran.id', (['8','9','31','26','19','53','54','55']))
                            ->orWhere('ms_pengeluaran.id','like','%'.$query.'%')
                            ->orWhere('ms_pengeluaran.nama_pengeluaran','like','%'.$query.'%')
                            ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi')
                            ->get();
                }else{
                    $data = DB::table('ms_pengeluaran')
                            ->leftJoin('coa_transaksi','ms_pengeluaran.coa','coa_transaksi.no')
                            ->leftJoin('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                             ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi',
                                DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                                DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                            ->whereIn('ms_pengeluaran.id', (['8','9','31','26','19','53','54','55']))
                            ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi')
                            ->get();
                }
            }else{ //Bukan TGSM
                if($query != ''){
                    $data = DB::table('ms_pengeluaran')
                            ->leftJoin('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
                            ->leftJoin('coa_transaksi_detail','coa_transaksi.no','=','coa_transaksi_detail.no')
                            ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi',
                                DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                                DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                            ->whereIn('ms_pengeluaran.id', (['8','9','31','19','53','54','55']))
                            ->orWhere('ms_pengeluaran.id','like','%'.$query.'%')
                            ->orWhere('ms_pengeluaran.nama_pengeluaran','like','%'.$query.'%')
                            ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi')
                            ->get();
                }else{
                    $data = DB::table('ms_pengeluaran')
                            ->leftJoin('coa_transaksi','ms_pengeluaran.coa','coa_transaksi.no')
                            ->leftJoin('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                             ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi',
                                DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                                DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                            ->whereIn('ms_pengeluaran.id', (['8','9','31','19','53','54','55']))
                            ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi')
                            ->get();
                }
            }
            
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_category" data-id="'.$row->id.'" data-nama_pengeluaran="'.$row->nama_pengeluaran.'" data-sifat="'.$row->sifat.'" data-jenis="'.$row->jenis.'" data-pembayaran="'.$row->pembayaran.'" data-kategori="'.$row->kategori.'" data-coa="'.$row->coa.'" data-kode_coa="'.$row->no.'" data-nama_coa="'.$row->nama_transaksi.'" data-debit="'.$row->debit_1.'" data-kredit="'.$row->kredit_1.'">
                            <td>'.$row->id.'</td>
                            <td>'.$row->nama_pengeluaran.'</td>
                            <td>'.$row->sifat.'</td>
                            <td hidden>'.$row->jenis.'</td>
                            <td hidden>'.$row->pembayaran.'</td>
                            <td hidden>'.$row->kategori.'</td>
                            <td hidden>'.$row->coa.'</td>
                            <td hidden>'.$row->no.'</td>
                            <td hidden>'.$row->nama_transaksi.'</td>
                            <td hidden>'.$row->debit_1.'</td>
                            <td hidden>'.$row->kredit_1.'</td>
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


    public function actionProduct(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                
						
				$data = DB::table('products')
						->join('categories', 'products.category_id', '=', 'categories.id')
						->whereRaw('(products.status_barang = 1 AND (products.kode LIKE ? OR products.nama_barang LIKE ? OR categories.name LIKE ?))', ['%'.$query.'%', '%'.$query.'%', '%'.$query.'%'])
						->get();
				
				
            }else{
                $data = DB::table('products')
                        ->join('categories','products.category_id','=','categories.id')
						->where('products.status_barang', 1)
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih" data-kode_kategori="'.$row->id.'" data-kategori="'.$row->name.'" data-kode_produk="'.$row->kode.'" data-nama_produk="'.$row->nama_barang.'" data-merk="'.$row->merk.'" data-ket="'.$row->ket.'" data-price="'.$row->price.'" data-satuan="'.$row->satuan.'">
                        <td hidden>'.$row->id.'</td>
                        <td>'.$row->name.'</td>
                        <td>'.$row->kode.'</td>
                        <td>'.$row->nama_barang.'</td>
                        <td>'.$row->merk.'</td>
                        <td>'.$row->ket.'</td>
                        <td>'.$row->satuan.'</td>
                        <td>'.$row->price.'</td>
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

    public function actionProduct_tgsm(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('products_tgsm')
                        ->join('categories','products_tgsm.category_id','=','categories.id')
                        ->where('products_tgsm.kode','like','%'.$query.'%')
                        ->orWhere('products_tgsm.nama_barang','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('products_tgsm')
                        ->join('categories','products_tgsm.category_id','=','categories.id')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih_tgsm" data-kode_produk="'.$row->kode_produk.'" data-nama_produk="'.$row->nama_produk.'" data-id_cat="'.$row->category_id.'" data-nama_cat="'.$row->name.'">
                        <td>'.$row->kode_produk.'</td>
                        <td>'.$row->nama_produk.'</td>
                        <td hidden>'.$row->category_id.'</td>
                        <td hidden>'.$row->name.'</td>
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
        if(Auth::user()->kode_divisi == '27'){ //-- Jika TGSM--
            $cari_jenis_pengeluaran = DB::table('pengajuan')
                                    ->select('pengajuan.jenis')
                                    ->where('pengajuan.no_urut', $no_urut)
                                    ->first();
            if($cari_jenis_pengeluaran->jenis == '26'){ // jika pengajuan material TGSM
                $pengajuan_v = DB::table('pengajuan')
                            ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                            ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                            ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                            ->join('users','pengajuan.id_user_input','=','users.id')
                            ->join('products_tgsm','pengajuan_detail.kode_product','=','products_tgsm.kode_produk')
                            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                            ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo',
                            'depos.nama_depo','pengajuan.jenis as kode_jenis','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran',
                            'pengajuan.id_user_input','users.name')
                            ->where('pengajuan.no_urut', $no_urut)->first();

                $details = DB::table('pengajuan_detail')
                        ->join('products_tgsm','pengajuan_detail.kode_product','=','products_tgsm.kode_produk')
                        ->join('categories','pengajuan_detail.id_kategori','=','categories.id')
                        ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
                        ->where('pengajuan_detail.no_urut', $no_urut)->get();

                $pengajuan_upload = DB::table('pengajuan_upload')
                                    ->select('pengajuan_upload.filename')
                                    ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                                    ->get();
            }else{
                $pengajuan_v = DB::table('pengajuan')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->join('products','pengajuan_detail.kode_product','=','products.kode')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','pengajuan.kode_depo',
                        'pengajuan.kode_divisi','pengajuan.keterangan as keterangan_pengajuan','pengajuan.id_user_input','perusahaans.nama_perusahaan','depos.nama_depo',
                        'pengajuan.jenis as kode_jenis','users.name','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.keterangan','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran')
                        ->where('pengajuan.no_urut', $no_urut)->first();

                $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')->join('categories','pengajuan_detail.id_kategori','=','categories.id')->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')->where('pengajuan_detail.no_urut', $no_urut)->get();

                $pengajuan_upload = DB::table('pengajuan_upload')
                                    ->select('pengajuan_upload.filename')
                                    ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                                    ->get();
            }
        }else{
            $pengajuan_v = DB::table('pengajuan')
                        ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('users','pengajuan.id_user_input','=','users.id')
                        ->join('products','pengajuan_detail.kode_product','=','products.kode')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.kode_perusahaan','pengajuan.kode_depo',
                        'pengajuan.kode_divisi','pengajuan.keterangan as keterangan_pengajuan','pengajuan.id_user_input','perusahaans.nama_perusahaan','depos.nama_depo',
                        'users.name','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.keterangan','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran')
                        ->where('pengajuan.no_urut', $no_urut)->first();

            $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')->join('categories','pengajuan_detail.id_kategori','=','categories.id')->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')->where('pengajuan_detail.no_urut', $no_urut)->get();

            $pengajuan_upload = DB::table('pengajuan_upload')
                                ->select('pengajuan_upload.filename')
                                ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                                ->get();
        }
        return view('pengajuan.pengajuan.view', compact('pengajuan_v','details','pengajuan_upload'));
    }

    public function download($filename)
    {
        $path = public_path('images/' . $filename);
        
        if (!file_exists($path)) {
            abort(404);
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($extension, ['xls', 'xlsx', 'xlsm', 'xlsb', 'ods'])) {
            return response()->download($path, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }
        
        return response()->file($path);
    }

    public function view_approval($no_urut)
    {   
        $data = DB::table('pengajuan')
                    ->leftjoin('users as user_atasan','pengajuan.id_user_approval_atasan','=','user_atasan.id')
                    ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                    ->leftjoin('users as user_ga','pengajuan.id_user_approval_ga','=','user_ga.id')
                    ->leftjoin('users as user_ops','pengajuan.id_user_approval_ops','=','user_ops.id')
                    ->leftjoin('users as user_pc','pengajuan.id_user_approval_pc','=','user_pc.id')
                    ->select(
                        'user_atasan.name as atasan',
                        'users.name as it',
                        'user_ga.name as ga',
                        'user_ops.name as ops',
                        'user_pc.name as pc',
                        'pengajuan.kode_pengajuan',
						'Pengajuan.tgl_pengajuan',
                        'pengajuan.jenis'
                        )
                    ->where('pengajuan.no_urut', $no_urut)
                    ->first();


        $data_approval = DB::table('pengajuan')
                    ->leftjoin('users as user_atasan','pengajuan.id_user_approval_atasan','=','user_atasan.id')
                    ->leftjoin('users','pengajuan.id_user_approval_it','=','users.id')
                    ->leftjoin('users as user_ga','pengajuan.id_user_approval_ga','=','user_ga.id')
                    ->leftjoin('users as user_ops','pengajuan.id_user_approval_ops','=','user_ops.id')
                    ->leftjoin('users as user_pc','pengajuan.id_user_approval_pc','=','user_pc.id')
                    ->select(
                        'user_atasan.name as atasan',
                        'pengajuan.status_atasan as st_atasan',
						'pengajuan.tgl_approval_atasan',
                        DB::raw('(CASE WHEN pengajuan.status_atasan = "1" THEN "Approved" WHEN pengajuan.status_atasan = "2" THEN "Denied" WHEN pengajuan.status_atasan = "3" THEN "Pending" END) AS status_atasan'),
                        'users.name as it',
                        'pengajuan.status_it as st_it',
						'pengajuan.tgl_approval_it',
                        DB::raw('(CASE WHEN pengajuan.status_it = "1" THEN "Approved" WHEN pengajuan.status_it = "2" THEN "Denied" WHEN pengajuan.status_it = "3" THEN "Pending" END) AS status_it'),
                        'user_ga.name as ga',
                        'pengajuan.status_ga as st_ga',
						'pengajuan.tgl_approval_ga',
                        DB::raw('(CASE WHEN pengajuan.status_ga = "1" THEN "Approved" WHEN pengajuan.status_ga = "2" THEN "Denied" WHEN pengajuan.status_ga = "3" THEN "Pending" END) AS status_ga'),
                        'user_ops.name as ops',
                        'pengajuan.status_ops as st_ops',
						'pengajuan.tgl_approval_ops',
                        DB::raw('(CASE WHEN pengajuan.status_ops = "1" THEN "Approved" WHEN pengajuan.status_ops = "2" THEN "Denied" WHEN pengajuan.status_ops = "3" THEN "Pending" END) AS status_ops'),
                        'user_pc.name as pc',
                        'pengajuan.status_pc as st_pc',
						'pengajuan.tgl_approval_pc',
                        DB::raw('(CASE WHEN pengajuan.status_pc = "1" THEN "Approved" WHEN pengajuan.status_pc = "2" THEN "Denied" WHEN pengajuan.status_pc = "3" THEN "Pending" END) AS status_pc'),
                        'pengajuan.kode_pengajuan',
                        'pengajuan.jenis'
                        )
                    ->where('pengajuan.no_urut', $no_urut)
                    ->get();

        return view('pengajuan.pengajuan.view_approval', compact('data','data_approval'));
    }

    public function create(Request $request)
    {   
    	$type = Category::orderBy('name','ASC')->get();
    	//$perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
    	//$depo = Depo::orderBy('nama_depo','ASC')->get();
        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();

        $divisi_finance = Divisi::whereIn('kode_divisi', ['5','34'])->get();

        //$produk = Product::orderBy('kode', 'ASC')->get();
        $produk = DB::table('products')->join('categories','products.category_id','=','categories.id')->get();

        if (request()->q != ''){
            $produk = DB::table('products')->select('products.kode','products.nama_barang','products.category_id','categories.name as kategori','products.merk','products.ket','products.stock','products.price','products.created_at','users.name as nama_user','products.updated_at')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('users', 'products.kode_user_input','=','users.id')
                    ->where('products.nama_barang', 'like', '%' . request()->q . '%')
                    ->get();
        }

        $divisi_ho = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->select('users.kode_divisi','divisi.nama_divisi')
                    ->where('users.id', Auth::user()->id)
                    ->first();

        $getRow = DB::table('pengajuan')->select(DB::raw('COUNT(kode_pengajuan) as NoUrut'))->first();
        if ($getRow->NoUrut > 0) {
            $no_urut = $getRow->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        $get_budget = DB::table('budget_atk')
                        ->select('budget_atk.budget')
                        ->where('budget_atk.kode_perusahaan', Auth::user()->kode_perusahaan)
                        ->where('budget_atk.kode_depo', Auth::user()->kode_depo)
                        ->where('budget_atk.kode_divisi', Auth::user()->kode_divisi)
                        ->first();
        
        if($get_budget == null){
            $budget = 0;
        }else{
            $budget = $get_budget->budget;
        }

    	return view('pengajuan.pengajuan.create', compact('divisi','produk','type','no_urut','divisi_ho','divisi_finance','get_budget','budget'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_perusahaan' => 'required|exists:perusahaans,kode_perusahaan'
        ]);

        //----baru ------------------------------------------------//
        $tahun = date('Y', strtotime($request->get('tgl')));
        $bulan = date('m', strtotime($request->get('tgl')));
        // $tanggal = date('d', strtotime($request->get('tgl')));

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
         //----End baru ------------------------------------------------//

        $kd_perusahaan = $request->get('kode_perusahaan');
        $kd_perusahaan_tujuan = $request->get('kode_perusahaan_tujuan');
        $kode_depo = $request->get('kode_depo');
        $kode_divisi = Auth::user()->kode_divisi;
        //$id_kat = $request->get('id_pengeluaran');

        
        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',$kode_depo)->first();


        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',Auth::user()->kode_divisi)->first();


        if(Auth::user()->kode_perusahaan == 'TGSM'){
            $getRow = DB::table('pengajuan')
                    ->select(DB::raw('MAX(kode_pengajuan) as NoUrut'))
                    ->where('kode_depo', $kode_depo)
                    ->where('kode_divisi', $kode_divisi);
            $rowCount = $getRow->count();

            if($rowCount > 0){
                //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                if ($rowCount < 9) {
                    $no_pengajuan = 'REQ '.'A'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_pengajuan = 'REQ '.'A'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_pengajuan = 'REQ '.'A'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else {
                    $no_pengajuan = 'REQ '.'A'.''.($rowCount + 1).'/'.$kd_perusahaan.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                }
            }else{
                //$no_pengajuan = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_pengajuan = 'REQ '.'A'.'0001'.'/'.$kd_perusahaan.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } 
        }else{
            $getRow = DB::table('pengajuan')
                    ->select(DB::raw('MAX(kode_pengajuan) as NoUrut'))
                    ->where('kode_depo', $kode_depo)
                    ->where('kode_divisi', $kode_divisi);
            $rowCount = $getRow->count();

            if($rowCount > 0){
                //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
                if ($rowCount < 9) {
                    $no_pengajuan = 'REQ '.'A'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_pengajuan = 'REQ '.'A'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_pengajuan = 'REQ '.'A'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                } else {
                    $no_pengajuan = 'REQ '.'A'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                }
            }else{
                //$no_pengajuan = '1'.'/'.$kode_divisi.'/'.$kode_depo;
                $no_pengajuan = 'REQ '.'A'.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } 
        }

        $getRow = DB::table('pengajuan')->select(DB::raw('COUNT(kode_pengajuan)+5 as NoUrut'))->first();
        if ($getRow->NoUrut > 0) {
            $no_urut = $getRow->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        Pengajuan::create([
            'kode_pengajuan' => $no_pengajuan,
            'tgl_pengajuan' => Carbon::now()->format('Y-m-d'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kode_depo' => $request->get('kode_depo'),
            'kode_divisi' => Auth::user()->kode_divisi,
            'jenis' => $request->get('id_pengeluaran'),
            'keterangan' => $request->get('ket'),
            'status_pengajuan' => '1',
            'id_user_input' => Auth::user()->id,
            'status_approval' => '1',
            'keterangan_tgsm' => $request->get('Keterangan_tgsm'),
            'sisa_budget' => $request->get('sisa_budget'),
            'no_urut' => $no_urut

        ]);
        
        $datas=[];
        foreach ($request->input('prod_id') as $key => $value) {
            // $datas["idtype.{$key}"] = 'required';
            // $datas["kode_produk.{$key}"] = 'required'; 
            // $datas["qty.{$key}"] = 'required';
            // $datas["kode_divisi.{$key}"] = 'required';
            // $datas["description.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
            foreach ($request->input("prod_id") as $key => $value) {

                // if($request->file('image')[$key]){
                //     $file = $request->file('image')[$key];
                //     $dt = Carbon::now();
                //     $acak = $file->getClientOriginalExtension();
                //     $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
                //     $request->file('image')[$key]->move("images/pengajuan", $fileName);
                //     $image = $fileName;
                // }else{
                //     $image = NULL;
                // }

                $data = new Pengajuan_Detail;

                $data->kode_pengajuan = $no_pengajuan;
                $data->id_kategori = $request->get("type_id")[$key];
                $data->kode_product = $request->get("prod_id")[$key];
                $data->qty = $request->get("qty")[$key];
                $data->qty_it = 0;
                $data->qty_ops = 0;
                $data->qty_ga = 0;
                $data->qty_pc = 0;
                $data->harga_satuan = str_replace(",", "", $request->get("harga_satuan")[$key]); 
                $data->harga_total = str_replace(",", "", $request->get("total_harga")[$key]); 
                $data->kode_divisi = $request->get("kode_divisi")[$key];
                $data->description = $request->get("desc")[$key];
                $data->no_urut =  $no_urut;
                $data->image = '';
                $data->save();

                //upload file
                if($request->hasfile('filename')) { 
                    foreach ($request->file('filename') as $file) {
                        if ($file->isValid()) {
                            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('images'), $filename);
                               
                            Pengajuan_Upload::create([
                                'kode_pengajuan' => $no_pengajuan,
                                'description' => $request->get("desc")[$key],
                                'filename' => $filename
                            ]);
                        }
                    }
                    echo 'Success';
                }else{
                    echo 'Gagal';
                }
            }
        alert()->success('Success.','New request has been created');
        return redirect()->route('pengajuan.index');
    }

    public function update(Request $request, $no_urut)
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        //$depo = Depo::orderBy('nama_depo','ASC')->get();
        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
        
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        $pengajuan_v = DB::table('pengajuan')->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                             ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                             ->join('users','pengajuan.id_user_input','=','users.id')
                                             ->join('products','pengajuan_detail.kode_product','=','products.kode')
                                             ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                             ->where('pengajuan.no_urut', $no_urut)->first();

        $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')->join('categories','pengajuan_detail.id_kategori','=','categories.id')->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')->where('pengajuan_detail.no_urut', $no_urut)->get();

        $pengajuan_upload = DB::table('pengajuan_upload')
                                ->select('pengajuan_upload.filename')
                                ->where('pengajuan_upload.kode_pengajuan', $pengajuan_v->kode_pengajuan)
                                ->get();

        return view ('pengajuan.pengajuan.edit', compact('perusahaan','depo','divisi','pengajuan_v','details','pengajuan_upload'));
    }

    public function edit(Request $request)
    {
        //cari status validasi//
        $cari_status_validasi = DB::table('pengajuan')
                                ->select('status_atasan','status_validasi_adm_it','status_validasi_adm_ga','status_validasi_adm_ops','status_validasi_adm_pc')
                                ->where('kode_pengajuan', $request->get("kode_pengajuan"))
                                ->first();

        if($cari_status_validasi->status_validasi_adm_it == '3'){
            $approved = DB::table('pengajuan')->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->update([
                            'status_pengajuan' => 0,
                            'status_validasi_adm_it' => 0,
                        ]);
        }elseif($cari_status_validasi->status_validasi_adm_ga == '3' ){
            $approved = DB::table('pengajuan')->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->update([
                            'status_pengajuan' => 0,
                            'status_validasi_adm_ga' => 0,
                        ]);
        }elseif($cari_status_validasi->status_validasi_adm_ops == '3' ){
            $approved = DB::table('pengajuan')->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->update([
                            'status_pengajuan' => 0,
                            'status_validasi_adm_ops' => 0,
                        ]);
        }elseif($cari_status_validasi->status_validasi_adm_pc == '3' ){
                        $approved = DB::table('pengajuan')->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->update([
                            'status_pengajuan' => 0,
                            'status_validasi_adm_pc' => 0,
                        ]);
        }elseif($cari_status_validasi->status_atasan == '3' ){
                        $approved = DB::table('pengajuan')->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->update([
                            'status_pengajuan' => 0,
                            'status_atasan' => 0,
                        ]);
        }
        //End cari status validasi//

        // $hapus_detail = DB::table('pengajuan_detail')->Where('pengajuan_detail.kode_pengajuan', $request->get("kode_pengajuan"))->delete();
        $hapus_data_upload = DB::table('pengajuan_upload')->Where('pengajuan_upload.kode_pengajuan', $request->get("kode_pengajuan"))->delete();

        $datas=[];
        foreach ($request->input('prod_id') as $key => $value) {
            
        }
        $validator = Validator::make($request->all(), $datas);
            foreach ($request->input("prod_id") as $key => $value) {
                // $data = new Pengajuan_Detail;

                // $data->kode_pengajuan = $request->get("kode_pengajuan");
                // $data->id_kategori = $request->get("type_id")[$key];
                // $data->kode_product = $request->get("prod_id")[$key];
                // $data->qty = $request->get("qty")[$key];
                // $data->kode_divisi = $request->get("kode_divisi")[$key];
                // $data->description = $request->get("desc")[$key];
                // $data->image = '';
                // $data->save();

                if($cari_status_validasi->status_validasi_adm_it == '3'){
                    $approved = DB::table('pengajuan_detail')
                        ->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->where('kode_product', $request->get("prod_id")[$key])
                        ->update([
                            'qty' => $request->get("qty")[$key],
                            'kode_divisi' => $request->get("kode_divisi")[$key],
                            'description' => $request->get("desc")[$key],
                            'status_cek_it' => 0,
                            'keterangan_detail_adm_it' => '',
                    ]);
                }elseif($cari_status_validasi->status_validasi_adm_ga == '3' ){
                    $approved = DB::table('pengajuan_detail')
                        ->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->where('kode_product', $request->get("prod_id")[$key])
                        ->update([
                            'qty' => $request->get("qty")[$key],
                            'kode_divisi' => $request->get("kode_divisi")[$key],
                            'description' => $request->get("desc")[$key],
                            'status_cek_ga' => 0,
                            'keterangan_detail_adm_ga' => '',
                    ]);
                }elseif($cari_status_validasi->status_validasi_adm_ops == '3' ){
                    $approved = DB::table('pengajuan_detail')
                        ->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->where('kode_product', $request->get("prod_id")[$key])
                        ->update([
                            'qty' => $request->get("qty")[$key],
                            'kode_divisi' => $request->get("kode_divisi")[$key],
                            'description' => $request->get("desc")[$key],
                            'status_cek_ops' => 0,
                            'keterangan_detail_adm_ops' => '',
                    ]);
                }elseif($cari_status_validasi->status_validasi_adm_pc == '3' ){
                    $approved = DB::table('pengajuan_detail')
                        ->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->where('kode_product', $request->get("prod_id")[$key])
                        ->update([
                            'qty' => $request->get("qty")[$key],
                            'kode_divisi' => $request->get("kode_divisi")[$key],
                            'description' => $request->get("desc")[$key],
                            'status_cek_pc' => 0,
                            'keterangan_detail_adm_pc' => '',
                    ]);   
                }elseif($cari_status_validasi->status_atasan == '3' ){
                    $approved = DB::table('pengajuan_detail')
                        ->where('kode_pengajuan', $request->get("kode_pengajuan"))
                        ->where('kode_product', $request->get("prod_id")[$key])
                        ->update([
                            'qty' => $request->get("qty")[$key],
                            'kode_divisi' => $request->get("kode_divisi")[$key],
                            'description' => $request->get("desc")[$key],
                            'status_cek_atasan' => 0,
                            'keterangan_detail_atasan' => '',
                    ]);  
                }

                //upload file
                if($request->hasfile('filename')) { 
                    foreach ($request->file('filename') as $file) {
                        if ($file->isValid()) {
                            $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                            $file->move(public_path('images'), $filename);
                               
                            Pengajuan_Upload::create([
                                'kode_pengajuan' => $request->get("kode_pengajuan"),
                                'description' => $request->get("desc")[$key],
                                'filename' => $filename
                            ]);
                        }
                    }
                    echo 'Success';
                }else{
                    echo 'Gagal';
                }
            }

        alert()->success('Success.','Pengajuan berhasil di edit');
        return redirect()->route('pengajuan.index');
    }

    public function pdf($no_urut)
    {
        $pengajuan_head = DB::table('pengajuan')
            ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan.id_user_input','=','users.id')
            ->leftJoin('users as user_atasan','pengajuan.id_user_approval_atasan','=','user_atasan.id')
            ->leftJoin('users as user_app_it','pengajuan.id_user_approval_it','=','user_app_it.id')
            ->leftJoin('users as user_app_ops','pengajuan.id_user_approval_ops','=','user_app_ops.id')
            ->leftJoin('users as user_app_ga','pengajuan.id_user_approval_ga','=','user_app_ga.id')
            ->leftJoin('users as user_app_pc','pengajuan.id_user_approval_pc','=','user_app_pc.id')
            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
            ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.keterangan','ms_pengeluaran.sifat','pengajuan.kode_perusahaan',
            'perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','divisi.nama_divisi','pengajuan.id_user_input','users.name',
            'pengajuan.kode_app_atasan','pengajuan.id_user_approval_atasan','user_atasan.name as nama_atasan','pengajuan.tgl_approval_atasan',
            'pengajuan.kode_app_it','pengajuan.id_user_approval_it','user_app_it.name as nama_atasan_it','pengajuan.tgl_approval_it',
            'pengajuan.kode_app_ops','pengajuan.id_user_approval_ops','user_app_ops.name as nama_atasan_ops','pengajuan.tgl_approval_ops',
            'pengajuan.kode_app_ga','pengajuan.id_user_approval_ga','user_app_ga.name as nama_atasan_ga','pengajuan.tgl_approval_ga',
            'pengajuan.kode_app_pc','pengajuan.id_user_approval_pc','user_app_pc.name as nama_atasan_pc','pengajuan.tgl_approval_pc',
            'pengajuan.kode_app_tgsm','pengajuan.kode_app_bod')
            ->where('pengajuan.no_urut', $no_urut)->first();

        $pengajuan_detail = DB::table('pengajuan_detail')
            ->join('products','pengajuan_detail.kode_product','=','products.kode')
            ->where('pengajuan_detail.no_urut',$no_urut)
            ->get();
			
        $total_jml = DB::table('pengajuan_detail')
            ->join('products','pengajuan_detail.kode_product','=','products.kode')
            ->select(DB::raw('SUM(products.price*pengajuan_detail.qty) as total'))
            ->where('pengajuan_detail.no_urut',$no_urut)
            ->first();
                                

        $pdf = PDF::loadview('pengajuan.pengajuan.pdf', compact('pengajuan_head','pengajuan_detail','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }


}
