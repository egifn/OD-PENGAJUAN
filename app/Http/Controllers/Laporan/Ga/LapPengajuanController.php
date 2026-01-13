<?php

namespace App\Http\Controllers\Laporan\Ga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Depo;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LapPengajuanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tanggal_awal == null) {
            $laporan = DB::table('pengajuan')
                        ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('divisi','pengajuan.kode_divisi','=','divisi.kode_divisi')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->select(
                            'pengajuan.tgl_pengajuan',
                            'pengajuan.kode_perusahaan',
                            'pengajuan.kode_depo',
                            'depos.nama_depo',
                            'pengajuan.kode_divisi',
                            'divisi.nama_divisi',
                            'pengajuan.kode_pengajuan',
                            'pengajuan.jenis',
                            'ms_pengeluaran.nama_pengeluaran'    
                        )
            ->whereBetween('pengajuan.tgl_pengajuan', ['0000-00-00', '0000-00-00'])
            ->orderBy('pengajuan.tgl_pengajuan', 'desc')
            ->get();
        }else{
            $laporan = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('divisi','pengajuan.kode_divisi','=','divisi.kode_divisi')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->select(
                            'pengajuan.tgl_pengajuan',
                            'pengajuan.kode_perusahaan',
                            'perusahaans.nama_perusahaan',
                            'pengajuan.kode_depo',
                            'depos.nama_depo',
                            'pengajuan.kode_divisi',
                            'divisi.nama_divisi',
                            'pengajuan.kode_pengajuan',
                            'pengajuan.jenis',
                            'ms_pengeluaran.nama_pengeluaran'    
                        )
            ->when($request->tanggal_awal && $request->tanggal_akhir, function ($q) use ($request) {
                $q->whereBetween('pengajuan.tgl_pengajuan', [$request->tanggal_awal, $request->tanggal_akhir]);
            })
            ->when($request->perusahaan, function ($q) use ($request) {
                $q->where('perusahaans.kode_perusahaan', $request->perusahaan);
            })
            ->when($request->depo, function ($q) use ($request) {
                $q->where('depos.kode_depo', $request->depo);
            })
            ->orderBy('pengajuan.tgl_pengajuan', 'desc')
            ->get();
        }

        $perusahaan = DB::table('perusahaans')->select('kode_perusahaan','nama_perusahaan')->get();
        $depo = DB::table('depos')->select('nama_depo')->get();

        return view('laporan.ga_pengajuan_barang.index', compact('laporan', 'perusahaan', 'depo'));
    }

    public function ajax_depo(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
            return response()->json($kodedepo);
    }

    public function view_excel(Request $request)
    {
        $laporan = DB::table('pengajuan')
                        ->join('perusahaans','pengajuan.kode_perusahaan','=','perusahaans.kode_perusahaan')
                        ->join('depos','pengajuan.kode_depo','=','depos.kode_depo')
                        ->join('divisi','pengajuan.kode_divisi','=','divisi.kode_divisi')
                        ->join('ms_pengeluaran','pengajuan.jenis','=','ms_pengeluaran.id')
                        ->select(
                            'pengajuan.tgl_pengajuan',
                            'pengajuan.kode_perusahaan',
                            'perusahaans.nama_perusahaan',
                            'pengajuan.kode_depo',
                            'depos.nama_depo',
                            'pengajuan.kode_divisi',
                            'divisi.nama_divisi',
                            'pengajuan.kode_pengajuan',
                            'pengajuan.jenis',
                            'ms_pengeluaran.nama_pengeluaran'    
                        )
            ->when($request->tanggal_awal && $request->tanggal_akhir, function ($q) use ($request) {
                $q->whereBetween('pengajuan.tgl_pengajuan', [$request->tanggal_awal, $request->tanggal_akhir]);
            })
            ->when($request->perusahaan, function ($q) use ($request) {
                $q->where('perusahaans.kode_perusahaan', $request->perusahaan);
            })
            ->when($request->depo, function ($q) use ($request) {
                $q->where('depos.kode_depo', $request->depo);
            })
            ->orderBy('pengajuan.tgl_pengajuan', 'desc')
            ->get();

        return view('laporan.ga_pengajuan_barang.view_excel', compact('laporan'));
    }
}
