<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KategoriPengeluaran;
use App\KategoriBuku;
Use App\User;
use Auth;
use DB;

class SubKategoriBukuController extends Controller
{
    public function index()
    {
    	$pengeluaran = DB::table('categories_fin_sub')->join('categories_fin','categories_fin_sub.id_categories','=','categories_fin.id_categories')->join('users','categories_fin_sub.id_user_input','=','users.id')
    									->get();

    	return view ('finance.kategori_pengeluaran.index', compact('pengeluaran'));
    }

    public function create(Request $request)
    {	
    	$kategori = KategoriBuku::orderBy('id_categories', 'ASC')->get();
    	
    	return view ('finance.kategori_pengeluaran.create', compact('kategori'));	
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'kode_kategori' => 'required|int',
    		'name' => 'required|string|max:255'
    	]);

    	KategoriPengeluaran::create([
    		'id_categories' => $request->get('kode_kategori'),
    		'sub_categories_name' => $request->get('name'),
    		'id_user_input' => Auth::user()->id
    	]);
    	return redirect(route('sub_category_fin.index'))->with(['success' => 'New Categories has been created']);
    }

    public function destroy($id_sub_categories)
    {
    	KategoriPengeluaran::find($id_sub_categories)->delete();
    	return redirect(route('sub_category_fin.index'))->with(['success' => 'Selected data deleted successfully!']);
    }
}
