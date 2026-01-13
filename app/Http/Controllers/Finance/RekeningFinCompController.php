<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rekening_Fin_Comp;
use App\Bank;
use App\Depo;
use App\Perusahaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekeningFinCompController extends Controller
{
    public function index()
    {
    	$rekening_fin_comp = DB::table('rekening_fin_comp')->join('banks','rekening_fin_comp.kode_bank','=','banks.kode_bank')
                                        ->join('perusahaans','rekening_fin_comp.kode_perusahaan','=','perusahaans.kode_perusahaan')
                                        ->leftJoin('depos','rekening_fin_comp.kode_depo','=','depos.kode_depo')
                                        ->join('users', 'rekening_fin_comp.kode_user','=','users.id')
                                        ->get();

    	return view ('finance.rekening_fin_comp.index',compact('rekening_fin_comp'));
    }

    public function create()
    {
    	$bank = Bank::orderBy('kode_bank', 'ASC')->get();
    	$depo = Depo::orderBy('nama_depo', 'DESC')->get();
        $perusahaan = Perusahaan::orderBy('nama_perusahaan', 'DESC')->get();
    	return view('finance.rekening_fin_comp.create',compact('bank','depo','perusahaan'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'norek' => 'required|string|max:255',
            'kode_bank' => 'required|',
            'kode_perusahaan' => 'required|string|',
            'kode_depo' => 'string'
    	]);

    	Rekening_Fin_Comp::create([
            'norek' => $request->get('norek'),
            'kode_bank' => $request->get('kode_bank'),
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'keterangan' => $request->get('keterangan'),
            'kode_depo' => $request->get('kode_depo'),
            'kode_user' => Auth::user()->id
    	]);
    	return redirect(route('rekening_fin_comp.index'))->with(['success' => 'New account added successfully']);
    }

    public function destroy($norek)
    {
    	Rekening_Fin_Comp::find($norek)->delete();
        return redirect(route('rekening_fin_comp.index'))->with(['success' => 'The selected account has been successfully deleted']);
    }
}
