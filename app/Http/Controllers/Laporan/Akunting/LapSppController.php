<?php

namespace App\Http\Controllers\Laporan\Akunting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use App\Depo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LapSppController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tanggal_awal == null) {
            $laporan = DB::table('spp')
                   ->select('spp.no_spp',
                            'spp.tgl_spp',
                            'spp.keterangan',
                            'spp.kategori',
                            'spp.jumlah',
                            'spp.status_spp_1',
                            'spp.status_spp_2')
                    ->whereBetween('spp.tgl_spp', ['0000-00-00', '0000-00-00'])
                    ->get();
        }else{
            $laporan = DB::table('spp')
                   ->select('spp.no_spp',
                            'spp.tgl_spp',
                            'spp.keterangan',
                            'spp.kategori',
                            'spp.jumlah',
                            'spp.status_spp_1',
                            'spp.status_spp_2')
                    ->where('spp.status_spp_1', 1)
                    ->where('spp.status_spp_2', 1)
                    ->when($request->tanggal_awal && $request->tanggal_akhir, function ($q) use ($request) {
                        $q->whereBetween('spp.tgl_spp', [$request->tanggal_awal, $request->tanggal_akhir]);
                    })
                    ->get();
        }
        
        $perusahaan = DB::table('perusahaans')->select('kode_perusahaan','nama_perusahaan')->get();
        $depo = DB::table('depos')->select('nama_depo')->get();

        return view('laporan.spp.index', compact('laporan','perusahaan', 'depo'));
    }

    public function ajax_depo(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
            return response()->json($kodedepo);
    }

    public function view_excel(Request $request)
    {
        $laporan = DB::table('spp')
                   ->select('spp.no_spp',
                            'spp.tgl_spp',
                            'spp.keterangan',
                            'spp.kategori',
                            'spp.jumlah',
                            'spp.status_spp_1',
                            'spp.status_spp_2')
                    ->where('spp.status_spp_1', 1)
                    ->where('spp.status_spp_2', 1)
                    ->when($request->tanggal_awal && $request->tanggal_akhir, function ($q) use ($request) {
                        $q->whereBetween('spp.tgl_spp', [$request->tanggal_awal, $request->tanggal_akhir]);
                    })
                    ->get();

        return view('laporan.spp.view_excel', compact('laporan'));
    }



}
