<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;

class PerusahaanController extends Controller
{
    public function index()
    {
    	$perusahaan = Perusahaan::orderBy('kode_perusahaan', 'DESC')->get();
    	return view('perusahaan.index', compact('perusahaan'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode_perusahaan' => 'required|string|max:255',
    		'nama_perusahaan' => 'required|string|'
    	]);

    	Perusahaan::create([
    		'kode_perusahaan' => $request->get('kode_perusahaan'),
    		'nama_perusahaan' => $request->get('nama_perusahaan')
    	]);
    	return redirect(route('perusahaan.index'))->with(['success' => 'Perusahaan baru ditambahkan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_perusahaan)
    {
    	Perusahaan::find($kode_perusahaan)->delete();
    	return redirect(route('perusahaan.index'))->with(['success' => 'Data Perusahaan yang dipilih berhasil Dihapus!']);
    	
    }

}
