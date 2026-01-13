<?php

namespace App\Http\Controllers\AssetList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardAssetController extends Controller
{
    public function index()
    {
    	return view ('asset_dashboard.index');
    }

    public function getDataTotalAsset(Request $request)
    {
        if (!isset($request->value)) {
            $total_asset = DB::table('asset_list_perusahaan')
                    ->select(DB::raw('SUM(asset_list_perusahaan.jml_asset) as total_asset'),
                    DB::raw('SUM(asset_list_perusahaan.n_baik) as total_baik'),
                    DB::raw('SUM(asset_list_perusahaan.n_perlu_diganti) as total_perlu_ganti'),
                    DB::raw('SUM(asset_list_perusahaan.n_perlu_perbaikan) as total_perlu_perbaikan'),
                    DB::raw('SUM(asset_list_perusahaan.n_dalam_perbaikan) as total_dalam_perbaikan'))
                    //->WhereNotIn('tr_penjualan_h.jenis_penjualan', ['Kredit'])
                    //->WhereNotIn('tr_penjualan_h.status_bayar', ['Batal'])
                    //->where('tgl_penjualan',  $date)
                    //->where('kode_cabang', Auth::user()->kd_lokasi)
                    // ->where('id_user_input', Auth::user()->id )
                    ->first();
        }else{
            $total_asset = DB::table('asset_list_perusahaan')
                    ->select(DB::raw('SUM(asset_list_perusahaan.jml_asset) as total_asset'),
                    DB::raw('SUM(asset_list_perusahaan.n_baik) as total_baik'),
                    DB::raw('SUM(asset_list_perusahaan.n_perlu_diganti) as total_perlu_ganti'),
                    DB::raw('SUM(asset_list_perusahaan.n_perlu_perbaikan) as total_perlu_perbaikan'),
                    DB::raw('SUM(asset_list_perusahaan.n_dalam_perbaikan) as total_dalam_perbaikan'))
                    //->WhereNotIn('tr_penjualan_h.jenis_penjualan', ['Kredit'])
                    //->WhereNotIn('tr_penjualan_h.status_bayar', ['Batal'])
                    //->where('tgl_penjualan',  $date)
                    //->where('kode_cabang', $request->value)
                    // ->where('id_user_input', Auth::user()->id )
                    ->first();
        }

        return response()->json([
            'data' => $total_asset
        ]);
    }

