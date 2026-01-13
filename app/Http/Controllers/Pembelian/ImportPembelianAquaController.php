<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportOtm;
use App\Import_Otm_H;
use Carbon\Carbon;
use Auth;
use Excel;
use DB;

class ImportPembelianAquaController extends Controller
{
    public function index()
    {
        $date = (date('Ym'));
        $date_1 = (date('Ymd'));

        $getRow = DB::table('import_otm_h')->select(DB::raw('MAX(RIGHT(kode_otm_h,6)) as NoUrut'))
                                        ->where('kode_otm_h', 'like', "%".$date."%");
        $rowCount = $getRow->count();

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode = $date_1."00000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $kode = $date_1."0000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $kode = $date_1."000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $kode = $date_1."00".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $kode = $date_1."0".''.($rowCount + 1);
            } else {
                    $kode = $date_1.($rowCount + 1);
            }
        }else{
            $kode = $date_1.sprintf("%06s", 1);
        } 

    	return view('pembelian.aqua.import', compact('kode'));
    }

    public function storeData(Request $request)
    {
        set_time_limit(0);
        
        Import_Otm_H::create([
            'kode_otm_h' => $request->get('kode'),
            'tgl_otm_h' => Carbon::now()->format('Y-m-d'),
            'id_user_input' => Auth::user()->id
        ]);

    	$this->validate($request, [
    		'file' => 'required|mimes:xls,xlsx'
    	]);

        if($request->hasFile('file'))
        {
            $startRow = $request->input('start_row', 2); // Dapatkan nilai startRow dari request
            $file = $request->file('file');
            $import = new ImportOtm($startRow); // Inisialisasi dengan 2 argumen

            $importResult = Excel::import($import, $file);

            if ($importResult) {
                return redirect()->back()->with('success', 'File Excel berhasil diimpor.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengimpor file Excel.');
            }
        }
    }
}
