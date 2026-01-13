<?php

namespace App\Http\Controllers\Sparepart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sparepart_Categories_Vendor;

class VendorCatController extends Controller
{
    public function index()
    {
    	$kategori = Sparepart_Categories_Vendor::orderBy('kode_kategori_vendor', 'ASC')->get();
    	return view('sparepart.vendor_category.index', compact('kategori'));
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'id_kat' => 'required|string|max:5',
    		'nama_kat' => 'required|string|'
    	]);

    	Sparepart_Categories_Vendor::create([
    		'kode_kategori_vendor' => $request->get('id_kat'),
    		'nama_kategori_vendor' => $request->get('nama_kat')
    	]);
    	return redirect(route('vendor_category.index'))->with(['success' => 'new data added successfully']);
    }

    public function destroy($kode_kategori_vendor)
    {
    	Sparepart_Categories_Vendor::find($kode_kategori_vendor)->delete();
    	return redirect(route('vendor_category.index'))->with(['success' => 'Selected data deleted successfully!']);
    }
}
