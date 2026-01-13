<?php

namespace App\Http\Controllers\Snd\Surat_eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratIsiController extends Controller
{
    public function index()
    {
        $date_start = (date('Y-m-d'));
        $date_end = (date('Y-m-d'));

        // $surat = DB::table('ms_surat_isi')
        //                 ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
        //                 ->join('perusahaans','ms_surat_isi.kode_perusahaan','=','perusahaans.kode_perusahaan')
        //                 ->join('users','ms_surat_isi.user_input','=','users.id')
        //                 ->select('ms_surat_isi_item.kode_surat','ms_surat_isi.tanggal','perusahaans.nama_perusahaan','ms_surat_isi.prihal','ms_surat_isi.jenis',DB::raw('SUM(ms_surat_isi_item.amount) as total'),'users.name','ms_surat_isi.no_urut')
        //                 ->WhereBetween('ms_surat_isi.tanggal', [$date_start,$date_end])
        //                 ->groupBy('ms_surat_isi_item.kode_surat','ms_surat_isi.tanggal','perusahaans.nama_perusahaan','ms_surat_isi.prihal','ms_surat_isi.jenis','users.name','ms_surat_isi.no_urut')
        //                 ->get();

        // $sub_total = DB::table('ms_surat_isi')
        //                 ->join('ms_surat_isi_item','ms_surat_isi.kode_surat','=','ms_surat_isi_item.kode_surat')
        //                 ->join('perusahaans','ms_surat_isi.kode_perusahaan','=','perusahaans.kode_perusahaan')
        //                 ->join('users','ms_surat_isi.user_input','=','users.id')
        //                 ->select(DB::raw('SUM(ms_surat_isi_item.amount) as sub_total'))
        //                 ->WhereBetween('ms_surat_isi.tanggal', [$date_start,$date_end])
        //                 ->Where('ms_surat_isi.jenis', 'Rupiah')
        //                 ->first();

    	return view ('snd.surat_eksternal.isi_surat.index'); //, compact('surat','sub_total')
    }
}
