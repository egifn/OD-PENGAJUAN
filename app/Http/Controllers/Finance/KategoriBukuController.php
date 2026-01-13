<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KategoriBuku;
use Auth;
use DB;

class KategoriBukuController extends Controller
{
    public function index()
    {
    	$kategori = DB::table('categories_fin')->join('users','categories_fin.id_user_input','=','users.id')
    				->get();
    	return view ('finance.kategori_buku.index', compact('kategori'));
    }

    public function create()
    {
    	return view ('finance.kategori_buku.create');	
    }

    public function destroy($id_categories)
    {
    	KategoriBuku::find($id_categories)->delete();
    	return redirect(route('category_fin.index'))->with(['success' => 'Selected data deleted successfully!']);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string|max:255'
    	]);

    	KategoriBuku::create([
    		'categories_name' => $request->get('name'),
    		'id_user_input' => Auth::user()->id
    	]);
    	return redirect(route('category_fin.index'))->with(['success' => 'New Categories has been created']);
    }
}
