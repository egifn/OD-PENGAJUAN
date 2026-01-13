<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Daftar_Selisih;
use Auth;
use DB;

class SelisihController extends Controller
{
    public function index()
    {	
    	$daftar_selisih = DB::table('daftar_selisih')
    	->orderBy('daftar_selisih.kode_selisih', 'asc')
    	->get();

    	return view('rekon.selisih.index', compact('daftar_selisih'));
    }

    public function create(Request $request)
    {
    	return view('rekon.selisih.create');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode_selisih' => 'required|string|max:5',
    		'nama_selisih' => 'required|string|max:150'
    	]);

    	Daftar_Selisih::create([
    		'kode_selisih' => $request->get('kode_selisih'),
    		'nama_selisih' => $request->get('nama_selisih'),
    		'keterangan' => $request->get('keterangan'),
    		'id_user_input' => Auth::user()->id
    	]);

    	return redirect(route('master_selisih.index'))->with(['success' => 'Data Selisih berhasil ditambahkan']);
    }

    public function destroy($id)
    {
    	
    	Daftar_Selisih::find($id)->delete();
    	//return redirect(route('vaccount.index'))->with(['success' => 'Virtual Account yang dipilih berhasil dihapus']);
    	return redirect()->back()->with(['success' => 'Selisih yang dipilih berhasil dihapus']);
    }
}
