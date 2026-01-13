<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bank;
use App\Imports\CatatanRekeningFinImport;
use App\Imports\CatatanRekeningFinImport_bca;
use App\Imports\CatatanRekeningFinImport_ocbc;
use App\Imports\CatatanRekeningFinImport_bri;
use App\Imports\CatatanRekeningFinImport_maybank;
use App\CatatanRekeningFin;
use Excel;

class CatatanRekeningFinController extends Controller
{
    public function index()
    {
    	$bank = Bank::orderBy('kode_bank', 'ASC')->get();
    	return view('finance.import_fin.index', compact('bank'));
    }

    public function storeData(Request $request)
    {   

        if(request()->kode_bank == '1'){
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new CatatanRekeningFinImport_ocbc, $file);
                return redirect()->back()->with(['success' => 'Import success']);
            }
            return redirect()->back()->with(['error' => 'Please choose file before']);
        }elseif(request()->kode_bank == '2'){
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new CatatanRekeningFinImport_bca, $file);
                return redirect()->back()->with(['success' => 'Import success']);
            }
            return redirect()->back()->with(['error' => 'Please choose file before']);
        }elseif(request()->kode_bank == '3'){
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new CatatanRekeningFinImport_bri,$file);
                return redirect()->back()->with(['success' => 'Import success']);
            }
            return redirect()->back()->with(['error' => 'Please choose file before']);
        }elseif(request()->kode_bank = '4'){
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new CatatanRekeningFinImport_maybank,$file);
                return redirect()->back()->with(['success' => 'Import success']);
            }
            return redirect()->back()->with(['error' => 'Please choose file before']);
        }elseif(request()->kode_bank = '5'){
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new CatatanRekeningFinImport_mega,$file);
                return redirect()->back()->with(['success' => 'Import success']);
            }
            return redirect()->back()->with(['error' => 'Please choose file before']);
        }else{
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                Excel::import(new CatatanRekeningFinImport, $file);
                return redirect()->back()->with(['success' => 'Import success']);
            }
            return redirect()->back()->with(['error' => 'Please choose file before']);
        }


    	
    }
}
