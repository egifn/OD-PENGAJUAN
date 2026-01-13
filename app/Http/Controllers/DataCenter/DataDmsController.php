<?php

namespace App\Http\Controllers\DataCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DataDmsImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Excel;
use Carbon\carbon;
use App\Data_Center_Upload;

class DataDmsController extends Controller
{
    public function index()
    {
        // $data = DB::table('import_dtc_ssd')
        //             ->select('import_dtc_ssd.id','import_dtc_ssd.area','import_dtc_ssd.kode_depo','import_dtc_ssd.nama_depo','import_dtc_ssd.kode_customer',
        //                 'import_dtc_ssd.kode_customer_2','import_dtc_ssd.do_date','import_dtc_ssd.week','import_dtc_ssd.day','import_dtc_ssd.month','import_dtc_ssd.year',
        //                 'import_dtc_ssd.kode_produk','import_dtc_ssd.nama_produk','import_dtc_ssd.produk','import_dtc_ssd.convert_nama_produk','import_dtc_ssd.merk_produk',
        //                 'import_dtc_ssd.tgl_join','import_dtc_ssd.id_promo','import_dtc_ssd.do_id','import_dtc_ssd.qty','import_dtc_ssd.c_qty','import_dtc_ssd.qty_2',
        //                 'import_dtc_ssd.dikon_distributor','import_dtc_ssd.jumlah','import_dtc_ssd.nama_customer','import_dtc_ssd.alamat','import_dtc_ssd.segmen',
        //                 'import_dtc_ssd.sub_segmen','import_dtc_ssd.con_segmen','import_dtc_ssd.convert_segmen','import_dtc_ssd.c_seg','import_dtc_ssd.kode_driver',
        //                 'import_dtc_ssd.nama_driver','import_dtc_ssd.kode_helper_1','import_dtc_ssd.nama_helper_1','import_dtc_ssd.kode_helper_2','import_dtc_ssd.nama_helper_2',
        //                 'import_dtc_ssd.kode_sales','import_dtc_ssd.nama_sales','import_dtc_ssd.no_kendaraan','import_dtc_ssd.kota','import_dtc_ssd.tipe_penjualan',
        //                 'import_dtc_ssd.status_dok','import_dtc_ssd.satuan','import_dtc_ssd.kecamatan','import_dtc_ssd.id_user_import')
        //             ->paginate(25);

        $data = DB::table('data_center_upload')
                    ->select('data_center_upload.id','data_center_upload.tgl_upload','data_center_upload.filename_upload','data_center_upload.keterangan','data_center_upload.id_user_input')
                    ->get();

        return view ('data_center.index', compact('data'));
    }

    public function cari()
    {
        if(request()->tanggal != ''){
            $date = explode(' - ' ,request()->tanggal);
            $date_start = Carbon::parse($date[0])->format('Y-m-d');
            $date_end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $data = DB::table('data_center_upload')
                    ->select('data_center_upload.id','data_center_upload.tgl_upload','data_center_upload.filename_upload','data_center_upload.keterangan','data_center_upload.id_user_input')
                    ->WhereBetween('data_center_upload.tgl_upload', [$date_start,$date_end])
                    ->get();

        return view ('data_center.index', compact('data'));
    }

    public function create()
    {
        return view('data_center.create_import');        
    }

    public function storeDataDms(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:xls,xlsx'
        // ]);

        // if($request->hasFile('file'))
        // {
        //     $file = $request->file('file');
        //     Excel::import(new DataDmsImport, $file);
        //     return redirect()->back()->with(['success' => 'Import success']);
        // }
        // return redirect()->back()->with(['error' => 'Please choose file before']);

        if($request->hasfile('upload_file')) { 
            foreach ($request->file('upload_file') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);
                       
                    Data_Center_Upload::create([
                        'tgl_upload' => Carbon::now()->format('Y-m-d'),
                        'filename_upload' => $filename,
                        'keterangan' => $request->get('keterangan'),
                        'id_user_input' => Auth::user()->id
                        
                    ]);
                }
            }
            echo 'Success';
        }else{
            echo 'Gagal';
        }

        alert()->success('Success.','Surat Program Sukses dikirim');
        return redirect()->route('data_center_dms.index');
    }
}
