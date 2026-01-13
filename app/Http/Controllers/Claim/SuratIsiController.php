<?php

namespace App\Http\Controllers\Claim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Perusahaan;
use App\MasterSuratIsi;
use App\MasterSuratIsiItem;
use Carbon\carbon;
use PDF;
use DB;
use Auth;

class SuratIsiController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $surat = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('perusahaans','ms_surat_isi.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('users','ms_surat_isi.user_input','=','users.id')
                        ->select('ms_surat_isi_item.kode_surat','ms_surat_isi.tanggal','perusahaans.nama_perusahaan','ms_surat_isi.prihal','ms_surat_isi.jenis',DB::raw('SUM(ms_surat_isi_item.amount) as total'),'users.name','ms_surat_isi.no_urut')
                        ->WhereBetween('ms_surat_isi.tanggal', [$date_start,$date_end])
                        ->groupBy('ms_surat_isi_item.kode_surat','ms_surat_isi.tanggal','perusahaans.nama_perusahaan','ms_surat_isi.prihal','ms_surat_isi.jenis','users.name','ms_surat_isi.no_urut')
                        ->get();

        $sub_total = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('perusahaans','ms_surat_isi.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('users','ms_surat_isi.user_input','=','users.id')
                        ->select(DB::raw('SUM(ms_surat_isi_item.amount) as sub_total'))
                        ->WhereBetween('ms_surat_isi.tanggal', [$date_start,$date_end])
                        ->Where('ms_surat_isi.jenis', 'Rupiah')
                        ->first();

    	return view ('claim.surat_isi.index', compact('surat','sub_total'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $surat = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('perusahaans','ms_surat_isi.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('users','ms_surat_isi.user_input','=','users.id')
                        ->select('ms_surat_isi_item.kode_surat','ms_surat_isi.tanggal','perusahaans.nama_perusahaan','ms_surat_isi.prihal','ms_surat_isi.jenis',DB::raw('SUM(ms_surat_isi_item.amount) as total'),'users.name','ms_surat_isi.no_urut')
                        ->WhereBetween('ms_surat_isi.tanggal', [$date_start,$date_end])
                        ->groupBy('ms_surat_isi_item.kode_surat','ms_surat_isi.tanggal','perusahaans.nama_perusahaan','ms_surat_isi.prihal','ms_surat_isi.jenis','users.name','ms_surat_isi.no_urut')
                        ->get();

        $sub_total = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('perusahaans','ms_surat_isi.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('users','ms_surat_isi.user_input','=','users.id')
                        ->select(DB::raw('SUM(ms_surat_isi_item.amount) as sub_total'))
                        ->WhereBetween('ms_surat_isi.tanggal', [$date_start,$date_end])
                        ->Where('ms_surat_isi.jenis', 'Rupiah')
                        ->first();

        return view ('claim.surat_isi.index', compact('surat','sub_total'));


    }


    public function create(Request $request)
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')
                        ->WhereIn('perusahaans.kode_perusahaan', ['TUA','TU','TA','WPS','LP'])
                        ->get();

        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get(); 

        // $getRow = DB::table('ms_surat_isi')->select(DB::raw('MAX(no_urut) as NoUrut'))->first();

        $rowCount = DB::table('ms_surat_isi')->select(DB::raw('MAX(no_urut) as NoUrut'))->first();
        if($rowCount->NoUrut > 0){
            $no_urut = $rowCount->NoUrut + 1;
        }else{
            $no_urut = '1';
        }


        return view ('claim.surat_isi.create', compact('perusahaan','depo','no_urut'));
    }

    public function actionDepo(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('depos')
                        ->Where('depos.kode_depo','like', '%'.$query.'%')
                        ->orWhere('depos.nama_depo','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('depos')
                        /*->Where('depos.kode_perusahaan','TUA')*/
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="pilih_depo" data-kode_depo="'.$row->kode_depo.'" data-nama_depo="'.$row->nama_depo.'">
                        <td>'.$row->kode_depo.'</td>
                        <td>'.$row->nama_depo.'</td>
                    </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">Data tidak ditemukan</td>
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

    public function actionSku(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('ms_surat_product')
                        ->Where('ms_surat_product.nama_produk','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('ms_surat_product')
                        /*->Where('depos.kode_perusahaan','TUA')*/
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="pilih_sku" data-kode_produk="'.$row->kode_produk.'" data-nama_produk="'.$row->nama_produk.'">
                        <td>'.$row->kode_produk.'</td>
                        <td>'.$row->nama_produk.'</td>
                    </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">Data tidak ditemukan</td>
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
        $this->validate($request,[
            
        ]);

        $tahun = date('Y', strtotime($request->get('tgl')));
        $bulan = date('m', strtotime($request->get('tgl')));
        $tanggal = date('d', strtotime($request->get('tgl')));
       
        $kd_perusahaan = $request->get('kode_perusahaan');

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


       /* $getRow = DB::table('ms_surat_isi')->select(DB::raw('MAX(kode_surat) as NoUrut'));
        $rowCount = $getRow->count();*/
        /*$rowCount = DB::table('ms_surat_isi')
				->select(DB::raw('MAX(no_urut) as NoUrut'))
				->first(); */
		
		$rowCount = DB::table('ms_surat_isi')
                ->select(DB::raw('COUNT(no_urut) as NoUrut'))
                ->where(DB::raw('RIGHT(kode_surat, 4)'), $tahun)
                ->first();

        if($rowCount->NoUrut > 0){
            $no_urut = $rowCount->NoUrut - 15;
            //$kodesurat = ($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;

            if ($no_urut < 9) {
                //$no_pengajuan_biaya = 'REQ '.'B'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                $kodesurat = '000'.''.($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($no_urut < 99) {
                //$no_pengajuan_biaya = 'REQ '.'B'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                $kodesurat = '00'.''.($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($no_urut < 999) {
                //$no_pengajuan_biaya = 'REQ '.'B'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                $kodesurat = '0'.''.($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                //$no_pengajuan_biaya = 'REQ '.'B'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
                $kodesurat = ($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            $no_urut = '0001';
            $kodesurat = '0001'.'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
        }
		
		$rowCount_no_urut = DB::table('ms_surat_isi')
                ->select(DB::raw('MAX(no_urut) as NoUrut'))
                ->first();
				
		$hasil_rowCount_no_urut = $rowCount_no_urut->NoUrut + 1;

        if(request()->jenis == 'rupiah'){
            MasterSuratIsi::create([
                'kode_surat' => $kodesurat,
                'kode_perusahaan' => $request->get('kode_perusahaan'), 
                'tanggal' => $request->get('tgl'), //Carbon::now()->format('Y-m-d'),
                'prihal' => $request->get('prihal'),
                'id_promo' => $request->get('id_promo'),
                'dokumen' => $request->get('dokumen'),
                'jenis' => 'Rupiah',
                'user_input' => Auth::user()->id,
                'no_urut' => $hasil_rowCount_no_urut,
                'menyetujui_ext' => $request->get('menyetujui'),
                'sebagai_ext' => $request->get('bagian'),
                'menyetujui_ext2' => $request->get('menyetujui_2'),
                'sebagai_ext2' => $request->get('bagian_2')
            ]);
        }else if(request()->jenis == 'box'){
            MasterSuratIsi::create([
                'kode_surat' => $kodesurat,
                'kode_perusahaan' => $request->get('kode_perusahaan'), 
                'tanggal' => $request->get('tgl'), //Carbon::now()->format('Y-m-d'),
                'prihal' => $request->get('prihal'),
                'id_promo' => $request->get('id_promo'),
                'dokumen' => $request->get('dokumen'),
                'jenis' => 'Box',
                'user_input' => Auth::user()->id,
                'no_urut' => $hasil_rowCount_no_urut,
                'menyetujui_ext' => $request->get('menyetujui'),
                'sebagai_ext' => $request->get('bagian'),
                'menyetujui_ext2' => $request->get('menyetujui_2'),
                'sebagai_ext2' => $request->get('bagian_2')
            ]);
        }
        

        if(request()->jenis == 'rupiah'){
            $datas=[];
            foreach ($request->input('kode_depo') as $key => $value) {
                    
            }
            $validator = Validator::make($request->all(), $datas);
            if($validator->passes()){
                foreach ($request->input("kode_depo") as $key => $value) {
                    $data = new MasterSuratIsiItem;

                    $data->kode_surat = $kodesurat;
                    $data->kode_depo = $request->get("kode_depo")[$key];
                    // $data->amount = $request->get("nominal")[$key];
                    $data->amount = str_replace(",", "", $request->get('nominal'))[$key];
                    $data->save();
                }
            }
        }else if(request()->jenis == 'box'){
            $datas=[];
            foreach ($request->input('cus') as $key => $value) {
                    
            }
            $validator = Validator::make($request->all(), $datas);
            if($validator->passes()){
                foreach ($request->input("cus") as $key => $value) {
                    $data = new MasterSuratIsiItem;

                    $data->kode_surat = $kodesurat;
                    $data->kode_depo = $request->get("cus")[$key];
                    // $data->amount = $request->get("nominal")[$key];
                    $data->amount = str_replace(",", "", $request->get('jumlah'))[$key];
                    $data->amount_2 = str_replace(",", "", $request->get('harga'))[$key];
                    $data->kode_produk = $request->get('kode_sku')[$key];
                    $data->save();
                }
            }
        }

        alert()->success('Success.','Surat Berhasil dibuat');
        return redirect()->route('isi_surat.index');

    }

    public function view($no_urut)
    {
        $jml_perusahaan = DB::table('ms_surat_isi')
                            ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                            ->join('depos','ms_surat_isi_item.kode_depo','=','depos.kode_depo')
                            ->select(DB::raw('count(distinct(depos.kode_perusahaan)) as jumlah_perusahaan'))
                            ->where('ms_surat_isi.no_urut', $no_urut)
                            ->first();

        $format = DB::table('ms_surat_isi')
                    ->join('ms_surat_template','ms_surat_isi.kode_perusahaan','=','ms_surat_template.kode_perusahaan')
                    ->join('perusahaans','ms_surat_template.kode_perusahaan','perusahaans.kode_perusahaan')
                    ->join('users','ms_surat_isi.user_input','=','users.id')
                    ->select('ms_surat_isi.kode_surat','ms_surat_isi.no_urut','ms_surat_isi.kode_perusahaan','ms_surat_isi.tanggal','ms_surat_isi.prihal as prihal_isi','ms_surat_isi.id_promo','ms_surat_isi.dokumen','ms_surat_isi.jenis','ms_surat_isi.user_input','users.name','ms_surat_template.id','ms_surat_template.kode_perusahaan','ms_surat_template.header_judul','ms_surat_template.header_alamat','ms_surat_template.kepada','ms_surat_template.alamat_tujuan_1','ms_surat_template.alamat_tujuan_2','ms_surat_template.alamat_tujuan_3','ms_surat_template.prihal','ms_surat_template.up','ms_surat_template.isi_1','ms_surat_template.isi_2','ms_surat_template.penutup','perusahaans.nama_perusahaan','ms_surat_isi.menyetujui_ext','ms_surat_isi.sebagai_ext','ms_surat_isi.menyetujui_ext2','ms_surat_isi.sebagai_ext2')
                    ->where('ms_surat_isi.no_urut', $no_urut)
                    ->first();

        $cari_depo = DB::table('ms_surat_isi')
                            ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                            ->select('ms_surat_isi_item.kode_depo')
                            ->where('ms_surat_isi.no_urut', $no_urut)
                            ->first();

        $jml_depo = DB::table('ms_surat_isi')
                            ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                            ->join('depos','ms_surat_isi_item.kode_depo','=','depos.kode_depo')
                            ->select(DB::raw('count(ms_surat_isi_item.kode_depo) as jumlah'))
                            ->where('ms_surat_isi.no_urut', $no_urut)
                            ->first();

        $format_detail = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('depos','ms_surat_isi_item.kode_depo','=','depos.kode_depo')
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->get();

        //======view untuk Box
        $header_sku = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('ms_surat_product','ms_surat_isi_item.kode_produk','=','ms_surat_product.kode_produk')
                        ->select('ms_surat_product.nama_produk','ms_surat_isi_item.amount','ms_surat_isi_item.amount_2')
                        ->Where('ms_surat_isi.no_urut', $no_urut)
                        ->get();

        $format_detail_box = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select('ms_surat_isi_item.kode_depo','ms_surat_isi_item.amount_2')
                        ->Where('ms_surat_isi.no_urut', $no_urut)
                        ->groupBy('ms_surat_isi_item.kode_depo','ms_surat_isi_item.amount_2')
                        ->get();

        $format_detail_box_total = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select(DB::raw('SUM(ms_surat_isi_item.amount) as total'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->first();

        $format_detail_box_total_rupiah = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select(DB::raw('SUM(ms_surat_isi_item.amount * ms_surat_isi_item.amount_2) as total,SUM(ms_surat_isi_item.amount_2) as amount_2'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->first();

         $total_sku_foot = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select(DB::raw('COUNT(ms_surat_isi_item.amount) as jml'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->first();

        // $format_detail_box = DB::table('ms_surat_isi')
        //                 ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
        //                 ->where('ms_surat_isi.no_urut', $no_urut)
        //                 ->get();

        // $format_detail_box_total = DB::table('ms_surat_isi')
        //                 ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
        //                 ->select(DB::raw('SUM(ms_surat_isi_item.amount + ms_surat_isi_item.amount_2) as total'))
        //                 ->where('ms_surat_isi.no_urut', $no_urut)
        //                 ->first();

        $format_total = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select('ms_surat_isi.kode_surat',DB::raw('SUM(ms_surat_isi_item.amount) as amount'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->groupBy('ms_surat_isi.kode_surat')
                        ->first();

        $format_jumlah = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select('ms_surat_isi.kode_surat',DB::raw('count(ms_surat_isi_item.amount) as jumlah'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->groupBy('ms_surat_isi.kode_surat')
                        ->first();

         return view('claim.surat_isi.view', compact('jml_perusahaan','jml_depo','format','cari_depo','format_detail','format_detail_box','header_sku','format_detail_box_total','format_detail_box_total_rupiah','total_sku_foot','format_total','format_jumlah'));
    }

    public function update(Request $request, $no_urut)
    {
        $depo = DB::table('depos')->orderBy('kode_perusahaan', 'ASC')->get(); 

        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')
                        ->WhereIn('perusahaans.kode_perusahaan', ['TUA','TU','TA','WPS','LP'])
                        ->get();

        $data_isi = DB::table('ms_surat_isi')
                    ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                    ->join('perusahaans','ms_surat_isi.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('users','ms_surat_isi.user_input','=','users.id')
                    ->select('ms_surat_isi.kode_surat',
                                'ms_surat_isi.no_urut',
                                'ms_surat_isi.kode_perusahaan',
                                'ms_surat_isi.tanggal',
                                'perusahaans.nama_perusahaan',
                                'ms_surat_isi.prihal',
                                'ms_surat_isi.id_promo',
                                'ms_surat_isi.jenis',
                                'ms_surat_isi.dokumen',
                                'ms_surat_isi.menyetujui_ext',
                                'ms_surat_isi.menyetujui_ext2',
                                'ms_surat_isi.sebagai_ext',
                                'ms_surat_isi.sebagai_ext2'
                            )
                    ->where('ms_surat_isi.no_urut', $no_urut)
                    ->first();

        $data_isi_detail = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('depos','ms_surat_isi_item.kode_depo','=','depos.kode_depo')
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->get();

        $data_isi_detail_box = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('ms_surat_product','ms_surat_isi_item.kode_produk','=','ms_surat_product.kode_produk')
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->get();

        return view ('claim.surat_isi.edit', compact('depo','perusahaan','data_isi','data_isi','data_isi_detail','data_isi_detail_box'));
    }

    public function edit(Request $request)
    {   
        
        $tahun = substr($request->get('tgl'), -4);
        $bulan = substr($request->get('tgl'), 3,-5);
        $tanggal = substr($request->get('tgl'),0,-8);
        $kd_perusahaan = $request->get('kode_perusahaan');
        $tgl_surat = $request->get('tgl');

        $tgl_surat = $tahun.'-'.$bulan.'-'.$tanggal;  
        

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

        // $rowCount = DB::table('ms_surat_isi')
        //             ->select(DB::raw('no_urut'))
        //             ->Where('ms_surat_isi.no_urut', $request->get("no_urut"))
        //             ->first();

        $kodesurat_kiriempat = DB::table('ms_surat_isi')
                    ->select(DB::raw('left(kode_surat,4) as kode_urut'))
                    ->Where('ms_surat_isi.no_urut', $request->get("no_urut"))
                    ->first();

        $kodesurat = $kodesurat_kiriempat->kode_urut.'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;


        // $rowCount = DB::table('ms_surat_isi')
        //         ->select(DB::raw('COUNT(no_urut) as NoUrut'))
        //         ->where(DB::raw('RIGHT(kode_surat, 4)'), $tahun)
        //         ->first();

        // $no_urut = $rowCount->NoUrut;
        // $kodesurat = ($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;

        // if($rowCount->no_urut > 0){
        //     $no_urut = $rowCount->no_urut;
        //     //$kodesurat = ($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;

        //     if ($no_urut < 9) {
        //         //$no_pengajuan_biaya = 'REQ '.'B'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        //         $kodesurat = '000'.''.($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
        //     } else if ($no_urut < 99) {
        //         //$no_pengajuan_biaya = 'REQ '.'B'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        //         $kodesurat = '00'.''.($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
        //     } else if ($no_urut < 999) {
        //         //$no_pengajuan_biaya = 'REQ '.'B'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        //         $kodesurat = '0'.''.($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
        //     } else {
        //         //$no_pengajuan_biaya = 'REQ '.'B'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        //         $kodesurat = ($no_urut).'/CL-'.$kd_perusahaan.'/'.$tanggal.'/'.$bulan_romawi.'/'.$tahun;
        //     }
        // }

        $edit_head = MasterSuratIsi::find($request->get('kode_surat'));
        $edit_head->update([
            'kode_surat' => $kodesurat,
            'kode_perusahaan' => $request->get("kode_perusahaan"),
            'tanggal' => $tgl_surat,
            'prihal' => $request->get("prihal"),
            'id_promo' => $request->get("id_promo"),
            'dokumen' => $request->get("dokumen"),
            'menyetujui_ext' => $request->get("menyetujui"),
            'sebagai_ext' => $request->get("bagian"),
            'menyetujui_ext2' => $request->get("menyetujui_2"),
            'sebagai_ext2' => $request->get("bagian_2")
        ]);

        $data_jenis = DB::table('ms_surat_isi')->select('jenis')
                    ->Where('ms_surat_isi.no_urut', $request->get("no_urut"))
                    ->first();

        if($data_jenis->jenis == 'Rupiah'){
            $hapus_detail = DB::table('ms_surat_isi_item')->Where('ms_surat_isi_item.kode_surat', $request->get("kode_surat"))->delete();

            $datas=[];
            foreach ($request->input('kode_depo') as $key => $value) {
                    
            }
            $validator = Validator::make($request->all(), $datas);
            if($validator->passes()){
                foreach ($request->input("kode_depo") as $key => $value) {
                    $data = new MasterSuratIsiItem;

                    $data->kode_surat = $kodesurat;
                    $data->kode_depo = $request->get("kode_depo")[$key];
                    $data->amount = str_replace(",", "", $request->get('amount'))[$key];
                    $data->save();
                }
            }
			
        }else{
            $hapus_detail = DB::table('ms_surat_isi_item')->Where('ms_surat_isi_item.kode_surat', $request->get("kode_surat"))->delete();

            $datas=[];
            foreach ($request->input('customer') as $key => $value) {
                    
            }
            $validator = Validator::make($request->all(), $datas);
            if($validator->passes()){
                foreach ($request->input("customer") as $key => $value) {
                    $data = new MasterSuratIsiItem;

                    $data->kode_surat = $kodesurat;
                    $data->kode_depo = $request->get("customer")[$key];
                    $data->amount = str_replace(",", "", $request->get('jumlah'))[$key];
                    $data->amount_2 = str_replace(",", "", $request->get('harga'))[$key];
                    $data->kode_produk = $request->get('kode_sku')[$key];
                    $data->save();
                }
            }
        }

        return redirect(route('isi_surat.index'))->with(['success' => 'Data berhasil diubah']);
    }

    public function pdf($no_urut)
    {
        $jml_perusahaan = DB::table('ms_surat_isi')
                            ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                            ->join('depos','ms_surat_isi_item.kode_depo','=','depos.kode_depo')
                            ->select(DB::raw('count(distinct(depos.kode_perusahaan)) as jumlah_perusahaan'))
                            ->where('ms_surat_isi.no_urut', $no_urut)
                            ->first();

        $format = DB::table('ms_surat_isi')
                    ->join('ms_surat_template','ms_surat_isi.kode_perusahaan','=','ms_surat_template.kode_perusahaan')
                    ->join('perusahaans','ms_surat_template.kode_perusahaan','perusahaans.kode_perusahaan')
                    ->join('users','ms_surat_isi.user_input','=','users.id')
                    ->select('ms_surat_isi.kode_surat','ms_surat_isi.no_urut','ms_surat_isi.kode_perusahaan','ms_surat_isi.tanggal','ms_surat_isi.prihal as prihal_isi','ms_surat_isi.id_promo','ms_surat_isi.dokumen','ms_surat_isi.jenis','ms_surat_isi.user_input','users.name','ms_surat_template.id','ms_surat_template.kode_perusahaan','ms_surat_template.header_judul','ms_surat_template.header_alamat','ms_surat_template.kepada','ms_surat_template.alamat_tujuan_1','ms_surat_template.alamat_tujuan_2','ms_surat_template.alamat_tujuan_3','ms_surat_template.prihal','ms_surat_template.up','ms_surat_template.isi_1','ms_surat_template.isi_2','ms_surat_template.penutup','perusahaans.nama_perusahaan','ms_surat_isi.menyetujui_ext','ms_surat_isi.sebagai_ext','ms_surat_isi.menyetujui_ext2','ms_surat_isi.sebagai_ext2')
                    ->where('ms_surat_isi.no_urut', $no_urut)
                    ->first();

        $cari_depo = DB::table('ms_surat_isi')
                            ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                            ->select('ms_surat_isi_item.kode_depo')
                            ->where('ms_surat_isi.no_urut', $no_urut)
                            ->first();

        $jml_depo = DB::table('ms_surat_isi')
                            ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                            ->join('depos','ms_surat_isi_item.kode_depo','=','depos.kode_depo')
                            ->select(DB::raw('count(ms_surat_isi_item.kode_depo) as jumlah'))
                            ->where('ms_surat_isi.no_urut', $no_urut)
                            ->first();

        $format_detail = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('depos','ms_surat_isi_item.kode_depo','=','depos.kode_depo')
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->get();

        //======view untuk Box
        $header_sku = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->join('ms_surat_product','ms_surat_isi_item.kode_produk','=','ms_surat_product.kode_produk')
                        ->select('ms_surat_product.nama_produk','ms_surat_isi_item.amount','ms_surat_isi_item.amount_2')
                        ->Where('ms_surat_isi.no_urut', $no_urut)
                        ->get();

        $format_detail_box = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select('ms_surat_isi_item.kode_depo','ms_surat_isi_item.amount_2')
                        ->Where('ms_surat_isi.no_urut', $no_urut)
                        ->groupBy('ms_surat_isi_item.kode_depo','ms_surat_isi_item.amount_2')
                        ->get();

        $format_detail_box_total = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select(DB::raw('SUM(ms_surat_isi_item.amount) as total'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->first();

        $format_detail_box_total_rupiah = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select(DB::raw('SUM(ms_surat_isi_item.amount * ms_surat_isi_item.amount_2) as total,SUM(ms_surat_isi_item.amount_2) as amount_2'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->first();

        $total_sku_foot = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select(DB::raw('COUNT(ms_surat_isi_item.amount) as jml'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->first();

        // $format_detail_box = DB::table('ms_surat_isi')
        //                 ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
        //                 ->where('ms_surat_isi.no_urut', $no_urut)
        //                 ->get();

        // $format_detail_box_total = DB::table('ms_surat_isi')
        //                 ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
        //                 ->select(DB::raw('SUM(ms_surat_isi_item.amount + ms_surat_isi_item.amount_2) as total'))
        //                 ->where('ms_surat_isi.no_urut', $no_urut)
        //                 ->first();

        $format_total = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select('ms_surat_isi.kode_surat',DB::raw('SUM(ms_surat_isi_item.amount) as amount'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->groupBy('ms_surat_isi.kode_surat')
                        ->first();

        $format_jumlah = DB::table('ms_surat_isi')
                        ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
                        ->select('ms_surat_isi.kode_surat',DB::raw('count(ms_surat_isi_item.amount) as jumlah'))
                        ->where('ms_surat_isi.no_urut', $no_urut)
                        ->groupBy('ms_surat_isi.kode_surat')
                        ->first();


        $pdf = PDF::loadview('claim.surat_isi.pdf', compact('jml_perusahaan','jml_depo','format','cari_depo','format_detail','header_sku','format_detail_box','format_detail_box_total','format_detail_box_total_rupiah','total_sku_foot','format_total','format_jumlah'));
        return $pdf->stream();
    }


}
