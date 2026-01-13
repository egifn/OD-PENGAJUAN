<?php

namespace App\Http\Controllers\PengajuanSerahTerimaUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class SerahTerimaController extends Controller
{
    public function index()
    {
    	$date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        $pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan.status_ops', 1)
                                ->Where('pengajuan.status_ga', 1)
                                
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->orderBy('pengajuan.status_validasi_adm_ga', 'ASC')
                                ->get();

        return view ('pengajuan_penerimaan_user.index', compact('pengajuan_masuk'));
    }

    public function cari(Request $request)
    {
    	if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $pengajuan_masuk = DB::table('pengajuan')
        						->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
								->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                ->join('users','pengajuan.id_user_input','=','users.id')
                                ->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')
                                ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                ->select('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->WhereBetween('pengajuan.tgl_pengajuan', [$date_start,$date_end])
                                ->where('pengajuan.status_atasan', 1)
                                ->Where('pengajuan.status_ops', 1)
                                ->Where('pengajuan.status_ga', 1)
                                
                                ->groupBy('pengajuan.kode_pengajuan','pengajuan.no_urut','pengajuan.tgl_pengajuan','users.name','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','pengajuan.kode_depo','depos.nama_depo','pengajuan.jenis','pengajuan.status_pengajuan','pengajuan.status_it','pengajuan.status_ga','pengajuan.status_ops','pengajuan.status_pc','ms_pengeluaran.nama_pengeluaran','ms_pengeluaran.sifat','pengajuan.keterangan_approval','pengajuan.status_validasi_adm_it','pengajuan.status_validasi_adm_ga','pengajuan.status_validasi_adm_ops','pengajuan.status_validasi_adm_pc','pengajuan.kode_divisi')
                                ->orderBy('pengajuan.status_validasi_adm_ga', 'ASC')
                                ->get();

        return view ('pengajuan_penerimaan_user.index', compact('pengajuan_masuk'));

    }

    public function view($no_urut)
    {
        $pengajuan_v = DB::table('pengajuan')->join('pengajuan_detail','pengajuan.kode_pengajuan','=','pengajuan_detail.kode_pengajuan')->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                             ->leftjoin('depos','pengajuan.kode_depo','=','depos.kode_depo')
                                             ->join('users','pengajuan.id_user_input','=','users.id')
                                             ->join('products','pengajuan_detail.kode_product','=','products.kode')
                                             ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                                             ->where('pengajuan.no_urut', $no_urut)->first();

        $details = DB::table('pengajuan_detail')->join('products','pengajuan_detail.kode_product','=','products.kode')
                                                ->join('divisi','pengajuan_detail.kode_divisi','=','divisi.kode_divisi')
            									->join('categories','products.category_id','=','categories.id')
            									->where('pengajuan_detail.no_urut', $no_urut)->get();

        

        return view('pengajuan_penerimaan_user.view', compact('pengajuan_v','details'));
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

        $kode_pengajuan = $request->kode_pengajuan;
        $penerima = $request->penerima;
        $kd_perusahaan = Auth::user()->kode_perusahaan;
        $kode_depo = Auth::user()->kode_depo;
        $kode_divisi = Auth::user()->kode_divisi;
        $kode_depo_pengaju = $request->kode_depo;

        $alias_depo = DB::table('depos')
                    ->select('alias')
                    ->where('kode_depo',$kode_depo)->first();

        $alias_divisi = DB::table('divisi')
                    ->select('alias')
                    ->where('kode_divisi',$kode_divisi)->first();

        $getRow = DB::table('serah_terima_pengajuan')
                    ->select(DB::raw('MAX(no_bkb_user) as NoUrut'));
        $rowCount = $getRow->count();

        if($rowCount > 0){
            //$no_pengajuan_biaya = ($rowCount + 1).'/'.$kode_divisi.'/'.$kode_depo;
            if ($rowCount < 9) {
                $no_bkb = 'BPA '.'A'.'000'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 99) {
                $no_bkb = 'BPA '.'A'.'00'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else if ($rowCount < 999) {
                $no_bkb = 'BPA '.'A'.'0'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            } else {
                $no_bkb = 'BPA '.'A'.''.($rowCount + 1).'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
            }
        }else{
            //$no_pengajuan = '1'.'/'.$kode_divisi.'/'.$kode_depo;
            $no_bkb = 'BPA '.'A'.'0001'.'/'.$kd_perusahaan.'-'.$alias_depo->alias.'/'.$alias_divisi->alias.'/'.$bulan_romawi.'/'.$tahun;
        } 

        DB::table('serah_terima_pengajuan')->insert([
            'no_bkb_user' => $no_bkb,
            'tgl_terima' => Carbon::now()->format('Y-m-d'),
            'penerima' => $penerima,
            'kode_pengajuan' => $kode_pengajuan,
            'id_user_input' => Auth::user()->id,
        ]);

        //========New==============
        $details = DB::table('pengajuan_detail')
            ->where('kode_pengajuan', $kode_pengajuan)
            ->select('kode_product', 'qty_pc') // qty_ga = jumlah yang disetujui
            ->get();

        foreach ($details as $detail) {
            $barang = DB::table('products')
                ->where('kode', $detail->kode_product)
                ->first();

            if ($barang) {
                $stok_baru = $barang->stock - $detail->qty_pc;
                if ($stok_baru < 0) {
                    $stok_baru = 0; // pastikan tidak minus
                }

                DB::table('products')
                    ->where('kode', $detail->kode_product)
                    ->update([
                        'stock' => $stok_baru,
                        'updated_at' => now(),
                    ]);
            }

            $existing = DB::table('products_stock_depo')
                ->where('kode_depo', $kode_depo_pengaju)
                ->where('kode_produk', $detail->kode_product)
                ->first();

            if ($existing) {
                // Jika sudah ada → update qty (tambahkan)
                DB::table('products_stock_depo')
                    ->where('kode_depo', $kode_depo_pengaju)
                    ->where('kode_produk', $detail->kode_product)
                    ->update([
                        'qty'        => $existing->qty + $detail->qty_pc,
                        'updated_at' => now(),
                    ]);
            } else {
                // Jika belum ada → insert baru
                DB::table('products_stock_depo')->insert([
                    'kode_depo'   => $kode_depo_pengaju,
                    'kode_produk' => $detail->kode_product,
                    'qty'         => $detail->qty_pc,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
        //========================================================

        $approved = DB::table('pengajuan')->where('kode_pengajuan', $kode_pengajuan)
                ->update([
                    'status_pengajuan' => 5, //sudah diterima oleh user pengaju
            ]);

        alert()->success('Berhasil.','Validasi Pengajuan Berhasil...');
        return redirect()->route('serah_terima_user.index');
    }

    public function pdf($no_urut)
    {
        $pengajuan_head = DB::table('pengajuan')
            ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
            ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.keterangan','ms_pengeluaran.sifat','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi','pengajuan.id_user_input','users.name','pengajuan.kode_app_atasan','pengajuan.kode_app_it','pengajuan.kode_app_ga','pengajuan.kode_app_ops','kode_app_pc','pengajuan.kode_app_tgsm','pengajuan.kode_app_bod','serah_terima_pengajuan.penerima','serah_terima_pengajuan.no_bkb_user','serah_terima_pengajuan.tgl_terima')
            ->where('pengajuan.no_urut', $no_urut)->first();

        $pengajuan_detail = DB::table('pengajuan_detail')
            ->join('products','pengajuan_detail.kode_product','=','products.kode')
            ->where('pengajuan_detail.no_urut',$no_urut)
            ->get();

        // $total_jml = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
        //                         ->get()->sum('tharga');
                                

        $pdf = PDF::loadview('pengajuan_penerimaan_user.pdf', compact('pengajuan_head','pengajuan_detail'))->setPaper('a4', 'potrait'); //landscape
        return $pdf->stream();
    }

    public function pdf_serah_terima(Request $request)
    {
        $pengajuan_head = DB::table('pengajuan')
            ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
            ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
            ->join('divisi','pengajuan.kode_divisi','=','divisi.kode_divisi')
            ->join('users','pengajuan.id_user_input','=','users.id')
            ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
            ->join('serah_terima_pengajuan','pengajuan.kode_pengajuan','=','serah_terima_pengajuan.kode_pengajuan')
            ->select('pengajuan.kode_pengajuan','pengajuan.tgl_pengajuan','pengajuan.keterangan','ms_pengeluaran.sifat','pengajuan.kode_perusahaan','perusahaans.nama_perusahaan','depos.nama_depo','divisi.nama_divisi','pengajuan.id_user_input','users.name','pengajuan.kode_app_atasan','pengajuan.kode_app_it','pengajuan.kode_app_ga','pengajuan.kode_app_ops','kode_app_pc','pengajuan.kode_app_tgsm','pengajuan.kode_app_bod','serah_terima_pengajuan.penerima','serah_terima_pengajuan.no_bkb_user','serah_terima_pengajuan.tgl_terima')
            ->where('pengajuan.no_urut',$request->no_urut)->first();

        $pengajuan_detail = DB::table('pengajuan_detail')
            ->join('products','pengajuan_detail.kode_product','=','products.kode')
            ->where('pengajuan_detail.no_urut',$request->no_urut)
            ->get();

        // $total_jml = Pengajuan_Biaya_Detail::where('no_urut', $no_urut)
        //                         ->get()->sum('tharga');
                                

        $pdf = PDF::loadview('pengajuan_penerimaan_user.pdf', compact('pengajuan_head','pengajuan_detail'))->setPaper('a4', 'potrait'); //landscape
        return $pdf->stream();
    }
}
