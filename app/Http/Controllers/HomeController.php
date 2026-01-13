<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['home']);
    }

    public function home()
    {
        return view('welcome'); // atau dashboard kamu
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->kode_divisi == '14') { //-- Jika BOD--
            $approval = DB::table('pengajuan')->join('perusahaans', 'pengajuan.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
                ->join('depos', 'pengajuan.kode_depo', '=', 'depos.kode_depo')
                ->join('ms_pengeluaran', 'pengajuan.jenis', '=', 'ms_pengeluaran.id')
                ->WhereIn('pengajuan.status_pengajuan', [0, 3])
                ->Where('pengajuan.status_it', 1)
                ->Where('pengajuan.status_ga', 1)
                ->Where('pengajuan.status_ops', 1)
                ->Where('pengajuan.status_pc', 1)
                ->orderBy('pengajuan.tgl_pengajuan', 'DESC')
                ->get();

            $approval_biaya = DB::table('pengajuan_biaya')
                ->join('perusahaans', 'pengajuan_biaya.kode_perusahaan', '=', 'perusahaans.kode_perusahaan')
                ->join('depos', 'pengajuan_biaya.kode_depo', '=', 'depos.kode_depo')
                ->join('ms_pengeluaran', 'pengajuan_biaya.kategori', '=', 'ms_pengeluaran.id')
                ->Where('pengajuan_biaya.status_atasan', 1)
                ->Where('pengajuan_biaya.status_ka_akunting', 1)
                ->Where('pengajuan_biaya.status_fin', 1)
                ->WhereIn('pengajuan_biaya.status_bod', [0, 3])
                ->orderBy('pengajuan_biaya.tgl_pengajuan_b', 'DESC')
                ->get();

            $app_vendor = DB::table('pengajuan_vendor')
                ->join('users as a', 'pengajuan_vendor.id_user_input', '=', 'a.id')
                ->leftJoin('users as b', 'pengajuan_vendor.id_user_app', '=', 'b.id')
                ->select('pengajuan_vendor.kode_pengajuan_v', 'pengajuan_vendor.tgl_pengajuan_v', 'pengajuan_vendor.nama_vendor', 'pengajuan_vendor.alamat', 'pengajuan_vendor.telepon', 'pengajuan_vendor.kategori_vendor', 'pengajuan_vendor.id_user_input', 'a.name as nama', 'pengajuan_vendor.status', 'pengajuan_vendor.id_user_app', 'b.name as nama_app')
                ->WhereIn('pengajuan_vendor.status', [0, 2])
                ->orderBy('pengajuan_vendor.tgl_pengajuan_v', 'DESC')
                ->get();

            $receipt = DB::table('tanda_terima_cek')->join('users', 'tanda_terima_cek.id_user_input', '=', 'users.id')
                ->WhereIn('tanda_terima_cek.status', [1, 3])
                ->orderBy('tanda_terima_cek.date_receipt', 'DESC')
                ->get();

            return view('home', compact('approval', 'approval_biaya', 'app_vendor', 'receipt'));
        } else {
            return view('home');
        }
    }
}
