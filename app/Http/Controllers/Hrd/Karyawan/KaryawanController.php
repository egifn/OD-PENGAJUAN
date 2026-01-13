<?php

namespace App\Http\Controllers\Hrd\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

use App\Perusahaan;
use App\Depo;
use App\Divisi;
use App\Divisi_Sub;
use App\User;

use Carbon\carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('hrd.karyawan.index');
    }

    public function data()
    {
        $data_karyawan = DB::table('ms_data_karyawan')
                        ->join('depos','ms_data_karyawan.depo','=','depos.kode_depo')
                        ->join('dt_area','ms_data_karyawan.area','=','dt_area.id')
                        ->join('users','ms_data_karyawan.id_user_input','=','users.id')
                        ->select(
                            'ms_data_karyawan.id',
                            'ms_data_karyawan.nama',
                            'ms_data_karyawan.alamat',
                            'ms_data_karyawan.tlp',
                            'ms_data_karyawan.nik', 
                            'ms_data_karyawan.id_dms',
                            'ms_data_karyawan.perusahaan',
                            'ms_data_karyawan.depo',
                            'depos.nama_depo',
                            'ms_data_karyawan.jabatan',
                            'ms_data_karyawan.area',
                            'dt_area.area_name',
                            'ms_data_karyawan.tgl_gabung',
                            'ms_data_karyawan.status',
                            'ms_data_karyawan.id_user_input',
                            'users.name'
                        )
                        ->get();
            

        return response()->json($data_karyawan);
    }

    public function create(Request $request)
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
        $kode_perusahaan = $request->get('1');
        $depo = DB::table('depos')->orderBy('kode_depo', 'ASC')->get(); 

        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
        $kode_divisi = $request->get('1');
        $divisi_sub = DB::table('divisi_sub')->where('kode_divisi', $kode_divisi)->orderBy('kode_divisi_sub')->get();
        $areas = DB::table('dt_area')->get();


        return view ('hrd.karyawan.create',compact('divisi','perusahaan','depo','divisi_sub','areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:50|unique:ms_data_karyawan,nik',
            'alamat' => 'nullable|string',
            'tlp' => 'nullable|string',
            'id_dms' => 'nullable|string',
            'perusahaan' => 'nullable|string',
            'depo' => 'required|string',
            'jabatan' => 'nullable|string',
            'area' => 'required|integer',
            'tgl_gabung' => 'required|date',
        ]);

        DB::table('ms_data_karyawan')->insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tlp' => $request->tlp,
            'nik' => $request->nik,
            'id_dms' => $request->id_dms,
            'perusahaan' => $request->perusahaan,
            'depo' => $request->depo,
            'jabatan' => $request->jabatan,
            'area' => $request->area,
            'tgl_gabung' => $request->tgl_gabung,
            'status' => '1',
            'id_user_input' => auth()->id(),
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

}
