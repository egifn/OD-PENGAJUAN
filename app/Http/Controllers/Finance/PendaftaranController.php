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
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function index()
    {
    	$perusahaan = Perusahaan::orderBy('nama_perusahaan', 'ASC')->get();
    	$bank = Bank::orderBy('kode_bank', 'ASC')->get();
        $pendaftaran = DB::table('pendaftaran_cekgiro')
                    ->join('perusahaans','pendaftaran_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('users','pendaftaran_cekgiro.id_user_input','=','users.id')
                    ->orderBy('pendaftaran_cekgiro.kode_daftar','ASC')
                    ->paginate(10);

    	return view ('finance.pendaftaran_cek_giro.index', compact('pendaftaran'));
    }

    public function cari(Request $request)
    {
        $q =  $request->q;
        $pendaftaran = DB::table('pendaftaran_cekgiro')
                    ->join('perusahaans','pendaftaran_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('users','pendaftaran_cekgiro.id_user_input','=','users.id')
                    
                    ->where('pendaftaran_cekgiro.kode_daftar','like',"%".$q."%")
                    ->orWhere('perusahaans.nama_perusahaan','like',"%".$q."%")
                    ->orWhere('pendaftaran_cekgiro.kode_seri_buku','like',"%".$q."%")
                    ->orWhere('pendaftaran_cekgiro.seri_awal','like',"%".$q."%")
                    ->orWhere('pendaftaran_cekgiro.seri_akhir','like',"%".$q."%")
                    ->orWhere('users.name','like',"%".$q."%")
                    ->orderBy('pendaftaran_cekgiro.kode_daftar','ASC')
                    ->paginate(10);

        return view ('finance.pendaftaran_cek_giro.index', compact('pendaftaran'));
    }

    public function cari_tanggal(Request $request)
    {
        $q = $request->get('q');
        
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if ($q == '')
        {
            $pendaftaran = DB::table('pendaftaran_cekgiro')
            ->join('perusahaans','pendaftaran_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('users','pendaftaran_cekgiro.id_user_input','=','users.id')
            ->WhereBetween('pendaftaran_cekgiro.tgl_daftar', [$date_start,$date_end])
            ->orderBy('pendaftaran_cekgiro.kode_daftar','ASC')
            ->paginate(10);
        }else{
            $pendaftaran = DB::table('pendaftaran_cekgiro')
            ->join('perusahaans','pendaftaran_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('users','pendaftaran_cekgiro.id_user_input','=','users.id')
            ->WhereBetween('pendaftaran_cekgiro.tgl_daftar', [$date_start,$date_end])
            ->orWhere('pendaftaran_cekgiro.kode_daftar','like',"%".$q."%")
            ->orWhere('perusahaans.nama_perusahaan','like',"%".$q."%")
            ->orWhere('pendaftaran_cekgiro.kode_seri_buku','like',"%".$q."%")
            ->orWhere('pendaftaran_cekgiro.seri_awal','like',"%".$q."%")
            ->orWhere('pendaftaran_cekgiro.seri_akhir','like',"%".$q."%")
            ->orWhere('users.name','like',"%".$q."%")
            ->orderBy('pendaftaran_cekgiro.kode_daftar','ASC')
            ->paginate(10);
        }
       

        return view ('finance.pendaftaran_cek_giro.index', compact('pendaftaran'));
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
                $data = DB::table('perusahaans')
                        ->where('perusahaans.nama_perusahaan','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('perusahaans')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih_perusahaan" data-kodeperusahaan="'.$row->kode_perusahaan.'" data-namaperusahaan="'.$row->nama_perusahaan.'">
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
    	return view('finance.pendaftaran_cek_giro.create',  compact('perusahaan','bank','rekening_fin_comp','kode','kategori'));
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'kode_perusahaan' => 'required|exists:perusahaans,kode_perusahaan',
        //     'norek' => '',
        //     'kode_bank' => 'required|exists:banks,kode_bank',
        //     'buku' => 'required|string',
        //     'no_awal' => 'required',
        //     'no_akhir' => 'required',

        // ]);

        // Pendaftaran_Cekgiro::create([
        //     'kode_daftar' => $request->get('kode'),
        //     'tgl_daftar' => Carbon::now()->format('Y-m-d'),
        //     'kode_perusahaan' => $request->get('kode_perusahaan'),
        //     'no_rek_comp' => $request->get('norek'),
        //     'kode_bank' =>  $request->get('kode_bank'),
        //     'kode_kategori' => $request->get('kode_kategori'),
        //     'kode_seri_buku' => $request->get('buku'),
        //     'seri_awal' => $request->get('no_awal'),
        //     'seri_akhir' => $request->get('no_akhir'),
        //     'keterangan' => $request->get('ket'),
        //     'status' => '0',
        //     'jenis' => $request->get('jenis'),
        //     'id_user_input' => Auth::user()->id
        // ]);

        //Header//
        $datas_header=[];
        $validator = Validator::make($request->all(), $datas_header);
        foreach ($request->input("kode_daftar_warkat") as $key => $value) {
            
            $getRow = Pendaftaran_Cekgiro::where('kode_perusahaan', $request->get("kode_perusahaan_warkat")[$key])->get();
            $rowCount = $getRow->count();

            $lastId = $getRow->first();

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

            $kode_daftar = 'REG '.$kode.''.'/'.''.$request->get("kode_perusahaan_warkat")[$key].''.'/'.''.$bulan_romawi.''.'/'.''.$tahun; 

            $data_header = new Pendaftaran_Cekgiro;
            $data_header->kode_daftar = $kode_daftar;
            $data_header->tgl_daftar = Carbon::now()->format('Y-m-d');
            $data_header->kode_perusahaan = $request->get("kode_perusahaan_warkat")[$key];
            $data_header->no_rek_comp = $request->get("no_rek_warkat")[$key];
            $data_header->kode_bank = $request->get("kode_bank_warkat")[$key];
            $data_header->kode_kategori = $request->get("kode_kategori_warkat")[$key];
            $data_header->kode_seri_buku = $request->get("kode_seri_buku_warkat")[$key];
            $data_header->seri_awal = $request->get("no_awal_warkat")[$key];
            $data_header->seri_akhir = $request->get("no_akhir_warkat")[$key];
            $data_header->keterangan = $request->get("keterangan_warkat")[$key];
            $data_header->status = '0';
            $data_header->jenis = $request->get("jenis_warkat")[$key];
            $data_header->no_urut = $request->get("kode_daftar_warkat")[$key];
            $data_header->id_user_input = Auth::user()->id;
            $data_header->save();
        }

        //Detail//
        $datas=[];
        foreach ($request->input('kode_cek') as $key => $value) {
            $datas["kode_cek.{$key}"] = 'required'; 
            $datas["no_cek.{$key}"] = 'required';
        }
        $validator = Validator::make($request->all(), $datas);
        
        foreach ($request->input("kode_cek") as $key => $value) {

            $getRow = Pendaftaran_Cekgiro::where('kode_perusahaan', $request->get("kode_perusahaan")[$key])->get();
            $rowCount = $getRow->count();

            $lastId = $getRow->first();

            $kode = "0001";

            if ($rowCount > 0) {
                if ($rowCount < 9) {
                    $kode = "000".''.($rowCount);
                } else if ($rowCount < 99) {
                        $kode = "00".''.($rowCount);
                } else if ($rowCount < 999) {
                        $kode = "0".''.($rowCount);
                } else {
                        $kode = ''.($rowCount);
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

            $kode_daftar_rincian = 'REG '.$kode.''.'/'.''.$request->get("kode_perusahaan")[$key].''.'/'.''.$bulan_romawi.''.'/'.''.$tahun; 


            $data = new Pendaftaran_Cekgiro_Detail;
            $data->kode_daftar = $kode_daftar_rincian;
            $data->id_cek = $request->get("kode_cek")[$key];
            $data->no_cek = $request->get("no_cek")[$key];
            $data->no_urut = $request->get("kode_daftar_rincian")[$key];
            $data->save();
        }
        
        alert()->success('Success.','New Registration has been created');
        return redirect()->route('pendaftaran_cek_giro.index');
    }

    
}
