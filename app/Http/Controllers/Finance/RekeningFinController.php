<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bank;
use App\Vendor;
use App\Sparepart_Vendor;
use App\Rekening_Fin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekeningFinController extends Controller
{
    public function index()
    {   
        $rekening = DB::table('rekening_fin')->join('banks','rekening_fin.kode_bank','=','banks.kode_bank')
                                        ->join('vendors','rekening_fin.kode_vendor','=','vendors.kode_vendor')
                                        ->Join('users','rekening_fin.id_user_input','=','users.id')
                                        ->get();

    	return view ('finance.rekening_fin.index', compact('rekening'));
    }

    public function create()
    {
    	$bank = Bank::orderBy('kode_bank', 'ASC')->get();
    	$vendor = Vendor::orderBy('nama_vendor', 'ASC')->get();

        $vendor_sp = Sparepart_Vendor::orderBy('nama_vendor', 'ASC')->get();

    	return view('finance.rekening_fin.create', compact('bank','vendor','vendor_sp'));
    }

    public function actionVendor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('vendors')
                        ->where('vendors.kode_vendor','like','%'.$query.'%')
                        ->orWhere('vendors.nama_vendor','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('vendors')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_vendor" data-kode_vendor="'.$row->kode_vendor.'" data-nama_vendor="'.$row->nama_vendor.'">
                            <td>'.$row->kode_vendor.'</td>
                            <td>'.$row->nama_vendor.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function actionVendorSp(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('sparepart_vendor')
                        ->where('sparepart_vendor.kode_vendor','like','%'.$query.'%')
                        ->orWhere('sparepart_vendor.nama_vendor','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('sparepart_vendor')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_vendor_sp" data-kode_vendor_sp="'.$row->kode_vendor.'" data-nama_vendor_sp="'.$row->nama_vendor.'">
                            <td>'.$row->kode_vendor.'</td>
                            <td>'.$row->nama_vendor.'</td>
                        </tr>
                    ';
                }
            }else{
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'norek' => 'required|string|max:255',
            'kode_bank' => 'required|'
            //'kode_vendor' => 'required|string|'
        ]);
        if(request()->vendor == 'non sparepart'){
            Rekening_Fin::create([
                'norek' => $request->get('norek'),
                'kode_bank' => $request->get('kode_bank'),
                'kode_vendor' => $request->get('kode_vendor'),
                'atas_nama' => $request->get('atas_nama'),
                'keterangan' => $request->get('keterangan'),
                'id_user_input' => Auth::user()->id
            ]);
        }else{
            Rekening_Fin::create([
                'norek' => $request->get('norek'),
                'kode_bank' => $request->get('kode_bank'),
                'kode_vendor' => $request->get('kode_vendor_sp'),
                'atas_nama' => $request->get('atas_nama_sp'),
                'id_user_input' => Auth::user()->id
            ]);
        }
        
        return redirect(route('rekening_fin.index'))->with(['success' => 'Rekening baru berhasil ditambahkan']);
    }

    public function destroy($norek)
    {
        Rekening_Fin::find($norek)->delete();
        return redirect(route('rekening_fin.index'))->with(['success' => 'Rekening yang dipilih berhasil dihapus']);
    }

    public function edit($kode_vendor)
    {
        $bank = Bank::orderBy('kode_bank', 'ASC')->get();
        $rekening =  DB::table('rekening_fin')
                        ->join('vendors','rekening_fin.kode_vendor','=','vendors.kode_vendor')
                        ->join('banks', 'rekening_fin.kode_bank','=','banks.kode_bank')
                        ->select('rekening_fin.id','rekening_fin.kode_vendor', 'vendors.nama_vendor', 
                        'rekening_fin.norek','rekening_fin.kode_bank', 'banks.nama_bank', 'rekening_fin.atas_nama', 'rekening_fin.keterangan')
                        ->where('rekening_fin.kode_vendor', $kode_vendor)
                        ->first();

        return view('finance.rekening_fin.edit', compact('bank','rekening'));

    }

    public function update(Request $request)
    {
        if($request->get("kode_bank") == '0'){
            return redirect(route('rekening_fin.index'))->with(['error' => 'Rekening yang dipilih gagal diubah/diedit, Bank harus dipilih/diisi...']);
        }else{
            $update_rekening = Rekening_Fin::find($request->get('id_rek'));
            $update_rekening->update([
                'norek' => $request->get("norek"),
                'kode_bank' => $request->get("kode_bank"),
                'kode_vendor' => $request->get("kode_vendor"),
                'atas_nama' => $request->get("atas_nama"),
                'keterangan' => $request->get("keterangan"),
                'id_user_update' => Auth::user()->id
            ]);

            return redirect(route('rekening_fin.index'))->with(['success' => 'Data Vendor berhasil diubah']);
        }
        
    }

}
