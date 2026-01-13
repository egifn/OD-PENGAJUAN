<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\MasterPengeluaran;
use Auth;
use File;
use DB;

class PengeluaranController extends Controller
{
    public function index()
    {	
    	$m_pengeluaran = DB::table('ms_pengeluaran')
    						->join('users','ms_pengeluaran.id_user_input','=','users.id')
                            ->leftJoin('coa_transaksi','ms_pengeluaran.coa','=','coa_transaksi.no')
    						->get();

    	return view('master_pengeluaran.index', compact('m_pengeluaran'));
    }

    public function actionCoa(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                //$data = DB::table('coa_lv4')
                  //      ->WhereIn('coa_lv4.kode_lv3', ['200102200'])
                    //    ->Where('coa_lv4.kode_lv4','like','%'.$query.'%')
                      //  ->orWhere('coa_lv4.account_name','like','%'.$query.'%')
                        //->get();

                $data = DB::table('coa_transaksi')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                        ->select('coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->Where('coa_transaksi.no','like','%'.$query.'%')
                        ->orWhere('coa_transaksi.nama_transaksi','like','%'.$query.'%')
                        ->groupBy('coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
            }else{
                //$data = DB::table('coa_lv4')
                  //      ->WhereIn('coa_lv4.kode_lv3', ['200102200'])
                    //    ->get();

                $data = DB::table('coa_transaksi')
                        ->join('coa_transaksi_detail','coa_transaksi.no','coa_transaksi_detail.no')
                         ->select('coa_transaksi.no','coa_transaksi.nama_transaksi',
                            DB::raw("(SELECT coa_transaksi_detail.id_debit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_debit IS NOT NULL) as debit_1"),
                            DB::raw("(SELECT coa_transaksi_detail.id_kredit FROM coa_transaksi_detail WHERE coa_transaksi_detail.no = coa_transaksi.no and coa_transaksi_detail.id_kredit IS NOT NULL) as kredit_1"))
                        ->groupBy('coa_transaksi.no','coa_transaksi.nama_transaksi')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                        <tr class="pilih_coa" data-kode_coa="'.$row->no.'" data-coa="'.$row->nama_transaksi.'" data-debit="'.$row->debit_1.'" data-kredit="'.$row->kredit_1.'">
                            <td>'.$row->no.'</td>
                            <td>'.$row->nama_transaksi.'</td>
                            <td hidden>'.$row->debit_1.'</td>
                            <td hidden>'.$row->kredit_1.'</td>
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

    	]);

    	MasterPengeluaran::create([
    		'nama_pengeluaran' => $request->get('addNamaPengeluaran'),
    		'sifat' => $request->get('addSifat'),
    		'jenis' => $request->get('addJenis'),
    		'pembayaran' => $request->get('addPembayaran'),
			'cara_pembayaran' => $request->get('addCaraPembayaran'),
			'kontrabon' => $request->get('addkontra'),
    		'keterangan' => $request->get('addKeterangan'),
            'kategori' => $request->get('addKategori'),
    		'coa' => $request->get('addCoa'),
    		'id_user_input' => Auth::user()->id
    	]);

    	Alert()->success('Berhasil.', 'Data Pengeluaran telah berhasil ditambahkan');
    	return redirect()->route('pengeluaran.index');
    }
}
