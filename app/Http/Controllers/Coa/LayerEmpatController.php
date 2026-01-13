<?php

namespace App\Http\Controllers\Coa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportLayer4;
use App\Coa_1;
use App\Coa_2;
use App\Coa_3;
use App\Coa_4;
use App\User;
use Auth;
use Excel;


class LayerEmpatController extends Controller
{
    public function index()
    {
    	$coa_4 = Coa_4::orderBy('kode_lv4', 'ASC')->paginate(6);
        $coa_3 = Coa_3::orderBy('kode_lv3', 'ASC')->get();
        $coa_1 = Coa_1::orderBy('kode_lv1', 'ASC')->get();
        $coa_2 = Coa_2::orderBy('kode_lv2', 'ASC')->get();
    	return view('coa.create_layer4',compact('coa_4','coa_1','coa_2','coa_3'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_satu' => 'required|string|max:255',
            'kode_dua' => 'required|string|max:255',
            'kode_tiga' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'acc' => 'required|string|'
        ]);

        Coa_4::create([
            'kode_lv4' => $request->get('kode'),
            'kode_lv3' => $request->get('kode_tiga'),
            'kode_lv2' => $request->get('kode_dua'),
            'account_name' => $request->get('acc'),
            'kode_lv1' => $request->get('kode_satu'),
            'id_user' => Auth::user()->id
        ]);
        return redirect()->back()->with(['success' => 'Data baru ditambahkan']);
    }

    public function destroy($kode_lv4)
    {
        Coa_4::find($kode_lv4)->delete();
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
    		Excel::Import(new ImportLayer4, $file);
    		return redirect()->back()->with(['success' => 'Import success']);
    	}
    	return redirect()->back()->with(['error' => 'Please choose file before']);
    }


}
