<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\VendorImport;
use App\Vendor;
use Excel;

class ImportVendorController extends Controller
{
	public function index()
    {
  
    	return view('finance.vendor_import.index');
    }

    public function storeDataVendor(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if($request->hasFile('file'))
        {
        	$file = $request->file('file');
            Excel::import(new VendorImport, $file);
            return redirect()->back()->with(['success' => 'Import success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    
}
