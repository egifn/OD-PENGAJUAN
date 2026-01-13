<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Depo_Korsis;
use App\Perusahaan_Korsis;
use Illuminate\Support\Str;
use DB;

class DepoKorsisController extends Controller
{
    public function index()
    {
    	//Menampilkan data depo di index depo
        $depo = DB::table('depos_korsis')->join('perusahaans_korsis','depos_korsis.kode_perusahaan','=','perusahaans_korsis.kode_perusahaan')->paginate(5);
        
        //Menampilkan combobox di index depo
        $perusahaan = Perusahaan_Korsis::orderBy('nama_perusahaan', 'DESC')->get();
        return view('depo_korsis.index', compact('depo','perusahaan'));
    }

    public function cari(Request $request)
    {
        $q =  $request->q;
        $depo =  DB::table('depos_korsis')->join('perusahaans_korsis','depos_korsis.kode_perusahaan','=','perusahaans_korsis.kode_perusahaan')->where('depos.nama_depo','like',"%".$q."%")
            ->orWhere('perusahaans_korsis.nama_perusahaan','like',"%".$q."%")
            ->paginate(5);
        $perusahaan = Perusahaan_Korsis::orderBy('nama_perusahaan', 'DESC')->get();

        return view('depo_korsis.index', compact('depo','perusahaan'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode_depo' => 'required|string|max:255',
    		'nama_depo' => 'required|string',
    		'alias' => 'string',
    		'kode_perusahaan' => 'required|exists:perusahaans,kode_perusahaan'
    	]);

    	Depo_Korsis::create([
    		'kode_depo' => $request->get('kode_depo'),
    		'nama_depo' => $request->get('nama_depo'),
    		'alias' => $request->get('alias'),
    		'kode_perusahaan' => $request->get('kode_perusahaan')
    	]);
    	return redirect(route('depo_korsis.index'))->with(['success' => 'Depo baru ditambahkan']);
    }

    public function destroy($kode_depo)
    {
    	Depo_Korsis::find($kode_depo)->delete();
    	return redirect(route('depo_korsis.index'))->with(['success' => 'Data Depo yang dipilih berhasil Dihapus!']);
    }
}
