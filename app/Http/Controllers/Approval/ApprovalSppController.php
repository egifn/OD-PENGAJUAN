<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pengajuan_Biaya_Detail;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalSppController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        if(Auth::user()->kode_sub_divisi == '5'){ //-- Jika Koordinator Biaya--
            $approval_spp = DB::table('pengajuan_biaya')
                            ->join('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.keterangan','pengajuan_biaya.no_spp','spp.tgl_spp','spp.jumlah','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                            ->WhereBetween('pengajuan_biaya.tgl_spp', [$date_start,$date_end])
                            ->get();
        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- Biaya Pusat (Akunting)--
            $approval_spp = DB::table('pengajuan_biaya')
                            ->join('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.keterangan','pengajuan_biaya.no_spp','spp.tgl_spp','spp.jumlah','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                            ->WhereBetween('pengajuan_biaya.tgl_spp', [$date_start,$date_end])
                            ->where('pengajuan_biaya.status_spp_1', 1)
                            ->get();
        }

        // Manual
        if(Auth::user()->kode_sub_divisi == '5'){ //-- Jika Koordinator Biaya--
            $data = DB::table('pengajuan_biaya')
                            ->rightjoin('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('spp.no_urut','spp.no_spp','spp.keterangan','spp.status','spp.tgl_spp','spp.jumlah','spp.status_spp_1','spp.status_spp_2')
                            ->where('spp.kategori', 'MANUAL')
                            ->WhereBetween('spp.tgl_spp', [$date_start,$date_end])
                            ->get();
        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- Biaya Pusat (Akunting)--
            $data = DB::table('pengajuan_biaya')
                            ->rightjoin('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('spp.no_urut','spp.no_spp','spp.keterangan','spp.status','spp.tgl_spp','spp.jumlah','spp.status_spp_1','spp.status_spp_2')
                            ->where('spp.kategori', 'MANUAL')
                            ->WhereBetween('spp.tgl_spp', [$date_start,$date_end])
                            ->where('spp.status_spp_1', 1)
                            ->get();
        }
    
        return view ('approval.approval_spp.index', compact('approval_spp','data'));
    }

    public function cari(Request $request)
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_sub_divisi == '5'){ //-- Jika Koordinator Biaya--
            $approval_spp = DB::table('pengajuan_biaya')
                            ->join('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.keterangan','pengajuan_biaya.no_spp','spp.tgl_spp','spp.jumlah','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                            ->WhereBetween('pengajuan_biaya.tgl_spp', [$date_start,$date_end])
                            ->get();
        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- Biaya Pusat (Akunting)--
            $approval_spp = DB::table('pengajuan_biaya')
                            ->join('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('pengajuan_biaya.no_urut','pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.keterangan','pengajuan_biaya.no_spp','spp.tgl_spp','spp.jumlah','pengajuan_biaya.status_spp_1','pengajuan_biaya.status_spp_2')
                            ->WhereBetween('pengajuan_biaya.tgl_spp', [$date_start,$date_end])
                            ->where('pengajuan_biaya.status_spp_1', 1)
                            ->get();
        }

        // Manual
        if(request()->tanggal_manual != ''){
            $date = explode(' - ' ,request()->tanggal_manual);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(Auth::user()->kode_sub_divisi == '5'){ //-- Jika Koordinator Biaya--
            $data = DB::table('pengajuan_biaya')
                            ->rightjoin('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('spp.no_urut','spp.no_spp','spp.keterangan','spp.status','spp.tgl_spp','spp.jumlah','spp.status_spp_1','spp.status_spp_2')
                            ->where('spp.kategori', 'MANUAL')
                            ->WhereBetween('spp.tgl_spp', [$date_start,$date_end])
                            ->get();
        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- Biaya Pusat (Akunting)--
            $data = DB::table('pengajuan_biaya')
                            ->rightjoin('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
                            ->select('spp.no_urut','spp.no_spp','spp.keterangan','spp.status','spp.tgl_spp','spp.jumlah','spp.status_spp_1','spp.status_spp_2')
                            ->where('spp.kategori', 'MANUAL')
                            ->WhereBetween('spp.tgl_spp', [$date_start,$date_end])
                            ->where('spp.status_spp_1', 1)
                            ->get();
        }
        
        return view ('approval.approval_spp.index', compact('approval_spp','data'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('value');
        if(Auth::user()->kode_sub_divisi == '5'){
            $data = DB::table('pengajuan_biaya')
                    ->join('spp', 'pengajuan_biaya.no_spp', '=', 'spp.no_spp')
                    ->select(
                        'pengajuan_biaya.no_urut',
                        'pengajuan_biaya.kode_pengajuan_b',
                        'pengajuan_biaya.tgl_pengajuan_b',
                        'pengajuan_biaya.keterangan',
                        'pengajuan_biaya.no_spp',
                        'spp.tgl_spp',
                        'spp.jumlah',
                        'pengajuan_biaya.status_spp_1',
                        'pengajuan_biaya.status_spp_2'
                    )

             ->where('pengajuan_biaya.kode_pengajuan_b', 'like', "%{$keyword}%")
                    ->orWhere('pengajuan_biaya.keterangan', 'like', "%{$keyword}%")
                    ->orWhere('pengajuan_biaya.no_spp', 'like', "%{$keyword}%")
                    ->orWhere('spp.no_spp', 'like', "%{$keyword}%")
                    ->orderByDesc('pengajuan_biaya.tgl_pengajuan_b')
                    ->get();
                
            $output = [
                'status' => true,
                'message' => 'success',
                'data'    => $data
            ];

            return response()->json($output, 200);
        }elseif(Auth::user()->kode_sub_divisi == '4'){
                $data = DB::table('pengajuan_biaya')
                    ->join('spp', 'pengajuan_biaya.no_spp', '=', 'spp.no_spp')
                    ->select(
                        'pengajuan_biaya.no_urut',
                        'pengajuan_biaya.kode_pengajuan_b',
                        'pengajuan_biaya.tgl_pengajuan_b',
                        'pengajuan_biaya.keterangan',
                        'pengajuan_biaya.no_spp',
                        'spp.tgl_spp',
                        'spp.jumlah',
                        'pengajuan_biaya.status_spp_1',
                        'pengajuan_biaya.status_spp_2'
                    )

                    ->where('spp.status_spp_1', 1)
                        ->where(function ($q) use ($keyword) {
                            $q->where('pengajuan_biaya.kode_pengajuan_b', 'like', "%{$keyword}%")
                            ->orWhere('pengajuan_biaya.keterangan', 'like', "%{$keyword}%")
                            ->orWhere('pengajuan_biaya.no_spp', 'like', "%{$keyword}%");
                        })
                        ->orderByDesc('spp.tgl_spp')
                        ->get();
                $output = [
                    'status' => true,
                    'message' => 'success',
                    'data'    => $data
                ];

                return response()->json($output, 200); 
        }
        
    }

    public function search_manual(Request $request)
    {
        $keyword = $request->get('value');
        
        if(Auth::user()->kode_sub_divisi == '5'){
                $data = DB::table('pengajuan_biaya')
                    ->rightJoin('spp', 'pengajuan_biaya.no_spp', '=', 'spp.no_spp')
                    ->select(
                        'spp.no_urut',
                        'spp.no_spp',
                        'spp.keterangan',
                        'spp.status',
                        'spp.tgl_spp',
                        'spp.jumlah',
                        'spp.status_spp_1',
                        'spp.status_spp_2'
                    )
                    ->where('spp.kategori', 'MANUAL')
                    ->where(function ($q) use ($keyword) {
                        $q->where('spp.no_spp', 'like', "%{$keyword}%")
                          ->orWhere('spp.keterangan', 'like', "%{$keyword}%")
                          ->orWhere('pengajuan_biaya.kode_pengajuan_b', 'like', "%{$keyword}%");
                    })
                    ->orderByDesc('spp.tgl_spp')
                    ->get();

                $output = [
                    'status' => true,
                    'message' => 'success',
                    'data'    => $data
                ];

                return response()->json($output, 200);
        }elseif(Auth::user()->kode_sub_divisi == '4'){
                $data = DB::table('pengajuan_biaya')
                    ->rightJoin('spp', 'pengajuan_biaya.no_spp', '=', 'spp.no_spp')
                    ->select(
                        'spp.no_urut',
                        'spp.no_spp',
                        'spp.keterangan',
                        'spp.status',
                        'spp.tgl_spp',
                        'spp.jumlah',
                        'spp.status_spp_1',
                        'spp.status_spp_2'
                    )

                    ->where('spp.kategori', 'MANUAL')
                    ->where('spp.status_spp_1', 1)
                    ->where(function ($q) use ($keyword) {
                        $q->where('spp.no_spp', 'like', "%{$keyword}%")
                          ->orWhere('spp.keterangan', 'like', "%{$keyword}%")
                          ->orWhere('pengajuan_biaya.kode_pengajuan_b', 'like', "%{$keyword}%");
                    })
                    ->orderByDesc('spp.tgl_spp')
                    ->get();

                $output = [
                    'status' => true,
                    'message' => 'success',
                    'data'    => $data
                ];

                return response()->json($output, 200);
            }
    }
	
	public function view_p_claim($no_urut)
    {
        $approval_pengajuan_tiv_head = DB::table('pengajuan_biaya')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('perusahaans as perusahaan_tujuan','pengajuan_biaya.kode_perusahaan_tujuan','=','perusahaan_tujuan.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.id_user_input','users.name','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_perusahaan_tujuan','perusahaan_tujuan.nama_perusahaan as perusahaan_tujuan',
                        'pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.kategori','ms_pengeluaran.nama_pengeluaran','pengajuan_biaya.keterangan','pengajuan_biaya.no_surat_program','pengajuan_biaya.id_program','pengajuan_biaya.no_urut',
                        'pengajuan_biaya.status_ssd','pengajuan_biaya.status_atasan','pengajuan_biaya.status_som','pengajuan_biaya.status_validasi_clm','pengajuan_biaya.status_claim','pengajuan_biaya.status_validasi_ng','pengajuan_biaya.status_ng','pengajuan_biaya.status_validasi_piutang','pengajuan_biaya.status_piutang','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya')
            ->where('pengajuan_biaya.no_urut', $no_urut)->first();

        $approval_pengajuan_tiv_detail = DB::table('pengajuan_biaya_detail')	
        	->Where('pengajuan_biaya_detail.no_urut', $no_urut)
        	->get();

        $approval_upload = DB::table('import_pencapaian_program_upload')
            ->select('import_pencapaian_program_upload.filename')
            ->where('import_pencapaian_program_upload.id_program', $approval_pengajuan_tiv_head->id_program)
            ->get();

        $approval_tiv_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $approval_pengajuan_tiv_head->kode_pengajuan_b)
            ->get();

        $total_jml = DB::table('pengajuan_biaya_detail')
                        ->select(DB::raw('SUM(pengajuan_biaya_detail.harga - pengajuan_biaya_detail.potongan) as ditransfer'))
                        ->where('pengajuan_biaya_detail.no_urut', $no_urut)
                        ->first();

        return view('approval.approval_spp.view_p_claim', compact('approval_pengajuan_tiv_head','approval_pengajuan_tiv_detail','approval_tiv_upload','total_jml','approval_upload'));
    }

    public function view($no_urut)
    {
        $approval_cost_spp_head = DB::table('pengajuan_biaya')
            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b','=','pengajuan_biaya_detail.kode_pengajuan_b')
            ->join('perusahaans','pengajuan_biaya.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan_biaya.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan_biaya.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan_biaya.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan_biaya.kategori','=','ms_pengeluaran.id')
            ->join('spp','pengajuan_biaya.no_spp','=','spp.no_spp')
            ->select('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan',DB::raw('SUM(pengajuan_biaya_detail.tharga) AS total'),'users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.no_spp','spp.no_urut as no_urut_spp','pengajuan_biaya.id_user_approval_spp_1','pengajuan_biaya.tgl_approval_spp_1','pengajuan_biaya.status_spp_1','pengajuan_biaya.id_user_approval_spp_2','pengajuan_biaya.tgl_approval_spp_2','pengajuan_biaya.status_spp_2')
            ->Where('pengajuan_biaya.no_urut', $no_urut)
            ->groupby('pengajuan_biaya.kode_pengajuan_b','pengajuan_biaya.tgl_pengajuan_b','pengajuan_biaya.kategori','pengajuan_biaya.tipe','pengajuan_biaya.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan_biaya.kode_depo','depos.nama_depo','pengajuan_biaya.kode_divisi','divisi.nama_divisi','pengajuan_biaya.keterangan','users.name','pengajuan_biaya.status_atasan','pengajuan_biaya.status_biaya_pusat','pengajuan_biaya.status_biaya','pengajuan_biaya.no_urut','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan_biaya.no_spp','spp.no_urut','pengajuan_biaya.id_user_approval_spp_1','pengajuan_biaya.tgl_approval_spp_1','pengajuan_biaya.status_spp_1','pengajuan_biaya.id_user_approval_spp_2','pengajuan_biaya.tgl_approval_spp_2','pengajuan_biaya.status_spp_2')
            ->first();

        $approval_cost_spp_detail = DB::table('pengajuan_biaya_detail') 
            ->Where('pengajuan_biaya_detail.no_urut', $no_urut)
            ->get();

        $approval_cost_spp_upload = DB::table('pengajuan_upload')
            ->select('pengajuan_upload.filename')
            ->where('pengajuan_upload.kode_pengajuan', $approval_cost_spp_head->kode_pengajuan_b)
            ->get();

        $approval_cost_spp_total =  Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
                                ->get()->sum('tharga');


        return view('approval.approval_spp.view', compact('approval_cost_spp_head','approval_cost_spp_detail','approval_cost_spp_upload','approval_cost_spp_total'));
    }

    public function view_manual($no_urut)
    {
        $no_urut = DB::table('spp')
            ->select('spp.no_urut','spp.no_spp','spp.jumlah',
                    'spp.id_user_approval_spp_1',
                     'spp.kode_approved_spp_1',
                     'spp.tgl_approval_spp_1',
                     'spp.status_spp_1',
                     'spp.id_user_approval_spp_2',
                     'spp.kode_approved_spp_2',
                     'spp.tgl_approval_spp_2',
                     'spp.status_spp_2')
            ->Where('spp.no_urut', $no_urut)
            ->first();

        $approval_spp_head = DB::table('spp')
            ->select('spp.no_urut',
                     'spp.no_spp',
                     'spp.tgl_spp',
                     'spp.no_kontrabon',
                     'spp.ditujukan',
                     'spp.kode_vendor',
                     'spp.for',
                     'spp.jumlah',
                     'spp.jatuh_tempo',
                     'spp.keterangan',
                     'spp.jenis',
                     'spp.status',
                     'spp.id_user_input',
                     'spp.kode_user_input_spp',
                     'spp.kode_perusahaan',
                     'spp.pajak_masukan',
                     'spp.pembayaran',
                     'spp.yang_mengajukan',
                     'spp.status_pajak',
                     'spp.id_user_approval_spp_1',
                     'spp.kode_approved_spp_1',
                     'spp.tgl_approval_spp_1',
                     'spp.status_spp_1',
                     'spp.id_user_approval_spp_2',
                     'spp.kode_approved_spp_2',
                     'spp.tgl_approval_spp_2',
                     'spp.status_spp_2'
                     )
            ->Where('spp.no_urut', $no_urut->no_urut)
            ->get();
            
        
        return view('approval.approval_spp.view_manual', compact('no_urut','approval_spp_head'));
    }

    public function approved(Request $request)
    {
		$tahun = (date('Y'));
        $bulan = (date('m'));

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
		
        if(Auth::user()->kode_sub_divisi == '5'){ //-- jika Biaya Pusat/Acc
            $no_urut = request()->no_urut;
            $no_urut_spp = request()->no_urut_spp;
            //dd($no_urut_spp);
			
			//Kode Approve SPP////
            $getRow = DB::table('spp')
							->select(DB::raw('MAX(kode_approved_spp_1) as No_Urut_app_1'))
							->where('id_user_approval_spp_1', Auth::user()->id)
							->whereMonth('tgl_approval_spp_1', $bulan)
                            ->whereYear('tgl_approval_spp_1', $tahun);
			$rowCount = $getRow->count();

			if($rowCount > 0){
				if ($rowCount < 9) {
					$kode_app_1 = 'APP '.'000'.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 99) {
					$kode_app_1 = 'APP '.'00'.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 999) {
					$kode_app_1 = 'APP '.'0'.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else {
					$kode_app_1 = 'APP '.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				}
			}else{
				$kode_app_1 = 'APP '.'0001'.'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
			}
            //end kode Approved SPP////

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 6,
                            'id_user_approval_spp_1' => Auth::user()->id,
                            'status_spp_1' => 1,
                            'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_1' => Auth::user()->id,
							'kode_approved_spp_1' => $kode_app_1,
                            'status_spp_1' => 1,
                            'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        ]);


        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- jika kepala Accunting
            $no_urut = request()->no_urut;
            $no_urut_spp = request()->no_urut_spp;
			
			//Kode Approve SPP////
            $getRow = DB::table('spp')
							->select(DB::raw('MAX(kode_approved_spp_2) as No_Urut_app_2'))
							->where('id_user_approval_spp_2', Auth::user()->id)
							->whereMonth('tgl_approval_spp_2', $bulan)
                            ->whereYear('tgl_approval_spp_2', $tahun);
			$rowCount = $getRow->count();

			if($rowCount > 0){
				if ($rowCount < 9) {
					$kode_app_2 = 'APP '.'000'.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 99) {
					$kode_app_2 = 'APP '.'00'.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 999) {
					$kode_app_2 = 'APP '.'0'.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else {
					$kode_app_2 = 'APP '.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				}
			}else{
				//$kode_app_2 = '1'.'/'.$kode_divisi.'/'.$kode_depo;
				$kode_app_2 = 'APP '.'0001'.'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
			}
            //end kode Approved SPP////

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                        ->update([
                            'status' => 6,
                            'id_user_approval_spp_2' => Auth::user()->id,
                            'status_spp_2' => 1,
                            'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                            'keterangan_approval' => $request->get('addKeterangan'),
                        ]);

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_2' => Auth::user()->id,
							'kode_approved_spp_2' => $kode_app_2,
                            'status_spp_2' => 1,
                            'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        ]);
        }

        alert()->success('Success.','Request Approved...');
        return redirect()->route('approval_spp.index');
    }

    public function denied(Request $request)
    {
        if(Auth::user()->kode_sub_divisi == '5'){ //-- jika Biaya Pusat/Acc
            $no_urut = request()->no_urut;
            $no_urut_spp = request()->no_urut_spp;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        //'status' => 2,
                        'id_user_approval_spp_1' => Auth::user()->id,
                        'status_spp_1' => 2,
                        'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_1' => Auth::user()->id,
                            'status_spp_1' => 2,
                            'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        ]);

        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- jika Kepala Akunting
            $no_urut = request()->no_urut;
            $no_urut_spp = request()->no_urut_spp;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        //'status' => 2,
                        'id_user_approval_spp_2' => Auth::user()->id,
                        'status_spp_2' => 2,
                        'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_2' => Auth::user()->id,
                            'status_spp_2' => 2,
                            'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        ]);
        }

        alert()->error('Oops...','Request Denied...');
        return redirect()->route('approval_spp.index');
    }

    public function pending(Request $request)
    {
        if(Auth::user()->kode_sub_divisi == '5'){ //-- jika Biaya Pusat/Acc
            $no_urut = request()->no_urut;
            $no_urut_spp = request()->no_urut_spp;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        //'status' => 3,
                        'id_user_approval_spp_1' => Auth::user()->id,
                        'status_spp_1' => 3,
                        'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_1' => Auth::user()->id,
                            'status_spp_1' => 3,
                            'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        ]);

        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- jika Biaya
            $no_urut = request()->no_urut;
            $no_urut_spp = request()->no_urut_spp;

            $approved = DB::table('pengajuan_biaya')->where('no_urut', $no_urut)
                    ->update([
                        //'status' => 3,
                        'id_user_approval_spp_2' => Auth::user()->id,
                        'status_spp_2' => 3,
                        'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        'keterangan_approval' => $request->get('addKeterangan'),
                    ]);

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_2' => Auth::user()->id,
                            'status_spp_2' => 3,
                            'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        ]);
        }

        alert()->warning('Warning.','Request Pending...');
        return redirect()->route('approval_spp.index');
    }

    public function approved_manual(Request $request)
    {
		$tahun = (date('Y'));
        $bulan = (date('m'));

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
		
        if(Auth::user()->kode_sub_divisi == '5'){ //-- jika Biaya Pusat/Acc
            $no_urut = request()->no_urut_spp;
            $no_urut_spp = request()->no_urut_spp;
            //dd($no_urut_spp);
			
			//Kode Approve SPP////
            $getRow = DB::table('spp')
							->select(DB::raw('MAX(kode_approved_spp_1) as No_Urut_app_1'))
							->where('id_user_approval_spp_1', Auth::user()->id)
							->whereMonth('tgl_approval_spp_1', $bulan)
                            ->whereYear('tgl_approval_spp_1', $tahun);
			$rowCount = $getRow->count();

			if($rowCount > 0){
				if ($rowCount < 9) {
					$kode_app_1 = 'APP '.'000'.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 99) {
					$kode_app_1 = 'APP '.'00'.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 999) {
					$kode_app_1 = 'APP '.'0'.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else {
					$kode_app_1 = 'APP '.''.($rowCount + 3).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				}
			}else{
				$kode_app_1 = 'APP '.'0001'.'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.BP'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
			}
            //end kode Approved SPP////

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_1' => Auth::user()->id,
							'kode_approved_spp_1' => $kode_app_1,
                            'status_spp_1' => 1,
                            'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        ]);


        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- jika kepala Accunting
            $no_urut = request()->no_urut_spp;
            $no_urut_spp = request()->no_urut_spp;
			
			//Kode Approve SPP////
            $getRow = DB::table('spp')
							->select(DB::raw('MAX(kode_approved_spp_2) as No_Urut_app_2'))
							->where('id_user_approval_spp_2', Auth::user()->id)
							->whereMonth('tgl_approval_spp_2', $bulan)
                            ->whereYear('tgl_approval_spp_2', $tahun);
			$rowCount = $getRow->count();

			if($rowCount > 0){
				if ($rowCount < 9) {
					$kode_app_2 = 'APP '.'000'.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 99) {
					$kode_app_2 = 'APP '.'00'.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else if ($rowCount < 999) {
					$kode_app_2 = 'APP '.'0'.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				} else {
					$kode_app_2 = 'APP '.''.($rowCount + 1).'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
				}
			}else{
				//$kode_app_2 = '1'.'/'.$kode_divisi.'/'.$kode_depo;
				$kode_app_2 = 'APP '.'0001'.'/'.'HO'.'-'.Auth::user()->kode_depo.'/'.'KA.ACC'.'/'.'ACC'.'/'.$bulan_romawi.'/'.$tahun;
			}
            //end kode Approved SPP////


            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_2' => Auth::user()->id,
							'kode_approved_spp_2' => $kode_app_2,
                            'status_spp_2' => 1,
                            'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        ]);
        }

        alert()->success('Success.','Request Approved...');
        return redirect()->route('approval_spp.index');
    }

    public function denied_manual(Request $request)
    {
        if(Auth::user()->kode_sub_divisi == '5'){ //-- jika Biaya Pusat/Acc
            $no_urut = request()->no_urut_spp;
            $no_urut_spp = request()->no_urut_spp;

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_1' => Auth::user()->id,
                            'status_spp_1' => 2,
                            'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        ]);

        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- jika Kepala Akunting
            $no_urut = request()->no_urut_spp;
            $no_urut_spp = request()->no_urut_spp;

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_2' => Auth::user()->id,
                            'status_spp_2' => 2,
                            'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        ]);
        }

        alert()->error('Oops...','Request Denied...');
        return redirect()->route('approval_spp.index');
    }

    public function pending_manual(Request $request)
    {
        if(Auth::user()->kode_sub_divisi == '5'){ //-- jika Biaya Pusat/Acc
            $no_urut = request()->no_urut_spp;
            $no_urut_spp = request()->no_urut_spp;

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_1' => Auth::user()->id,
                            'status_spp_1' => 3,
                            'tgl_approval_spp_1' => Carbon::now()->format('Y-m-d'),
                        ]);

        }elseif(Auth::user()->kode_sub_divisi == '4'){ //-- jika Biaya
            $no_urut = request()->no_urut_spp;
            $no_urut_spp = request()->no_urut_spp;

            $approved_spp = DB::table('spp')->where('no_urut', $no_urut_spp)
                        ->update([
                            'id_user_approval_spp_2' => Auth::user()->id,
                            'status_spp_2' => 3,
                            'tgl_approval_spp_2' => Carbon::now()->format('Y-m-d'),
                        ]);
        }

        alert()->warning('Warning.','Request Pending...');
        return redirect()->route('approval_spp.index');
    }
}
