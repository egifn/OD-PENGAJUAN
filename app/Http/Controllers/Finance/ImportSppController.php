<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\SppHeadImport;
use App\Imports\SppDetailImport;
use App\Rcm_Spp_Temp;
use App\Rcm_Spp_Detail_Temp;
use Excel;

class ImportSppController extends Controller
{
    public function index()
    {
  
    	return view('finance.spp_import.index');
    }

    public function storeDataHead(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            Excel::import(new SppHeadImport, $file);
            return redirect()->back()->with(['success' => 'Import success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

    public function storeDataDetail(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

    	if($request->hasFile('file'))
        {
            $file = $request->file('file');
            Excel::import(new SppDetailImport, $file);
            return redirect()->back()->with(['success' => 'Import success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
