<?php

namespace App\Http\Controllers\Ga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GaRekapAtkController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        return view('ga.rekap_atk.index');
    }

    public function cari(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ', $request->tgl_cari);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');

        $bulan = (date('m')+1);
        
        if ($bulan == '01'){
            $nama_bulan = 'Januari'; 
        }elseif ($bulan == '02'){
            $nama_bulan = 'Februari';
        }elseif ($bulan == '03'){
            $nama_bulan = 'Maret';
        }elseif ($bulan == '04'){
            $nama_bulan = 'April';
        }elseif ($bulan == '05'){
            $nama_bulan = 'Mei';
        }elseif ($bulan == '06'){
            $nama_bulan = 'Juni';
        }elseif ($bulan == '07'){
            $nama_bulan = 'Juli';
        }elseif ($bulan == '08'){
            $nama_bulan = 'Agustus';
        }elseif ($bulan == '09'){
            $nama_bulan = 'September';
        }elseif ($bulan == '10'){
            $nama_bulan = 'Oktober';
        }elseif ($bulan == '11'){
            $nama_bulan = 'November';
        }elseif ($bulan == '12'){
            $nama_bulan = 'Desember';
        }

        $data_po = DB::table('pengajuan')
            ->join('pengajuan_detail', 'pengajuan.kode_pengajuan', '=', 'pengajuan_detail.kode_pengajuan')
            ->join('products', 'pengajuan_detail.kode_product', '=', 'products.kode')
            ->select(
                'pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                DB::raw('SUM(pengajuan_detail.qty_ops) as qty_ops'),
                DB::raw('SUM(pengajuan_detail.qty_ga) as qty_ga'),
                DB::raw('(SELECT SUM(rekap_pengajuan_detail.qty_jadi) 
                        FROM rekap_pengajuan 
                        INNER JOIN rekap_pengajuan_detail 
                            ON rekap_pengajuan.kode_rekap = rekap_pengajuan_detail.kode_rekap 
                        WHERE rekap_pengajuan.periode = ? 
                            AND rekap_pengajuan_detail.kode_product = pengajuan_detail.kode_product
                        ) AS qty_pc'),
                'products.satuan',
                'products.price'
            )
            ->whereBetween('pengajuan.tgl_pengajuan', [$date_start, $date_end])
            ->whereIn('pengajuan.status_ops',['1'])
            ->whereNotIn('pengajuan_detail.id_kategori',['2','3','4'])
            ->groupBy(
                'pengajuan_detail.kode_product',
                'products.nama_barang',
                'products.merk',
                'products.ket',
                'products.satuan',
                'products.price'
            )
            ->addBinding($nama_bulan, 'select');
    


        $data = $data_po->get();
        $output = [
            'status'  => true,
            'message' => 'success',
            'data'    => $data
        ];

        return response()->json($output, 200);
    }

    public function rekap_excel(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode(' - ', $request->tanggal);
        $date_start = Carbon::parse($date[0])->format('Y-m-d');
        $date_end = Carbon::parse($date[1])->format('Y-m-d');
		
		$bulan = (date('m')+1);
        
        if ($bulan == '01'){
            $nama_bulan = 'Januari'; 
        }elseif ($bulan == '02'){
            $nama_bulan = 'Februari';
        }elseif ($bulan == '03'){
            $nama_bulan = 'Maret';
        }elseif ($bulan == '04'){
            $nama_bulan = 'April';
        }elseif ($bulan == '05'){
            $nama_bulan = 'Mei';
        }elseif ($bulan == '06'){
            $nama_bulan = 'Juni';
        }elseif ($bulan == '07'){
            $nama_bulan = 'Juli';
        }elseif ($bulan == '08'){
            $nama_bulan = 'Agustus';
        }elseif ($bulan == '09'){
            $nama_bulan = 'September';
        }elseif ($bulan == '10'){
            $nama_bulan = 'Oktober';
        }elseif ($bulan == '11'){
            $nama_bulan = 'November';
        }elseif ($bulan == '12'){
            $nama_bulan = 'Desember';
        }

        $tombol_excel = $request->input('btn_excel');
        if($tombol_excel == 'excel'){
            $data_po = DB::table('pengajuan')
                ->join('pengajuan_detail', 'pengajuan.kode_pengajuan', '=', 'pengajuan_detail.kode_pengajuan')
                ->join('products', 'pengajuan_detail.kode_product', '=', 'products.kode')
                ->select(
                    'pengajuan_detail.kode_product',
                    'products.nama_barang',
                    'products.merk',
                    'products.ket',
                    DB::raw('SUM(pengajuan_detail.qty_ops) as qty_ops'),
                    DB::raw('SUM(pengajuan_detail.qty_ga) as qty_ga'),
                    DB::raw('(SELECT SUM(rekap_pengajuan_detail.qty_jadi) 
                            FROM rekap_pengajuan 
                            INNER JOIN rekap_pengajuan_detail 
                                ON rekap_pengajuan.kode_rekap = rekap_pengajuan_detail.kode_rekap 
                            WHERE rekap_pengajuan.periode = ? 
                                AND rekap_pengajuan_detail.kode_product = pengajuan_detail.kode_product
                            ) AS qty_pc'),
                    'products.satuan',
                    'products.price'
                )
                ->whereBetween('pengajuan.tgl_pengajuan', [$date_start, $date_end])
                ->whereIn('pengajuan.status_ops',['1'])
                ->whereNotIn('pengajuan_detail.id_kategori',['2','3','4'])
                ->groupBy(
                    'pengajuan_detail.kode_product',
                    'products.nama_barang',
                    'products.merk',
                    'products.ket',
                    'products.satuan',
                    'products.price'
                )
                ->addBinding($nama_bulan, 'select')
                ->get();

            return view ('ga.rekap_atk.view_excel', compact('data_po'));
        }
        
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
            ->WhereIn('pengajuan.status_ops',['1'])
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
}
