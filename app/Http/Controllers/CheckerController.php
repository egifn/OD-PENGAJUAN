<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Perusahaan;
use App\Depo;
use App\Checker;
use Carbon\carbon;
use Auth;
use DB;

class CheckerController extends Controller
{

	public function ajax(Request $request) // dropdown perusahaan dan depo
    {
        $perusahaandepo = Depo::Where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($perusahaandepo);
    }

    public function index(Request $request)
    {
    	$perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
    	$kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)
                                  ->orderBy('nama_depo', 'ASC')
                                  ->get();

        if(Auth::user()->kode_divisi == '22'){ //BOGOR
            $checker = DB::table('checker')
                ->join('perusahaans','checker.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','checker.kode_depo','=','depos.kode_depo')
                ->get();
        }else{
            $checker = DB::table('checker')
                ->join('perusahaans','checker.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','checker.kode_depo','=','depos.kode_depo')
                ->where ('checker.kode_depo', Auth::user()->kode_depo)
                ->get();
        }
        

        return view('checker.index', compact('perusahaan','depo','checker'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		
    	]);

    	Checker::create([
    		'nama_checker' => $request->get('nama'),
    		'kode_perusahaan' => $request->get('kode_perusahaan'),
    		'kode_depo' => $request->get('kode_depo'),
            'kategori' => $request->get('kategori_produk')
    	]);
    	return redirect(route('checker.index'))->with(['success' => 'Checker baru berhasil ditambahkan']);
    }

    public function destroy($id_checker)
    {
        Checker::find($id_checker)->delete();
        return redirect(route('checker.index'))->with(['success' => 'Data berhasil dihapus']);
    }

    public function view($id_checker)
    {   
        $perusahaan = Perusahaan::orderBy('nama_perusahaan','ASC')->get();
        //$kode_perusahaan = $request->get('1');

        //$checker = Checker::find($id_checker);

        $checker = DB::table('checker')
                ->join('perusahaans','checker.kode_perusahaan','=','perusahaans.kode_perusahaan')
                ->join('depos','checker.kode_depo','=','depos.kode_depo')
                ->Where('checker.id_checker', $id_checker)
                ->first();


        return view('checker.edit', compact('perusahaan','checker'));
    }



    public function update(Request $request)
    {
        $update_checker = Checker::find($request->get('id'));
        $update_checker->update([
            'nama_checker' => $request->get("nama"),
            'kode_perusahaan' => $request->get("kode_perusahaan"),
            'kode_depo' => $request->get("kode_depo"),
            'kategori' => $request->get("kategori_produk")
        ]);
		
		$update_kat_user_checker = DB::table('users')
                                    ->select('users.name')
                                    ->Where('users.name', $request->get("nama"))
                                    ->update([
                                        'kategori' =>  $request->get("kategori_produk")
                                    ]);

        return redirect(route('checker.index'))->with(['success' => 'Data Checker berhasil diubah']);
    }


}
