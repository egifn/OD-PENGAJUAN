<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
    	$category = Category::with(['parent'])->orderBy('created_at', 'ASC')->paginate(10);
    	$parent = Category::getParent()->orderBy('name', 'ASC')->get();
    	return view('categories.index', compact('category', 'parent'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
        	'name' => 'required|string|max:50|unique:categories'
    	]);

    	$request->request->add(['slug' => $request->name]);

    	Category::create($request->except('_token'));

    	return redirect(route('category.index'))->with(['success' => 'Kategori Baru Ditambahkan!']);
    }
	
	public function view($id)
	{
		$product = DB::table('products')->select('products.kode','products.nama_barang','products.category_id','categories.name as kategori','products.merk','products.satuan','products.ket','products.stock','products.price','products.created_at','users.name as nama_user','products.updated_at')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('users', 'products.kode_user_input','=','users.id')
					->where('products.category_id', $id)
					->where('products.status_barang', 1)
                    ->paginate(15);

        if (request()->q != '') {
            $product = DB::table('products')->select('products.kode','products.nama_barang','products.category_id','categories.name as kategori','products.merk','products.satuan','products.ket','products.stock','products.price','products.created_at','users.name as nama_user','products.updated_at')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('users', 'products.kode_user_input','=','users.id')
					->where('products.category_id', $id)
					->where('products.status_barang', 1)
                    ->where('products.nama_barang', 'like', '%' . request()->q . '%')
                    ->paginate(15);
        }
		return view('categories.view', compact('product'));
	}

    public function edit($id)
    {
    	$category = Category::find($id); 
    	$parent = Category::getParent()->orderBy('name', 'ASC')->get(); 
  
    	return view('categories.edit', compact('category', 'parent'));
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
        	'name' => 'required|string|max:50|unique:categories,name,' . $id
    	]);

    	$category = Category::find($id);

    	$category->update([
        	'name' => $request->name,
        	'parent_id' => $request->parent_id
    	]);

    	return redirect(route('category.index'))->with(['success' => 'Kategori Diperbaharui!']);
    }

    public function destroy($id)
    {
    	$category = Category::withCount(['child'])->find($id);
    	if ($category->child_count == 0) {
    		$category->delete();
    		return redirect(route('category.index'))->with(['success' => 'Kategori Dihapus!']);
    	}
    	return redirect(route('category.index'))->with(['error' => 'Kategori Ini Memiliki Anak Kategori!']);
    }
	
	public function hapus($kode)
    {
		$get_categoris = DB::table('products')
						->select('category_id')
						->where('kode', $kode)
						->first();

        $update_product = Product::find($kode);
        $update_product->update([
            'status_barang' => 0,
            'kode_user_update' => Auth::user()->id
        ]);
        
        return redirect(route('category.view', $get_categoris->category_id))->with(['success' => 'Produk yang dipilih berhasil Dihapus!']);
    }
}
