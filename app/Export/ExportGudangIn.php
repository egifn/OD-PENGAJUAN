<?php
namespace App\Export;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Perusahaan;
use DB;
use Carbon\carbon;

class ExportGudangIn implements FromCollection
{
    public function collection()
    {
        //return User::all();
        return DB::table('barang_dagang_in')
                    ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
                    ->join('users','barang_dagang_in.id_user_input','=','users.id')
                    ->select('barang_dagang_in.doc_id','barang_dagang_in.tanggal','barang_dagang_in.waktu','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in.kategori','barang_dagang_in.nama_driver','barang_dagang_in.no_mobil','barang_dagang_in.from','users.name')
                    ->WhereBetween('barang_dagang_in.tanggal', ['2021-10-13','2021-10-13'])
                    ->get();
    }
}

// class ExportGudangIn implements FromView
// {
//     public function view(): View
//     {
//         //return User::all();
//         $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();

//         $in = DB::table('barang_dagang_in')
//                     ->join('perusahaans','barang_dagang_in.kode_perusahaan','=','perusahaans.kode_perusahaan')
//                     ->join('depos','barang_dagang_in.kode_depo','=','depos.kode_depo')
//                     ->join('users','barang_dagang_in.id_user_input','=','users.id')
//                     ->select('barang_dagang_in.doc_id','barang_dagang_in.tanggal','barang_dagang_in.waktu','perusahaans.nama_perusahaan','depos.nama_depo','barang_dagang_in.kategori','barang_dagang_in.nama_driver','barang_dagang_in.no_mobil','barang_dagang_in.from','users.name','barang_dagang_in.status','barang_dagang_in.status_bs')
//                     ->WhereBetween('barang_dagang_in.tanggal', ['2021-10-13','2021-10-13'])
//                     ->get();

//         return view('masuk_barang_gudang.checker.index', compact('perusahaan','in'));
//     }
// }

