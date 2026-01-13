<?php

namespace App\Http\Controllers\Tarif_Bbm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Depo;
use Carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TarifBbmController extends Controller
{
    public function index()
    {
        $data_tarif_bbm = DB::table('tarif_bbm')
                        ->join('depos','tarif_bbm.kd_dari_depo','=','depos.kode_depo')
                        ->join('depos as ke_depo','tarif_bbm.kd_ke_depo','=','ke_depo.kode_depo')
                        ->join('users','tarif_bbm.id_user_input','=','users.id')
                        ->select('tarif_bbm.id','tarif_bbm.kd_dari_depo','depos.nama_depo as dari_depo','tarif_bbm.kd_ke_depo','ke_depo.nama_depo as ke_depo','tarif_bbm.kendaraan',
                                'tarif_bbm.uang','tarif_bbm.id_user_input','users.name')
                        ->get();
        return view ('tarif_bbm.index', compact('data_tarif_bbm'));
    }

    public function create(Request $request)
    {
    	// $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
    	// $kode_perusahaan = $request->get('1');
    	// $depo = DB::table('depos')->Where('kode_perusahaan', $kode_perusahaan)
    	// 		->orderBy('nama_depo', 'ASC')
    	// 		->get();

    	// $data = DB::table('users')
    	// 	->join('perusahaans','users.kode_perusahaan','=','perusahaans.kode_perusahaan')
    	// 	->join('depos','users.kode_depo','=','depos.kode_depo')
    	// 	->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
    	// 	->Where('users.id', Auth::user()->id)
    	// 	->first();

        $depo = DB::table('depos')
    			->orderBy('nama_depo', 'ASC')
    			->get();

    	return view('tarif_bbm.create', compact('depo')); 
    }

    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        DB::table('tarif_bbm')->insert([
            'kd_dari_depo' => $request->dari_kode_depo,
            'kd_ke_depo' => $request->ke_kode_depo,
            'kendaraan' => $request->kendaraan,
            'uang' => $request->uang_bensin,
            'id_user_input' => Auth::user()->id,
        ]);

        alert()->success('Success.','Tarif BBM Berhasil ditambahkan');
        return redirect()->route('tarif_bbm.index');
    }

    public function update_view($id)
    {
        $depo = DB::table('depos')
    			->orderBy('nama_depo', 'ASC')
    			->get();

        $data_tarif_bbm_update = DB::table('tarif_bbm')
            ->join('depos','tarif_bbm.kd_dari_depo','=','depos.kode_depo')
            ->join('depos as ke_depo','tarif_bbm.kd_ke_depo','=','ke_depo.kode_depo')
            ->join('users','tarif_bbm.id_user_input','=','users.id')
            ->select('tarif_bbm.id','tarif_bbm.kd_dari_depo','depos.nama_depo as dari_depo','tarif_bbm.kd_ke_depo','ke_depo.nama_depo as ke_depo','tarif_bbm.kendaraan',
                                'tarif_bbm.uang','tarif_bbm.id_user_input','users.name')
            ->Where('tarif_bbm.id', $id)
            ->first();
        
        return view ('tarif_bbm.update',compact('depo','data_tarif_bbm_update'));
    }

    public function edit(Request $request)
    {
            // $edit_head =  DB::table('tarif_bbm')->where('tarif_bbm.id', $request->get('id_tarif')); //User::find($request->get('kode'));
            // $edit_head->update([
            //     'kd_dari_depo' => $request->get("kd_dari_depo"),
            //     'kd_ke_depo' => $request->get("kd_ke_depo"),
            //     'kendaraan' => $request->get("kendaraan"),
            //     'uang' => $request->get("uang"),
            //     'id_user_input' => Auth::user()->id
                
            // ]);

            $edit = DB::table('tarif_bbm')->where('tarif_bbm.id', $request->get('id_tarif'))->update([
                'kd_dari_depo' => $request->get("dari_kode_depo"),
                'kd_ke_depo' => $request->get("ke_kode_depo"),
                'kendaraan' => $request->get("kendaraan"),
                'uang' => $request->get("uang_bensin"),
                'id_user_input' => Auth::user()->id
            ]);
        return redirect(route('tarif_bbm.index'))->with(['success' => 'Data berhasil diubah']);
    }
    
}
