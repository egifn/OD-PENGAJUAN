<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perusahaan;
use App\Depo;
use App\Divisi;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRegistrationLuarController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
           
        $depo = Depo::orderBy('kode_depo', 'ASC')
                ->whereNotIn('kode_depo', ['000','001'])
                ->get();

        $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
    
        return view ('user_registration_luar', compact('perusahaan','divisi','depo'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string|max:255',
    		'username' => 'required|string',
    		'password' => 'string',
    		'kode_divisi' => 'required|exists:divisi,kode_divisi'
    	]);

        User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'email_verified_at' =>'',
            'password' => Hash::make($request->get('password')),
            'remember_token' => '',
            'kode_perusahaan' => $request->get('kode_perusahaan'),
            'kode_depo' => $request->get('kode_depo'),
            'kode_divisi' => $request->get('kode_divisi'),
            'kode_sub_divisi' => $request->get('kode_sub_divisi'),
            'type' => $request->get('type'),
            'id_employee' => $request->get('id_employee'),
            'kategori' => $request->get('kategori'),
            'status_user' => 'Aktif'
        ]);

    	alert()->success('Berhasil.','Penguna Berhasil Mendaftar...');
        return redirect('/login')->withSuccess('Berhasil');
    }
}
