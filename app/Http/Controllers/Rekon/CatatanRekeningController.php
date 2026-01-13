<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\CatatanRekeningImport;
use App\CatatanRekening;
use Excel;


class CatatanRekeningController extends Controller
{
    public function index()
    {
    	return view('rekon.import.index');
    }

    public function storeData(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

    	if($request->hasFile('file')) 
    	{
    		$file = $request->file('file');
    		Excel::import(new CatatanRekeningImport, $file);
    		return redirect()->back()->with(['success' => 'Import success']);
    	}
    	return redirect()->back()->with(['error' => 'Please choose file before']);
    }

}
