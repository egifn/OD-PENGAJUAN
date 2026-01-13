<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pembelian;
use App\Pembelian_Detail;
use App\Perusahaan;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapAtkController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        return view('purchasing.rekap_atk.index');
    }

    public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ', $request->tgl_cari);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');

        $data_po = DB::table('pengajuan')
            ->join('pengajuan_detail', 'pengajuan.kode_pengajuan', '=', 'pengajuan_detail.kode_pengajuan')
            ->join('products', 'pengajuan_detail.kode_product', '=', 'products.kode')
            ->select(
                'pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                DB::raw('SUM(pengajuan_detail.qty_ga) as qty'),
                'products.satuan',
                'products.price'
            )
            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start, $date_end])
            ->WhereIn('pengajuan.status_ga',['1'])
            ->WhereIn('pengajuan.status_validasi_adm_pc',['0'])
            ->WhereNotIn('pengajuan_detail.id_kategori',['2','3','4'])
            ->groupBy(
                'pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                'products.satuan',
                'products.price'
            );

        $data = $data_po->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function cari_all(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ', $request->tgl_cari);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');

        $data_po_all = DB::table('pengajuan')
            ->join('pengajuan_detail', 'pengajuan.kode_pengajuan', '=', 'pengajuan_detail.kode_pengajuan')
            ->join('products', 'pengajuan_detail.kode_product', '=', 'products.kode')
            ->select(
                'pengajuan.kode_pengajuan',
                'pengajuan.tgl_pengajuan',
                'pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                'pengajuan_detail.qty_ga as qty',
                'products.satuan',
                'products.price'
            )
            ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start, $date_end])
            ->WhereIn('pengajuan.status_ga',['1'])
            ->WhereIn('pengajuan.status_validasi_adm_pc',['0'])
            ->WhereNotIn('pengajuan_detail.id_kategori',['2','3','4'])
            ->orderBy('products.nama_barang');

        $data_all = $data_po_all->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data_all
        ];

        return response()->json($output, 200);
    }

    public function store(Request $request)
    {
        // dd($request->kode_produk);
        // dd($request->kode_pengajuan_all);

        $tahun = (date('Y'));
        $bulan = (date('m'));
        
        if ($bulan == '01'){
            $bulan_romawi = 'I';
            $nama_bulan = 'Januari'; 
        }elseif ($bulan == '02'){
            $bulan_romawi = 'II';
            $nama_bulan = 'Februari';
        }elseif ($bulan == '03'){
            $bulan_romawi = 'III';
            $nama_bulan = 'Maret';
        }elseif ($bulan == '04'){
            $bulan_romawi = 'IV';
            $nama_bulan = 'April';
        }elseif ($bulan == '05'){
            $bulan_romawi = 'V';
            $nama_bulan = 'Mei';
        }elseif ($bulan == '06'){
            $bulan_romawi = 'VI';
            $nama_bulan = 'Juni';
        }elseif ($bulan == '07'){
            $bulan_romawi = 'VII';
            $nama_bulan = 'Juli';
        }elseif ($bulan == '08'){
            $bulan_romawi = 'VIII';
            $nama_bulan = 'Agustus';
        }elseif ($bulan == '09'){
            $bulan_romawi = 'IX';
            $nama_bulan = 'September';
        }elseif ($bulan == '10'){
            $bulan_romawi = 'X';
            $nama_bulan = 'Oktober';
        }elseif ($bulan == '11'){
            $bulan_romawi = 'XI';
            $nama_bulan = 'November';
        }elseif ($bulan == '12'){
            $bulan_romawi = 'XII';
            $nama_bulan = 'Desember';
        }

        $kd_perusahaan = Auth::user()->kode_perusahaan;
        $kode_depo = Auth::user()->kode_depo;
        $kode_divisi = Auth::user()->kode_divisi;

        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',$kode_depo)->first();

        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getRow = DB::table('rekap_pengajuan')
                    ->select(DB::raw('MAX(kode_rekap) as NoUrut'));
        $rowCount = $getRow->count();

        if($rowCount > 0){
            if ($rowCount < 9) {
                $no_pengajuan = 'RKP '.'A'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_pengajuan = 'RKP '.'A'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_pengajuan = 'RKP '.'A'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_pengajuan = 'RKP '.'A'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            //$no_pengajuan = '1'.'/'.$kode_divisi.'/'.$kode_depo;
            $no_pengajuan = 'RKP '.'A'.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        } 

        $getRow = DB::table('rekap_pengajuan')->select(DB::raw('COUNT(kode_rekap) as NoUrut'))->first();
        if ($getRow->NoUrut > 0) {
            $no_urut = $getRow->NoUrut + 1;
        }else{
            $no_urut = 1;
        }

        DB::table('rekap_pengajuan')->insert([
            'kode_rekap' => $no_pengajuan,
            'periode' => $nama_bulan,
            'tgl_rekap' => Carbon::now()->format('Y-m-d'),
            'id_user_input' => Auth::user()->id,
            'status' => '0',
            'no_urut' => $no_urut,
        ]);

        // Detail //
        $kode_product = $request->kode_produk;
        $qty_awal =  $request->jml_qty_masuk;
        $qty_jadi = $request->jml_qty_jadi;
        $harga = str_replace(",", "", $request->harga);
        $chk = $request->chk;
        
        for ($i=0; $i < count((array)$kode_product); $i++) { 
            if($chk[$i] == 1){
                DB::table('rekap_pengajuan_detail')->insert([
                    'kode_rekap' => $no_pengajuan,
                    'kode_product' => $kode_product[$i],
                    'qty_awal' => $qty_awal[$i],
                    'qty_jadi' => $qty_jadi[$i],
                    'harga' => $harga[$i],
                    'total_harga' => $harga[$i]*$qty_jadi[$i],
                    'status' => 0,
                    'no_urut' => $no_urut,
                ]);
            }
        }

        // update status //
        $kode_pengajuan_all = $request->kode_pengajuan_all;
        $tgl_pengajuan_all =  $request->tgl_pengajuan_all;
        $kode_product_all = $request->kode_product_all;

        for ($u=0; $u < count((array)$kode_pengajuan_all); $u++) { 
            $data_update = DB::table('pengajuan')
                    ->select('pengajuan.status_validasi_adm_pc')
                    ->where('pengajuan.kode_pengajuan', $kode_pengajuan_all[$u])
                    ->update([
                        'status_validasi_adm_pc' => 1
                    ]);
        }
		
		for ($u=0; $u < count((array)$kode_pengajuan_all); $u++) { 
            $data_update_status = DB::table('pengajuan_detail')
                    ->select('pengajuan_detail.status_cek_pc','pengajuan_detail.id_user_adm_pc','pengajuan_detail.tgl_approval_adm_pc','pengajuan_detail.keterangan_detail_admin_pc')
                    ->where('pengajuan_detail.kode_pengajuan', $kode_pengajuan_all[$u])
                    ->update([
                        'pengajuan_detail.status_cek_pc' => 1,
                        'pengajuan_detail.id_user_adm_pc' => Auth::user()->id,
                        'pengajuan_detail.tgl_approval_adm_pc' => Carbon::now()->format('Y-m-d')
                    ]);
        }

        $output = [
            'msg'  => 'Transaksi baru berhasil ditambah',
            'res'  => true,
            'type' => 'success'
        ];
        return response()->json($output, 200);
    
    }

    public function index_view()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $data_rekap = DB::table('rekap_pengajuan')   
                ->join('users','rekap_pengajuan.id_user_input','=','users.id') 
                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                        'users.name','rekap_pengajuan.status','rekap_pengajuan.no_urut')
                ->WhereBetween('rekap_pengajuan.tgl_rekap', [$date_start,$date_end])
                ->orderBy('rekap_pengajuan.tgl_rekap', 'DESC')
                ->get();

        return view('purchasing.rekap_atk.index_view', compact('data_rekap'));
    }

    public function cari_rekap(Request $request)
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data_rekap = DB::table('rekap_pengajuan')   
                ->join('users','rekap_pengajuan.id_user_input','=','users.id') 
                ->select('rekap_pengajuan.kode_rekap','rekap_pengajuan.periode','rekap_pengajuan.tgl_rekap','rekap_pengajuan.id_user_input',
                        'users.name','rekap_pengajuan.status','rekap_pengajuan.no_urut')
                ->WhereBetween('rekap_pengajuan.tgl_rekap', [$date_start,$date_end])
                ->orderBy('rekap_pengajuan.tgl_rekap', 'DESC')
                ->get();

        return view ('purchasing.rekap_atk_app.index', compact('rekap'));
    }
}
