<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vendor;
use App\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index()
    {   
        //$vendor = Vendor::orderBy('kode_vendor', 'ASC')->paginate(8);
        $vendor = DB::table('vendors')->Join('users','vendors.id_user_input','=','users.id')
                                        ->get();

    	return view('finance.vendor_fin.index',compact('vendor'));
    }

    public function create(Request $request)
    {   
        $getRow = Vendor::orderBy('kode_vendor', 'ASC')->get();
        $rowCount = $getRow->count();

        $lastId = $getRow->first();

        $kode = "0000000001";

        if ($rowCount > 0) {
            if ($rowCount < 9) {
                    $kode = "000000000".''.($rowCount + 1);
            } else if ($rowCount < 99) {
                    $kode = "00000000".''.($rowCount + 1);
            } else if ($rowCount < 999) {
                    $kode = "0000000".''.($rowCount + 1);
            } else if ($rowCount < 9999) {
                    $kode = "000000".''.($rowCount + 1);
            } else if ($rowCount < 99999) {
                    $kode = "00000".''.($rowCount + 1);
            } else {
                    $kode = '0000'.($rowCount + 1);
            }
        } 

    	return view('finance.vendor_fin.create',compact('kode'));
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
            'kode' => 'required|string',
            'vendor_name' => 'required|string',
            'address' => 'required|string',
            'telphone' => 'required|string',
            'fax' => 'required|string',
            'email' => 'required|string',
            'cp' => 'required|string',
            'position' => 'required|string',
            'top' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'required',
            'status_1' => 'required|string',
            'status_2' => 'required|string',
            'memo' => 'required|string',
            'memo_date' => 'required',
            'approved' => 'required|string',
            'approved_date' => 'required',
            'ket' => 'required|string'
        ]);

        Vendor::create([
            'kode_vendor' => $request->get('kode'),
            'nama_vendor' => $request->get('vendor_name'),
            'alamat' => $request->get('address'),
            'telp' => $request->get('telphone'),
            'fax' => $request->get('fax'),
            'email' => $request->get('email'),
            'contact_person' => $request->get('cp'),
            'jabatan' => $request->get('position'),
            'top' => $request->get('top'),
            'tgl_mulai' => $request->get('start_date'),
            'tgl_selesai' => $request->get('end_date'),
            'status_1' => $request->get('status_1'),
            'status_2' => $request->get('status_2'),
            'memo' => $request->get('memo'),
            'tgl_memo' => $request->get('memo_date'),
            'approved_by' => $request->get('approved'),
            'tgl_approved' => $request->get('approved_date'),
            'keterangan' => $request->get('ket'),
            'id_user_input' => Auth::user()->id
        ]);

        return redirect(route('vendor_fin.index'))->with(['success' => 'New vendor added successfully']);
    }

    public function destroy($kode_vendor)
    {
        Vendor::find($kode_vendor)->delete();
        return redirect(route('vendor_fin.index'))->with(['success' => 'The selected Account has been successfully deleted']);
    }

    public function edit($kode_vendor)
    {
        $vendor = DB::table('vendors')
                  ->where('vendors.kode_vendor', $kode_vendor)
                  ->first();

        return view('finance.vendor_fin.edit', compact('vendor'));
    }

    public function update(Request $request)
    {
        $update_vendor = Vendor::find($request->get('kode'));
        $update_vendor->update([
            'nama_vendor' => $request->get("vendor_name"),
            'alamat' => $request->get("address"),
            'telp' => $request->get("telphone"),
            'fax' => $request->get("fax"),
            'email' => $request->get("email"),
            'contact_person' => $request->get("cp"),
            'jabatan' => $request->get("position"),
            'status_1' => $request->get("status_1"),
            'status_2' => $request->get("status_2"),
            'top' => $request->get("top"),
            'memo' => $request->get("memo"),
            'keterangan' => $request->get("ket"),
            'id_user_input' => Auth::user()->id
        ]);

        return redirect(route('vendor_fin.index'))->with(['success' => 'Data Vendor berhasil diubah']);
    }


    
}
