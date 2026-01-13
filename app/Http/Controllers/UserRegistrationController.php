<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Perusahaan;
use App\Perusahaan_Korsis;
use App\Depo;
use App\Depo_Korsis;
use App\Divisi;
use App\Divisi_Sub;
use App\User;
use App\KategoriBuku;
use App\KategoriPengeluaran;
use Auth;
use DB;

class UserRegistrationController extends Controller
{
    public function index()
    {
        if(Auth::user()->kode_divisi == '23'){ // jika divisi KORSIS
            $pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->WhereIn('users.kode_divisi', [23,6])
					->WhereIn('users.kode_sub_divisi', [2,3])
					->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
                    ->get();
        }else{
			if(Auth::user()->kode_divisi == '6'){
                $pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->where('users.kode_depo', '002')
					->where('users.kode_divisi', 6)
                    ->WhereIn('users.type', ['Manager','Admin'])
                    ->get();
            }elseif(Auth::user()->kode_divisi == '100'){
                $pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->get();
            }elseif(Auth::user()->kode_divisi == '2'){
                if(Auth::user()->kode_sub_divisi == '18'){
                    $pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->where('users.kode_perusahaan', 'TUA')
                    //->where('users.kode_depo', Auth::user()->kode_depo)
                    ->WhereIn('users.type', ['Manager','Admin'])
                    ->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
                    ->get();
                }elseif(Auth::user()->kode_sub_divisi == '19'){
                    $pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->where('users.kode_perusahaan', 'LP')
                    //->where('users.kode_depo', Auth::user()->kode_depo)
                    ->WhereIn('users.type', ['Manager','Admin'])
                    ->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
                    ->get();
                }elseif(Auth::user()->kode_sub_divisi == '20'){
                    $pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->where('users.kode_perusahaan', 'WPS')
                    //->where('users.kode_depo', Auth::user()->kode_depo)
                    ->WhereIn('users.type', ['Manager','Admin'])
                    ->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
                    ->get();
                }

            }else{
				if(Auth::user()->kode_perusahaan == 'WPS'){
					$pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->where('users.kode_perusahaan', Auth::user()->kode_perusahaan)
                    ->where('users.kode_depo', Auth::user()->kode_depo)
                    ->WhereIn('users.type', ['Manager','Admin'])
                    ->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
                    ->get();
				}elseif(Auth::user()->kode_perusahaan == 'LP'){
					$pengguna = DB::table('users')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->where('users.kode_perusahaan', Auth::user()->kode_perusahaan)
                    ->where('users.kode_depo', Auth::user()->kode_depo)
                    ->WhereIn('users.type', ['Manager','Admin'])
                    ->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
                    ->get();
				}elseif(Auth::user()->kode_perusahaan == 'TUA'){
					if(Auth::user()->kode_depo == '002'){
						$pengguna = DB::table('users')
						->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
						->where('users.kode_perusahaan', Auth::user()->kode_perusahaan)
						->where('users.kode_depo', Auth::user()->kode_depo)
						->where('users.kode_divisi', Auth::user()->kode_divisi)
						->WhereIn('users.type', ['Manager','Admin'])
						->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
						->get();
					}else{
						if(Auth::user()->kode_divisi == '10'){
							$pengguna = DB::table('users')
							->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
							->where('users.kode_perusahaan', Auth::user()->kode_perusahaan)
							->where('users.kode_depo', Auth::user()->kode_depo)
							->where('users.kode_divisi', Auth::user()->kode_divisi)
							->WhereIn('users.type', ['Manager','Admin'])
							->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
							->get();
						}else{
							$pengguna = DB::table('users')
							->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
							->where('users.kode_perusahaan', Auth::user()->kode_perusahaan)
							->where('users.kode_depo', Auth::user()->kode_depo)
							->WhereIn('users.type', ['Manager','Admin'])
							->WhereIn('users.status_user', ['Aktif','Tidak Aktif'])
							->get();
						}
					}
				}
            }
            
        }
        

        return view ('user_registration.index', compact('pengguna'));
    }

    public function ajax_depo_user(Request $request)
    {
        if(Auth::user()->kode_divisi == '23'){ // jika divisi KORSIS
            $kodedepo = Depo_Korsis::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
            return response()->json($kodedepo);
        }else{
            $kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
            return response()->json($kodedepo);
        }
        
    }

    public function ajax_divisi(Request $request)
    {
        $kodedivisi = Divisi_Sub::where('kode_divisi', $request->divisi_id)->pluck('kode_divisi_sub','nama_divisi_sub');
        return response()->json($kodedivisi);
    }

