<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Virtualaccount;
use App\Perusahaan;
use App\Depo;
use App\Rekening;
use DB;

class VirtualaccountController extends Controller
{
    public function ajax_depo_va(Request $request)
    {
        $kodedepo = Depo::where('kode_perusahaan', $request->perusahaandms_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
    }

    public function ajax_rekening_bank(Request $request)
    {
        $norek = Rekening::where('kode_perusahaan', $request->perusahaanrek_id)->pluck('norek');
        return response()->json($norek);
    }

    public function ajax_rekening_bank_depo(Request $request)
    {
        $norek = Rekening::where('kode_depo', $request->deporek_id)->pluck('norek');
        return response()->json($norek);
    }

    public function index()
    {
    	$virtualaccount = DB::table('virtualaccounts')->join('perusahaans','virtualaccounts.kode_perusahaan','=','perusahaans.kode_perusahaan')
    												->join('depos','virtualaccounts.kode_depo','=','depos.kode_depo')
    												->join ('rekenings','virtualaccounts.norek','=','rekenings.norek')->get();

    	return view('rekon.vaccount.index', compact('virtualaccount'));
    }	

    public function create()
    {
    	$depo = Depo::orderBy('nama_depo', 'DESC')->get();
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'DESC')->get();
        $rekening = Rekening::orderBy('norek','DESC')->get();
    	return view('rekon.vaccount.create', compact('perusahaan','depo','rekening'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'va' => 'required|string|max:255',
    		'kode_perusahaan' => 'required|string|',
    		'kode_depo' => 'required|string|',
    		'jenis' => 'required|string|',
    		'norek' => 'required|string|'
    	]);

    	Virtualaccount::create([
    		'virtualaccount' => $request->get('va'),
    		'kode_perusahaan' => $request->get('kode_perusahaan'),
    		'kode_depo' => $request->get('kode_depo'),
    		'jenis' => $request->get('jenis'),
    		'norek' => $request->get('norek')
    	]);
    	return redirect(route('virtualaccount.index'))->with(['success' => 'Virtual Account berhasil ditambahkan']);
    	//return redirect()->back()->with(['success' => 'Virtual Account berhasil ditambahkan']);
    }

    public function destroy($virtualaccount)
    {
    	Virtualaccount::find($virtualaccount)->delete();
    	//return redirect(route('vaccount.index'))->with(['success' => 'Virtual Account yang dipilih berhasil dihapus']);
    	return redirect()->back()->with(['success' => 'Virtual Account yang dipilih berhasil dihapus']);
    }
}
