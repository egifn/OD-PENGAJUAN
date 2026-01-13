<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Divisi;
use App\User;
use Auth;
use DB;

class DivisiController extends Controller
{
    public function index()
    {
    	$divisi = Divisi::orderBy('nama_divisi','ASC')->paginate(5);
    	return view('divisi.index', compact('divisi'));
    }

    public function cari(Request $request)
    {
        $q =  $request->q;
        $divisi =  Divisi::where('nama_divisi','like',"%".$q."%")->paginate(5);

        return view('divisi.index', compact('divisi'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'nama_divisi' => 'required',
            'kepala_divisi' => 'required'
    	]);

    	Divisi::create([
    		'nama_divisi' => $request->nama_divisi,
            'kepala_divisi' => $request->kepala_divisi,
    		'id_user_input' => Auth::user()->id
    	]);
    	return redirect(route('divisi.index'))->with(['success' => 'Divisi baru ditambahkan']);
    }

    public function destroy($kode_divisi)
    {
        Product::find($kode_divisi)->delete();
        return redirect(route('divisi.index'))->with(['success' => 'Divisi yang dipilih berhasil Dihapus!']);
    }

    public function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('divisi')
                        ->where('nama_divisi', 'like', '%'.$query.'%')
                        ->get();
            }
            else
            {
                $data = DB::table('divisi')
                        ->orderBy('nama_divisi','ASC')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                        <td>'.$row->nama_divisi.'</td>
                        
                    </tr>
                    ';
                }
            }
            else
            {
                $output = '
                <tr>
                    <td align="center" colspan="2">No Data Found</td>
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
}
