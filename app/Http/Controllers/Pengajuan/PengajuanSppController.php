<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Divisi;
use App\Pengajuan_Biaya;
use App\Pengajuan_Biaya_Detail;
use App\JurnalUmum;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class PengajuanSppController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $request_detail = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','pengajuan_biaya.tipe',DB::raw('SUM(pengajuan_biaya_detail.tharga) as total'),'pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.keterangan')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', [10])
                    ->groupBy('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.keterangan')
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b','Desc')
                    ->get();

        $sum = DB::table('pengajuan_biaya')
                    ->select(DB::raw('count(pengajuan_biaya.kode_pengajuan_b) as sum'))
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', [10])
                    ->first();

        $jumlah = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->select(DB::raw('sum(pengajuan_biaya_detail.tharga) as total'))
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', [10])
                    ->first();

        return view ('pengajuan.pengajuan_spp.index', compact('request_detail','sum','jumlah'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $request_detail = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                    ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
                    ->join('users','pengajuan_biaya.id_user_input','=','users.id')
                    ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                    ->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','pengajuan_biaya.tipe',DB::raw('SUM(pengajuan_biaya_detail.tharga) as total'),'pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.keterangan')
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', [10])
                    ->groupBy('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.status','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.keterangan')
                    ->orderBy('pengajuan_biaya.tgl_pengajuan_b','Desc')
                    ->get();

        $sum = DB::table('pengajuan_biaya')
                    ->select(DB::raw('count(pengajuan_biaya.kode_pengajuan_b) as sum'))
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', [10])
                    ->first();

        $jumlah = DB::table('pengajuan_biaya')
                    ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                    ->select(DB::raw('sum(pengajuan_biaya_detail.tharga) as total'))
                    ->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
                    ->WhereIn('pengajuan_biaya.kategori', [10])
                    ->first();

        return view ('pengajuan.pengajuan_spp.index', compact('request_detail','sum','jumlah'));
    }

    public function view($no_urut)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')->where('pengajuan_biaya_detail.no_urut',$no_urut)->get();

        $pengajuan_biaya_detail_total = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');

        return view('pengajuan.pengajuan_spp.view', compact('pengajuan_biaya_head','pengajuan_biaya_detail','pengajuan_biaya_detail_total'));
    }

    public function view_approval($no_urut)
    {
        $data = DB::table('pengajuan_biaya')
                    ->leftjoin('users','pengajuan_biaya.id_user_approval_biaya_pusat','=','users.id')
                    ->leftjoin('users as user_1','pengajuan_biaya.id_user_approval_biaya','=','user_1.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b')
                    ->where('pengajuan_biaya.no_urut', $no_urut)
                    ->first();

        $data_approval = DB::table('pengajuan_biaya')
                    ->leftjoin('users','pengajuan_biaya.id_user_approval_biaya_pusat','=','users.id')
                    ->leftjoin('users as user_1','pengajuan_biaya.id_user_approval_biaya','=','user_1.id')
                    ->select('pengajuan_biaya.kode_pengajuan_b','users.name as biaya_pusat','user_1.name as biaya')
                    ->where('pengajuan_biaya.no_urut', $no_urut)
                    ->get();

        return view('pengajuan.pengajuan_spp.view_approval', compact('data','data_approval'));
    }

    public function create()
    {	
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();

    	$data = DB::table('pengajuan_biaya')
        		->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
        		->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', ['-','-'])
        		->Where('pengajuan_biaya.kategori', 7)
        		->get();

       	$datatotal = DB::table('pengajuan_biaya')
        		->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
        		->select(DB::raw('SUM(pengajuan_biaya_detail.tharga) as tharga'))
        		->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', ['-','-'])
        		->Where('pengajuan_biaya.kategori', 7)
        		->first();

        $getRow = DB::table('pengajuan_biaya')->select(DB::raw('MAX(kode_pengajuan_b) as NoUrut'));
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
            $no_urut = $rowCount + 1;
        }else{
            $no_urut = 1;
        }

    	return view ('pengajuan.pengajuan_spp.create', compact('perusahaan','data','no_urut','datatotal'));	
    }



    public function cari_data(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data = DB::table('pengajuan_biaya')
        		->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
        		->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
        		->Where('pengajuan_biaya.kategori', 7)
        		->get();

        $datatotal = DB::table('pengajuan_biaya')
        		->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
        		->select(DB::raw('SUM(pengajuan_biaya_detail.tharga) as tharga'))
        		->WhereBetween('pengajuan_biaya.tgl_pengajuan_b', [$date_start,$date_end])
        		->Where('pengajuan_biaya.kategori', 7)
        		->first();

        $getRow = DB::table('pengajuan_biaya')->select(DB::raw('MAX(kode_pengajuan_b) as NoUrut'));
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
            $no_urut = $rowCount + 1;
        }else{
            $no_urut = 1;
        }

        return view ('pengajuan.pengajuan_spp.create', compact('data','no_urut','datatotal'));
    }

    public function actionBiaya(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if ($request->tanggal_awal && $request->tanggal_akhir && $query != '') {
                $data = DB::table('pengajuan_biaya')
                            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan','depos.nama_depo','ms_pengeluaran.sifat','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.kode_vendor','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga','pengajuan_biaya_detail.no_urut','pengajuan_biaya.status','pengajuan_biaya.status_buat_spp')
                            ->Where('pengajuan_biaya.status_buat_spp', '0')
                            //->WhereIn('pengajuan_biaya.kategori', ['33','9','12','21','17','18','11','16'])
                            ->whereNotIn('pengajuan_biaya.kode_depo',['002'])
                            ->WhereNotIn('pengajuan_biaya.kategori', ['118','119','43'])
                            ->whereBetween('pengajuan_biaya.tgl_pengajuan_b', [$request->tanggal_awal, $request->tanggal_akhir])
                            ->where(function($q) use ($query) {
                                $q->where('pengajuan_biaya.kode_pengajuan_b','like','%'.$query.'%')
                                  ->orWhere('pengajuan_biaya_detail.description','like','%'.$query.'%')
                                  ->orWhere('depos.nama_depo','like','%'.$query.'%');
                            })
                            ->get();
            }elseif($request->tanggal_awal && $request->tanggal_akhir && $query == '') {
                $data = DB::table('pengajuan_biaya')
                            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan','depos.nama_depo','ms_pengeluaran.sifat','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.kode_vendor','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga','pengajuan_biaya_detail.no_urut','pengajuan_biaya.status','pengajuan_biaya.status_buat_spp')
                            ->Where('pengajuan_biaya.status_buat_spp', '0')
                            //->WhereIn('pengajuan_biaya.kategori', ['33','9','12','21','17','18','11','16'])
                            ->whereNotIn('pengajuan_biaya.kode_depo',['002'])
                            ->WhereNotIn('pengajuan_biaya.kategori', ['118','119','43'])
                            ->whereBetween('pengajuan_biaya.tgl_pengajuan_b', [$request->tanggal_awal, $request->tanggal_akhir])
                            
                            ->get();
            }elseif($query != ''){
                $data = DB::table('pengajuan_biaya')
                            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan','depos.nama_depo','ms_pengeluaran.sifat','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.kode_vendor','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga','pengajuan_biaya_detail.no_urut','pengajuan_biaya.status','pengajuan_biaya.status_buat_spp')
                            ->Where('pengajuan_biaya.status_buat_spp', '0')
                            //->WhereIn('pengajuan_biaya.kategori', ['33','9','12','21','17','18','11','16'])
                            ->whereNotIn('pengajuan_biaya.kode_depo',['002'])
                            ->WhereNotIn('pengajuan_biaya.kategori', ['118','119','43'])
                            ->Where('pengajuan_biaya.kode_pengajuan_b','like','%'.$query.'%')
                            ->orWhere('pengajuan_biaya_detail.description','like','%'.$query.'%')
                            ->orWhere('depos.nama_depo','like','%'.$query.'%')
                            ->get();
            }else{
                $data = DB::table('pengajuan_biaya')
                            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
                            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
                            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
                            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.kode_perusahaan','depos.nama_depo','ms_pengeluaran.sifat','pengajuan_biaya_detail.description','pengajuan_biaya_detail.spesifikasi','pengajuan_biaya_detail.kode_vendor','pengajuan_biaya_detail.no_rekening','pengajuan_biaya_detail.bank','pengajuan_biaya_detail.pemilik_rekening','pengajuan_biaya_detail.qty','pengajuan_biaya_detail.harga','pengajuan_biaya_detail.jml_harga','pengajuan_biaya_detail.potongan','pengajuan_biaya_detail.tharga','pengajuan_biaya_detail.no_urut','pengajuan_biaya.status','pengajuan_biaya.status_buat_spp')
                            ->Where('pengajuan_biaya.status_buat_spp', '0')
                            //->WhereIn('pengajuan_biaya.kategori', ['33','9','12','21','17','18','11','16'])
                            ->whereNotIn('pengajuan_biaya.kode_depo',['002'])
                            ->WhereNotIn('pengajuan_biaya.kategori', ['118','119','43'])
                            ->get(); 
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) 
                {
                    $output .= '
                        <tr class="pilih_biaya" 
                            data-id="'.$row->kode_pengajuan_b.'" 
                            data-tgl="'.$row->tgl_pengajuan_b.'"
                            data-uraian="'.$row->description.'" 
                            data-spek="'.$row->spesifikasi.'"
                            data-kode_vendor="'.$row->kode_vendor.'"
                            data-no_rek="'.$row->no_rekening.'"
                            data-bank="'.$row->bank.'"
                            data-pemilik="'.$row->pemilik_rekening.'" 
                            data-qty="'.$row->qty.'" 
                            data-harga="'.number_format($row->harga).'" 
                            data-jml_harga="'.number_format($row->jml_harga).'"  
                            data-potongan="'.number_format($row->potongan).'"
                            data-tharga="'.number_format($row->tharga).'"
                            data-no_urut="'.$row->no_urut.'"
                            data-kode_perusahaan="'.$row->kode_perusahaan.'"
                            data-nama_depo="'.$row->nama_depo.'">

                            <td><input type="checkbox" class="checkItem"></td>
                            <td>'.$row->kode_pengajuan_b.'</td>
                            <td>'.$row->tgl_pengajuan_b.'</td>
                            <td>'.$row->description.'</td>
                            <td>'.$row->spesifikasi.'</td>
                            <td hidden>'.$row->kode_vendor.'</td>
                            <td hidden>'.$row->no_rekening.'</td>
                            <td hidden>'.$row->bank.'</td>
                            <td hidden>'.$row->pemilik_rekening.'</td>
                            <td hidden>'.$row->qty.'</td>
                            <td hidden>'.number_format($row->harga).'</td>
                            <td hidden>'.number_format($row->jml_harga).'</td>
                            <td hidden>'.number_format($row->potongan).'</td>
                            <td>'.number_format($row->tharga).'</td>
                            <td hidden>'.$row->no_urut.'</td>
                            <td hidden>'.$row->kode_perusahaan.'</td>
                            <td>'.$row->nama_depo.'</td>
                        </tr>
                    ';    
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="10">No Data Found</td>
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
    	$this->validate($request, [

        ]);

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

        //$kd_perusahaan = $request->get('kode_perusahaan');
        $kd_perusahaan_tujuan = $request->get('kode_perusahaan_tujuan');
        $kode_depo = $request->get('kode_depo');
        $kode_divisi = $request->get('kode_divisi');
        //$id_kat = $request->get('id_pengeluaran');

        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',$kode_depo)->first();

        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getRow = DB::table('pengajuan_biaya')
                    ->select(DB::raw('MAX(kode_pengajuan_b) as NoUrut'))
                    ->where('kode_perusahaan_tujuan', $kd_perusahaan_tujuan)
                    ->where('kode_depo', $kode_depo)
                    ->where('kode_divisi', $kode_divisi);
        $rowCount = $getRow->count();


        if($rowCount > 0){
            //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
            if ($rowCount < 9) {
                $no_pengajuan_biaya = 'REQ '.'B'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_pengajuan_biaya = 'REQ '.'B'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_pengajuan_biaya = 'REQ '.'B'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_pengajuan_biaya = 'REQ '.'B'.''.($rowCount + 1).'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            //$no_pengajuan_biaya = '1'.'/'.$kode_divisi.'/'.$kode_depo;
            $no_pengajuan_biaya = 'REQ '.'B'.'0001'.'/'.$kd_perusahaan_tujuan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        }

        //header
        Pengajuan_Biaya::create([
            'kode_pengajuan_b' => $no_pengajuan_biaya,
            'tgl_pengajuan_b' => Carbon::now()->format('Y-m-d'),
            'kategori' => $request->get('id_pengeluaran'),
            'tipe' => $request->get('tipe'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kode_depo' => $request->get('kode_depo'),
            'kode_divisi' => $request->get('kode_divisi'),
            'kode_perusahaan_tujuan' => $request->get('kode_perusahaan_tujuan'),
            'status' => '0', //Note: untuk biaya non rutin yang sudah dibuatkan pengajuan SPP
            'keterangan' => $request->get('ket'),
            'id_user_input' => Auth::user()->id,
            'no_urut' => $request->get('no_urut')
        ]);

        //detail
        Pengajuan_Biaya_Detail::create([
            'kode_pengajuan_b' => $no_pengajuan_biaya,
            'no_description_detail' => '1',
            'description' => $request->get('ket'),
            'spesifikasi' => $request->get('ket'),
            'qty' => '1',
            'harga' => $request->get('total_biaya_temp'),
            'jml_harga' => $request->get('total_biaya_temp'),
            'potongan' => '0',
            'tharga' => $request->get('total_biaya_temp'),
            'no_urut' => $request->get('no_urut')
        ]);


        $datas=[];
        foreach ($request->input("kode") as $key => $value) {
        }
        $validator = Validator::make($request->all(), $datas);
        // if($validator->passes()){
            foreach ($request->input("kode") as $key => $value) {
                

                $update = DB::table('pengajuan_biaya')->where('kode_pengajuan_b', $request->get("kode")[$key])
                    ->update([
                        'status_buat_spp' => 1,
                        'no_spp' => $no_pengajuan_biaya
                    ]);
            }
        // }

        alert()->success('Success.','Pengajuan Berhasil');
        return redirect()->route('pengajuan_spp.index');
    }

    public function pdf($no_urut)
    {
        $pengajuan_biaya_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $pengajuan_biaya_detail = DB::table('pengajuan_biaya_detail')->where('pengajuan_biaya_detail.no_urut',$no_urut)->get();

        $total_jml = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');

        $pdf = PDF::loadview('pengajuan.pengajuan_spp.pdf', compact('pengajuan_biaya_head','pengajuan_biaya_detail','total_jml'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }


}
