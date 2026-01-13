<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use Auth;
use DB;

class AreaController extends Controller
{
    public function index()
    {
    	$area = Area::where('area.kode_depo', Auth::user()->kode_depo)->orderBy('kode_area', 'ASC')->get();
    	return view('area.index', compact('area'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'nama_area' => 'required|string|'
    	]);

    	//Area::create([
    	//	'kode_area' => $request->get('kode_area'),
        //	'nama_area' => $request->get('nama_area'),
		//	'kode_depo' => Auth::user()->kode_depo
    	//]);
		
		$getRow = DB::table('area')->select(DB::raw('MAX(left(kode_area,1)) as urut'))
                                        ->where('kode_depo', Auth::user()->kode_depo)
                                        ->first();

        if($getRow->urut == '') {
            $kode = "A".''."-".''.Auth::user()->kode_depo;
        }elseif($getRow->urut == 'A') {
            $kode = "B".''."-".''.Auth::user()->kode_depo;
        }elseif($getRow->urut == 'B') {
            $kode = "C".''."-".''.Auth::user()->kode_depo;
        }elseif($getRow->urut == 'C') {
            $kode = "D".''."-".''.Auth::user()->kode_depo;
        }elseif($getRow->urut == 'D') {
            $kode = "E".''."-".''.Auth::user()->kode_depo;
        }elseif($getRow->urut == 'E') {
            $kode = "F".''."-".''.Auth::user()->kode_depo;
        }elseif($getRow->urut == 'F') {
            $kode = "G".''."-".''.Auth::user()->kode_depo;
        }elseif($getRow->urut == 'G') {
            $kode = "H".''."-".''.Auth::user()->kode_depo;
        }

    	Area::create([
    		'kode_area' => $kode,
    		'nama_area' => $request->get('nama_area'),
            'kode_depo' => Auth::user()->kode_depo 
    	]);
    	return redirect(route('area.index'))->with(['success' => 'New area added']);
    }

    public function destroy($kode_area)
    {
    	Area::find($kode_area)->delete();
    	return redirect(route('area.index'))->with(['success' => 'Deleted successfully!']);
    	
    }
}
