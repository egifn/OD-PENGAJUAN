<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\VendorAccountImport;
use App\Rekening_Fin;
use Excel;

class ImportRekeningFinController extends Controller
{
    public function index()
    {
  
    	return view('finance.rekening_fin_import.index');
    }

    public function storeDataRekening(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if($request->hasFile('file'))
        {
        	$file = $request->file('file');
            Excel::import(new VendorAccountImport, $file);
            return redirect()->back()->with(['success' => 'Import success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
