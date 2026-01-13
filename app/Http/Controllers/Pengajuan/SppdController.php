<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Pengajuan_sppd;
use App\Pengajuan_sppd_detail;
use Carbon\carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SppdController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if (Auth::user()->kode_divisi == '0') {
            $pengajuan_sppd = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->leftJoin('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->leftJoin('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
                ->orderBy('pengajuan_sppd.tgl_pengajuan_sppd', 'DESC')
                ->get();
        }else{
            $pengajuan_sppd = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->leftJoin('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->leftJoin('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
                ->Where('pengajuan_sppd.kode_depo', Auth::user()->kode_depo)
                ->Where('pengajuan_sppd.kode_divisi', Auth::user()->kode_divisi)
                ->orderBy('pengajuan_sppd.tgl_pengajuan_sppd', 'DESC')
                ->get();
        }

    	return view('pengajuan.sppd.index', compact('pengajuan_sppd'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if (Auth::user()->kode_divisi == '0') {
            $pengajuan_sppd = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->leftJoin('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->leftJoin('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
                ->orderBy('pengajuan_sppd.tgl_pengajuan_sppd', 'DESC')
                ->get();
        }else{
            $pengajuan_sppd = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->leftJoin('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->leftJoin('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->WhereBetween('pengajuan_sppd.tgl_pengajuan_sppd', [$date_start,$date_end])
                ->Where('pengajuan_sppd.kode_depo', Auth::user()->kode_depo)
                ->Where('pengajuan_sppd.kode_divisi', Auth::user()->kode_divisi)
                ->orderBy('pengajuan_sppd.tgl_pengajuan_sppd', 'DESC')
                ->get();
        }
        return view('pengajuan.sppd.index', compact('pengajuan_sppd'));
    }

    public function ajax_depo_tujuan(Request $request)
    {
    	$perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id_tujuan)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
    }

    public function actionCategory(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('ms_pengeluaran')
                        ->leftJoin('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
                        ->leftJoin('coa_transaksi_detail','coa_transaksi.no','=','coa_transaksi_detail.no')
                        ->select('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->Where('ms_pengeluaran.id','like','%'.$query.'%')
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
                        ->groupBy('ms_pengeluaran.id','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','ms_pengeluaran.jenis','ms_pengeluaran.pembayaran','ms_pengeluaran.kategori','ms_pengeluaran.coa','coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
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

    public function view($kode_pengajuan_sppd)
    {
        $pengajuan_sppd_v = DB::table('pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->leftJoin('perusahaans as perusahaan_tujuan','pengajuan_sppd.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->leftJoin('depos as depo_tujuan','pengajuan_sppd.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan_1',
                    'pengajuan_sppd.tujuan_depo',
                    'depo_tujuan.nama_depo as tujuan_depo_1',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.kendaraan',
                    'pengajuan_sppd.sebagai',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                ->first();

            $detailSppd = DB::table('pengajuan_sppd')
                ->join('pengajuan_sppd_detail','pengajuan_sppd.kode_pengajuan_sppd','=','pengajuan_sppd_detail.kode_pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd_detail.tujuan_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd_detail.tujuan_depo','=','depos.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                         'pengajuan_sppd_detail.tujuan_perusahaan',
                         'perusahaans.nama_perusahaan',
                         'pengajuan_sppd_detail.tujuan_depo',
                         'depos.nama_depo',
                         'pengajuan_sppd_detail.tgl_mulai',
                         'pengajuan_sppd_detail.tgl_akhir',
                         'pengajuan_sppd_detail.jml_hari',
                         'pengajuan_sppd_detail.keperluan')
                ->where('pengajuan_sppd.kode_pengajuan_sppd',$kode_pengajuan_sppd)
                ->get();

        return view('pengajuan.sppd.view', compact('pengajuan_sppd_v','detailSppd'));
    }

    public function view_approval($kode_pengajuan_sppd)
    {
        $data = DB::table('pengajuan_sppd')
                    ->leftjoin('users','pengajuan_sppd.id_user_approval_biaya','=','users.id')
                    ->leftjoin('users as user_1','pengajuan_sppd.id_user_approval_hrd','=','user_1.id')
                    ->select('pengajuan_sppd.kode_pengajuan_sppd')
                    ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->first();

        $data_approval = DB::table('pengajuan_sppd')
                    ->leftjoin('users','pengajuan_sppd.id_user_approval_biaya','=','users.id')
                    ->leftjoin('users as user_1','pengajuan_sppd.id_user_approval_hrd','=','user_1.id')
                    ->select('pengajuan_sppd.kode_pengajuan_sppd','users.name as biaya','user_1.name as hrd')
                    ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                    ->get();

        return view('pengajuan.sppd.view_approval', compact('data','data_approval'));
    }

    public function create(Request $request)
    {

    	$perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
    	$kode_perusahaan = $request->get('1');
    	$depo = DB::table('depos')->Where('kode_perusahaan', $kode_perusahaan)
    			->orderBy('nama_depo', 'ASC')
    			->get();

    	$data = DB::table('users')
    		->join('perusahaans','users.kode_perusahaan','=','perusahaans.kode_perusahaan')
    		->join('depos','users.kode_depo','=','depos.kode_depo')
    		->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
    		->Where('users.id', Auth::user()->id)
    		->first();

    	return view('pengajuan.sppd.create', compact('data','perusahaan','depo'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        $kode_depo = $request->get('kode_depo');
        $kode_divisi = $request->get('kode_divisi');

        $getRow = DB::table('pengajuan_sppd')->select(DB::raw('MAX(kode_pengajuan_sppd) as NoUrut'));
        $rowCount = $getRow->count();
        if($rowCount > 0){
            $no_pengajuan_sppd = ($rowCount + 1).'-'.$kode_divisi.'-'.$kode_depo;
        }else{
            $no_pengajuan_sppd = '1'.'-'.$kode_divisi.'-'.$kode_depo;
        }

        //---Mencari Jumlah Hari---------------------------
        // $dari_tgl = $request->get('lama_tugas');
        // $sampai_tgl = $request->get('sampai');

        // $start = Carbon::parse(date('Y-m-d', strtotime($request->get('lama_tugas')))); 
        // $end = Carbon::parse(date('Y-m-d', strtotime($request->get('sampai')))); 

        // $jml_hari = $start->diffInDays($end);
        //---End Mencari Jumlah Hari-----------------------
    
        Pengajuan_sppd::create([
            'kode_pengajuan_sppd' => $no_pengajuan_sppd,
            'id_pengeluaran' => $request->get('id_pengeluaran'),
            'tgl_pengajuan_sppd' => Carbon::now()->format('Y-m-d'),
            'pelaksana' => $request->get('pelaksana'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kode_depo' => $request->get('kode_depo'),
            'kode_divisi' => $request->get('kode_divisi'),
            // 'tujuan_perusahaan' => $request->get('kode_perusahaan_tujuan'),
            // 'tujuan_depo' => $request->get('kode_depo_tujuan'),
            // 'tgl_mulai' => $request->get('lama_tugas'),
            // 'tgl_akhir' => $request->get('sampai'),
            //'jml_hari' => $jml_hari,
            //'keperluan' => $request->get('keperluan'),
            'kendaraan' => $request->get('kendaraan'),
            'sebagai' => $request->get('sebagai'),
            'id_user_input' => Auth::user()->id
        ]);

        $datas=[];
        foreach ($request->input("kode_depo_tujuan") as $key => $value) {
            
        }
        $validator = Validator::make($request->all(), $datas);

        //if($validator->passes()){
        foreach ($request->input("kode_depo_tujuan") as $key => $value) {
            //---Mencari Jumlah Hari---------------------------
            $start = Carbon::parse(date('Y-m-d', strtotime($request->get('lama_tugas')[$key]))); 
            $end = Carbon::parse(date('Y-m-d', strtotime($request->get('sampai')[$key]))); 
            $jml_hari = $start->diffInDays($end);
            $jml_hari = $jml_hari + 1;
            //---End Mencari Jumlah Hari-----------------------

            $data = new Pengajuan_sppd_detail;

            $data->kode_pengajuan_sppd = $no_pengajuan_sppd;
            $data->tujuan_perusahaan = $request->get("kode_perusahaan_tujuan")[$key];
            $data->tujuan_depo = $request->get("kode_depo_tujuan")[$key];
            $data->tgl_mulai = $request->get("lama_tugas")[$key];
            $data->tgl_akhir = $request->get("sampai")[$key];
            $data->jml_hari = $jml_hari;
            $data->keperluan = $request->get("keperluan")[$key];
            $data->save();
        }

        alert()->success('Success.','Pembuatan SPPD berhasil dibuat');
        return redirect()->route('sppd.index');
    }

    public function pdf($kode_pengajuan_sppd)
    {
        $pengajuan_sppd_v = DB::table('pengajuan_sppd')
                ->join('pengajuan_sppd_detail','pengajuan_sppd.kode_pengajuan_sppd','=','pengajuan_sppd_detail.kode_pengajuan_sppd')
                ->join('perusahaans','pengajuan_sppd.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','pengajuan_sppd.kode_depo','=','depos.kode_depo')
                ->join('users','pengajuan_sppd.id_user_input','=','users.id')
                ->join('divisi','pengajuan_sppd.kode_divisi','=','divisi.kode_divisi')
                ->join('ms_pengeluaran','pengajuan_sppd.id_pengeluaran','=','ms_pengeluaran.id')
                ->leftJoin('perusahaans as perusahaan_tujuan','pengajuan_sppd_detail.tujuan_perusahaan','=','perusahaan_tujuan.kode_perusahaan')
                ->leftJoin('depos as depo_tujuan','pengajuan_sppd_detail.tujuan_depo','=','depo_tujuan.kode_depo')
                ->select('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'divisi.kepala_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan as tujuan_perusahaan_1',
                    'pengajuan_sppd.tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    DB::raw('sum(pengajuan_sppd_detail.jml_hari) as jml_hari'),
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->where('pengajuan_sppd.kode_pengajuan_sppd', $kode_pengajuan_sppd)
                ->groupBy('pengajuan_sppd.kode_pengajuan_sppd',
                    'pengajuan_sppd.id_pengeluaran',
                    'ms_pengeluaran.nama_pengeluaran',
                    'ms_pengeluaran.sifat',
                    'pengajuan_sppd.tgl_pengajuan_sppd',
                    'pengajuan_sppd.pelaksana',
                    'pengajuan_sppd.kode_perusahaan',
                    'perusahaans.nama_perusahaan',
                    'pengajuan_sppd.kode_depo',
                    'depos.nama_depo',
                    'pengajuan_sppd.kode_divisi',
                    'divisi.nama_divisi',
                    'divisi.kepala_divisi',
                    'pengajuan_sppd.tujuan_perusahaan',
                    'perusahaan_tujuan.nama_perusahaan',
                    'pengajuan_sppd.tujuan_depo',
                    'pengajuan_sppd.tgl_mulai',
                    'pengajuan_sppd.tgl_akhir',
                    'pengajuan_sppd.keperluan',
                    'pengajuan_sppd.id_user_input',
                    'pengajuan_sppd.status_biaya',
                    'pengajuan_sppd.status_hrd',
                    'pengajuan_sppd.status_atasan',
                    'users.name')
                ->first();

        $detailSppd = DB::table('pengajuan_sppd')
                        ->join('pengajuan_sppd_detail','pengajuan_sppd.kode_pengajuan_sppd','=','pengajuan_sppd_detail.kode_pengajuan_sppd')
                        ->join('depos','pengajuan_sppd_detail.tujuan_depo','=','depos.kode_depo')
                        ->select('pengajuan_sppd.kode_pengajuan_sppd',
                                 'pengajuan_sppd_detail.tujuan_depo',
                                 'depos.nama_depo',
                                 'pengajuan_sppd_detail.keperluan')
                        ->where('pengajuan_sppd.kode_pengajuan_sppd',$kode_pengajuan_sppd)
                        ->get();

        $detailSppdArray = $detailSppd->toArray();

        //return view('pengajuan.sppd.view', compact('pengajuan_sppd_v'));
        $pdf = PDF::loadview('pengajuan.sppd.pdf', compact('pengajuan_sppd_v','detailSppdArray'));
        return $pdf->stream();
    }
}
