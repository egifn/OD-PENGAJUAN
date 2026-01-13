<?php

namespace App\Http\Controllers\Saldo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaldoTagihanTunaiController extends Controller
{
    public function index()
    {
 		return view ('saldo.tagihan_tunai.index');   	
    }
}
