<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Depo;
use App\Perusahaan;
use Illuminate\Support\Str;
use DB;

class DepoController extends Controller
{
    public function index()
    {
    	//Menampilkan data depo di index depo
        $depo = DB::table('depos')->join('perusahaans','depos.kode_perusahaan','=','perusahaans.kode_perusahaan')->paginate(5);
        
        //Menampilkan combobox di index depo
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'DESC')->get();
        return view('depo.index', compact('depo','perusahaan'));
    }

    public function cari(Request $request)
    {
        $q =  $request->q;
        $depo =  DB::table('depos')->join('perusahaans','depos.kode_perusahaan','=','perusahaans.kode_perusahaan')->where('depos.nama_depo','like',"%".$q."%")
            ->orWhere('perusahaans.nama_perusahaan','like',"%".$q."%")
            ->paginate(5);
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'DESC')->get();

        return view('depo.index', compact('depo','perusahaan'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode_depo' => 'required|string|max:255',
    		'nama_depo' => 'required|string',
    		'alias' => 'string',
    		'kode_perusahaan' => 'required|exists:perusahaans,kode_perusahaan'
    	]);

    	Depo::create([
    		'kode_depo' => $request->get('kode_depo'),
    		'nama_depo' => $request->get('nama_depo'),
    		'alias' => $request->get('alias'),
    		'kode_perusahaan' => $request->get('kode_perusahaan')
    	]);
    	return redirect(route('depo.index'))->with(['success' => 'Depo baru ditambahkan']);
    }

    public function destroy($kode_depo)
    {
    	Depo::find($kode_depo)->delete();
    	return redirect(route('depo.index'))->with(['success' => 'Data Depo yang dipilih berhasil Dihapus!']);
    }
}
