<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tipe_Cekgiro;
use Auth;


class TypeController extends Controller
{
    public function index()
    {
    	$tipe = Tipe_Cekgiro::orderBy('kode_tipe', 'ASC')
    			->get();

    	return view('finance.tipe.index',compact('tipe'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode' => 'required|string|max:5',
    		'type' => 'required|string|'
    	]);

    	Tipe_Cekgiro::create([
    		'kode_tipe' => $request->get('kode'),
    		'tipe' => $request->get('type'),
    		'id_user_input' => Auth::user()->id
    	]);
    	return redirect(route('type.index'))->with(['success' => 'New Type added successfully']);
    }
}
