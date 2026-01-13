<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan_Korsis;

class PerusahaanKorsisController extends Controller
{
    public function index()
    {
    	$perusahaan = Perusahaan_Korsis::orderBy('kode_perusahaan', 'DESC')->get();
    	return view('perusahaan_korsis.index', compact('perusahaan'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode_perusahaan' => 'required|string|max:255',
    		'nama_perusahaan' => 'required|string|'
    	]);

    	Perusahaan_Korsis::create([
    		'kode_perusahaan' => $request->get('kode_perusahaan'),
    		'nama_perusahaan' => $request->get('nama_perusahaan')
    	]);
    	return redirect(route('perusahaan_korsis.index'))->with(['success' => 'Perusahaan baru ditambahkan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_perusahaan)
    {
    	Perusahaan_Korsis::find($kode_perusahaan)->delete();
    	return redirect(route('perusahaan_korsis.index'))->with(['success' => 'Data Perusahaan yang dipilih berhasil Dihapus!']);
    	
    }
}
