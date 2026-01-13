<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kontrabon;
use App\Kontrabon_Detail;
use App\Pengajuan_Biaya;
use App\Penerimaan;
use App\Vendor;
use App\Spp;
use App\Pengajuan_Upload;
use App\Perusahaan;
use App\Spp_Sumberdana;
use App\Rekening_Fin_Comp;
use App\Bank;
use App\Rcm_Spp_Temp;
use PDF;
use Carbon\carbon;
use Illuminate\Support\Facades\DB;
use illuminate\Support\Facades\Auth;

class SppController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $spp = DB::table('spp')->join('users','spp.id_user_input','=','users.id')
                        ->WhereBetween('spp.tgl_spp', [$date_start,$date_end])
                        ->orderBy('spp.tgl_spp', 'ASC')
                        ->get();

    	return view ('finance.spp.index', compact('spp'));
    }

    public function cari(Request $request)
    {   
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

         $spp = DB::table('spp')->join('users','spp.id_user_input','=','users.id')
                        ->WhereBetween('spp.tgl_spp', [$date_start,$date_end])
                        ->orderBy('spp.tgl_spp', 'ASC')
                        ->get();

        return view ('finance.spp.index', compact('spp'));
    }

    public function actionVendor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('vendors')
                        ->leftJoin('rekening_fin','vendors.kode_vendor','=','rekening_fin.kode_vendor')
                        ->leftJoin('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                        ->where('vendors.kode_vendor','like', '%'.$query.'%')
                        ->orWhere('vendors.nama_vendor','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('vendors')
                        ->leftJoin('rekening_fin','vendors.kode_vendor','=','rekening_fin.kode_vendor')
                        ->leftJoin('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_vendor" data-kvendor="'.$row->kode_vendor.'" data-nvendor="'.$row->nama_vendor.'" 
                        data-status="'.$row->status_1.'" data-bank="'.$row->nama_bank.'" data-norek="'.$row->norek.'" data-atas_nama="'.$row->atas_nama.'">
                            <td>'.$row->kode_vendor.'</td>
                            <td>'.$row->nama_vendor.'</td>
                            <td>'.$row->alamat.'</td>
                            <td>'.$row->status_1.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->norek.'</td>
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

    public function actionPayment(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('rekening_fin_comp')->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                                ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->select('rekening_fin_comp.norek','banks.nama_bank','perusahaans.nama_perusahaan','rekening_fin_comp.kode_perusahaan')
                                ->where('rekening_fin_comp.norek','like','%'.$query.'%')
                                ->get();
            }else{
                $data = DB::table('rekening_fin_comp')->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                                ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                ->select('rekening_fin_comp.norek','banks.nama_bank','perusahaans.nama_perusahaan','rekening_fin_comp.kode_perusahaan')
                                ->get();
            }
             $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_payment" data-norek="'.$row->norek.'" data-bank="'.$row->nama_bank.'" data-kodeperusahaan="'.$row->kode_perusahaan.'" data-namaperusahaan="'.$row->nama_perusahaan.'">
                            <td>'.$row->norek.'</td>
                            <td>'.$row->nama_bank.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->nama_perusahaan.'</td>
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

    public function actionKontra(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('kontrabon')->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                                            ->join('penerimaan','kontrabon_detail.no_faktur','=','penerimaan.no_faktur')
                                            ->join('ms_pengeluaran','kontrabon.type','=','ms_pengeluaran.id')
                                            ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','kontrabon.id_user_input','=','users.id')
                                            ->select('kontrabon.no_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','vendors.status_1','kontrabon.id_user_input','users.name','ms_pengeluaran.pembayaran')
                                            ->groupBy('kontrabon.no_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','vendors.status_1','kontrabon.id_user_input','users.name','ms_pengeluaran.pembayaran')
                                            ->Where('kontrabon.status', 0)
                                            ->Where('kontrabon.no_kontrabon','like','%'.$query.'%')
                                            ->orWhere('vendors.nama_vendor','like','%'.$query.'%')
                                            ->get();
            }else{
                $data = DB::table('kontrabon')->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                                            ->join('penerimaan','kontrabon_detail.no_faktur','=','penerimaan.no_faktur')
                                            ->join('ms_pengeluaran','kontrabon.type','=','ms_pengeluaran.id')
                                            ->join('vendors','kontrabon.kode_vendor','=','vendors.kode_vendor')
                                            ->join('users','kontrabon.id_user_input','=','users.id')
                                            ->select('kontrabon.no_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','vendors.status_1','kontrabon.id_user_input','users.name','ms_pengeluaran.pembayaran')
                                            ->groupBy('kontrabon.no_kontrabon','kontrabon.kode_vendor','vendors.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','vendors.status_1','kontrabon.id_user_input','users.name','ms_pengeluaran.pembayaran')
                                            ->where('kontrabon.status', 0)
                                            ->get();
            }
             $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih" data-kontrabon="'.$row->no_kontrabon.'" data-vendor="'.$row->nama_vendor.' / '.$row->status_1.'" data-total="'.number_format($row->total).'" data-terbilang="'. terbilang($row->total).'" data-jt="'.$row->jatuh_tempo.'" data-keterangan="'.$row->keterangan.'" data-pajak="'.$row->status_1.'" data-idUser="'.$row->id_user_input.'" data-user="'.$row->name.'" data-kdVendor="'.$row->kode_vendor.'" data-pembayaran="'.$row->pembayaran.'">
                            <td>'.$row->no_kontrabon.'</td>
                            <td>'.$row->nama_vendor.'</td>
                            <td align="right">'.number_format($row->total).'</td>
                            <td>'.$row->jatuh_tempo.'</td>
                            <td>'.$row->keterangan.'</td>
                            <td hidden>'.$row->status_1.'</td>
                            <td hidden>'.$row->id_user_input.'</td>
                            <td hidden>'.$row->name.'</td>
                            <td hidden>'.$row->kode_vendor.'</td>
                            <td hidden>'.$row->pembayaran.'</td>
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

    public function actionRequest(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan_tujuan as kode_perusahaan','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga + pengajuan_biaya_detail.potongan) as total'),'pengajuan_biaya.kategori','ms_pengeluaran.pembayaran','pengajuan_biaya.id_user_input','users.name')
                // ->Where('pengajuan_biaya.kategori', ['Rutin'])
                //->WhereIn('pengajuan_biaya.kategori', ['118','119','43','10'])
                //->Where('pengajuan_biaya.status', 0)
                // ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                // ->where('pengajuan_biaya.status_ka_akunting', 1)
                ->where('pengajuan_biaya.status_biaya_pusat', 1)
                ->whereIn('pengajuan_biaya.kode_depo', ['002','005','006','007','008'])
                //->Where('pengajuan_biaya.status_buat_spp', null)
                ->Where('pengajuan_biaya.status_buat_spp', 0)
                ->Where('pengajuan_biaya.kode_pengajuan_b','like','%'.$query.'%')
                ->groupBy('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.keterangan','pengajuan_biaya.kategori','ms_pengeluaran.pembayaran','pengajuan_biaya.id_user_input','users.name')
                ->get();
            }else{
                $data = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan_tujuan as kode_perusahaan','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga + pengajuan_biaya_detail.potongan) as total'),'pengajuan_biaya.kategori','ms_pengeluaran.pembayaran','pengajuan_biaya.id_user_input','users.name')
                // ->Where('pengajuan_biaya.kategori', ['Rutin'])
                //->WhereIn('pengajuan_biaya.kategori', ['118','119','43','10'])
                //->Where('pengajuan_biaya.status', 0)
                // ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                // ->where('pengajuan_biaya.status_ka_akunting', 1)
                ->where('pengajuan_biaya.status_biaya_pusat', 1)
                ->whereIn('pengajuan_biaya.kode_depo', ['002','005','006','007','008'])
                //->Where('pengajuan_biaya.status_buat_spp', null)
                ->Where('pengajuan_biaya.status_buat_spp', 0)
                ->groupBy('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.keterangan','pengajuan_biaya.kategori','ms_pengeluaran.pembayaran','pengajuan_biaya.id_user_input','users.name')
                ->get();
            }
             $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_request" data-pengajuan="'.$row->kode_pengajuan_b.'" data-tanggal="'.$row->tgl_pengajuan_b.'" data-perusahaan="'.$row->kode_perusahaan.'" data-keterangan="'.$row->keterangan.'" data-total="'.number_format($row->total).'" data-terbilang="'.terbilang($row->total).'"  data-idUser="'.$row->id_user_input.'" data-user="'.$row->name.'" data-kategori="'.$row->kategori.'" data-pembayaran="'.$row->pembayaran.'">
                            <td>'.$row->kode_pengajuan_b.'</td>
                            <td>'.$row->tgl_pengajuan_b.'</td>
                            <td>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->keterangan.'</td>
                            <td align="right">'.number_format($row->total).'</td>
                            <td hidden>'.$row->id_user_input.'</td>
                            <td hidden>'.$row->name.'</td>
                            <td hidden>'.$row->kategori.'</td>
                            <td hidden>'.$row->pembayaran.'</td>
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

    public function actionSparepart(Request $request) //jika menggunakan import rcm
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('rcm_spp_temp')
                        ->Where('rcm_spp_temp.status', 0)
                        ->Where('rcm_spp_temp.code','like','%'.$query.'%')
                        ->orWhere('rcm_spp_temp.no_kontrabon','like','%'.$query.'%')
                        ->orWhere('rcm_spp_temp.supplier_name','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('rcm_spp_temp')
                        ->where('rcm_spp_temp.status', 0)
                        ->get();
            }
             $total_row = $data->count();
            if($total_row > 0)
            {                              
                foreach ($data as $row) { 
                    $output .= '
                        <tr class="pilih_sparepart" data-code="'.$row->code.'" data-kontra="'.$row->no_kontrabon.'" data-supplier_code="'.$row->supplier_code.'" data-supplier="'.$row->supplier_name.'" data-total="'.number_format($row->total_value_kontrabon).'" data-terbilang="'.terbilang($row->total_value_kontrabon).'" data-jt="'.$row->date_payment.'" data-user="'.$row->user_created.'">
                            <td>'.$row->code.'</td>
                            <td>'.$row->no_kontrabon.'</td>
                            <td hidden>'.$row->supplier_code.'</td>
                            <td>'.$row->supplier_name.'</td>
                            <td align="right">'.number_format($row->total_value_kontrabon).'</td>
                            <td hidden>'.$row->date_payment.'</td>
                            <td hidden>'.$row->user_created.'</td>

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

    public function actionSparepartKontra(Request $request) //jika tidak menggunakan import rcm
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('kontrabon')->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                                            ->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
                                             ->join('users','kontrabon.id_user_input','=','users.id')
                                             ->select('kontrabon.no_kontrabon','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','users.name','sparepart_vendor.status as pajak')
                                             ->groupBy('kontrabon.no_kontrabon','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','users.name','sparepart_vendor.status')
                                            ->Where('kontrabon.status', 0)
                                            ->Where('kontrabon.no_kontrabon','like','%'.$query.'%')
                                            ->orWhere('sparepart_vendor.nama_vendor','like','%'.$query.'%')
                                            ->get();
            }else{
                $data = DB::table('kontrabon')->join('kontrabon_detail','kontrabon.no_kontrabon','=','kontrabon_detail.no_kontrabon')
                                             ->join('sparepart_vendor','kontrabon.kode_vendor','=','sparepart_vendor.kode_vendor')
                                             ->join('users','kontrabon.id_user_input','=','users.id')
                                             ->select('kontrabon.no_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','users.name','sparepart_vendor.status as pajak')
                                             ->groupBy('kontrabon.no_kontrabon','kontrabon.kode_vendor','sparepart_vendor.nama_vendor','kontrabon.total','kontrabon.jatuh_tempo','kontrabon.keterangan','users.name','sparepart_vendor.status')
                                             ->Where('kontrabon.status', 0)
                                            ->get();
            }
             $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_kontra_sparepart" data-kontrabon="'.$row->no_kontrabon.'" data-kodevendor="'.$row->kode_vendor.'" data-vendor="'.$row->nama_vendor.' / '.$row->pajak.'" data-total="'.number_format($row->total).'" data-terbilang="'. terbilang($row->total).'" data-jt="'.$row->jatuh_tempo.'" data-keterangan="'.$row->keterangan.'" data-user="'.$row->name.'" data-pajak="'.$row->pajak.'">
                            <td>'.$row->no_kontrabon.'</td>
                            <td hidden>'.$row->kode_vendor.'</td>
                            <td>'.$row->nama_vendor.'</td>
                            <td align="right">'.number_format($row->total).'</td>

                            <td hidden>'.$row->jatuh_tempo.'</td>
                            <td hidden>'.$row->keterangan.'</td>
                            <td hidden>'.$row->name.'</td>
                            <td hidden>'.$row->pajak.'</td>
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

    public function create()
    {	
    	
        $date = (date('Ym'));
        $date_1 = (date('Ymd'));

        
        
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        $dana = Spp_Sumberdana::orderBy('kode','ASC')->get();
        
    	//return view ('finance.spp.create', compact('perusahaan','dana','no_urut'));
        return view ('finance.spp.create', compact('perusahaan','dana'));
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            //'no_spp' => 'required|string|max:255',
            //'kontrabon' => 'required|string|max:255',
            //'no_order' => 'required|string|max:255'

            //'no_spp' => 'required|string|max:255'
        ]); 

        $kd_perusahaan = $request->get('kode_perusahaan_spp');
        $kd_sumber = $request->get('kode_sumber');
        // $date_1 = (date('dmY'));

        $tahun = date('Y');
        $bulan = date('m');

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

        $getRow = DB::table('spp')->select(DB::raw('MAX(RIGHT(no_spp,4)) as NoUrut'))->where('kode_perusahaan', $kd_perusahaan);
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            // if ($rowCount < 9) {
            //         $no_spp = $kd_perusahaan.'/'.$request->get('kode_supplier').'/SPP/'.$date_1.'/'."000".''.($rowCount + 1);
            // } else if ($rowCount < 99) {
            //         $no_spp = $kd_perusahaan.'/'.$request->get('kode_supplier').'/SPP/'.$date_1.'/'."00".''.($rowCount + 1);
            // } else if ($rowCount < 999) {
            //         $no_spp = $kd_perusahaan.'/'.$request->get('kode_supplier').'/SPP/'.$date_1.'/'."0".''.($rowCount + 1);
            // } else {
            //         $no_spp = $kd_perusahaan.'/'.$request->get('kode_supplier').'/SPP/'.$date_1.'/'.($rowCount + 1);
            // }

            if ($rowCount < 9) {
                $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->get('kode_supplier').'/'."000".''.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->get('kode_supplier').'/'."00".''.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->get('kode_supplier').'/'."0".''.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->get('kode_supplier').'/'.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            // $no_spp = $kd_perusahaan.'/'.$request->get('kode_supplier').'/SPP/'.$date_1.'/'.sprintf("%04s", 1);
            $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->get('kode_supplier').'/'.'0001'.'/'.$bulan_romawi.'/'.$tahun;
        }
		
		//---kode input SPP//
        $getRow_buat = DB::table('spp')
            ->select(DB::raw('MAX(kode_user_input_spp) as No_Urut_buat'))
            ->where('id_user_input', Auth::user()->id)
            ->whereMonth('tgl_approval_spp_2', $bulan)
            ->whereYear('tgl_approval_spp_2',$tahun);
        $rowCount_buat = $getRow_buat->count();

        if($rowCount_buat > 0){
            if ($rowCount_buat < 9) {
                $kode_buat_spp = Auth::user()->id.' 000'.''.($rowCount_buat + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'ADM.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount_buat < 99) {
                $kode_buat_spp = Auth::user()->id.' 00'.''.($rowCount_buat + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'ADM.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount_buat < 999) {
                $kode_buat_spp = Auth::user()->id.' 0'.''.($rowCount_buat + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'ADM.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $kode_buat_spp = Auth::user()->id.' '.($rowCount_buat + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'ADM.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            //$kode_buat_spp = '1'.'/'.$kode_divisi.'/'.$kode_depo;
            $kode_buat_spp = Auth::user()->id.' 0001'.'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'ADM.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
        }
        //---End kode input SPP//

        $getRow_u = DB::table('spp')->select(DB::raw('MAX(no_spp) as NoUrut'));
        $rowCount_u = $getRow_u->count();

        if ($rowCount_u > 0) {
            $no_urut = $rowCount_u + 1;
        }else{
            $no_urut = 1;
        }

        if(request()->bayar == 'kredit'){
            Spp::create([
                'no_urut' => $no_urut,
                'no_spp' => $no_spp,
                'tgl_spp' => Carbon::parse($request->get('tgl_spp')),
                'no_kontrabon' => $request->get('kontrabon'),
                'kode_pembelian' => '',
                'ditujukan' => $request->get('tujuan'),
                'metode_pembayaran' => $request->get('metode_pembayaran'),
                'kode_vendor' => $request->get('kode_supplier'),
                'for' => $request->get('supplier'),
                'jumlah' => str_replace(",", "", $request->get('total')),
                'jatuh_tempo' => Carbon::parse($request->get('jt')),
                'keterangan' => $request->get('ket'),
                'jenis' =>  $request->get('jenis_pembayaran'),
                'status' => '0',
                'id_user_input' => Auth::user()->id,
				'kode_user_input_spp' => $kode_buat_spp,
                'kode_perusahaan' => $request->get('kode_perusahaan_spp'),
                'sumber_dana' => $request->get('kode_sumber'),
                'pajak_masukan' => $request->get('pajak_masukan'),
                'pembayaran' => $request->get('norek'),
                'yang_mengajukan' => $request->get('request_by'),
                'status_pajak' => $request->get('status_pajak')
            ]);
        }else if(request()->bayar == 'sparepart'){
            Spp::create([
                'no_urut' => $no_urut,
                'no_spp' => $request->get('spp_sparepart'), //$no_spp,
                'tgl_spp' => Carbon::parse($request->get('tgl_spp')),
                'no_kontrabon' => $request->get('kontra_sparepart'),
                'kode_pembelian' => '',
                'ditujukan' => $request->get('tujuan'),
                'metode_pembayaran' => $request->get('metode_pembayaran'),
                'kode_vendor' => $request->get('kode_supplier'),
                'for' => $request->get('supplier'),
                'jumlah' => str_replace(",", "", $request->get('total')),
                'jatuh_tempo' => Carbon::parse($request->get('jt')),
                'keterangan' => $request->get('ket'),
                'jenis' =>  'Kredit (Cek)',
                'status' => '0',
                'id_user_input' => Auth::user()->id,
				'kode_user_input_spp' => $kode_buat_spp,
                'kode_perusahaan' => $request->get('kode_perusahaan_spp'),
                'sumber_dana' => $request->get('kode_sumber'),
                'pajak_masukan' => $request->get('pajak_masukan'),
                'pembayaran' => $request->get('norek'),
                'yang_mengajukan' => $request->get('request_by'),
                'status_pajak' => $request->get('status_pajak')
            ]);
        }else if(request()->bayar == 'tunai'){
            Spp::create([
                'no_urut' => $no_urut,
                'no_spp' => $no_spp,
                'tgl_spp' => Carbon::parse($request->get('tgl_spp')),
                'no_kontrabon' => $request->get('request'),
                'kode_pembelian' => $request->get('no_order'),
                'ditujukan' => $request->get('tujuan'),
                'metode_pembayaran' => $request->get('metode_pembayaran'),
                'kode_vendor' => $request->get('kode_supplier'),
                'for' => $request->get('supplier'),
                'jumlah' => str_replace(",", "", $request->get('total')),
                'jatuh_tempo' => Carbon::parse($request->get('jt')),
                'keterangan' => $request->get('ket'),
                'jenis' =>  $request->get('jenis_pembayaran'),
                'status' => '0',
                'id_user_input' => Auth::user()->id,
				'kode_user_input_spp' => $kode_buat_spp,
                'kode_perusahaan' => $request->get('kode_perusahaan_spp'),
                'sumber_dana' => $request->get('kode_sumber'),
                'pajak_masukan' => $request->get('pajak_masukan'),
                'pembayaran' => $request->get('norek'),
                'yang_mengajukan' => $request->get('request_by'),
                'status_pajak' => $request->get('status_pajak')
            ]);
        }else{
            Spp::create([
                'no_urut' => $no_urut,
                'no_spp' => $no_spp,
                'tgl_spp' => Carbon::parse($request->get('tgl_spp')),
                'no_kontrabon' => $request->get('kode_dokumen'),
                'kode_pembelian' => $request->get('no_order'),
                'ditujukan' => $request->get('tujuan'),
                'metode_pembayaran' => $request->get('metode_pembayaran'),
                'kode_vendor' => $request->get('kode_supplier'),
                'for' => $request->get('supplier'),
                'jumlah' => str_replace(",", "", $request->get('total')),
                'jatuh_tempo' => Carbon::parse($request->get('jt')),
                'keterangan' => $request->get('ket'),
                'jenis' =>  '-',
                'status' => '0',
                'id_user_input' => Auth::user()->id,
				'kode_user_input_spp' => $kode_buat_spp,
                'kode_perusahaan' => $request->get('kode_perusahaan_spp'),
                'sumber_dana' => $request->get('kode_sumber'),
                'pajak_masukan' => $request->get('pajak_masukan'),
                'pembayaran' => $request->get('norek'),
                'yang_mengajukan' => $request->get('request_by'),
                'status_pajak' => $request->get('status_pajak'),
                'kategori' => 'MANUAL'
            ]);

            //upload file
            if($request->hasfile('filename')) { 
                foreach ($request->file('filename') as $file) {
                    if ($file->isValid()) {
                        $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                        $file->move(public_path('images'), $filename);
                               
                        Pengajuan_Upload::create([
                            'kode_pengajuan' => $request->get('kode_dokumen'),
                            'description' => $request->get('ket'),
                            'filename' => $filename
                        ]);
                    }
                }
                echo 'Success';
            }else{
                echo 'Gagal';
            }
        }

        if(request()->bayar == 'kredit'){
            //----Ditutup Ditutup sementara untuk kebutuhan input manual
            $kontrabon_update = Kontrabon::find($request->get('kontrabon'));
            $kontrabon_update->update([
               'status' => '1'
            ]);
        }elseif(request()->bayar == 'sparepart'){
            //----Dibuka untuk import RCM, Ditutup jika tanpa import RCM
            $spp_sparepart_update = DB::table('rcm_spp_temp')->where('code', $request->get("spp_sparepart"))
                                    ->update([
                                        'status' =>'1'
                                    ]);

            //----Ditutup untuk import RCM, Dibuka jika tanpa import RCM
            //$kontrabon_update = Kontrabon::find($request->get('kontra_sparepart'));
            //$kontrabon_update->update([
              //  'status' => '1'
            //]);
        }elseif(request()->bayar == 'tunai'){
            $pengajuan_biaya_update = Pengajuan_Biaya::find($request->get('request'));
            $pengajuan_biaya_update->update([
                'status_buat_spp' => '1',
                'no_spp' => $no_spp,
                'tgl_spp' => Carbon::now()->format('Y-m-d'),
                'status' => '5'
            ]);
        }

        

        return redirect(route('spp.create'))->with(['success' => 'New SPP successfully created']);
        //return redirect(route('spp.spp_pdf',$request->get('no_urut'))) ->with(['success' => 'New SPP successfully created']);
    }

    public function pdf($no_urut)
    {   
        $tgl_cetak = Carbon::now()->format('d/m/y'); //h:i a

        $spp_pdf = DB::table('spp')->join('users','spp.id_user_input','=','users.id')
                        ->leftjoin('users AS ka_biaya','spp.id_user_approval_spp_1','=','ka_biaya.id')
                        ->leftjoin('users AS ka_acc','spp.id_user_approval_spp_2','=','ka_acc.id')
                        ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                        ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                        ->leftjoin('pengajuan_biaya','spp.no_spp','=','pengajuan_biaya.no_spp')
						->select('spp.no_urut','spp.no_spp','spp.tgl_spp','spp.no_kontrabon','spp.kode_pembelian',
						'spp.ditujukan','spp.for','spp.jumlah','spp.jatuh_tempo','spp.keterangan','spp.jenis',
						'spp.id_user_input','spp.kode_user_input_spp','spp.kode_depo','spp.sumber_dana','spp.pajak_masukan','spp.kode_vendor',
						'banks.nama_bank','spp.pembayaran','rekening_fin.atas_nama','spp.metode_pembayaran','spp.yang_mengajukan',
						'spp.kode_approved_spp_1','spp.kode_approved_spp_2','users.name','ka_biaya.name AS ka_biaya','ka_acc.name AS ka_acc',
                        'pengajuan_biaya.tgl_pengajuan_b','spp.tgl_spp','spp.tgl_approval_spp_1','spp.tgl_approval_spp_2')
                        ->where('spp.no_urut', $no_urut)
                        ->orderBy('spp.no_urut', 'ASC')
                        ->first();

        $sd_1 = DB::table('spp_sumber_dana')->where('kode',1)->first();
        $sd_2 = DB::table('spp_sumber_dana')->where('kode',2)->first();
        $sd_3 = DB::table('spp_sumber_dana')->where('kode',3)->first();
        $sd_4 = DB::table('spp_sumber_dana')->where('kode',4)->first();
        $sd_5 = DB::table('spp_sumber_dana')->where('kode',5)->first();

        $pdf = PDF::loadview('finance.spp.pdf', compact('spp_pdf','tgl_cetak','sd_1','sd_2','sd_3','sd_4','sd_5'));
        return $pdf->stream();
    }

    public function view($no_urut)
    {
        $spp_detail = DB::table('spp')->join('users','spp.id_user_input','=','users.id')
                        ->join('rekening_fin','spp.pembayaran','=','rekening_fin.norek')
                        ->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                        ->select('spp.no_urut','spp.no_spp','spp.tgl_spp','spp.no_kontrabon','spp.kode_pembelian','spp.kode_vendor','spp.ditujukan','spp.for','spp.jumlah','spp.jatuh_tempo','spp.keterangan','spp.jenis','spp.id_user_input','spp.kode_depo','spp.sumber_dana','spp.pajak_masukan','banks.nama_bank','spp.pembayaran','rekening_fin.atas_nama','spp.yang_mengajukan')
                        ->where('spp.no_urut', $no_urut)
                        ->orderBy('spp.no_urut', 'ASC')
                        ->first();

        return view ('finance.spp.view', compact('spp_detail'));
    }

    public function view_excel(Request $request)
    {
        $spp = DB::table('spp')->join('users','spp.id_user_input','=','users.id')
                        ->WhereBetween('spp.tgl_spp', [$request->tanggal_awal, $request->tanggal_akhir])
                        ->orderBy('spp.tgl_spp', 'ASC')
                        ->get();
        return view ('finance.spp.view_excel', compact('spp'));
    }


}
