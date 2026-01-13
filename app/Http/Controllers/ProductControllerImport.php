<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductImport;
use App\Product;
use Excel;

class ProductControllerImport extends Controller
{
    public function index()
    {
    	return view('product.import');
    }

    public function storeDataProduct(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if($request->hasFile('file'))
        {
        	$file = $request->file('file');
            Excel::import(new ProductImport, $file);
            return redirect()->back()->with(['success' => 'Import success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