    public function actionEmployee(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != ''){
                $data = DB::table('checker')
                        ->where('checker.id_checker','like','%'.$query.'%')
                        ->orWhere('checker.nama_checker','like','%'.$query.'%')
                        ->get();
            }else{
                $data = DB::table('checker')
                        ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr class="pilih" data-id="'.$row->id_checker.'" data-nama="'.$row->nama_checker.'" data-kategori="'.$row->kategori.'">
                        <td>'.$row->id_checker.'</td>
                        <td>'.$row->nama_checker.'</td>
                        <td>'.$row->kategori.'</td>
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

    public function create(Request $request)
    {    
        if(Auth::user()->kode_divisi == '23'){ // jika divisi KORSIS
            $perusahaan = Perusahaan_Korsis::orderBy('kode_perusahaan', 'ASC')->get();
            $kode_perusahaan = $request->get('1');
            $depo = DB::table('depos_korsis')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get(); 

            $divisi = DB::table('divisi')->WhereIn('kode_divisi', [6,23])->orderBy('nama_divisi','ASC')->get();
            $kode_divisi = $request->get('1');
            $divisi_sub = DB::table('divisi_sub')->where('kode_divisi', $kode_divisi)->orderBy('kode_divisi_sub')->get();
        }else{
            $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
            $kode_perusahaan = $request->get('1');
            $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get(); 

            $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
            $kode_divisi = $request->get('1');
            $divisi_sub = DB::table('divisi_sub')->where('kode_divisi', $kode_divisi)->orderBy('kode_divisi_sub')->get();
        }
        
  
        

        
    	return view ('user_registration.create',compact('divisi','perusahaan','depo','divisi_sub'));
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string|max:255',
    		'username' => 'required|string',
    		'password' => 'string',
    		'kode_divisi' => 'required|exists:divisi,kode_divisi'
    	]);
		
		if(Auth::user()->kode_divisi == '23'){ // jika divisi KORSIS
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
				'kode_sub_divisi' => '2',
				'type' => $request->get('akses'),
				'id_employee' => $request->get('id_employee'),
				'kategori' => $request->get('kategori'),
				'status_user' => 'Aktif'
			]);
		}else{
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

		}
    	
    	return redirect(route('user_registration.index'))->with(['success']);
    }
	
	public function update_view(Request $request, $id)
	{
		if(Auth::user()->kode_divisi == '23'){ // jika divisi KORSIS
            $perusahaan = Perusahaan_Korsis::orderBy('kode_perusahaan', 'ASC')->get();
            $kode_perusahaan = $request->get('1');
            $depo = DB::table('depos_korsis')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get(); 

            $divisi = DB::table('divisi')->WhereIn('kode_divisi', [6,23])->orderBy('nama_divisi','ASC')->get();
            $kode_divisi = $request->get('1');
            $divisi_sub = DB::table('divisi_sub')->where('kode_divisi', $kode_divisi)->orderBy('kode_divisi_sub')->get();
			
			$data_pengguna = DB::table('users')
					->join('perusahaans','users.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->WhereIn('users.kode_divisi', [23,6])
                    ->Where('users.id', $id)
                    ->first();
			
			return view ('user_registration.update',compact('divisi','perusahaan','depo','divisi_sub','data_pengguna'));
        }else{
            $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();
            $kode_perusahaan = $request->get('1');
            $depo = DB::table('depos')->where('kode_perusahaan', $kode_perusahaan)->orderBy('kode_depo', 'ASC')->get(); 

            $divisi = Divisi::orderBy('nama_divisi','ASC')->get();
            $kode_divisi = $request->get('1');
            $divisi_sub = DB::table('divisi_sub')->where('kode_divisi', $kode_divisi)->orderBy('kode_divisi_sub')->get();
			
			$data_pengguna = DB::table('users')
                    ->leftJoin('perusahaans','users.kode_perusahaan','=','perusahaans.kode_perusahaan')
                    ->leftJoin('depos','users.kode_depo','=','depos.kode_depo')
                    ->join('divisi','users.kode_divisi','=','divisi.kode_divisi')
                    ->leftJoin('checker','users.id_employee','=','checker.id_checker')
                    ->Where('users.id', $id)
                    ->first();

            return view ('user_registration.update',compact('divisi','perusahaan','depo','divisi_sub','data_pengguna'));
        }
	}
	
	public function edit(Request $request)
    {
        if(Auth::user()->kode_divisi == '23'){ // jika divisi KORSIS
			$edit_head = User::find($request->get('kode'));
            $edit_head->update([
                'name' => $request->get("name"),
                'username' => $request->get("username"),
                'kode_perusahaan' => $request->get("kode_perusahaan"),
                'kode_divisi' => $request->get("kode_divisi"),
                'type' => $request->get("akses"),
				'id_employee' => $request->get('id_employee'),
                'status_user' => $request->get("status")
                
            ]);
        }else{
            if($request->get("kode_perusahaan")==null){
                $cari_perusahaan = DB::table('users')
                    ->select('users.kode_perusahaan')
                    ->where('users.username', $request->get("username_temp"))
                    ->first();

                $kode_perusahaan = $cari_perusahaan->kode_perusahaan; 
            }else{
                $kode_perusahaan = $request->get("kode_perusahaan");
            }

            if($request->get("kode_depo")==null){
                $cari_depo = DB::table('users')
                    ->select('users.kode_depo')
                    ->where('users.username', $request->get("username_temp"))
                    ->first();

                $kode_depo = $cari_depo->kode_depo; 
            }else{
                $kode_depo = $request->get("kode_depo");
            }

            $edit_head = User::find($request->get('kode'));
            $edit_head->update([
                'name' => $request->get("name"),
                'username' => $request->get("username"),
                'kode_perusahaan' => $kode_perusahaan,
                'kode_depo' => $kode_depo,
                'kode_divisi' => $request->get("kode_divisi"),
                'type' => $request->get("type"),
                'id_employee' => $request->get('id_employee'),
                'status_user' => $request->get("status")
                
            ]);
        }

        return redirect(route('user_registration.index'))->with(['success' => 'Data berhasil diubah']);
    }
}
