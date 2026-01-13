<?php

namespace App\Http\Controllers\Coa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coa_1;
use App\Coa_2;
use App\Coa_3;
use App\Coa_4;
use App\User;
use DB;

class AccountController extends Controller
{
    public function index()
    {
    	//$account_1 = Coa_1::with(['coa_2'])->with(['coa_3'])->get();
    	$account_1 = Coa_1::with(['coa_2'])
    				->with(['coa_3'])
    				->with(['coa_4'])
    				->get();

    	$account_2 = Coa_2::with(['coa_3'])->get();
    	return view('coa.index', compact('account_1','account_2'));
    }

  
}
