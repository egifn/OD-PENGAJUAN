<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserResetController extends Controller
{
    public function index(Request $request)
    {
        $data_user = DB::table('users')
                    ->where('users.id', Auth::user()->id)
                    ->first();
        
        return view('user_reset.index', compact('data_user'));
    }

    public function edit(Request $request)
    {
        $edit_head = User::find($request->get('id_user'));
        $edit_head->update([ 
            'username' => $request->get("username"),
            'password' => Hash::make($request->get('password'))
        ]);

        alert()->success('Success.','Kata sandi/Password baru berhasil diubah...');
        return view('user_reset.view');
    }
	
	public function reset(request $request)
    {
        $cari_username = DB::table('users')
                        ->where('users.username', $request->get('username'))
                        ->select('users.id','users.username')
                        ->first(); 

        if($cari_username->username != ''){
            $reset_pass = User::find($cari_username->id);
            $reset_pass->update([ 
               'password' => Hash::make($request->get('password'))
            ]);

            alert()->success('Success.','Reset berhasil...');
            return redirect('/login')->withSuccess('Berhasil');
        }else{
            
        }

        
        // $data_user = DB::table('users')
        //             ->where('users.id', Auth::user()->id)
        //             ->first();

        // $reset_pass = User::find($request->get('username'));
        // $reset_pass->update([ 
        //     'password' => Hash::make($request->get('password'))
        // ]);

        // alert()->success('Success.','Reset berhasil...');
        // return view('login.index');
    }
}
