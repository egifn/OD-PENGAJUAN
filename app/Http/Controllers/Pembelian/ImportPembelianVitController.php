<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportCo;
use App\Imports\ImportBotolKosong;
use Excel;

class ImportPembelianVitController extends Controller
{
    public function index()
    {
    	return view('Pembelian.vit.import');
    }


    public function storeData(Request $request)
    {
        set_time_limit(0); 
        
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if($request->hasFile('file'))
        {
        	if($request->jenis == 'CO')
        	{
                $startRow = $request->input('start_row', 2); // Dapatkan nilai startRow dari request
                $file = $request->file('file');
                $import = new ImportCo($startRow); // Inisialisasi dengan 2 argumen

                $importResult = Excel::import($import, $file);
                
                if ($importResult) {
                    return redirect()->back()->with('success', 'File Excel berhasil diimpor.');
                } else {
                    return redirect()->back()->with('error', 'Gagal mengimpor file Excel.');
                }
        	}else{
                $startRow = $request->input('start_row', 2); // Dapatkan nilai startRow dari request
                $file = $request->file('file');
                $import = new ImportBotolKosong($startRow); // Inisialisasi dengan 2 argumen

                $importResult = Excel::import($import, $file);
                
                if ($importResult) {
                    return redirect()->back()->with('success', 'File Excel berhasil diimpor.');
                } else {
                    return redirect()->back()->with('error', 'Gagal mengimpor file Excel.');
                }
        	}
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }


}
