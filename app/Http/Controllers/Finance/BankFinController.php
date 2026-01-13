<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bank;

class BankFinController extends Controller
{
    public function index()
    {
    	$bank = Bank::orderBy('kode_bank', 'ASC')->get();
    	return view('finance.bank_fin.index', compact('bank'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'nama_bank' => 'required|string|max:255'
    	]);

    	Bank::create([
    		'nama_bank' => $request->get('nama_bank')
    	]);
    	return redirect(route('bank_fin.index'))->with(['success' => 'Bank baru ditambahkan']);
    }

    public function destroy($kode_bank)
    {
    	Bank::find($kode_bank)->delete();
    	return redirect(route('bank_fin.index'))->with(['success' => 'Data Bank yang dipilih berhasil Dihapus!']);
    	
    }
}
