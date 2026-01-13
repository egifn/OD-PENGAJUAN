<?php

namespace App\Http\Controllers\Coa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportLayer1;
use App\Coa_1;
use App\User;
use Auth;
use Excel;


class LayerSatuController extends Controller
{
    public function index()
    {
    	$coa_1 = Coa_1::orderBy('kode_lv1', 'ASC')->paginate(6);
    	return view('coa.create_layer1',compact('coa_1'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode' => 'required|string|max:255',
            'acc' => 'required|string|'
        ]);

        Coa_1::create([
            'kode_lv1' => $request->get('kode'),
            'account_name' => $request->get('acc'),
            'id_user' => Auth::user()->id
        ]);
        return redirect()->back()->with(['success' => 'Data baru ditambahkan']);
    }

    public function destroy($kode_lv1)
    {
        Coa_1::find($kode_lv1)->delete();
        return redirect()->back()->with(['success' => 'Data yang dipilih berhasil Dihapus!']);
    }

    //IMPORT DATA
    public function storeData(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

    	if($request->hasFile('file')) 
    	{
    		$file = $request->file('file');
    		Excel::Import(new ImportLayer1, $file);
    		return redirect()->back()->with(['success' => 'Import success']);
    	}
    	return redirect()->back()->with(['error' => 'Please choose file before']);
    }


}