    public function getDataTotalChart(Request $request)
    {
        $result = DB::table('asset_list_perusahaan')
                ->selectRaw('
                    SUM(CASE WHEN kode_perusahaan = "TUA" AND n_baik > 0 THEN n_baik ELSE 0 END) AS Jml_TUA_baik,
                    SUM(CASE WHEN kode_perusahaan = "TUA" AND n_perlu_diganti > 0 THEN n_perlu_diganti ELSE 0 END) AS Jml_TUA_rusak_perlu_diganti,
                    SUM(CASE WHEN kode_perusahaan = "TUA" AND n_perlu_perbaikan > 0 THEN n_perlu_perbaikan ELSE 0 END) AS Jml_TUA_rusak_perlu_diperbaiki,
                    SUM(CASE WHEN kode_perusahaan = "TUA" AND n_dalam_perbaikan > 0 THEN n_dalam_perbaikan ELSE 0 END) AS Jml_TUA_dalam_perbaikan,

                    SUM(CASE WHEN kode_perusahaan = "TU" AND n_baik > 0 THEN n_baik ELSE 0 END) AS Jml_TU_baik,
                    SUM(CASE WHEN kode_perusahaan = "TU" AND n_perlu_diganti > 0 THEN n_perlu_diganti ELSE 0 END) AS Jml_TU_rusak_perlu_diganti,
                    SUM(CASE WHEN kode_perusahaan = "TU" AND n_perlu_perbaikan > 0 THEN n_perlu_perbaikan ELSE 0 END) AS Jml_TU_rusak_perlu_diperbaiki,
                    SUM(CASE WHEN kode_perusahaan = "TU" AND n_dalam_perbaikan > 0 THEN n_dalam_perbaikan ELSE 0 END) AS Jml_TU_dalam_perbaikan,

                    SUM(CASE WHEN kode_perusahaan = "TA" AND n_baik > 0 THEN n_baik ELSE 0 END) AS Jml_TA_baik,
                    SUM(CASE WHEN kode_perusahaan = "TA" AND n_perlu_diganti > 0 THEN n_perlu_diganti ELSE 0 END) AS Jml_TA_rusak_perlu_diganti,
                    SUM(CASE WHEN kode_perusahaan = "TA" AND n_perlu_perbaikan > 0 THEN n_perlu_perbaikan ELSE 0 END) AS Jml_TA_rusak_perlu_diperbaiki,
                    SUM(CASE WHEN kode_perusahaan = "TA" AND n_dalam_perbaikan > 0 THEN n_dalam_perbaikan ELSE 0 END) AS Jml_TA_dalam_perbaikan
                ')
                ->first();

        return response()->json([
            'data' => $result
        ]);
    }

    public function getDataTotalDepoChart(Request $request)
    {
        $result_depo = DB::table('asset_list_perusahaan')
                ->selectRaw('
                    SUM(CASE WHEN kode_depo = "029" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Lembang,
                    SUM(CASE WHEN kode_depo = "030" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Majalaya,
                    SUM(CASE WHEN kode_depo = "343" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Padalarang,
                    SUM(CASE WHEN kode_depo = "900" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Sadakeling,
                    SUM(CASE WHEN kode_depo = "902" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Metro,
                    SUM(CASE WHEN kode_depo = "904" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Katapang,
                    SUM(CASE WHEN kode_depo = "912" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Cicalengka,
                    SUM(CASE WHEN kode_depo = "914" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Soreang,
                    SUM(CASE WHEN kode_depo = "930" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Sumedang,
                    SUM(CASE WHEN kode_depo = "031" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Pangandaran,
                    SUM(CASE WHEN kode_depo = "032" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Tasikmalaya,
                    SUM(CASE WHEN kode_depo = "033" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Penggung,
                    SUM(CASE WHEN kode_depo = "036" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Kuningan,
                    SUM(CASE WHEN kode_depo = "335" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Purwakarta,
                    SUM(CASE WHEN kode_depo = "341" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Kanci,
                    SUM(CASE WHEN kode_depo = "344" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Kasomalang,
                    SUM(CASE WHEN kode_depo = "908" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Pamanukan,
                    SUM(CASE WHEN kode_depo = "910" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Jatisari,
                    SUM(CASE WHEN kode_depo = "916" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Banjarsari,
                    SUM(CASE WHEN kode_depo = "917" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Garut,
                    SUM(CASE WHEN kode_depo = "919" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Jatibarang,
                    SUM(CASE WHEN kode_depo = "920" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Majalengka,
                    SUM(CASE WHEN kode_depo = "021" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Pelabuhan_Ratu,
                    SUM(CASE WHEN kode_depo = "337" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Bogor,
                    SUM(CASE WHEN kode_depo = "342" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Citeureup,
                    SUM(CASE WHEN kode_depo = "901" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Parung,
                    SUM(CASE WHEN kode_depo = "906" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Sukabumi,
                    SUM(CASE WHEN kode_depo = "911" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Cianjur,
                    SUM(CASE WHEN kode_depo = "915" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Sentul,
                    SUM(CASE WHEN kode_depo = "925" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Parung_Panjang,
                    SUM(CASE WHEN kode_depo = "926" AND jml_asset = "1" THEN jml_asset ELSE 0 END) AS Tapos
                ')
                ->first(); 

        return response()->json([
            'data' => $result_depo
        ]);
    }
}
