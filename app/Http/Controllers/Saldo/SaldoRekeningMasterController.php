<?php

namespace App\Http\Controllers\Saldo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaldoRekeningMasterController extends Controller
{
    public function index()
    {
 		return view ('saldo.rekening_master.index');   	
    }
}
