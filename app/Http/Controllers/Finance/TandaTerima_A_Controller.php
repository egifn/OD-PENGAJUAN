<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Perusahaan;
use App\Tanda_Terima_Cek_Vendor;
use App\Tanda_Terima_Cek_Vendor_Detail;
use App\Pengisian_Cekgiro_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class TandaTerima_A_Controller extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_izin_a = DB::table('izin_a')
                    // ->join('rekening_fin_comp','izin_b.rekening_pembayar','=','rekening_fin_comp.norek')
                    // ->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                    ->select('izin_a.kode_izin_a','izin_a.tgl_izin_a','izin_a.no_izin_a','izin_a.judul_izin_a',
                            'izin_a.no_urut')
                    //->WhereBetween('izin_a.tgl_izin_a', [$date_start,$date_end])
                    ->get();

    	return view('finance.tanda_terima_cek_giro_a.index', compact('data_izin_a'));
    }

    public function view($receipt_id)
    {
        $tanda_terima_head = DB::table('tanda_terima_cek')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->first();   

        $tanda_terima_detail = DB::table('tanda_terima_cek')
                ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
                ->join('pengisian_cekgiro_detail','tanda_terima_cek_detail.cek_giro','=','pengisian_cekgiro_detail.id_cek')
                ->select('tanda_terima_cek.receipt_id','tanda_terima_cek_detail.jenis_pengeluaran','tanda_terima_cek_detail.total','pengisian_cekgiro_detail.total_cek','tanda_terima_cek_detail.cek_giro','tanda_terima_cek_detail.tanggal','tanda_terima_cek_detail.kd_perusahaan','tanda_terima_cek_detail.bank','tanda_terima_cek_detail.norek_perusahaan','tanda_terima_cek_detail.vendor','tanda_terima_cek_detail.atas_nama','tanda_terima_cek_detail.bank_vendor','tanda_terima_cek_detail.norek_vendor','tanda_terima_cek_detail.status')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->groupBy('tanda_terima_cek.receipt_id','tanda_terima_cek_detail.jenis_pengeluaran','tanda_terima_cek_detail.total','pengisian_cekgiro_detail.total_cek','tanda_terima_cek_detail.cek_giro','tanda_terima_cek_detail.tanggal','tanda_terima_cek_detail.kd_perusahaan','tanda_terima_cek_detail.bank','tanda_terima_cek_detail.norek_perusahaan','tanda_terima_cek_detail.vendor','tanda_terima_cek_detail.atas_nama','tanda_terima_cek_detail.bank_vendor','tanda_terima_cek_detail.norek_vendor','tanda_terima_cek_detail.status')
                ->get();

        $total_jml = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->sum('total');

        $count = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->count('receipt_id');

        return view('finance.tanda_terima_cek_giro_a.view',compact('tanda_terima_head','tanda_terima_detail','total_jml','count'));
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
                        ->join('izin_h_detail','izin_b_detail.no_cek','=','izin_h_detail.id_cek')
                        ->join('rekening_fin_comp','izin_h_detail.no_rekening','=','rekening_fin_comp.norek')
                        ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                        ->join('banks AS bank_vendor','izin_b_detail.kode_bank_vendor','=','bank_vendor.kode_bank')
                        ->select('izin_b.kode_izin_b','izin_b.no_izin_b','izin_b_detail.keterangan','izin_b_detail.id_cek','izin_b_detail.no_cek',
                        'izin_b_detail.kode_perusahaan','izin_h_detail.kode_bank','banks.nama_bank','rekening_fin_comp.atas_nama_rek','izin_h_detail.no_rekening','izin_b_detail.kode_vendor','izin_b_detail.atas_nama','izin_b_detail.kode_bank_vendor','bank_vendor.nama_bank AS nama_bank_vendor','izin_b_detail.no_rekening_vendor',
                        'izin_b_detail.status')
                        ->where('izin_b_detail.status', 0)
                        ->get();
            }else{
                $data = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('izin_h_detail','izin_b_detail.no_cek','=','izin_h_detail.id_cek')
                        ->join('rekening_fin_comp','izin_h_detail.no_rekening','=','rekening_fin_comp.norek')
                        ->join('banks','izin_h_detail.kode_bank','=','banks.kode_bank')
                        ->leftjoin('banks AS bank_vendor','izin_b_detail.kode_bank_vendor','=','bank_vendor.kode_bank')
                        ->select('izin_b.kode_izin_b','izin_b.no_izin_b','izin_b_detail.keterangan','izin_b_detail.id_cek','izin_b_detail.no_cek',
                        'izin_b_detail.kode_perusahaan','izin_h_detail.kode_bank','banks.nama_bank','rekening_fin_comp.atas_nama_rek','izin_h_detail.no_rekening','izin_b_detail.kode_vendor','izin_b_detail.atas_nama','izin_b_detail.kode_bank_vendor','bank_vendor.nama_bank AS nama_bank_vendor','izin_b_detail.no_rekening_vendor',
                        'izin_b_detail.status')
                        ->where('izin_b_detail.status', 0)
                        ->get();
                
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_cek" data-kode="'.$row->kode_izin_b.'" data-id_cek="'.$row->no_cek.'" data-an="'.$row->atas_nama_rek.'" data-kode_bank="'.$row->kode_bank.'" data-nama_bank="'.$row->nama_bank.'" data-no_rek="'.$row->no_rekening.'" data-kode_vendor="'.$row->kode_vendor.'" data-kode_bank_vendor="'.$row->kode_bank_vendor.'" data-nama_bank_vendor="'.$row->nama_bank_vendor.'" data-no_rek_vendor="'.$row->no_rekening_vendor.'">
                            <td hidden>'.$row->kode_izin_b.'</td>
                            <td>'.$row->no_cek.'</td>
                            <td>'.$row->atas_nama_rek.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->no_rekening.'</td>
                            <td>'.$row->kode_vendor.'</td>
                            <td>'.$row->atas_nama.'</td>
                            <td>'.$row->nama_bank_vendor.'</td>
                            <td>'.$row->no_rekening_vendor.'</td>
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
                ->join('vendors','rekening_fin.kode_vendor','=','vendors.kode_vendor')
                ->select('spp.no_spp','spp.keterangan','spp.jumlah','spp.kode_vendor','vendors.nama_vendor','spp.for','spp.pembayaran','banks.kode_bank','banks.nama_bank','rekening_fin.atas_nama')
                ->Where('spp.status', 0)
                ->Where('spp.status_pakai', 0)
                ->Where('spp.no_spp','like','%'.$query.'%')
                ->orderBy('spp.no_spp','ASC')
                ->get();
            }else{
                $data = DB::table('spp')
                ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                ->join('vendors','rekening_fin.kode_vendor','=','vendors.kode_vendor')
                ->select('spp.no_spp','spp.keterangan','spp.jumlah','spp.kode_vendor','vendors.nama_vendor','spp.for','spp.pembayaran','banks.kode_bank','banks.nama_bank','rekening_fin.atas_nama')
                ->Where('spp.status', 0)
                ->Where('spp.status_pakai', 0)
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
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();

        $date = (date('Ym'));
        $date_1 = (date('Ymd'));
        $id = 'A';

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
            $keterangan_id = "A-".''.($rowCountCode + 1);
        }else{
            $keterangan_id = "A-1";
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

    	return view('finance.tanda_terima_cek_giro_a.create', compact('cek_giro','receipt','keterangan_id','perusahaan'));
    }

    public function store(Request $request)
    {
        $getRow = DB::table('izin_a')
            ->select(DB::raw('MAX(kode_izin_a) as NoUrut'));
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
        
        $kode_daftar = 'A '.$kode.''.'/'.''.$bulan_romawi.''.'/'.''.$tahun;
        
        $getRow_urut = DB::table('izin_a')->select(DB::raw('COUNT(kode_izin_a) as NoUrut'))->first();
        if ($getRow_urut->NoUrut > 0) {
            $no_urut = $getRow_urut->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        DB::table('izin_a')->insert([
            'kode_izin_a' =>  $kode_daftar,
            'tgl_izin_a' => Carbon::now()->format('Y-m-d'),
            'no_izin_a' => $request->get('no_izin'),
            'judul_izin_a' => $request->get('description'),
            'nama_rekening_pembayar' =>$request->get('rekening_pembayar'),
            'nama_rekening_tujuan' => $request->get('rekening_tujuan'),
            'kode_perusahaan' => $request->get('kode_perusahaan_tujuan'),
            'kode_bank' => $request->get('kode_bank'),
            'kode_bank_tujuan' => $request->get('kode_bank_vendor'),
            'no_cek' => $request->get('no_cek'),
            'norek_pembayar' => $request->get('no_rek'),
            'norek_tujuan' => $request->get('no_rek_vendor'),
            'status' => 0,
            'no_urut' => $no_urut,
            'id_user_input'  => Auth::user()->id,
        ]);

        $update_cek = DB::table('izin_b_detail')
                            ->select('izin_b_detail.status')
                            ->Where('izin_b_detail.no_cek', $request->get('no_cek'))
                            ->update([
                                'status' => 1,
                            ]);

        $jumlah_row = count($request->spp);

        for ($i = 0; $i < $jumlah_row; $i++) {
                DB::table('izin_a_detail')->insert([
                    'kode_izin_a' => $kode_daftar,
                    'no_spp' => $request->spp[$i],
                    'no_urut' => $no_urut,
                ]);

                $update_spp = DB::table('spp')
                            ->select('spp.status_pakai')
                            ->Where('spp.no_spp', $request->spp[$i])
                            ->update([
                                'status_pakai' => 1,
                            ]);

        }
        

        alert()->success('Success.','New Receipt successfully created');
        return redirect()->route('tanda_terima_a.index');
    }

    public function pdf($receipt_id)
    {
        $tanda_terima_head = DB::table('tanda_terima_cek')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->first();

        // $tanda_terima_detail = DB::table('tanda_terima_cek')
        //         ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
        //         ->Where('tanda_terima_cek.receipt_id', $receipt_id)
        //         ->get();

        $tanda_terima_detail = DB::table('tanda_terima_cek')
                ->join('tanda_terima_cek_detail','tanda_terima_cek.receipt_id','=','tanda_terima_cek_detail.receipt_id')
                ->join('pengisian_cekgiro_detail','tanda_terima_cek_detail.cek_giro','=','pengisian_cekgiro_detail.id_cek')
                ->select('tanda_terima_cek.receipt_id','tanda_terima_cek_detail.jenis_pengeluaran','tanda_terima_cek_detail.total','pengisian_cekgiro_detail.total_cek','tanda_terima_cek_detail.cek_giro','tanda_terima_cek_detail.tanggal','tanda_terima_cek_detail.kd_perusahaan','tanda_terima_cek_detail.bank','tanda_terima_cek_detail.norek_perusahaan','tanda_terima_cek_detail.vendor','tanda_terima_cek_detail.atas_nama','tanda_terima_cek_detail.bank_vendor','tanda_terima_cek_detail.norek_vendor','tanda_terima_cek_detail.status')
                ->Where('tanda_terima_cek.receipt_id', $receipt_id)
                ->groupBy('tanda_terima_cek.receipt_id','tanda_terima_cek_detail.jenis_pengeluaran','tanda_terima_cek_detail.total','pengisian_cekgiro_detail.total_cek','tanda_terima_cek_detail.cek_giro','tanda_terima_cek_detail.tanggal','tanda_terima_cek_detail.kd_perusahaan','tanda_terima_cek_detail.bank','tanda_terima_cek_detail.norek_perusahaan','tanda_terima_cek_detail.vendor','tanda_terima_cek_detail.atas_nama','tanda_terima_cek_detail.bank_vendor','tanda_terima_cek_detail.norek_vendor','tanda_terima_cek_detail.status')
                ->get();

        $total_jml = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->sum('total');

        $count = Tanda_Terima_Cek_Vendor_Detail::where('receipt_id', $receipt_id)
                                ->get()->count('receipt_id');

        $pdf = PDF::loadview('finance.tanda_terima_cek_giro_a.pdf', compact('tanda_terima_head','tanda_terima_detail','total_jml','count'))->setPaper('a4', 'landscape');
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
