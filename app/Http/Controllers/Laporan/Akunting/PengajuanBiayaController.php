<?php

namespace App\Http\Controllers\Laporan\Akunting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Depo;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanBiayaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->tanggal_awal == null) {
            $laporan = DB::table('pengajuan_biaya')
            ->select(
                'pengajuan_biaya.kode_pengajuan_b',
                'pengajuan_biaya.tgl_pengajuan_b',
                'pengajuan_biaya.kategori',
                'ms_pengeluaran.nama_pengeluaran',
                'pengajuan_biaya.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'pengajuan_biaya.kode_depo',
                'depos.nama_depo',
                'pengajuan_biaya.kode_divisi',
                'divisi.nama_divisi',
                'pengajuan_biaya.keterangan',
                'pengajuan_biaya.status_biaya AS ka_keuangan_depo',
                'pengajuan_biaya.status_atasan AS ops_depo',
                'pengajuan_biaya.status_validasi_acc AS pic_ho',
                'pengajuan_biaya.status_biaya_pusat'
            )
            ->Join('ms_pengeluaran', 'pengajuan_biaya.kategori', '=', 'ms_pengeluaran.id')
            ->join('perusahaans', 'pengajuan_biaya.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->Join('depos', 'pengajuan_biaya.kode_depo', '=', 'depos.kode_depo')
            ->join('divisi', 'pengajuan_biaya.kode_divisi', '=', 'divisi.kode_divisi')

            ->whereBetween('pengajuan_biaya.tgl_pengajuan_b', ['0000-00-00', '0000-00-00'])
            ->whereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43','118','119','130','137'])
            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'desc')
            ->get();
        }else{
            $laporan = DB::table('pengajuan_biaya')
            ->select(
                'pengajuan_biaya.kode_pengajuan_b',
                'pengajuan_biaya.tgl_pengajuan_b',
                'pengajuan_biaya.kategori',
                'ms_pengeluaran.nama_pengeluaran',
                'pengajuan_biaya.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'pengajuan_biaya.kode_depo',
                'depos.nama_depo',
                'pengajuan_biaya.kode_divisi',
                'divisi.nama_divisi',
                'pengajuan_biaya.keterangan',
                'pengajuan_biaya.status_biaya AS ka_keuangan_depo',
                'pengajuan_biaya_detail.tgl_approval_detail',
                'pengajuan_biaya.status_atasan AS ops_depo',
                'pengajuan_biaya_detail.tgl_approval_detail_atasan',
                'pengajuan_biaya.status_validasi_acc AS pic_ho',
                'pengajuan_biaya_detail.tgl_approval_detail_acc',
                'pengajuan_biaya.status_biaya_pusat',
                'pengajuan_biaya.tgl_approval_biaya_pusat'
            )
            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b', '=', 'pengajuan_biaya_detail.kode_pengajuan_b')
            ->Join('ms_pengeluaran', 'pengajuan_biaya.kategori', '=', 'ms_pengeluaran.id')
            ->join('perusahaans', 'pengajuan_biaya.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->Join('depos', 'pengajuan_biaya.kode_depo', '=', 'depos.kode_depo')
            ->join('divisi', 'pengajuan_biaya.kode_divisi', '=', 'divisi.kode_divisi')
            ->whereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43','118','119','130','137'])
            ->when($request->tanggal_awal && $request->tanggal_akhir, function ($q) use ($request) {
                $q->whereBetween('pengajuan_biaya.tgl_pengajuan_b', [$request->tanggal_awal, $request->tanggal_akhir]);
            })
            ->when($request->perusahaan, function ($q) use ($request) {
                $q->where('perusahaans.kode_perusahaan', $request->perusahaan);
            })
            ->when($request->depo, function ($q) use ($request) {
                $q->where('depos.kode_depo', $request->depo);
            })
            ->groupby(
                'pengajuan_biaya.kode_pengajuan_b',
                'pengajuan_biaya.tgl_pengajuan_b',
                'pengajuan_biaya.kategori',
                'ms_pengeluaran.nama_pengeluaran',
                'pengajuan_biaya.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'pengajuan_biaya.kode_depo',
                'depos.nama_depo',
                'pengajuan_biaya.kode_divisi',
                'divisi.nama_divisi',
                'pengajuan_biaya.keterangan',
                'pengajuan_biaya.status_biaya',
                'pengajuan_biaya_detail.tgl_approval_detail',
                'pengajuan_biaya.status_atasan',
                'pengajuan_biaya_detail.tgl_approval_detail_atasan',
                'pengajuan_biaya.status_validasi_acc',
                'pengajuan_biaya_detail.tgl_approval_detail_acc',
                'pengajuan_biaya.status_biaya_pusat',
                'pengajuan_biaya.tgl_approval_biaya_pusat'
            )
            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'desc')
            ->get();
        }
        

        $perusahaan = DB::table('perusahaans')->select('kode_perusahaan','nama_perusahaan')->get();
        $depo = DB::table('depos')->select('nama_depo')->get();

        return view('laporan.biaya_jasa.index', compact('laporan', 'perusahaan', 'depo'));
    }

    public function ajax_depo(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
            return response()->json($kodedepo);
    }

    public function view_excel(Request $request)
    {
        $laporan = DB::table('pengajuan_biaya')
            ->select(
                'pengajuan_biaya.kode_pengajuan_b',
                'pengajuan_biaya.tgl_pengajuan_b',
                'pengajuan_biaya.kategori',
                'ms_pengeluaran.nama_pengeluaran',
                'pengajuan_biaya.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'pengajuan_biaya.kode_depo',
                'depos.nama_depo',
                'pengajuan_biaya.kode_divisi',
                'divisi.nama_divisi',
                'pengajuan_biaya.keterangan',
                'pengajuan_biaya.status_biaya AS ka_keuangan_depo',
                'pengajuan_biaya_detail.tgl_approval_detail',
                'pengajuan_biaya.status_atasan AS ops_depo',
                'pengajuan_biaya_detail.tgl_approval_detail_atasan',
                'pengajuan_biaya.status_validasi_acc AS pic_ho',
                'pengajuan_biaya_detail.tgl_approval_detail_acc',
                'pengajuan_biaya.status_biaya_pusat',
                'pengajuan_biaya.tgl_approval_biaya_pusat'
            )
            ->join('pengajuan_biaya_detail','pengajuan_biaya.kode_pengajuan_b', '=', 'pengajuan_biaya_detail.kode_pengajuan_b')
            ->join('ms_pengeluaran', 'pengajuan_biaya.kategori', '=', 'ms_pengeluaran.id')
            ->join('perusahaans', 'pengajuan_biaya.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
            ->join('depos', 'pengajuan_biaya.kode_depo', '=', 'depos.kode_depo')
            ->join('divisi', 'pengajuan_biaya.kode_divisi', '=', 'divisi.kode_divisi')
            ->whereNotIn('pengajuan_biaya.kategori', ['1','2','3','4','5','43','118','119','130','137'])
            ->when($request->tanggal_awal && $request->tanggal_akhir, function ($q) use ($request) {
                $q->whereBetween('pengajuan_biaya.tgl_pengajuan_b', [$request->tanggal_awal, $request->tanggal_akhir]);
            })
            ->when($request->perusahaan, function ($q) use ($request) {
                $q->where('perusahaans.kode_perusahaan', $request->perusahaan);
            })
            ->when($request->depo, function ($q) use ($request) {
                $q->where('depos.kode_depo', $request->depo);
            })
            ->groupby(
                'pengajuan_biaya.kode_pengajuan_b',
                'pengajuan_biaya.tgl_pengajuan_b',
                'pengajuan_biaya.kategori',
                'ms_pengeluaran.nama_pengeluaran',
                'pengajuan_biaya.kode_perusahaan',
                'perusahaans.nama_perusahaan',
                'pengajuan_biaya.kode_depo',
                'depos.nama_depo',
                'pengajuan_biaya.kode_divisi',
                'divisi.nama_divisi',
                'pengajuan_biaya.keterangan',
                'pengajuan_biaya.status_biaya',
                'pengajuan_biaya_detail.tgl_approval_detail',
                'pengajuan_biaya.status_atasan',
                'pengajuan_biaya_detail.tgl_approval_detail_atasan',
                'pengajuan_biaya.status_validasi_acc',
                'pengajuan_biaya_detail.tgl_approval_detail_acc',
                'pengajuan_biaya.status_biaya_pusat',
                'pengajuan_biaya.tgl_approval_biaya_pusat'
            )
            ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'desc')
            ->get();

        return view('laporan.biaya_jasa.view_excel', compact('laporan'));
    }


}
