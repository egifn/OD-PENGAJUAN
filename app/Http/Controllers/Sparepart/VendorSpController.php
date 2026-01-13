<?php

namespace App\Http\Controllers\Sparepart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sparepart_Vendor;
use Auth;
use DB;

class VendorSpController extends Controller
{
    public function index()
    {
        $sparepart_vendor = DB::table('sparepart_vendor')
                        ->join('sparepart_categories_vendor','sparepart_vendor.sub_kelompok','=','sparepart_categories_vendor.kode_kategori_vendor')
                        ->join('users','sparepart_vendor.id_user_input','=','users.id')
                        ->select('sparepart_vendor.kelompok','sparepart_vendor.sub_kelompok','sparepart_vendor.id as kode_cat','sparepart_vendor.sub_kelompok','sparepart_categories_vendor.nama_kategori_vendor','sparepart_vendor.kode_vendor','sparepart_vendor.nama_vendor','sparepart_vendor.status','sparepart_vendor.created_at','sparepart_vendor.id_user_input','users.name')
                        ->orderBy('sparepart_vendor.id', 'ASC')
                        ->get();
    	return view('sparepart.vendor_sp.index', compact('sparepart_vendor'));
    }

    public function actionVendor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::connection('sqlsrv')
                        ->table('ms_supplier')
                        ->where('ms_supplier.supp_code','like', '%'.$query.'%')
                        ->orWhere('ms_supplier.supp_desc','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::connection('sqlsrv')
                        ->table('ms_supplier')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_vendor" data-kode_vendor="'.$row->supp_code.'" data-nama_vendor="'.$row->supp_desc.'">
                            <td>'.$row->supp_code.'</td>
                            <td>'.$row->supp_desc.'</td>
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

    public function actionKategori(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('sparepart_categories_vendor')
                        ->where('sparepart_categories_vendor.kode_kategori_vendor','like', '%'.$query.'%')
                        ->orWhere('sparepart_categories_vendor.nama_kategori_vendor','like', '%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('sparepart_categories_vendor')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach ($data as $row) {
                    $output .= '
                        <tr class="pilih_kategori" data-kode="'.$row->kode_kategori_vendor.'" data-nama="'.$row->nama_kategori_vendor.'">
                            <td>'.$row->kode_kategori_vendor.'</td>
                            <td>'.$row->nama_kategori_vendor.'</td>
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

    public function create()
    {
    	return view('sparepart.vendor_sp.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            
        ]);

        $getRow = DB::table('sparepart_vendor')->select(DB::raw('MAX(SUBSTRING(id,1)) as NoUrut'))
                                                ->where('sub_kelompok', $request->get('kode_kategori'));
        $rowCount = $getRow->count();
        if ($rowCount > 0) {
            $no_btb = $request->get('kode_kategori').''.($rowCount + 1);
        }else{
            $no_btb = $request->get('kode_kategori').sprintf("%01s", 1);
        }

        Sparepart_Vendor::create([
            'kode_vendor' => $request->get('kode_supp'),
            'kelompok' => $request->get('jenis'),
            'sub_kelompok' => $request->get('kode_kategori'),
            'id' => $no_btb, 
            'nama_vendor' => $request->get('supplier'),
            'status' => $request->get('faktur'),
            'id_user_input' => Auth::user()->id 
        ]);
        return redirect(route('vendor_sp.index'))->with(['success' => 'New vendor added successfully']);
    }
}
