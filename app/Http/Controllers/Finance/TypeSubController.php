<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tipe_Cekgiro_Sub;
use App\Tipe_Cekgiro;
use DB;
use Auth;

class TypeSubController extends Controller
{
    public function index()
    {
    	$tipe = Tipe_Cekgiro::orderBy('kode_tipe', 'ASC')
    			->get();
    	$tipe_sub = DB::table('tipe_cekgiro_sub')->join('tipe_cekgiro','tipe_cekgiro_sub.kode_tipe','=','tipe_cekgiro.kode_tipe')->orderBy('tipe_cekgiro_sub.kode_tipe', 'ASC')->get();

    	return view('finance.tipe_sub.index', compact('tipe_sub','tipe'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode' => 'required|string|max:5',
    		'type' => 'required|string',
    		'kode_tipe' => 'required|string|max:5'
    	]);

    	Tipe_Cekgiro_Sub::create([
    		'kode_sub' => $request->get('kode'),
    		'kode_tipe' => $request->get('kode_tipe'),
    		'sub_tipe' => $request->get('type'),
    		'id_user_input' => Auth::user()->id
    	]);
    	return redirect(route('sub_type.index'))->with(['success' => 'New Type added successfully']);
    }
}
