<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapAtkAppController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $rekap = DB::table('rekap_pengajuan')   
                ->join('users','rekap_pengajuan.id_user_input','=','users.id') 
                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                        'users.name','rekap_pengajuan.status','rekap_pengajuan.no_urut')
                ->WhereBetween('rekap_pengajuan.tgl_rekap', [$date_start,$date_end])
                ->orderBy('rekap_pengajuan.tgl_rekap', 'DESC')
                ->get();

        return view('purchasing.rekap_atk_app.index', compact('rekap'));
    }

    public function cari(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $rekap = DB::table('rekap_pengajuan')
        ->join('users','rekap_pengajuan.id_user_input','=','users.id')    
                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                        'users.name','rekap_pengajuan.status','rekap_pengajuan.no_urut')
                ->WhereBetween('rekap_pengajuan.tgl_rekap', [$date_start,$date_end])
                ->orderBy('rekap_pengajuan.tgl_rekap', 'DESC')
                ->get();

        return view ('purchasing.rekap_atk_app.index', compact('rekap'));
    }

    public function view($no_urut)
    {
        $header = DB::table('rekap_pengajuan')
                    ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                            'rekap_pengajuan.status','rekap_pengajuan.no_urut')
                    ->where('rekap_pengajuan.no_urut', $no_urut)->first();

        $rekap_pengajuan_v = DB::table('rekap_pengajuan')
                            ->join('rekap_pengajuan_detail','rekap_pengajuan.kode_rekap','=','rekap_pengajuan_detail.kode_rekap')
                            ->join('users','rekap_pengajuan.id_user_input','=','users.id')
                            ->join('products','rekap_pengajuan_detail.kode_product','=','products.kode')
                            ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.no_urut','rekap_pengajuan_detail.kode_product','products.nama_barang',
                                    'products.merk','products.ket','rekap_pengajuan_detail.qty_awal','rekap_pengajuan_detail.qty_jadi','products.satuan',
                                    'rekap_pengajuan_detail.harga','rekap_pengajuan_detail.total_harga','rekap_pengajuan_detail.status')
                            ->where('rekap_pengajuan.no_urut', $no_urut)->get();

        $total_rekap = DB::table('rekap_pengajuan_detail')
                        ->select(DB::raw('SUM(rekap_pengajuan_detail.total_harga) as total_all'))
                        ->where('rekap_pengajuan_detail.no_urut', $no_urut)
                        ->first();
						
						
						
		$bulan = date('m', strtotime($header->tgl_rekap));
        $date_filter = $bulan-1;
        
        $rekap_pengajuan_v_all = DB::table('pengajuan')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('rekap_pengajuan_detail','pengajuan_detail.kode_product','=','rekap_pengajuan_detail.kode_product')
                                ->join('rekap_pengajuan','rekap_pengajuan_detail.kode_rekap','=','rekap_pengajuan.kode_rekap')
                                ->join('products','rekap_pengajuan_detail.kode_product','=','products.kode')
                                ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan_detail.kode_product','rekap_pengajuan_detail.kode_rekap',
                                        'rekap_pengajuan_detail.kode_product','products.nama_barang','rekap_pengajuan.no_urut')
                                ->whereMonth('pengajuan.tgl_pengajuan', $date_filter)
                                ->WhereYear('pengajuan.tgl_pengajuan', $header->tgl_rekap)
                                ->where('pengajuan.jenis', 8)
                                ->WhereIn('pengajuan.status_ga',['1'])
                                ->WhereIn('pengajuan.status_validasi_adm_pc',['1'])
                                ->WhereNotIn('pengajuan_detail.id_kategori',['2'])
                                ->where('rekap_pengajuan.no_urut', $no_urut)
                                ->get();

        return view('purchasing.rekap_atk_app.view', compact('header','rekap_pengajuan_v','total_rekap','rekap_pengajuan_v_all')); 
    }

    public function approved(Request $request)
    {
        $no_urut = $request->no_urut;
		
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
		
		$getRow = DB::table('rekap_pengajuan')
                    ->select(DB::raw('count(kode_rekap) as NoUrut'))
                    ->whereMonth('tgl_rekap', '=', $bulan);
        $rowCount = $getRow->count();
		
		if ($rowCount < 9) {
            $no_pengajuan = 'APP '.'000'.''.$rowCount.'/'.'TUA-HO'.'-'.'PC'.'/'.$bulan_romawi.'/'.$tahun;
        } else if ($rowCount < 99) {
            $no_pengajuan = 'APP '.'00'.''.$rowCount.'/'.'TUA-HO'.'-'.'PC'.'/'.$bulan_romawi.'/'.$tahun;
        } else if ($rowCount < 999) {
            $no_pengajuan = 'APP '.'0'.''.$rowCount.'/'.'TUA-HO'.'-'.'PC'.'/'.$bulan_romawi.'/'.$tahun;
        } else {
            $no_pengajuan = 'APP '.''.$rowCount.'/'.'TUA-HO'.'-'.'PC'.'/'.$bulan_romawi.'/'.$tahun;
        }

        $approved = DB::table('rekap_pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status' => 1, //approved atau ok
					'status_approval_pc' => 1,
                    'id_user_approval_pc' => Auth::user()->id,
                    'tgl_approval_pc' =>  Carbon::now()->format('Y-m-d'),
                    'keterangan_approval_pc' => 'ok',
                    'kode_approval_pc' => $no_pengajuan
            ]);
			
		// update pengajuan //
        $kode_pengajuan_all = $request->kode_pengajuan_all;
        for ($u=0; $u < count((array)$kode_pengajuan_all); $u++) {
            $data_update = DB::table('pengajuan')
                    ->select('pengajuan.id_user_approval_pc','pengajuan.status_pc','pengajuan.tgl_approval_pc','pengajuan.kode_app_pc')
                    ->where('pengajuan.kode_pengajuan', $kode_pengajuan_all[$u])
                    ->update([
                        'pengajuan.id_user_approval_pc' => Auth::user()->id,
                        'pengajuan.status_pc' => 1,
                        'pengajuan.tgl_approval_pc' => Carbon::now()->format('Y-m-d'),
                        'pengajuan.kode_app_pc' => ''

                    ]);
        }
        
        $output = [
            'msg'  => 'Transaksi baru berhasil ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);

        alert()->success('Berhasil.','Validasi pengajuan berhasil...');
        return redirect()->route('rekap_atk_app.index');
    }

    public function pending(Request $request)
    {
        $no_urut = $request->no_urut;

        $approved = DB::table('rekap_pengajuan')->where('no_urut', $no_urut)
                ->update([
                    'status' => 2, //pending
            ]);
			
		// update pengajuan //
        $kode_pengajuan_all = $request->kode_pengajuan_all;
        for ($u=0; $u < count((array)$kode_pengajuan_all); $u++) {
            $data_update = DB::table('pengajuan')
                    ->select('pengajuan.id_user_approval_pc','pengajuan.status_pc','pengajuan.tgl_approval_pc','pengajuan.kode_app_pc')
                    ->where('pengajuan.kode_pengajuan', $kode_pengajuan_all[$u])
                    ->update([
                        'pengajuan.id_user_approval_pc' => Auth::user()->id,
                        'pengajuan.status_pc' => 2,
                        'pengajuan.tgl_approval_pc' => Carbon::now()->format('Y-m-d'),
                        'pengajuan.kode_app_pc' => ''

                    ]);
        }

        $output = [
            'msg'  => 'Transaksi ditunda',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);

        alert()->success('Berhasil.','Validasi pengajuan ditunda...');
        return redirect()->route('rekap_atk_app.index');
    }

    
}
