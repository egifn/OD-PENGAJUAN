<?php

namespace App\Http\Controllers\Saldo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaldoPenjualanTunaiController extends Controller
{
    public function index()
    {
 		return view ('saldo.penjualan_tunai.index');   	
    }
}
