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


class SppGroupController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();

        $biaya = DB::table('pengajuan_biaya')
                ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan_tujuan as kode_perusahaan','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga + pengajuan_biaya_detail.potongan) as total'),'pengajuan_biaya.kategori','ms_pengeluaran.pembayaran','pengajuan_biaya.id_user_input','users.name')
                // ->Where('pengajuan_biaya.kategori', ['Rutin'])
                //->WhereIn('pengajuan_biaya.kategori',  ['118','119','43','10'])
                // ->Where('pengajuan_biaya.status', 0)
                // ->Where('pengajuan_biaya.status_biaya_pusat', 1)
                // ->where('pengajuan_biaya.status_ka_akunting', 1)
                ->where('pengajuan_biaya.status_biaya_pusat', 1)
                ->whereIn('pengajuan_biaya.kode_depo', ['002','005','006','007','008'])
                //->Where('pengajuan_biaya.status_buat_spp', null)
                ->Where('pengajuan_biaya.status_buat_spp', 0)
                ->groupBy('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kode_perusahaan_tujuan','pengajuan_biaya.keterangan','pengajuan_biaya.kategori','ms_pengeluaran.pembayaran','pengajuan_biaya.id_user_input','users.name')
                ->get();

        $sparepart = DB::table('rcm_spp_temp')
                ->where('rcm_spp_temp.status', 0)
                ->get();

    
        return view ('finance.spp_group.index', compact('perusahaan','biaya','sparepart'));
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

    public function store(Request $request)
    {
        $getRowGroup = DB::table('spp')->select(DB::raw('MAX(no_spp) as NoUrut'));
        $rowCountGroup = $getRowGroup->count();

        // $kode_pengajuan = $request->kode_pengajuan_b;

        // if(!$kode_pengajuan || count($kode_pengajuan) == 0){
        //     return response()->json([
        //         'message' => 'Tidak ada data yang dikirim'
        //     ], 400);
        // }

        $selected = $request->selected_pengajuan;

        if(!$selected || count($selected) == 0){
            return response()->json([
                'message' => 'Tidak ada data yang dipilih'
            ], 400);
        }

        foreach($request->kode_pengajuan_b as $i => $kode){
            if (!in_array($kode, $selected)) {
                continue;
            }
            
            $getRow = DB::table('spp')->select(DB::raw('MAX(no_spp) as NoUrut'));
            $rowCount = $getRow->count();

            if ($rowCount > 0) {
                $no_urut = $rowCount + 1;
            }else{
                $no_urut = 1;
            }

            $kd_perusahaan = $request->kode_perusahaan_spp[$i];
            
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
                if ($rowCount < 9) {
                    $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->kode_vendor[$i].'/'."000".''.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 99) {
                    $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->kode_vendor[$i].'/'."00".''.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
                } else if ($rowCount < 999) {
                    $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->kode_vendor[$i].'/'."0".''.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
                } else {
                    $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->kode_vendor[$i].'/'.($rowCount + 1).'/'.$bulan_romawi.'/'.$tahun;
                }
            }else{
                // $no_spp = $kd_perusahaan.'/'.$request->kode_vendor[$i].'/SPP/'.$date_1.'/'.sprintf("%04s", 1);
                $no_spp = 'SPP '.''.$kd_perusahaan.'/'.$request->kode_vendor[$i].'/'.'0001'.'/'.$bulan_romawi.'/'.$tahun;
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
            
            DB::table('spp')->insert([
                'no_urut' => $no_urut,
                'no_spp' => $no_spp,
                'tgl_spp' => Carbon::now()->format('Y-m-d'),
                'no_kontrabon' => $kode,
                'kode_pembelian' => '',
                'ditujukan' => $request->ditujukan[$i],
                'metode_pembayaran' => $request->metode_pembayaran[$i],
                'kode_vendor' => $request->kode_vendor[$i],
                'for' => $request->supplier[$i],
                'jumlah' => str_replace(",", "", $request->total[$i]),
                'jatuh_tempo' => Carbon::parse($request->jt[$i]),
                'keterangan' => $request->keterangan[$i],
                'jenis' =>  $request->pembayaran[$i],
                'status' => '0',
                'id_user_input' => Auth::user()->id,
				'kode_user_input_spp' => $kode_buat_spp,
                'kode_perusahaan' => $request->kode_perusahaan_spp[$i],
                'sumber_dana' => '',
                'pajak_masukan' => $request->fktur_pajak[$i],
                'pembayaran' => $request->norek[$i],
                'yang_mengajukan' => $request->nama_user[$i],
                'status_pajak' => '',
                'no_group' => $rowCountGroup,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $pengajuan_biaya_update = Pengajuan_Biaya::find($kode);
            $pengajuan_biaya_update->update([
                'status_buat_spp' => '1',
                'no_spp' => $no_spp,
                'tgl_spp' => Carbon::now()->format('Y-m-d'),
                'status' => '5'
            ]);
        }

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'success' => true,
            'no_group' => $rowCountGroup
        ], 200);
    }

    public function pdf($no_group)
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
                        ->where('spp.no_group', $no_group)
                        ->orderBy('spp.no_urut', 'ASC')
                        ->get();

        $sd_1 = DB::table('spp_sumber_dana')->where('kode',1)->first();
        $sd_2 = DB::table('spp_sumber_dana')->where('kode',2)->first();
        $sd_3 = DB::table('spp_sumber_dana')->where('kode',3)->first();
        $sd_4 = DB::table('spp_sumber_dana')->where('kode',4)->first();
        $sd_5 = DB::table('spp_sumber_dana')->where('kode',5)->first();

        $pdf = PDF::loadview('finance.spp_group.pdf', compact('spp_pdf','tgl_cetak','sd_1','sd_2','sd_3','sd_4','sd_5'));
        return $pdf->stream('finance.spp_group.pdf');
    }
}
