<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\User;
use Session;
use Auth;
use File;
use DB;

class ProductController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $product = DB::table('products')->select('products.kode','products.nama_barang','products.category_id','categories.name as kategori','products.merk','products.satuan','products.ket','products.stock','products.price','products.created_at','users.name as nama_user','products.updated_at')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('users', 'products.kode_user_input','=','users.id')
					->where('products.status_barang', 1)
                    ->paginate(20);

        if (request()->q != '') {
            $product = DB::table('products')->select('products.kode','products.nama_barang','products.category_id','categories.name as kategori','products.merk','products.satuan','products.ket','products.stock','products.price','products.created_at','users.name as nama_user','products.updated_at')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('users', 'products.kode_user_input','=','users.id')
					->where('products.status_barang', 1)
                    ->where('products.nama_barang', 'like', '%' . request()->q . '%')
                    ->paginate(20);
        }
    	return view ('product.index', compact('product'));

        //return view ('product.index');
    }

    public function create()
    {
    	$category = Category::orderBy('name','ASC')->get();
    	return view('product.create', compact('category'));
    }

    public function view($kode)
    {

        $category = Category::orderBy('name','ASC')->get();

        $product = DB::table('products')->select('products.kode','products.nama_barang','products.category_id','categories.name as kategori','products.merk','products.satuan','products.ket','products.stock','products.price','products.created_at','users.name as nama_user','products.updated_at')
                    ->join('categories','products.category_id','=','categories.id')
                    ->join('users', 'products.kode_user_input','=','users.id')
					->Where('products.kode', $kode)
                    ->first();

        return view('product.update', compact('product','category'));

    }

    public function store(Request $request)
    {
    	
        if(request()->category_id == '1'){
            $kode_category = request()->category_id;

            $getRow = Product::where('category_id', $kode_category)
                    ->orderBy('kode', 'DESC')->get();
            $rowCount = $getRow->count();
        
            $lastId = $getRow->first();

            $kode = "AT00001";

            if ($rowCount > 0) {
                if ($rowCount < 9) {
                    $kode = "AT0000".''.($rowCount + 6);
                } else if ($rowCount < 99) {
                    $kode = "AT000".''.($rowCount + 6);
                } else if ($rowCount < 999) {
                    $kode = "AT00".''.($rowCount + 6);
                } else if ($rowCount < 9999) {
                    $kode = "AT0".''.($rowCount + 6);
                } else {
                    $kode = "AT".''.($rowCount + 6);
                }
            }
        }elseif(request()->category_id == '2'){
            $kode_category = request()->category_id;

            $getRow = Product::where('category_id', $kode_category)
                    ->orderBy('kode', 'DESC')->get();
            $rowCount = $getRow->count();
        
            $lastId = $getRow->first();

            $kode = "IT00001";

            if ($rowCount > 0) {
                if ($rowCount < 9) {
                    $kode = "IT0000".''.($rowCount + 1);
                } else if ($rowCount < 99) {
                    $kode = "IT000".''.($rowCount + 1);
                } else if ($rowCount < 999) {
                    $kode = "IT00".''.($rowCount + 1);
                } else if ($rowCount < 9999) {
                    $kode = "IT0".''.($rowCount + 1);
                } else {
                    $kode = "IT".''.($rowCount + 1);
                }
            }
        }elseif(request()->category_id == '3'){
            $kode_category = request()->category_id;

            $getRow = Product::where('category_id', $kode_category)
                    ->orderBy('kode', 'DESC')->get();
            $rowCount = $getRow->count();
        
            $lastId = $getRow->first();

            $kode = "OP00001";

            if ($rowCount > 0) {
                if ($rowCount < 9) {
                    $kode = "OP0000".''.($rowCount + 1);
                } else if ($rowCount < 99) {
                    $kode = "OP000".''.($rowCount + 1);
                } else if ($rowCount < 999) {
                    $kode = "OP00".''.($rowCount + 1);
                } else if ($rowCount < 9999) {
                    $kode = "OP0".''.($rowCount + 1);
                } else {
                    $kode = "OP".''.($rowCount + 1);
                }
            }
        }elseif(request()->category_id == '4'){
            $kode_category = request()->category_id;

            $getRow = Product::where('category_id', $kode_category)
                    ->orderBy('kode', 'DESC')->get();
            $rowCount = $getRow->count();
        
            $lastId = $getRow->first();

            $kode = "SP00001";

            if ($rowCount > 0) {
                if ($rowCount < 9) {
                    $kode = "UM0000".''.($rowCount + 1);
                } else if ($rowCount < 99) {
                    $kode = "UM000".''.($rowCount + 1);
                } else if ($rowCount < 999) {
                    $kode = "UM00".''.($rowCount + 1);
                } else if ($rowCount < 9999) {
                    $kode = "UM0".''.($rowCount + 1);
                } else {
                    $kode = "UM".''.($rowCount + 1);
                }
            }
        }


    	$this->validate($request, [
    		'name' => 'required|string|max:255',
    		'description' => 'required',
    		'merk' => 'required|string|',
    		'price' => 'required|string|',
    		'stock' => 'required|string|',
    		'category_id' => 'required|exists:categories,id'
    	]);

    	try {
    		
    		$product = Product::create([
    			'kode' => $kode,
    			'nama_barang' => $request->name,
    			'category_id' => $request->category_id,
    			'merk' => $request->merk,
                'satuan' => $request->satuan,
    			'ket' => $request->description,
    			'price' => $request->price,
    			'stock' => $request->stock,
                'kode_user_input' => Auth::user()->id
    		]);

    		return redirect(route('product.index'))->with(['success' => 'Produk baru ditambahkan']);

    	} catch (Exception $e) {
    		return redirect()->back()->with(['error' => $e->getMessage()]);
    	}
    }

    public function update(Request $request)
    {
        $update_product = Product::find($request->get('kode'));
        $update_product->update([
            'nama_barang' => $request->get("name"),
            'category_id' => $request->get("category_id"),
            'merk' => $request->get("merk"),
            'satuan' => $request->get("satuan"),
            'ket' => $request->get("description"),
            'price' => $request->get("price"),
            'stock' => $request->get("stock"),
            'kode_user_update' => Auth::user()->id

        ]);

        return redirect(route('product.index'))->with(['success' => 'Data produk berhasil diubah']);
    }

    public function destroy($kode)
    {
        //Product::find($kode)->delete();
		
		$update_product = Product::find($kode);
        $update_product->update([
            'status_barang' => 0,
            'kode_user_update' => Auth::user()->id
        ]);
		
        return redirect(route('product.index'))->with(['success' => 'Produk yang dipilih berhasil Dihapus!']);
    }
}
