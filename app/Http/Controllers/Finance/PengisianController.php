<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Perusahaan;
use App\Spp;
use App\Pengisian_Cekgiro;
use App\Pengisian_Cekgiro_Detail;
use App\Pendaftaran_cekgiro;
use App\Pendaftaran_cekgiro_detail;
use App\KategoriBuku;
use App\KategoriPengeluaran;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PengisianController extends Controller
{
    public function index()
    {   
        $tipe = DB::table('tipe_cekgiro_sub')
                    ->get();


        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	$pengisian = DB::table('pengisian_cekgiro')
            ->join('pengisian_cekgiro_detail','pengisian_cekgiro.kode_pengisian','=','pengisian_cekgiro_detail.kode_pengisian')
            ->join('perusahaans','pengisian_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('categories_fin','pengisian_cekgiro.id_categories','=','categories_fin.id_categories')
            ->join('categories_fin_sub','pengisian_cekgiro.id_sub_categories','=','categories_fin_sub.id_sub_categories')
            ->join('users','pengisian_cekgiro.id_user_input','=','users.id')
            ->select('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro.tgl_pengisian','perusahaans.nama_perusahaan','categories_fin.categories_name','pengisian_cekgiro.kode_sub','categories_fin_sub.sub_categories_name','pengisian_cekgiro_detail.no_spp','pengisian_cekgiro_detail.total_cek','users.name')
            ->WhereBetween('pengisian_cekgiro.tgl_pengisian', [$date_start,$date_end])
            ->groupBy('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro.tgl_pengisian','perusahaans.nama_perusahaan','categories_fin.categories_name','pengisian_cekgiro.kode_sub','categories_fin_sub.sub_categories_name','pengisian_cekgiro_detail.no_spp','pengisian_cekgiro_detail.total_cek','users.name')
            ->orderBy('pengisian_cekgiro.kode_pengisian', 'ASC')
            ->paginate(8);

    	return view('finance.pengisian_cek_giro.index',compact('pengisian','tipe'));
    }

    public function cari(Request $request)
    {   
        $tipe = DB::table('tipe_cekgiro_sub')
                    ->get();

        $kode_sub = $request->kode_sub;

        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->kode_sub != '')
        {
            $kode_sub = request()->kode_sub;
        }

        if ($kode_sub == '')
        {
            $pengisian = DB::table('pengisian_cekgiro')
                ->join('pengisian_cekgiro_detail','pengisian_cekgiro.kode_pengisian','=','pengisian_cekgiro_detail.kode_pengisian')
                ->join('perusahaans','pengisian_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('categories_fin','pengisian_cekgiro.id_categories','=','categories_fin.id_categories')
                ->join('categories_fin_sub','pengisian_cekgiro.id_sub_categories','=','categories_fin_sub.id_sub_categories')
                ->join('users','pengisian_cekgiro.id_user_input','=','users.id')
                ->select('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro.tgl_pengisian','perusahaans.nama_perusahaan','categories_fin.categories_name','pengisian_cekgiro.kode_sub','categories_fin_sub.sub_categories_name','pengisian_cekgiro_detail.no_spp','pengisian_cekgiro_detail.total_cek','users.name')
                ->WhereBetween('pengisian_cekgiro.tgl_pengisian', [$date_start,$date_end])
                ->groupBy('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro.tgl_pengisian','perusahaans.nama_perusahaan','categories_fin.categories_name','pengisian_cekgiro.kode_sub','categories_fin_sub.sub_categories_name','pengisian_cekgiro_detail.no_spp','pengisian_cekgiro_detail.total_cek','users.name')
                ->orderBy('pengisian_cekgiro.kode_pengisian', 'ASC')
                ->paginate(8);
        }else{
            $pengisian = DB::table('pengisian_cekgiro')
                ->join('pengisian_cekgiro_detail','pengisian_cekgiro.kode_pengisian','=','pengisian_cekgiro_detail.kode_pengisian')
                ->join('perusahaans','pengisian_cekgiro.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('categories_fin','pengisian_cekgiro.id_categories','=','categories_fin.id_categories')
                ->join('categories_fin_sub','pengisian_cekgiro.id_sub_categories','=','categories_fin_sub.id_sub_categories')
                ->join('users','pengisian_cekgiro.id_user_input','=','users.id')
                ->select('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro.tgl_pengisian','perusahaans.nama_perusahaan','categories_fin.categories_name','pengisian_cekgiro.kode_sub','categories_fin_sub.sub_categories_name','pengisian_cekgiro_detail.no_spp','pengisian_cekgiro_detail.total_cek','users.name')
                ->WhereBetween('pengisian_cekgiro.tgl_pengisian', [$date_start,$date_end])
                ->Where('pengisian_cekgiro.kode_sub', $kode_sub)
                ->groupBy('pengisian_cekgiro.kode_pengisian','pengisian_cekgiro_detail.id_cek','pengisian_cekgiro.tgl_pengisian','perusahaans.nama_perusahaan','categories_fin.categories_name','pengisian_cekgiro.kode_sub','categories_fin_sub.sub_categories_name','pengisian_cekgiro_detail.no_spp','pengisian_cekgiro_detail.total_cek','users.name')
                ->orderBy('pengisian_cekgiro.kode_pengisian', 'ASC')
                ->paginate(8);
        }

        return view('finance.pengisian_cek_giro.index',compact('pengisian','tipe'));
    }

    public function actionSpp(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('spp')
                        //->join('pengajuan_biaya','spp.no_spp','=','pengajuan_biaya.no_spp')
                        ->Where('spp.status',9)
                        ->Where('spp.status_spp_1',1)
                        ->Where('spp.status_spp_2',1)
                        //->where('pengajuan_biaya.status_bod',1)
                        ->WhereNotIn('spp.jenis', ['Non Kredit (Uang Tunai)','Non Kredit (Debit RK Master)'])
                        ->Where('spp.no_spp','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('spp')
                        //->join('pengajuan_biaya','spp.no_spp','=','pengajuan_biaya.no_spp')
                        ->Where('spp.status',9)
                        ->Where('spp.status_spp_1',1)
                        ->Where('spp.status_spp_2',1)
                        //->where('pengajuan_biaya.status_bod',1)
                        ->WhereNotIn('spp.jenis', ['Non Kredit (Uang Tunai)','Non Kredit (Debit RK Master)'])
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                    <tr class="pilih_spp" data-nospp="'.$row->no_spp.'" data-tgl="'.$row->tgl_spp.'" data-jumlah="'.number_format($row->jumlah).'" data-desc="'.$row->keterangan.'">
                        <td>'.$row->no_spp.'</td>
                        <td>'.date('d-M-Y', strtotime($row->tgl_spp)).'</td>
                        <td align="right">'.number_format($row->jumlah).'</td>
                        <td>'.$row->keterangan.'</td>
                        <td>'.$row->jenis.'</td>

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
                //$data = DB::table('pendaftaran_cekgiro')->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
                //    ->Where('pendaftaran_cekgiro_detail.status_detail',0)
                //    ->Where('pendaftaran_cekgiro_detail.id_cek','like','%'.$query.'%')
                //    ->orWhere('pendaftaran_cekgiro_detail.no_cek','like','%'.$query.'%')
                //    ->orderBy('pendaftaran_cekgiro_detail.no_cek','ASC')
                //    ->get();
					
				$data = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('vendors','izin_detail_b.kode_vendor','=','vendors.kode_vendor')
                        ->join('banks','izin_detail_b.kode_bank','=','banks.kode_bank')
                        ->where('izin_b_detail.status', 0)
                        ->Where('izin_b_detail.id_cek','like','%'.$query.'%')
                        ->orderBy('izin_b_detail.id_cek', 'ASC')
                        ->get();
            }else{
                //$data = DB::table('pendaftaran_cekgiro')->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')
                //    ->Where('pendaftaran_cekgiro_detail.status_detail',0)
                //    ->orderBy('pendaftaran_cekgiro_detail.no_cek','ASC')
                //    ->get();
				
				$data = DB::table('izin_b')
                        ->join('izin_b_detail','izin_b.kode_izin_b','=','izin_b_detail.kode_izin_b')
                        ->join('vendors','izin_b_detail.kode_vendor','=','vendors.kode_vendor')
                        ->join('banks','izin_b_detail.kode_bank','=','banks.kode_bank')
                        ->where('izin_b_detail.status', 0)
                        ->orderBy('izin_b_detail.id_cek', 'ASC')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih_cekgiro" data-noizin="'.$row->no_izin_b.'" 
                                              data-judulizin="'.$row->judul_izin_b.'" 
                                              data-idcek="'.$row->id_cek.'" 
                                              data-norek="'.$row->no_rekening.'" 
                                              data-kodevendor="'.$row->kode_vendor.'" 
                                              data-namavendor="'.$row->nama_vendor.'" 
                                              data-atasnama="'.$row->atas_nama.'" 
                                              data-kodebank="'.$row->kode_bank.'"
                                              data-namabank="'.$row->nama_bank.'"  
                                              data-tglizin="'.$row->tgl_izin_b.'">


                        <td>'.$row->no_izin_b.'</td>
                        <td>'.$row->id_cek.'</td>
                        <td>'.$row->tgl_izin_b.'</td>
                        <td>'.$row->judul_izin_b.'</td>
                        <td>'.$row->no_rekening.'</td>
                        <td>'.$row->kode_vendor.'</td>
                        <td>'.$row->nama_vendor.'</td>
                        <td>'.$row->atas_nama.'</td>
                        <td>'.$row->kode_bank.'</td>
                        <td>'.$row->nama_bank.'</td>
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

    public function ajax_cat(Request $request) // dropdown categories n subCategories
    {
        $subcategories = KategoriPengeluaran::Where('id_categories', $request->cat_id)->pluck('id_sub_categories','sub_categories_name');
        return response()->json($subcategories);
    }

    public function create(Request $request)
    {
    	$perusahaan = Perusahaan::orderBy('nama_perusahaan', 'ASC')->get();
    	$spp = Spp::orderBy('no_spp', 'ASC')->get();
    	$cekgiro = DB::table('pendaftaran_cekgiro')->join('pendaftaran_cekgiro_detail','pendaftaran_cekgiro.kode_daftar','=','pendaftaran_cekgiro_detail.kode_daftar')->orderBy('pendaftaran_cekgiro_detail.no_cek','ASC')->get();
    	$kategori = KategoriBuku::orderBy('id_categories', 'ASC')->get();


    	$id_categories = $request->get('1');
    	$subkategori = DB::table('categories_fin_sub')->where('id_categories', $id_categories)
    										->orderBy('id_sub_categories', 'ASC')->get();	

        $sub_tipe = DB::table('tipe_cekgiro_sub')->join('tipe_cekgiro','tipe_cekgiro_sub.kode_tipe','=','tipe_cekgiro.kode_tipe')->orderBy('tipe_cekgiro_sub.kode_tipe', 'ASC')->get();
    	

    	$getRow = Pengisian_Cekgiro::orderBy('kode_pengisian', 'DESC')->get();
        $rowCount = $getRow->count();
        $lastId = $getRow->first();
        $kode = "0000001";
        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode = "000000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $kode = "00000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $kode = "0000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $kode = "000".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $kode = "00".''.($rowCount + 1);
            } else if ($rowCount < 999999) {
                    $kode = "0".''.($rowCount + 1);
            } else {
                    $kode = ''.($rowCount + 1);
            }
        } 

    	return view('finance.pengisian_cek_giro.create', compact('perusahaan','spp','cekgiro','kode','kategori','subkategori','sub_tipe'));
    }

    public function store(Request $request)
    {
    	
        if(request()->radio == 'satu'){
            $this->validate($request,[
                'kode_perusahaan' => 'required|exists:perusahaans,kode_perusahaan',
                'kode_kategori' => 'required|exists:categories_fin,id_categories',
                'kode_subkategori' => 'required|exists:categories_fin_sub,id_sub_categories'
            ]);

            Pengisian_Cekgiro::create([
                'kode_pengisian' => $request->get('kode'),
                'tgl_pengisian' => Carbon::now()->format('Y-m-d'),
                'kode_perusahaan' => $request->get('kode_perusahaan'),
                //'bulan_pengeluaran_awal' => $request->get('bulan_awal'),
                //'bulan_pengeluaran_akhir' => $request->get('bulan_akhir'),
                'kode_sub' => $request->get('kode_sub'),
                'id_categories' => $request->get('kode_kategori'),
                'id_sub_categories' => $request->get('kode_subkategori'),
                'description' => $request->get('note'),
                'no_invoice' => $request->get('noinvoice'),
                'no_kontrabon' => $request->get('nokontrabon'),
                'no_surat_jalan' => $request->get('nosuratjalan'),
                'status' => '0',
                'id_user_input' => Auth::user()->id
            ]);

            $datas=[];
            foreach ($request->input('nospp') as $key => $value) {
                
            }
            $validator = Validator::make($request->all(), $datas);
                foreach ($request->input("nospp") as $key => $value) {
                    $data = new Pengisian_Cekgiro_Detail;

                    $data->kode_pengisian = $request->get('kode');
                    $data->no_spp = $request->get("nospp")[$key];
                    $data->id_cek = $request->get("id_nocekgiro")[$key];
                    $data->total_spp = str_replace(",", "", $request->get("nominalspp")[$key]);
                    $data->total_cek = str_replace(",", "", $request->get("nominalcek")[$key]);
                    $data->tgl_cek = $request->get("tglcek")[$key];
                    $data->status = '0';
                    $data->save();

                    $spp_update = DB::table('spp')->where('no_spp', $request->get("nospp")[$key])
                            ->update([
                                'status' =>'1'
                            ]);

                    $cekgiro_update = DB::table('pendaftaran_cekgiro_detail')->where('id_cek', $request->get("id_nocekgiro")[$key])
                            ->update([
                                'status_detail' =>'1'
                            ]);
                }
        }elseif(request()->radio == 'dua'){
            $this->validate($request,[
                'kode_perusahaan' => 'required|exists:perusahaans,kode_perusahaan',
                'kode_kategori' => 'required|exists:categories_fin,id_categories',
                'kode_subkategori' => 'required|exists:categories_fin_sub,id_sub_categories'
            ]);

            Pengisian_Cekgiro::create([
                'kode_pengisian' => $request->get('kode'),
                'tgl_pengisian' => Carbon::now()->format('Y-m-d'),
                'kode_perusahaan' => $request->get('kode_perusahaan'),
                //'bulan_pengeluaran_awal' => $request->get('bulan_awal'),
                //'bulan_pengeluaran_akhir' => $request->get('bulan_akhir'),
                'kode_sub' => $request->get('kode_sub'),
                'id_categories' => $request->get('kode_kategori'),
                'id_sub_categories' => $request->get('kode_subkategori'),
                'description' => $request->get('note'),
                'no_invoice' => $request->get('noinvoice'),
                'no_kontrabon' => $request->get('nokontrabon'),
                'no_surat_jalan' => $request->get('nosuratjalan'),
                'status' => '0',
                'id_user_input' => Auth::user()->id
            ]);

            $datas=[];
            foreach ($request->input('nospp') as $key => $value) {
                
            }
            $validator = Validator::make($request->all(), $datas);
                foreach ($request->input("nospp") as $key => $value) {
                    $data = new Pengisian_Cekgiro_Detail;

                    $data->kode_pengisian = $request->get('kode');
                    $data->no_spp = $request->get("nospp")[$key];
                    $data->id_cek = $request->get("id_nocekgiro_dua");
                    $data->total_spp = str_replace(",", "", $request->get("nominalspp")[$key]);
                    $data->total_cek = str_replace(",", "", $request->get("nominalcek_dua"));
                    $data->tgl_cek = $request->get("tglcek_dua");
                    $data->status = '0';
                    $data->save();

                    $spp_update = DB::table('spp')->where('no_spp', $request->get("nospp")[$key])
                            ->update([
                                'status' =>'1'
                            ]);

                    $cekgiro_update = DB::table('pendaftaran_cekgiro_detail')->where('id_cek', $request->get("id_nocekgiro_dua"))
                            ->update([
                                'status_detail' =>'1'
                            ]);
                }
        }elseif(request()->radio == 'tiga'){
            $this->validate($request,[
                'kode_perusahaan' => 'required|exists:perusahaans,kode_perusahaan',
                'kode_kategori' => 'required|exists:categories_fin,id_categories',
                'kode_subkategori' => 'required|exists:categories_fin_sub,id_sub_categories'
            ]);

            Pengisian_Cekgiro::create([
                'kode_pengisian' => $request->get('kode'),
                'tgl_pengisian' => Carbon::now()->format('Y-m-d'),
                'kode_perusahaan' => $request->get('kode_perusahaan'),
                //'bulan_pengeluaran_awal' => $request->get('bulan_awal'),
                //'bulan_pengeluaran_akhir' => $request->get('bulan_akhir'),
                'kode_sub' => $request->get('kode_sub'),
                'id_categories' => $request->get('kode_kategori'),
                'id_sub_categories' => $request->get('kode_subkategori'),
                'description' => $request->get('note'),
                'no_invoice' => $request->get('noinvoice'),
                'no_kontrabon' => $request->get('nokontrabon'),
                'no_surat_jalan' => $request->get('nosuratjalan'),
                'status' => '0',
                'id_user_input' => Auth::user()->id
            ]);

            $datas=[];
            foreach ($request->input('id_nocekgiro_tiga') as $key => $value) {
                
            }
            $validator = Validator::make($request->all(), $datas);
                foreach ($request->input("id_nocekgiro_tiga") as $key => $value) {
                    $data = new Pengisian_Cekgiro_Detail;

                    $data->kode_pengisian = $request->get('kode');
                    $data->no_spp = $request->get("nospp_tiga");
                    $data->id_cek = $request->get("id_nocekgiro_tiga")[$key];
                    $data->total_spp = str_replace(",", "", $request->get("nominalspp_tiga"));
                    $data->total_cek = str_replace(",", "", $request->get("nominalcek_tiga")[$key]);
                    $data->tgl_cek = $request->get("tglcek_tiga")[$key];
                    $data->status = '0';
                    $data->save();

                    $spp_update = DB::table('spp')->where('no_spp', $request->get("nospp_tiga"))
                            ->update([
                                'status' =>'1'
                            ]);

                    $cekgiro_update = DB::table('pendaftaran_cekgiro_detail')->where('id_cek', $request->get("id_nocekgiro_tiga")[$key])
                            ->update([
                                'status_detail' =>'1'
                            ]);
                }
        }
    	
    	alert()->success('Success.','New Registration has been created');
        return redirect()->route('pengisian_cek_giro.index');

    }
}
