<?php

namespace App\Http\Controllers\Hrd\Tunjangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TunjanganController extends Controller
{
    public function index()
    {
        return view('hrd.tunjangan.index');
    }

    public function data()
    {
        $data_tunjangan = DB::table('ms_data_tunjangan')
                        ->join('users','ms_data_tunjangan.id_user_input','=','users.id')
                        ->select(
                            'ms_data_tunjangan.id',
                            'ms_data_tunjangan.nama_tunjangan',
                            'ms_data_tunjangan.nilai',
                            'ms_data_tunjangan.id_user_input',
                            'users.name'
                        )
                        ->get();
         return response()->json($data_tunjangan);
    }

    public function create(Request $request)
    {
        return view ('hrd.tunjangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
    
        ]);

        DB::table('ms_data_tunjangan')->insert([
            'nama_tunjangan' => $request->nama,
            'nilai' => $request->nilai,
            'status' => '1',
            'id_user_input' => auth()->id(),
        ]);

        return redirect()->route('tunjangan.index')->with('success', 'Data Tunjangan berhasil ditambahkan.');
    }
}
