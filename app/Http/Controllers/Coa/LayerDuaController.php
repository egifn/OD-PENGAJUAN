<?php

namespace App\Http\Controllers\Coa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportLayer2;
use App\Coa_1;
use App\Coa_2;
use App\User;
use Auth;
use Excel;

class LayerDuaController extends Controller
{
    public function index()
    {
    	$coa_2 = Coa_2::orderBy('kode_lv2', 'ASC')->paginate(6);
        $coa_1 = Coa_1::orderBy('kode_lv1', 'ASC')->get();
    	return view('coa.create_layer2',compact('coa_2','coa_1'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_satu' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'acc' => 'required|string|'
        ]);

        Coa_2::create([
            'kode_lv2' => $request->get('kode'),
            'account_name' => $request->get('acc'),
            'kode_lv1' => $request->get('kode_satu'),
            'id_user' => Auth::user()->id
        ]);
        return redirect()->back()->with(['success' => 'Data baru ditambahkan']);
    }

    public function destroy($kode_lv2)
    {
        Coa_2::find($kode_lv2)->delete();
        return redirect()->back()->with(['success' => 'Data yang dipilih berhasil Dihapus!']);
    }

    public function storeData(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

    	if($request->hasFile('file')) 
    	{
    		$file = $request->file('file');
    		Excel::Import(new ImportLayer2, $file);
    		return redirect()->back()->with(['success' => 'Import success']);
    	}
    	return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
