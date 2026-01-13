<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Area_Sub;
use Auth;
use DB;

class AreaSubController extends Controller
{
	public function index()
    {
    	$area_sub = DB::table('area_sub')->join('area','area_sub.kode_area','=','area.kode_area')
					->where('area.kode_depo', Auth::user()->kode_depo)
					->paginate(8);
        
    	$area = Area::where('kode_depo', Auth::user()->kode_depo)->orderBy('kode_area', 'ASC')->get();
    
    	return view('area_sub.index', compact('area_sub','area'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode_sub' => 'required|string|max:255',
    		'kode_area' => 'required|exists:area,kode_area',
    		'nama_sub' => 'required|string'
    	]);

    	Area_Sub::create([
    		'kode_sub_area' => $request->get('kode_sub'),
    		'kode_area' => $request->get('kode_area'),
    		'nama_sub_area' => $request->get('nama_sub'),
			'kode_depo' => Auth::user()->kode_depo
    	]);
    	return redirect(route('area_sub.index'))->with(['success' => 'New area added']);
    }

    public function destroy($kode_sub_area)
    {
    	Area_Sub::find($kode_sub_area)->delete();
    	return redirect(route('area_sub.index'))->with(['success' => 'Deleted successfully!']);
    }
    
}
